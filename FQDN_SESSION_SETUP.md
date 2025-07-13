# FQDN and Session Configuration Guide

## Overview
This guide explains the fixes implemented for FQDN handling and session persistence in the Dr. Fintan medical appointment application.

## Issues Fixed

### 1. FQDN Redirect Problems
- **Problem**: Login redirects used hardcoded URLs like `/patient/dashboard`
- **Solution**: Updated to use Laravel route helpers like `route('patient.dashboard')`
- **Impact**: Redirects now work correctly with any domain (localhost, FQDN, etc.)

### 2. Session Persistence Issues
- **Problem**: Sessions expired after 2 hours, no "remember me" functionality
- **Solution**: 
  - Increased session lifetime to 7 days (10080 minutes)
  - Added "remember me" checkbox to login form
  - Implemented persistent login functionality
- **Impact**: Users stay logged in longer and can choose persistent sessions

### 3. Navigation State Problems
- **Problem**: Navbar always showed login/register regardless of authentication status
- **Solution**: 
  - Added view composer to share authentication state globally
  - Updated navbar to show user profile when authenticated
  - Added dashboard links and logout option
- **Impact**: Better user experience with proper navigation state

## Configuration for FQDN

### Environment Variables (.env)
```env
# Application URL - Set to your FQDN
APP_URL=https://your-domain.com

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=10080  # 7 days in minutes
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null     # Leave null for automatic domain detection
SESSION_SECURE_COOKIE=null  # Will auto-detect HTTPS
```

### For HTTPS/SSL Sites
If using HTTPS, you may want to force secure cookies:
```env
SESSION_SECURE_COOKIE=true
```

### For Subdomain Support
If you need sessions to work across subdomains:
```env
SESSION_DOMAIN=.your-domain.com
```

## Features Added

### 1. Remember Me Functionality
- Checkbox on login form
- Extends session to browser's remember token
- Survives browser restarts when checked

### 2. Enhanced Navigation
- **Authenticated Users**: See profile icon, email, dashboard link, logout
- **Guest Users**: See login and register buttons
- **Mobile Responsive**: Proper mobile menu with authentication state

### 3. Role-Based Dashboard Access
- **Patients**: Direct link to patient dashboard
- **Doctors**: Direct link to doctor dashboard  
- **Admins**: Direct link to admin dashboard

## Testing Checklist

### Local Testing
- [ ] Login works with localhost
- [ ] Redirects work correctly
- [ ] Session persists across browser tabs
- [ ] Remember me functionality works
- [ ] Navbar shows correct state

### FQDN Testing
- [ ] Login works with full domain name
- [ ] Redirects include proper domain
- [ ] Sessions work across page refreshes
- [ ] HTTPS redirects work (if applicable)
- [ ] Cross-subdomain sessions work (if configured)

### User Experience Testing
- [ ] Profile dropdown works on desktop
- [ ] Mobile menu shows authentication state
- [ ] Dashboard links work for all roles
- [ ] Logout works and clears session
- [ ] Navigation state updates immediately

## Troubleshooting

### Sessions Not Persisting
1. Check database sessions table exists
2. Verify SESSION_DRIVER=database in .env
3. Ensure proper file permissions on storage/framework/sessions

### FQDN Redirects Not Working
1. Verify APP_URL matches your domain
2. Check web server configuration
3. Ensure TrustProxies middleware is configured

### Remember Me Not Working
1. Check users table has remember_token column
2. Verify checkbox name="remember" in login form
3. Check browser cookie settings

## Security Considerations

1. **Session Security**: Sessions are database-stored and encrypted
2. **CSRF Protection**: All forms include CSRF tokens
3. **Session Regeneration**: Sessions regenerated on login to prevent fixation
4. **Secure Cookies**: Automatically enabled for HTTPS sites
5. **Role-Based Access**: Middleware enforces proper role permissions

## Video Calling System

### Daily.co Integration
The application now uses a simplified Daily.co integration based on the working Daily Laravel repository with full appointment system integration:

#### Setup Daily.co API Key and Custom Domain
1. Sign up at [Daily.co](https://www.daily.co/)
2. Get your API key from the dashboard
3. **Set up custom domain** (recommended for branding):
   - Go to Daily.co dashboard → Domains
   - Add your custom domain (e.g., `yourcompany.daily.co`)
   - Follow DNS setup instructions
4. Add to your `.env` file:
```env
DAILY_API_KEY=your_daily_api_key_here
DAILY_DOMAIN=yourcompany.daily.co

# HTTPS Configuration (for production video calls)
FORCE_HTTPS=false
APP_DOMAIN=your-domain.com
```

#### HTTPS Requirements
- **Development**: Works on localhost with HTTP
- **Production**: Requires HTTPS for camera/microphone access
- **Browser Security**: Modern browsers block media access on HTTP (except localhost)
- **Automatic Detection**: System detects HTTPS and shows appropriate warnings

#### Video Call Features (Enhanced Implementation)
- ✅ **Custom Domain Branding**: Uses your Daily.co custom domain for professional appearance
- ✅ **Token-Based Security**: Secure meeting tokens with role-based permissions
- ✅ **Full Appointment Integration**: Video calls linked to specific appointments
- ✅ **Automatic Room Management**: Rooms named `consultation-{appointmentId}`
- ✅ **Session Tracking**: Start/end times recorded in appointment records
- ✅ **Recording Management**: Recording IDs stored with appointments
- ✅ **Payment Integration**: Video consultations ($75) vs regular ($45)
- ✅ **Role-Based Access**: Only appointment participants can join
- ✅ **Video and Audio Controls**: Device selection and management
- ✅ **Screen Sharing**: Full screen sharing capability
- ✅ **Background Blur**: Privacy-focused background effects
- ✅ **Real-time Chat**: In-call messaging system
- ✅ **HTTPS Support**: Automatic detection and warnings

#### Usage
- **Doctors**: Click "Video" button in appointment list
- **Patients**: Click "Video Call" button in appointment list
- **Opens in new window**: Dedicated video consultation interface
- **Automatic room creation**: Based on appointment ID (`consultation-{appointmentId}`)

#### Key Features
- **Device Management**: Camera and microphone selection
- **Recording Management**: Start/stop recording with download links
- **Chat System**: Real-time messaging during consultation
- **Screen Sharing**: Share screen during consultation
- **Background Effects**: Blur background for privacy

#### Appointment System Integration
- **Booking System**: Supports video/audio consultation types
- **Payment Processing**: Integrated with Paystack for video consultation fees
- **Database Tracking**: Full video call session tracking in appointments table
- **Status Management**: Automatic appointment status updates (pending → completed)
- **Access Control**: Only appointment participants (doctor/patient) can access rooms

#### Database Fields Added
```sql
video_room_name          # Daily.co room name
video_call_started_at    # When video call began
video_call_ended_at      # When video call ended
video_call_metadata      # Room URL and metadata
recording_id             # Daily.co recording ID
```

### Video Call Routes
```bash
# Web Routes
GET  /video-call/consultation/{appointmentId}  # Video consultation interface

# API Routes (matching Daily Laravel example)
POST /api/create-room                          # Create consultation room
POST /api/recording/start                      # Start recording
POST /api/recording/stop                       # Stop recording
POST /api/end-call                             # End call and update appointment
GET  /api/recording                            # List recordings
GET  /api/recording/{recordingId}              # Get recording access
```

## Maintenance

### Session Cleanup
Laravel automatically cleans up expired sessions. For manual cleanup:
```bash
php artisan session:table  # Create sessions table if needed
php artisan migrate        # Run migration
```

### Cache Clearing
After configuration changes:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```
