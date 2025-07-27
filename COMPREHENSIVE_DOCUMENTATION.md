# Dr. Fintan Medical Platform - Comprehensive Documentation

## 🏥 Platform Overview

Dr. Fintan Medical Platform is a comprehensive telemedicine solution that enables patients to book appointments, consult with doctors via video calls, and manage their medical records. The platform supports both web and mobile interfaces with PWA capabilities.

## 🎯 Core Features

### 👥 User Management System
- **Multi-role Authentication**: Admin, Doctor, Patient roles
- **Profile Management**: Complete profile editing for all user types
- **Secure Registration**: Email verification and password policies
- **Role-based Access Control**: Granular permissions system

### 📅 Appointment Management
- **Real-time Booking**: Live availability checking
- **Calendar Integration**: Interactive calendar with slot management
- **Appointment Status Tracking**: Pending, Confirmed, Completed, Cancelled
- **Automated Notifications**: Email and push notifications
- **Payment Integration**: Paystack payment gateway

### 🎥 Video Consultation
- **Daily.co Integration**: Professional video calling
- **Mobile Optimized**: PWA-compatible video calls
- **Recording Capabilities**: Session recording for medical records
- **Screen Sharing**: Document and image sharing during calls
- **Call Quality Management**: Adaptive bitrate and quality controls

### 📱 Mobile & PWA Features
- **Progressive Web App**: Installable mobile experience
- **Offline Support**: Service worker for offline functionality
- **Push Notifications**: Real-time appointment updates
- **Touch-optimized UI**: 44px touch targets, swipe gestures
- **Dark Mode**: System preference detection and manual toggle

### 🔔 Notification System
- **Multi-channel Notifications**: Email, SMS, Push, In-app
- **Role-based Notifications**: Customized for each user type
- **Real-time Updates**: WebSocket integration for live updates
- **Notification Preferences**: User-configurable notification settings

## ⚙️ Configuration Guide

### 🌐 Environment Setup

#### Required Environment Variables
```bash
# Application
APP_NAME="Dr. Fintan Medical Platform"
APP_ENV=production
APP_KEY=base64:your-app-key
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dr_fintan_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Daily.co Video Integration
DAILY_API_KEY=your-daily-api-key
DAILY_DOMAIN=your-daily-domain

# Payment Gateway (Paystack)
PAYSTACK_PUBLIC_KEY=pk_test_your_public_key
PAYSTACK_SECRET_KEY=sk_test_your_secret_key

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# Push Notifications
VAPID_PUBLIC_KEY=your-vapid-public-key
VAPID_PRIVATE_KEY=your-vapid-private-key

# File Storage
FILESYSTEM_DISK=public
```

### 🎨 Theme Configuration

#### Tailwind CSS Customization
```javascript
// tailwind.config.js
export default {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          500: '#3b82f6',
          600: '#2563eb',
          900: '#1e3a8a',
        },
        mobile: {
          primary: '#3b82f6',
          secondary: '#64748b',
        }
      }
    }
  }
}
```

#### Dark Mode Configuration
- **Class-based Toggle**: Uses `class` strategy for manual control
- **System Preference**: Automatically detects OS dark mode
- **Persistence**: Saves preference in localStorage
- **Component Support**: All UI components support dark mode

### 📱 PWA Configuration

#### Manifest Settings
```json
{
  "name": "Dr. Fintan Medical Consultation",
  "short_name": "Dr. Fintan",
  "display": "standalone",
  "orientation": "portrait-primary",
  "theme_color": "#3b82f6",
  "background_color": "#ffffff"
}
```

#### Service Worker Features
- **Offline Support**: Caches essential pages and assets
- **Background Sync**: Queues actions when offline
- **Push Notifications**: Handles notification display
- **Update Management**: Automatic updates with user notification

## 👤 Profile Management

### 🏠 Landing Page Profile Editing

#### Admin Profile Configuration
Location: `resources/views/frontend/home.blade.php`

```php
<!-- Admin Quick Actions -->
@if(Auth::check() && Auth::user()->role === 'admin')
<div class="admin-quick-edit">
    <button onclick="editSiteInfo()" class="edit-btn">
        <i class="fas fa-edit"></i> Edit Site Info
    </button>
</div>
@endif
```

