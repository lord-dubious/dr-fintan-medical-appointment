# DATA_MODEL.md

## Database Schema

### Overview
- **Database Type**: MySQL or PostgreSQL
- **ORM/ODM**: Eloquent ORM (Laravel)
- **Migration Tool**: Laravel Migrations (`php artisan migrate`)

### Entity Relationship Diagram
(Conceptual Diagram - actual relationships are defined in Eloquent models and migrations)
```
+---------+     +----------+     +------------+     +-----------+
|  Users  |<----|  Doctors |<----| Appointments |<----| Patients  |
| (id,...) |     | (id,...) |     | (id,...)   |     | (id,...)  |
+---------+     +----------+     +------------+     +-----------+
    ^                  |
    |                  v
    |           +----------------+
    |           | DoctorSchedules|
    |           | (id,doctor_id,)| 
    |           |   start_time)  | 
    +-----------+----------------+

+-------------+
| MediaLibrary|
| (id,...)    |
+-------------+

+-------------+
| PageContent |
| (id,...)    |
+-------------+

+-------------+
| SiteSetting |
| (id,...)    |
+-------------+
```

## Tables/Collections (from `database/migrations`)

### `users` Table (`0001_01_01_000000_create_users_table.php`)
```sql
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### `doctors` Table (`2025_03_21_153542_create_doctors_table.php`)
```sql
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` int(11) NOT NULL,
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consultation_fee` decimal(8,2) NOT NULL,
  `languages_spoken` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_user_id_unique` (`user_id`),
  CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### `patients` Table (`2025_03_21_153958_create_patients_table.php`)
```sql
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medical_history` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patients_user_id_unique` (`user_id`),
  CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### `appointments` Table (`2025_03_26_065712_create_appointments_table.php`)
```sql
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `daily_room_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily_room_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_patient_id_foreign` (`patient_id`),
  KEY `appointments_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Other Tables (briefly)
- `doctor_schedules`: Stores specific time slots for doctors.
- `media_libraries`: Manages uploaded media files.
- `page_contents`: Stores content for static pages.
- `site_settings`: General application settings.

## Application Models (Eloquent)

### `User` Model (`app/Models/User.php`)
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role' // Added role column for user types (admin, doctor, patient)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
}
```

### `Doctor` Model (`app/Models/Doctor.php`)
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'qualification',
        'experience',
        'license_number',
        'consultation_fee',
        'languages_spoken',
        'availability' // JSON field for working hours
    ];

    protected $casts = [
        'availability' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
```

### `Patient` Model (`app/Models/Patient.php`)
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'medical_history',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
```

### `Appointment` Model (`app/Models/Appointment.php`)
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'status',
        'daily_room_url',
        'daily_room_name',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
```

## Validation Rules

Laravel uses form requests and validation rules within controllers to handle data validation. Examples can be found in `app/Http/Requests/` (if implemented) or directly in controller methods.

### Example Validation (in a Controller)
```php
use Illuminate\Http\Request;

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|date_format:H:i',
    ]);

    // Process validated data
}
```

## Common Queries

Eloquent provides a powerful and expressive way to interact with the database.

### Example Eloquent Queries
```php
// Get all doctors with their associated user data
$doctors = Doctor::with('user')->get();

// Find a patient by user ID
$patient = Patient::where('user_id', $userId)->first();

// Get upcoming appointments for a doctor
$upcomingAppointments = Appointment::where('doctor_id', $doctorId)
    ->where('appointment_date', '>=', now()->toDateString())
    ->orderBy('appointment_date')
    ->orderBy('appointment_time')
    ->get();

// Create a new appointment
$appointment = Appointment::create([
    'patient_id' => $patientId,
    'doctor_id' => $doctorId,
    'appointment_date' => '2025-07-30',
    'appointment_time' => '10:00',
    'status' => 'pending',
]);
```

## Migrations

Laravel's migration system allows for version control of your database schema. Migration files are located in `database/migrations/`.

### Creating Migrations
```bash
php artisan make:migration create_something_table
```

### Running Migrations
```bash
php artisan migrate
```

### Rolling Back Migrations
```bash
php artisan migrate:rollback
php artisan migrate:reset
php artisan migrate:fresh # Drops all tables and re-runs all migrations
```

## Indexes and Performance

Laravel migrations allow defining indexes. Eloquent relationships are optimized for common query patterns.

### Example Indexes (from migrations)
- `users_email_unique` on `email` column in `users` table.
- `doctors_user_id_unique` on `user_id` column in `doctors` table.
- Foreign keys are implicitly indexed.

### Query Optimization Tips
1. Use `with()` for eager loading relationships to avoid N+1 query problems.
2. Use `select()` to retrieve only necessary columns.
3. Utilize database indexes effectively.
4. Cache query results where appropriate.

## Keywords <!-- #keywords -->
- database
- schema
- laravel models
- eloquent
- migrations
- queries
- validation
- data structure