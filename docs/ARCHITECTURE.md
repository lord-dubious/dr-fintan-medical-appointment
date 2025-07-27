# ARCHITECTURE.md

## Tech Stack
- **Backend**: Laravel (PHP Framework)
- **Frontend**: Blade (Templating), JavaScript, CSS
- **Database**: MySQL/PostgreSQL (Eloquent ORM)
- **Video Conferencing**: Daily.co API
- **Payment Gateway**: Paystack API

## Directory Structure
```
dr-fintan-medical-appointment/
├── app/                  # Application core (Models, Http, Providers, Services, Console, Exceptions)
│   ├── Console/          # Artisan commands
│   ├── Exceptions/       # Custom exceptions
│   ├── Facades/          # Custom facades (e.g., Daily)
│   ├── Http/             # Controllers, Middleware, Requests
│   │   ├── Controllers/  # Application controllers (Admin, Doctor, Patient, API, Auth, Frontend)
│   │   ├── Middleware/   # HTTP middleware
│   ├── Models/           # Eloquent models
│   ├── Providers/        # Service providers
│   └── Services/         # Business logic and external service integrations (DailyService, PaystackService)
├── bootstrap/            # Framework bootstrap
├── config/               # Application configuration files
├── database/             # Database migrations, seeders, factories
│   ├── factories/        # Model factories for testing/seeding
│   ├── migrations/       # Database schema migrations
│   └── seeders/          # Database seeders for initial data
├── public/               # Publicly accessible assets (CSS, JS, images)
├── resources/            # Frontend assets (CSS, JS) and Blade views
│   ├── css/              # SCSS/CSS files
│   ├── js/               # JavaScript files
│   └── views/            # Blade templates (admin, doctor, user, frontend, layouts, components)
├── routes/               # Web, API, Console routes
├── storage/              # Application generated files (logs, cache, sessions)
├── tests/                # Automated tests (Feature, Unit)
├── .env                  # Environment configuration (local, staging, production)
├── .gitignore            # Git ignored files and directories
├── composer.json         # Composer dependencies (PHP)
├── package.json         # Node.js dependencies (Frontend)
└── README.md             # Project README
```

## Key Architectural Decisions
- **MVC Pattern**: The application strictly adheres to the Model-View-Controller architectural pattern, providing clear separation of concerns.
- **Service Layer**: Business logic for external integrations (Daily.co, Paystack) is encapsulated in a dedicated `Services` layer for reusability and testability.
- **Role-Based Access Control**: Middleware is used to enforce role-based access for Admin, Doctor, and Patient users, ensuring secure access to specific functionalities.
- **Modular Controllers**: Controllers are organized by user roles (admin, doctor, user) and functionality (API, auth, frontend) for better maintainability.
- **Blade Templating**: Laravel's Blade templating engine is used for rendering dynamic HTML content, promoting component reusability and cleaner views.

## Component Architecture

### Controllers (app/Http/Controllers/)
- **Admin**: `AdminController`, `AppointmentController`, `ContentController`, `DashboardController`, `DoctorController`, `MediaController`, `PatientController`, `SettingsController`
  - Manage system-wide configurations, users, and appointments.
- **Doctor**: `AppointmentController`, `DashboardController`, `ProfileController`
  - Manage doctor-specific appointments and profile settings.
- **User/Patient**: `AppointmentController`, `DashboardController`, `ProfileController`
  - Manage patient-specific appointments and profiles.
- **API**: `VideoConsultationController`
  - Handles API requests related to video consultations.
- **Auth**: `LoginController`
  - Manages user authentication.
- **Frontend**: `HomeController`
  - Handles public-facing pages.

### Models (app/Models/)
- `Appointment`: Manages appointment data and relationships.
- `Doctor`: Represents doctor profiles and associated data.
- `DoctorSchedule`: Manages doctor availability.
- `MediaLibrary`: Handles media file storage.
- `PageContent`: Manages static page content.
- `Patient`: Represents patient profiles.
- `SiteSetting`: Stores application-wide settings.
- `User`: Core user model with role-based extensions.

### Services (app/Services/)
- `DailyService`: Interacts with the Daily.co API for video call management.
- `PaystackService`: Integrates with Paystack for payment processing.

## System Flow Diagram
```
+----------------+       +-------------------+       +--------------------+
|     User       |------>|    Web Browser    |------>|  Laravel Frontend  |
| (Admin, Doctor,|       |                   |       |    (Blade Views)   |
|    Patient)    |<------|                   |<------|                    |
+----------------+       +-------------------+       +--------------------+
         |                                                    |
         | (HTTP/S Requests)                                  | (API Calls)
         v                                                    v
+-----------------------+                            +-------------------+
|   Laravel Backend     |                            |   Daily.co API    |
| (Controllers, Models, |<----------------------------| (Video Calls)     |
|       Services)       |---------------------------->|                   |
+-----------------------+                            +-------------------+
         |                                                    |
         | (Database Queries)                                 | (Payment Processing)
         v                                                    v
+-----------------------+                            +-------------------+
|   MySQL/PostgreSQL    |                            |   Paystack API    |
|     (Database)        |<----------------------------| (Payments)        |
+-----------------------+                            +-------------------+
```

## Common Patterns

### MVC Architecture
- **Models**: Responsible for data interaction (`app/Models/User.php`).
- **Views**: Handle presentation (`resources/views/`).
- **Controllers**: Process requests and interact with models and views (`app/Http/Controllers/`).

### Service Integration
- External APIs are abstracted behind service classes (`app/Services/DailyService.php`, `app/Services/PaystackService.php`).

### Middleware for Authorization
- Custom middleware (`app/Http/Middleware/AdminMiddleware.php`) ensures only authorized users access specific routes.