#### Site Information Editing
- **Site Title**: Editable from admin dashboard
- **Hero Content**: Dynamic content management
- **Contact Information**: Real-time updates
- **Service Descriptions**: Rich text editing

### 📄 About Page Profile Editing

#### Doctor Profile Showcase
Location: `resources/views/frontend/about.blade.php`

```php
<!-- Doctor Profiles Section -->
<div class="doctors-section">
    @foreach($doctors as $doctor)
    <div class="doctor-card">
        @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->id === $doctor->user_id))
        <button onclick="editDoctorProfile({{ $doctor->id }})" class="edit-profile-btn">
            <i class="fas fa-edit"></i>
        </button>
        @endif
        
        <img src="{{ $doctor->profile_image_url }}" alt="{{ $doctor->name }}">
        <h3>{{ $doctor->name }}</h3>
        <p>{{ $doctor->specialization }}</p>
        <div class="bio">{{ $doctor->bio }}</div>
    </div>
    @endforeach
</div>
```

#### Editable Elements
- **Doctor Photos**: Upload and crop functionality
- **Specializations**: Multi-select specialization tags
- **Bio Information**: Rich text editor
- **Qualifications**: Dynamic list management
- **Contact Information**: Real-time validation

### 🔧 Profile Editing Functions

#### User Profile Controller
Location: `app/Http/Controllers/user/ProfileController.php`

Key Functions:
- `updateBasicInfo()`: Name, email, phone, address
- `updatePatientInfo()`: Medical history, allergies, emergency contacts
- `updateProfileImage()`: Image upload with validation
- `updatePassword()`: Secure password change

#### Doctor Profile Controller
Location: `app/Http/Controllers/doctor/ProfileController.php`

Key Functions:
- `updateDoctorInfo()`: Specializations, qualifications, experience
- `updateAvailability()`: Working hours and schedule
- `updateConsultationFee()`: Pricing management

## 🎥 Video Call Permissions & Mobile Support

### 📱 Mobile Video Call Setup

#### Permission Handling
```javascript
// Mobile video call permissions
async function requestVideoPermissions() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { 
                facingMode: 'user',
                width: { ideal: 1280 },
                height: { ideal: 720 }
            },
            audio: {
                echoCancellation: true,
                noiseSuppression: true,
                autoGainControl: true
            }
        });
        
        return { success: true, stream };
    } catch (error) {
        return { success: false, error: error.message };
    }
}
```

#### PWA Video Integration
- **Camera Access**: Automatic permission requests
- **Microphone Access**: Audio quality optimization
- **Screen Orientation**: Landscape mode for video calls
- **Background Handling**: Maintains connection during app switching

### 🔒 Security & Privacy
- **End-to-end Encryption**: All video calls encrypted
- **HIPAA Compliance**: Medical data protection
- **Session Recording**: Optional with consent
- **Access Logs**: Complete audit trail

## 🚀 Deployment Instructions

### 📦 Production Setup

1. **Server Requirements**
   - PHP 8.1+
   - MySQL 8.0+
   - Node.js 18+
   - SSL Certificate

2. **Installation Steps**
   ```bash
   git clone repository
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   php artisan key:generate
   php artisan migrate --force
   php artisan storage:link
   ```

3. **Performance Optimization**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan queue:work --daemon
   ```

## 🔧 Maintenance & Updates

### 📊 Monitoring
- **Application Logs**: Laravel log monitoring
- **Performance Metrics**: Response time tracking
- **Error Tracking**: Automated error reporting
- **User Analytics**: Usage pattern analysis

### 🔄 Regular Maintenance
- **Database Backups**: Daily automated backups
- **Security Updates**: Monthly security patches
- **Performance Reviews**: Quarterly optimization
- **Feature Updates**: Continuous deployment

## 📞 Support & Troubleshooting

### 🆘 Common Issues
- **Video Call Problems**: Check browser permissions
- **Mobile Installation**: Enable "Add to Home Screen"
- **Notification Issues**: Verify push notification settings
- **Payment Failures**: Check Paystack configuration

### 📧 Contact Information
- **Technical Support**: tech@drfintan.com
- **User Support**: support@drfintan.com
- **Emergency Contact**: emergency@drfintan.com

---

*This documentation is continuously updated. Last updated: [Current Date]*
