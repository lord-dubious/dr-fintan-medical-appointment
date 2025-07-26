// Dr. Fintan Enhanced PWA Service Worker
const CACHE_NAME = 'dr-fintan-v1.2';
const OFFLINE_PAGE = '/offline.html';
const DB_NAME = 'DrFintanDB';
const DB_VERSION = 1;

// Assets to cache for offline functionality
const STATIC_ASSETS = [
  '/',
  '/offline.html',
  '/manifest.json',
  '/assets/css/style.css',
  '/assets/css/bootstrap.min.css',
  '/assets/js/main.js',
  '/assets/js/bootstrap.bundle.min.js',
  '/assets/js/jquery-3.7.0.min.js',
  '/assets/images/logo.png',
  '/assets/images/favicon.ico'
];

// API endpoints to cache
const API_CACHE_PATTERNS = [
  /\/api\/appointments/,
  /\/api\/patients/,
  /\/api\/doctors/,
  /\/mobile-api\//
];

// IndexedDB setup
const STORES = {
  appointments: 'appointments',
  patients: 'patients',
  doctors: 'doctors',
  cache: 'cache',
  sync: 'sync'
};

// Initialize IndexedDB
function initDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(DB_NAME, DB_VERSION);
    
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve(request.result);
    
    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      
      // Create object stores
      Object.values(STORES).forEach(storeName => {
        if (!db.objectStoreNames.contains(storeName)) {
          const store = db.createObjectStore(storeName, { keyPath: 'id', autoIncrement: true });
          
          // Add indexes based on store type
          switch (storeName) {
            case STORES.appointments:
              store.createIndex('date', 'appointment_date', { unique: false });
              store.createIndex('status', 'status', { unique: false });
              store.createIndex('patient_id', 'patient_id', { unique: false });
              break;
            case STORES.patients:
              store.createIndex('name', 'name', { unique: false });
              store.createIndex('email', 'email', { unique: false });
              break;
            case STORES.doctors:
              store.createIndex('name', 'name', { unique: false });
              store.createIndex('specialization', 'specialization', { unique: false });
              break;
            case STORES.cache:
              store.createIndex('url', 'url', { unique: true });
              store.createIndex('timestamp', 'timestamp', { unique: false });
              break;
            case STORES.sync:
              store.createIndex('action', 'action', { unique: false });
              store.createIndex('timestamp', 'timestamp', { unique: false });
              break;
          }
        }
      });
    };
  });
}

// Store data in IndexedDB
async function storeData(storeName, data) {
  try {
    const db = await initDB();
    const transaction = db.transaction([storeName], 'readwrite');
    const store = transaction.objectStore(storeName);
    
    if (Array.isArray(data)) {
      for (const item of data) {
        await store.put({ ...item, _cached: Date.now() });
      }
    } else {
      await store.put({ ...data, _cached: Date.now() });
    }
    
    return true;
  } catch (error) {
    console.error('[SW] Error storing data:', error);
    return false;
  }
}

// Retrieve data from IndexedDB
async function getData(storeName, key = null) {
  try {
    const db = await initDB();
    const transaction = db.transaction([storeName], 'readonly');
    const store = transaction.objectStore(storeName);
    
    if (key) {
      const result = await store.get(key);
      return result ? result.result : null;
    } else {
      const results = await store.getAll();
      return results.map(item => {
        const { _cached, ...data } = item;
        return data;
      });
    }
  } catch (error) {
    console.error('[SW] Error retrieving data:', error);
    return null;
  }
}

// Queue action for background sync
async function queueForSync(action, data) {
  try {
    const syncData = {
      id: Date.now(),
      action,
      data,
      timestamp: Date.now(),
      retries: 0
    };
    
    await storeData(STORES.sync, syncData);
    
    // Register background sync
    if ('serviceWorker' in navigator && 'sync' in window.ServiceWorkerRegistration.prototype) {
      const registration = await navigator.serviceWorker.ready;
      await registration.sync.register('background-sync');
    }
    
    return true;
  } catch (error) {
    console.error('[SW] Error queuing for sync:', error);
    return false;
  }
}

