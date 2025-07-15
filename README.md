# Medical Appointment and Video Consultation System

## Project Overview
This is a comprehensive web application designed to streamline the process of booking medical appointments and facilitating secure video consultations between patients and doctors. It provides a robust platform for managing appointments, user roles, and integrates essential services like video conferencing and online payments.

## Key Technologies
The application is built using the following core technologies:
*   **Laravel:** A powerful PHP framework for the backend logic and API development.
*   **Daily.co:** Integrated for real-time video and audio consultation capabilities.
*   **Paystack:** Used for secure and efficient online payment processing for appointments.
*   **Blade:** Laravel's templating engine for rendering dynamic frontend views.
*   **MySQL/PostgreSQL:** Relational databases for data storage.
*   **Composer:** PHP dependency management.
*   **Node.js & npm:** JavaScript runtime and package manager for frontend assets.

## Architectural Components
The application follows a standard Laravel MVC (Model-View-Controller) architecture with additional components:
*   **Routes:** Defines all application endpoints and maps them to corresponding controller actions.
*   **Controllers:** Handle incoming requests, process data, and interact with models and services before returning responses.
*   **Models:** Represent the data structure and business logic, interacting directly with the database.
*   **Middleware:** Filters HTTP requests entering the application, handling tasks like authentication, authorization, and request manipulation.
*   **Services:** Encapsulate complex business logic, such as Daily.co API interactions and Paystack payment processing, promoting reusability and separation of concerns.
*   **Views:** Responsible for presenting data to the user, primarily built using Laravel Blade templates.

## User Roles
The system supports three distinct user roles, each with specific functionalities and access levels:

### Admin
*   **Dashboard Overview:** Comprehensive view of total appointments, doctors, and patients.
*   **User Management:** Manage doctor and patient accounts, including creation, editing, and deletion.
*   **Appointment Oversight:** View and manage all appointments across the system.
*   **Site Settings:** Configure global application settings.
*   **Content Management:** Manage static pages and dynamic content.
*   **Media Library:** Organize and manage uploaded media files.
*   **Login as Doctor:** Ability to impersonate a doctor for administrative purposes.

### Doctor
*   **Personal Dashboard:** View and manage their own appointments.
*   **Profile Management:** Update personal information, medical specializations, and working hours.
*   **Appointment Management:** Accept, reject, reschedule, or complete appointments.
*   **Video Consultation Access:** Join scheduled video consultation rooms.

### Patient
*   **Personal Dashboard:** View and manage their booked appointments.
*   **Profile Management:** Update personal details.
*   **Appointment Booking:** Search for doctors and book appointments based on availability.
*   **Video Consultation Access:** Join scheduled video consultation rooms.
*   **Payment Processing:** Initiate and complete payments for appointments.

## Payment Integration (Paystack)
The application integrates with Paystack for secure and seamless payment processing.
*   **Service Class:** A dedicated service class (`app/Services/PaystackService.php` - *Note: This path is an assumption based on common Laravel practices and the task description. Actual path might vary.*) handles all interactions with the Paystack API, including initiating transactions, verifying payments, and handling callbacks.
*   **Controller Integration:** Payment logic is integrated into relevant controllers (e.g., `app/Http/Controllers/user/AppointmentController.php`) to manage the payment flow during appointment booking.
*   **Configuration:** Paystack API keys (public and secret) are securely stored in the `.env` file and accessed via Laravel's configuration system.
*   **Payment Flow:**
    1.  Patient books an appointment.
    2.  System initiates a payment request to Paystack.
    3.  Patient is redirected to Paystack's secure payment gateway.
    4.  Upon successful payment, Paystack redirects the patient back to the application with a payment reference.
    5.  The application verifies the payment status with Paystack and updates the appointment status accordingly.

## Other Significant Features
*   **Video Consultation:** Real-time video and audio calls powered by Daily.co, with dynamic room creation and secure token-based access.
*   **Appointment Management:** Comprehensive system for booking, tracking, and managing appointments with various statuses (pending, confirmed, cancelled, expired, completed).
*   **User Dashboards:** Dedicated dashboards for Admin, Doctor, and Patient roles providing tailored functionalities and overviews.
*   **Content Management:** Admin panel allows for managing static pages and dynamic content within the application.
*   **Media Library:** Integrated media management system for handling images and other files uploaded to the application.
*   **Doctor Scheduling:** Doctors can set and manage their availability and working hours.
*   **Email Notifications:** Automated email notifications for appointment confirmations, reminders, and other important events.

## Installation and Setup

### Prerequisites
*   PHP >= 8.1
*   Composer
*   Node.js & npm
*   MySQL or PostgreSQL database
*   Daily.co account (for video/audio calls)
*   Paystack account (for payment processing)

### Steps
1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-repo/medical_Appointment.git
    cd medical_Appointment
    ```
2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```
3.  **Install Node.js dependencies:**
    ```bash
    npm install
    npm run dev # or npm run build for production
    ```
4.  **Copy `.env.example` and configure your environment:**
    ```bash
    cp .env.example .env
    ```
    Edit the `.env` file with your database credentials, Daily.co API key, and Paystack API keys.
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=medical_appointment
    DB_USERNAME=root
    DB_PASSWORD=

    DAILY_API_KEY=your_daily_co_api_key
    DAILY_DOMAIN=your_daily_co_domain

    PAYSTACK_PUBLIC_KEY=your_paystack_public_key
    PAYSTACK_SECRET_KEY=your_paystack_secret_key
    PAYSTACK_PAYMENT_URL=https://api.paystack.co
    ```
5.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```
6.  **Run database migrations:**
    ```bash
    php artisan migrate
    ```
7.  **Seed the database (optional, for demo data):**
    ```bash
    php artisan db:seed
    ```
8.  **Link storage to public (for profile images, etc.):**
    ```bash
    php artisan storage:link
    ```
9.  **Start the development server:**
    ```bash
    php artisan serve
    ```
    The application will be accessible at `http://127.0.0.1:8000`.

## Usage
*   **Admin Panel:** Access at `/admin/dashboard` (default credentials can be found in database seeds or created manually).
*   **Doctor Panel:** Access at `/doctor/dashboard`.
*   **Patient Panel:** Access at `/user/dashboard`.
*   **Appointment Booking:** Available on the frontend.

## Security
If you discover any security vulnerabilities, please report them responsibly.

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
