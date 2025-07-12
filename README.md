# Medical Appointment System

A comprehensive medical appointment management system built with Laravel 12, featuring multi-role authentication and complete appointment lifecycle management.

## 🚀 Features

### **Multi-Role Authentication**
- **Admin Dashboard**: Complete system management
- **Doctor Portal**: Appointment management and patient interaction
- **Patient Portal**: Appointment booking and history

### **Core Functionality**
- ✅ **Appointment Booking System** with availability checking
- ✅ **Real-time Status Management** (confirmed, pending, cancelled)
- ✅ **SMS Notifications** via Twilio integration
- ✅ **Doctor Availability Management**
- ✅ **Patient Management System**
- ✅ **Department-based Organization**
- ✅ **Responsive UI** with Tailwind CSS

### **Technical Features**
- ✅ **RESTful API** endpoints
- ✅ **Database Migrations** with sample data
- ✅ **Role-based Middleware** protection
- ✅ **Soft Deletes** for data integrity
- ✅ **Modern Frontend** with Vite build system

## 🛠️ Tech Stack

- **Backend**: Laravel 12 + PHP 8.2
- **Database**: SQLite (default) / MySQL compatible
- **Frontend**: Tailwind CSS 4.0 + Vite
- **SMS**: Twilio SDK
- **Package Manager**: PNPM

## 📋 Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- PNPM
- SQLite extension for PHP

## ⚡ Quick Setup

The system is already configured and ready to run! Just start the server:

```bash
# Start the development server
php artisan serve --host=0.0.0.0 --port=8000
```

Visit: `http://localhost:8000`

## 🔐 Default Login Credentials

### Admin Access
- **Email**: `admin@medical.com`
- **Password**: `password123`

### Doctor Access
- **Email**: `doctor1@medical.com` to `doctor5@medical.com`
- **Password**: `doctor123`

### Patient Access
- **Email**: `patient@medical.com`
- **Password**: `password123`

## 🏗️ Manual Setup (if needed)

If you need to set up from scratch:

```bash
# 1. Install PHP dependencies
php composer.phar install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Setup database
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# 4. Install frontend dependencies
pnpm install
pnpm run build

# 5. Start server
php artisan serve
```

## 🎯 System Overview

### **Database Schema**
- **Users**: Authentication and role management
- **Doctors**: Doctor profiles with specializations
- **Patients**: Patient information and history
- **Appointments**: Complete appointment lifecycle

### **User Roles & Permissions**

#### **Admin Dashboard** (`/admin`)
- View all appointments, doctors, and patients
- Manage doctor profiles and availability
- System-wide statistics and reporting
- User management and role assignment

#### **Doctor Portal** (`/doctor`)
- View assigned appointments
- Update appointment status
- Manage availability schedule
- Patient interaction history

#### **Patient Portal** (`/patient`)
- Book new appointments
- View appointment history
- Check appointment status
- Generate access tokens for API

## 🔗 API Endpoints

### **Authentication**
```bash
POST /api/generate-token    # Generate API access token
```

### **Web Routes**
```bash
GET  /                      # Homepage
GET  /appointment          # Public appointment booking
POST /appointment/store    # Store new appointment
GET  /login               # Login page
POST /login/auth          # Authenticate user
GET  /logout              # Logout user
```

### **Admin Routes** (Prefix: `/admin`)
```bash
GET  /dashboard           # Admin dashboard
GET  /doctors            # Manage doctors
GET  /patients           # Manage patients
GET  /appointments       # Manage appointments
```

### **Doctor Routes** (Prefix: `/doctor`)
```bash
GET  /dashboard          # Doctor dashboard
GET  /appointment        # View appointments
PUT  /appointments/{id}/status  # Update appointment status
```

### **Patient Routes** (Prefix: `/patient`)
```bash
GET  /dashboard          # Patient dashboard
GET  /appointment        # View appointments
GET  /book_appointment   # Book new appointment
POST /book_appointment/store  # Store appointment
```

## 🚀 Development Commands

### **Laravel Commands**
```bash
# Database operations
php artisan migrate:fresh --seed  # Reset database with sample data
php artisan db:seed               # Add sample data only

# Development server with all services
composer run dev                  # Runs server + queue + logs + vite

# Individual services
php artisan serve                 # Web server
php artisan queue:work           # Background jobs
php artisan pail                 # Real-time logs
```

### **Frontend Development**
```bash
pnpm run dev     # Development with hot reload
pnpm run build   # Production build
```

## 📱 SMS Integration (Twilio)

To enable SMS notifications:

1. **Get Twilio Credentials**
   - Sign up at [Twilio](https://www.twilio.com)
   - Get Account SID, Auth Token, and Phone Number

2. **Configure Environment**
   ```bash
   # Add to .env file
   TWILIO_SID=your_account_sid
   TWILIO_TOKEN=your_auth_token
   TWILIO_FROM=your_twilio_phone_number
   ```

3. **SMS Features**
   - Appointment confirmations
   - Reminder notifications
   - Status change alerts

## 🔧 Configuration

### **Database Configuration**
Default: SQLite (`database/database.sqlite`)

For MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical_appointment
DB_USERNAME=root
DB_PASSWORD=your_password
```

### **Mail Configuration**
```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
```

## 🎨 Customization

### **Adding New Departments**
Edit `database/seeders/DoctorSeeder.php`:
```php
$departments = [
    'Cardiology',
    'Your New Department',
    // ... more departments
];
```

### **Styling**
- Tailwind CSS classes in Blade templates
- Custom CSS in `resources/css/app.css`
- Build with `pnpm run build`

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter=AppointmentTest
```

## 📊 Sample Data

The system includes:
- **5 Doctors** across different specializations
- **3 User accounts** (admin, doctor, patient)
- **15 Medical departments**
- **Realistic appointment scenarios**

## 🔒 Security Features

- **Role-based Access Control** (RBAC)
- **CSRF Protection** on all forms
- **SQL Injection Prevention** via Eloquent ORM
- **Password Hashing** with bcrypt
- **Session Management** with database storage

## 📈 Production Deployment

1. **Environment Setup**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   ```

2. **Optimize for Production**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   pnpm run build
   ```

3. **Queue Workers**
   ```bash
   php artisan queue:work --daemon
   ```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🎉 You're All Set!

Your Medical Appointment System is now running at:
**http://localhost:8000**

Start exploring with the default credentials above! 🏥✨