// Install event - cache static assets
self.addEventListener('install', (event) => {
  console.log('[SW] Installing service worker');
  
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('[SW] Caching static assets');
        return cache.addAll(STATIC_ASSETS);
      })
      .then(() => {
        console.log('[SW] Static assets cached successfully');
        return self.skipWaiting();
      })
      .catch((error) => {
        console.error('[SW] Error caching static assets:', error);
      })
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
  console.log('[SW] Activating service worker');
  
  event.waitUntil(
    caches.keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cacheName) => {
            if (cacheName !== CACHE_NAME) {
              console.log('[SW] Deleting old cache:', cacheName);
              return caches.delete(cacheName);
            }
          })
        );
      })
      .then(() => {
        console.log('[SW] Service worker activated');
        return self.clients.claim();
      })
  );
});

// Fetch event - handle network requests
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);
  
  // Skip non-GET requests and chrome-extension requests
  if (request.method !== 'GET' || url.protocol === 'chrome-extension:') {
    return;
  }
  
  // Handle different types of requests
  if (isAPIRequest(url)) {
    event.respondWith(handleAPIRequest(request));
  } else if (isNavigationRequest(request)) {
    event.respondWith(handleNavigationRequest(request));
  } else {
    event.respondWith(handleStaticRequest(request));
  }
});

// Check if request is for API
function isAPIRequest(url) {
  return API_CACHE_PATTERNS.some(pattern => pattern.test(url.pathname));
}

// Check if request is navigation
function isNavigationRequest(request) {
  return request.mode === 'navigate' || 
         (request.method === 'GET' && request.headers.get('accept').includes('text/html'));
}

// Handle API requests with cache-first strategy for offline support
async function handleAPIRequest(request) {
  const url = new URL(request.url);
  
  try {
    // Try network first for fresh data
    const networkResponse = await fetch(request);
    
    if (networkResponse.ok) {
      // Cache successful responses
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, networkResponse.clone());
      
      // Store in IndexedDB for offline access
      const data = await networkResponse.clone().json();
      await cacheAPIData(url.pathname, data);
      
      return networkResponse;
    }
    
    throw new Error('Network response not ok');
  } catch (error) {
    console.log('[SW] Network failed, trying cache for:', request.url);
    
    // Try cache first
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      return cachedResponse;
    }
    
    // Try IndexedDB
    const offlineData = await getOfflineAPIData(url.pathname);
    if (offlineData) {
      return new Response(JSON.stringify(offlineData), {
        headers: { 'Content-Type': 'application/json' }
      });
    }
    
    // Return offline response for API
    return new Response(JSON.stringify({ 
      error: 'Offline', 
      message: 'This data is not available offline' 
    }), {
      status: 503,
      headers: { 'Content-Type': 'application/json' }
    });
  }
}

// Handle navigation requests
async function handleNavigationRequest(request) {
  try {
    // Try network first
    const networkResponse = await fetch(request);
    return networkResponse;
  } catch (error) {
    console.log('[SW] Navigation failed, serving offline page');
    
    // Try cache
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      return cachedResponse;
    }
    
    // Serve offline page
    const offlineResponse = await caches.match(OFFLINE_PAGE);
    return offlineResponse || new Response('Offline', { status: 503 });
  }
}

// Handle static asset requests
async function handleStaticRequest(request) {
  // Cache first strategy for static assets
  const cachedResponse = await caches.match(request);
  if (cachedResponse) {
    return cachedResponse;
  }
  
  try {
    const networkResponse = await fetch(request);
    
    // Cache successful responses
    if (networkResponse.ok) {
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, networkResponse.clone());
    }
    
    return networkResponse;
  } catch (error) {
    console.log('[SW] Failed to fetch static asset:', request.url);
    return new Response('Asset not available offline', { status: 503 });
  }
}

// Cache API data in IndexedDB
async function cacheAPIData(endpoint, data) {
  try {
    let storeName = STORES.cache;
    
    // Determine appropriate store based on endpoint
    if (endpoint.includes('/appointments')) {
      storeName = STORES.appointments;
    } else if (endpoint.includes('/patients')) {
      storeName = STORES.patients;
    } else if (endpoint.includes('/doctors')) {
      storeName = STORES.doctors;
    }
    
    await storeData(storeName, data);
  } catch (error) {
    console.error('[SW] Error caching API data:', error);
  }
}

