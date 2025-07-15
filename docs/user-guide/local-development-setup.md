# Local Development Setup

This section provides step-by-step instructions on how to set up the project locally for development purposes.

## Prerequisites

1.  **PHP and Composer**: Ensure you have PHP and Composer installed on your system.
2.  **Node.js and npm**: Install Node.js and npm for frontend dependencies.
3.  **Database**: Set up a local database (e.g., MySQL).

## Cloning the Repository

1.  Clone the repository using Git: `git clone https://github.com/your-repo/medical-appointment.git`
2.  Navigate into the project directory: `cd medical-appointment`

## Installing Dependencies

1.  Install PHP dependencies: `composer install`
2.  Install npm dependencies: `npm install`

## Environment Configuration

1. Copy the `.env.example` file to `.env`: `cp .env.example .env`
2. Generate the application key: `php artisan key:generate`
3. Configure your database settings in the `.env` file. Ensure you set the `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` variables according to your local database setup.

## Running Migrations and Seeders

1. Run migrations to set up the database schema: `php artisan migrate`
2. Run seeders to populate the database with initial data: `php artisan db:seed`

## Serving the Application

1.  Start the Laravel development server: `php artisan serve`
2.  Access the application at `http://localhost:8000`

## Additional Configuration

1.  **Daily.co Integration**: Configure Daily.co API keys in the `.env` file.
2.  **Paystack Integration**: Configure Paystack API keys in the `.env` file.