# Dr. Fintan Medical Appointment System

Professional medical appointment system for Dr. Fintan Ekochin - Virtual consultations with fintan-style UI design.

## Features

- 🎨 **Fintan-Style UI Design** - Modern, clean interface matching the original fintan app
- 📱 **Responsive Design** - Works perfectly on desktop, tablet, and mobile
- 🌙 **Dark Mode Support** - Complete dark mode with proper color schemes
- 📅 **Smart Booking System** - Easy appointment scheduling with calendar interface
- 👨‍⚕️ **Dr. Fintan Profile** - Dedicated to Dr. Fintan Ekochin's practice
- 🔒 **Secure** - Built with Laravel security best practices
- ⚡ **Fast Performance** - Optimized for speed and user experience

## Technology Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Styling**: Inter Font + Fintan Design System
- **Icons**: Font Awesome + Lucide

## Design System

### Fintan Style Classes
- `.fintan-card` - Large cards with 8px padding
- `.fintan-card-sm` - Medium cards with 6px padding
- `.fintan-card-xs` - Small cards with 4px padding
- `.fintan-text-primary` - Main text colors
- `.fintan-text-secondary` - Secondary text colors
- `.fintan-btn-primary` - Primary buttons with gradients
- `.fintan-btn-secondary` - Secondary buttons with borders

### Color Scheme
- **Primary**: Blue-600 to Indigo-600 gradients
- **Font**: Inter (matching fintan app)
- **Dark Mode**: Proper gray-800 backgrounds with good contrast

## Installation

1. Clone the repository
```bash
git clone https://github.com/lord-dubious/dr-fintan-medical-appointment.git
cd dr-fintan-medical-appointment
```

2. Install dependencies
```bash
composer install
npm install
```

3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

4. Database setup
```bash
php artisan migrate
php artisan db:seed --class=DoctorSeeder
```

5. Start the development server
```bash
php artisan serve
```

## Pages

- **Home** (`/`) - Dr. Fintan's profile and practice overview
- **About** (`/about`) - Detailed information about Dr. Fintan
- **Contact** (`/contact`) - Contact form and information
- **Appointment** (`/appointment`) - Book consultations with Dr. Fintan

## Database

- **Dr. Fintan Ekochin** is the only doctor in the system
- **Department**: Integrative Medicine & Neurology
- **Specialties**: Complementary, Functional, Orthomolecular, and Lifestyle Medicine

## Contributing

This is a specialized medical appointment system for Dr. Fintan Ekochin's practice.

## License

Private project for Dr. Fintan Ekochin's medical practice.