// Get offline API data
async function getOfflineAPIData(endpoint) {
  try {
    let storeName = STORES.cache;
    
    // Determine appropriate store based on endpoint
    if (endpoint.includes('/appointments')) {
      storeName = STORES.appointments;
    } else if (endpoint.includes('/patients')) {
      storeName = STORES.patients;
    } else if (endpoint.includes('/doctors')) {
      storeName = STORES.doctors;
    }
    
    return await getData(storeName);
  } catch (error) {
    console.error('[SW] Error getting offline API data:', error);
    return null;
  }
}

// Background sync event
self.addEventListener('sync', (event) => {
  console.log('[SW] Background sync triggered:', event.tag);
  
  if (event.tag === 'background-sync') {
    event.waitUntil(processSyncQueue());
  }
});

// Process background sync queue
async function processSyncQueue() {
  try {
    const syncItems = await getData(STORES.sync);
    
    for (const item of syncItems) {
      try {
        await processSync(item);
        
        // Remove from queue after successful sync
        const db = await initDB();
        const transaction = db.transaction([STORES.sync], 'readwrite');
        const store = transaction.objectStore(STORES.sync);
        await store.delete(item.id);
        
      } catch (error) {
        console.error('[SW] Error processing sync item:', error);
        
        // Increment retry count
        item.retries = (item.retries || 0) + 1;
        
        // Remove if too many retries
        if (item.retries > 3) {
          const db = await initDB();
          const transaction = db.transaction([STORES.sync], 'readwrite');
          const store = transaction.objectStore(STORES.sync);
          await store.delete(item.id);
        } else {
          await storeData(STORES.sync, item);
        }
      }
    }
  } catch (error) {
    console.error('[SW] Error processing sync queue:', error);
  }
}

// Process individual sync item
async function processSync(item) {
  const { action, data } = item;
  
  switch (action) {
    case 'book-appointment':
      await fetch('/api/appointments', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      break;
      
    case 'update-appointment':
      await fetch(`/api/appointments/${data.id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      break;
      
    case 'cancel-appointment':
      await fetch(`/api/appointments/${data.id}`, {
        method: 'DELETE'
      });
      break;
      
    default:
      console.log('[SW] Unknown sync action:', action);
  }
}

// Push notification event
self.addEventListener('push', (event) => {
  console.log('[SW] Push notification received');
  
  const options = {
    body: 'You have a new notification from Dr. Fintan',
    icon: '/assets/images/icon-192x192.png',
    badge: '/assets/images/badge-72x72.png',
    vibrate: [200, 100, 200],
    data: {
      url: '/'
    },
    actions: [
      {
        action: 'view',
        title: 'View',
        icon: '/assets/images/view-icon.png'
      },
      {
        action: 'dismiss',
        title: 'Dismiss',
        icon: '/assets/images/dismiss-icon.png'
      }
    ]
  };
  
  if (event.data) {
    const payload = event.data.json();
    options.body = payload.body || options.body;
    options.data = payload.data || options.data;
  }
  
  event.waitUntil(
    self.registration.showNotification('Dr. Fintan', options)
  );
});

// Notification click event
self.addEventListener('notificationclick', (event) => {
  console.log('[SW] Notification clicked:', event.action);
  
  event.notification.close();
  
  if (event.action === 'view' || !event.action) {
    const url = event.notification.data.url || '/';
    
    event.waitUntil(
      clients.matchAll({ type: 'window' }).then((clientList) => {
        // Check if app is already open
        for (const client of clientList) {
          if (client.url === url && 'focus' in client) {
            return client.focus();
          }
        }
        
        // Open new window
        if (clients.openWindow) {
          return clients.openWindow(url);
        }
      })
    );
  }
});

// Message event for communication with main thread
self.addEventListener('message', (event) => {
  console.log('[SW] Message received:', event.data);
  
  const { type, payload } = event.data;
  
  switch (type) {
    case 'SKIP_WAITING':
      self.skipWaiting();
      break;
      
    case 'CACHE_DATA':
      storeData(payload.store, payload.data);
      break;
      
    case 'GET_CACHED_DATA':
      getData(payload.store, payload.key).then(data => {
        event.ports[0].postMessage({ type: 'CACHED_DATA', data });
      });
      break;
      
    case 'QUEUE_SYNC':
      queueForSync(payload.action, payload.data);
      break;
  }
});

console.log('[SW] Enhanced service worker loaded');