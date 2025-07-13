# 🏥 Medical Appointment System

A comprehensive medical appointment management system built with **Laravel 12**, featuring multi-role authentication, complete appointment lifecycle management, and modern responsive design.

![Laravel](https://img.shields.io/badge/Laravel-12-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/Database-MySQL-orange?style=flat-square&logo=mysql)
![Tailwind](https://img.shields.io/badge/CSS-Tailwind-38B2AC?style=flat-square&logo=tailwind-css)

## 🚀 Features

### **🔐 Multi-Role Authentication**
- **👨‍💼 Admin Dashboard**: Complete system management and oversight
- **👨‍⚕️ Doctor Portal**: Appointment management and patient interaction
- **🏥 Patient Portal**: Appointment booking and medical history

### **📅 Core Functionality**
- ✅ **Smart Appointment Booking** with real-time availability checking
- ✅ **Status Management** (pending, confirmed, cancelled)
- ✅ **SMS Notifications** via Twilio integration
- ✅ **Doctor Availability Management** with scheduling
- ✅ **Patient Management System** with medical records
- ✅ **Department-based Organization** (15+ specializations)
- ✅ **Image Upload** for patient profiles

### **⚡ Technical Features**
- ✅ **RESTful API** endpoints for external integration
- ✅ **Database Migrations** with comprehensive sample data
- ✅ **Role-based Middleware** protection
- ✅ **Soft Deletes** for data integrity
- ✅ **Modern Frontend** with Vite build system
- ✅ **Responsive Design** for all devices

## 🛠️ Tech Stack

| Component | Technology |
|-----------|------------|
| **Backend** | Laravel 12 + PHP 8.2 |
| **Database** | MySQL (Aiven Cloud) |
| **Frontend** | Tailwind CSS 4.0 + Vite |
| **SMS** | Twilio SDK |
| **Package Manager** | PNPM |
| **Authentication** | Laravel Sanctum |

## 📋 Prerequisites

- **PHP 8.2+** with extensions: `mysql`, `sqlite3`, `mbstring`, `xml`
- **Composer** for PHP dependency management
- **Node.js 18+** for frontend assets
- **PNPM** for package management
- **MySQL** database (cloud or local)

## ⚡ Quick Start

### **1. Clone & Install**
```bash
git clone https://github.com/lord-dubious/fintan-new.git
cd fintan-new
composer install
pnpm install
```

### **2. Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

### **3. Database Setup**
```bash
# Configure your database in .env file
php artisan migrate --seed
```

### **4. Build & Run**
```bash
pnpm run build
php artisan serve
```

Visit: **http://localhost:8000**

## 🔐 Default Login Credentials

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| **👨‍💼 Admin** | `admin@medical.com` | `password123` | Full system access |
| **👨‍⚕️ Doctor** | `doctor1@medical.com` | `doctor123` | Appointment management |
| **🏥 Patient** | `patient@medical.com` | `password123` | Booking & history |

*Note: 10 doctor accounts available (doctor1-doctor10@medical.com)*

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
