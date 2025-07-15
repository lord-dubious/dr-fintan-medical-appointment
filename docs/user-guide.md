# Medical Appointment Booking System User Guide

## Introduction
This guide provides comprehensive instructions for using the medical appointment booking system. It covers all user roles: Admin, Doctor, and Patient.

## Getting Started

### Registration and Login

The system supports registration and login for three user roles: Admin, Doctor, and Patient.

#### Admin Registration/Login:
- Admins can register via the admin registration page.
- Login using credentials provided by the system.
- Authentication is handled through the `LoginController`, which validates email and password.

#### Doctor Registration/Login:
- Doctors need to register using their medical license and personal details.
- Login after approval from the admin.
- The system checks the user's role and redirects them to the appropriate dashboard.

#### Patient Registration/Login:
- Patients can register using their email and personal information.
- Login to book appointments.
- The `LoginController` handles authentication and redirects patients to their dashboard.

## Admin Guide
### Dashboard Overview
The admin dashboard provides a comprehensive overview of system activities through various statistics and pending appointments.

#### Stats Cards
The dashboard displays key metrics through stats cards:
- **Total Appointments**: Shows total appointments and today's appointments count.
- **Pending Appointments**: Displays number of appointments awaiting approval.
- **Active Appointments**: Shows count of upcoming appointments.
- **Total Doctors**: Lists the number of registered doctors with a link to view all doctors.
- **Total Patients**: Displays the count of registered patients with a link to view all patients.
- **Expired/Cancelled**: Shows count of past or cancelled appointments.

#### Pending Appointments Table
The dashboard includes a detailed table listing pending appointments with the following information:
- **ID**: Appointment identification number.
- **Patient**: Name of the patient.
- **Doctor**: Name of the assigned doctor.
- **Department**: Department of the assigned doctor.
- **Date & Time**: Scheduled date and time of the appointment.
- **Status**: Current status of the appointment (displayed through a status badge).
- **Actions**: Buttons to **Approve** or **Reject** the appointment.

Admins can take immediate action on pending appointments directly from this table by approving or rejecting them. Upon taking action, the status is updated, and action buttons are replaced with a "Processed" label.

### Managing Doctors
- **Add Doctor**: Navigate to the Doctors section and fill in the required details.
- **Edit Doctor**: Select a doctor from the list and update their information.
- **View Doctor**: View detailed profiles and schedules.
- **Delete Doctor**: Remove a doctor from the system (requires confirmation).

### Managing Patients
- **View Patients**: List of all patients with options to view their profiles.
- **Manage Appointments**: View and update appointment statuses for patients.

### Managing Appointments
- **View Appointments**: List of all appointments with filters by date, status, etc.
- **Update Status**: Change appointment status (e.g., confirmed, canceled, completed).

### Managing Content
- **Pages**: Edit static pages like About, Contact, etc.
- **Settings**: Configure system settings such as working hours, holidays.

### Managing Media
- Upload and manage images, documents, and other media files used in the system.

## Doctor Guide

### Dashboard Overview
- View upcoming appointments, patient messages, and schedule.

### Managing Profile
- **Basic Information**: Update name, email, phone number, address, and bio.
- **Professional Information**: Manage specializations, qualifications, years of experience, license number, consultation fee, and languages spoken.
- **Working Hours**: Set your weekly schedule in JSON format.
- **Profile Image**: Upload or change your profile picture.
- **Security**: Update your account password.

### Profile Management Details
1. **Basic Information Tab**:
   - Update personal details such as full name, email address, phone number, address, and bio.
   - Save changes using the "Save Changes" button.

2. **Professional Information Tab**:
   - Manage your specializations and qualifications by adding or removing fields as needed.
   - Update years of experience, license number, and consultation fee.
   - List the languages you speak.
   - Save professional information using the "Save Professional Information" button.

3. **Working Hours Tab**:
   - Set your availability by providing a weekly schedule in JSON format.
   - Example format: `{"monday": {"start": "09:00", "end": "17:00"}, "tuesday": {"start": "09:00", "end": "17:00"}}`
   - Save working hours using the "Save Working Hours" button.

4. **Profile Image Tab**:
   - Click the camera icon on your current profile image to upload a new image.
   - The system supports various image formats.

5. **Security Tab**:
   - Update your password by entering your current password and confirming your new password.
   - Use the "Update Password" button to save changes.

### Viewing and Managing Appointments
- View list of appointments, filter by date or status.
- Confirm, reschedule, or cancel appointments.

### Conducting Video Consultations
- Access the video consultation room via the appointment details.
- Start the session at the scheduled time.

## Patient Guide
### Dashboard Overview
The Patient Dashboard provides an overview of the patient's appointment statistics and profile information. It displays cards showing total appointments, active appointments, and expired/cancelled appointments. The dashboard also includes a section for profile information, displaying the patient's name, phone number, and email.

#### Appointment Statistics
- **Total Appointments**: Displays the total number of appointments the patient has scheduled.
- **Active Appointments**: Shows the number of upcoming appointments.
- **Expired/Cancelled**: Indicates the number of past appointments that have expired or been cancelled.
- **Today's Appointments**: Highlights the number of appointments scheduled for the current day.

#### Profile Information
The profile information section displays:
- Patient's name
- Phone number
- Email address

This information is retrieved from the patient's profile data and the authenticated user details.

### Booking an Appointment
1. **Search Doctors**: Use the search function to find doctors by name, specialty, or availability.
2. **Check Availability**: View the doctor's calendar for open slots.
3. **Select Time**: Choose a suitable time slot.
4. **Payment Process**: Complete payment via Paystack to confirm the appointment.

### Managing Profile
- Update personal information, contact details, and medical history.

### Viewing and Managing Appointments
- List of current and past appointments.
- Cancel or reschedule appointments (if allowed).

### Joining Video Consultations
- Click the link in the appointment confirmation to join the video call.

## Payment Information

### Payment Methods
- **Credit/Debit Cards**: Major cards like Visa, Mastercard, and Verve are accepted.
- **Other Payment Methods**: Paystack supports additional payment methods such as bank transfers and mobile money.

### Payment Process
1. **Select Appointment**: Choose the appointment you wish to pay for.
2. **Proceed to Payment**: Click on the "Pay Now" button to initiate the payment process.
3. **Enter Payment Details**: Provide your card details or select another supported payment method.
4. **Confirm Payment**: Review the payment summary and confirm.

### Payment Confirmation
- Upon successful payment, a confirmation email is sent to the patient's registered email address.
- The appointment status is updated to "Confirmed" in the system.

### Troubleshooting Payment Issues
- **Failed Transactions**: If a transaction fails, check your card details or try another payment method.
- **Refunds**: Refunds for cancelled appointments are processed automatically within 5-7 business days.

## Troubleshooting/FAQ
### Common Issues
- **Issue 1**: Unable to login.  
  *Solution*: Check credentials or reset password.
- **Issue 2**: Payment failed.  
  *Solution*: Ensure card details are correct or try another payment method.
- **Issue 3**: Video consultation not starting.  
  *Solution*: Check internet connection and browser permissions.

### Local Development Setup

#### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or PostgreSQL database
- Daily.co account (for video/audio calls)
- Paystack account (for payment processing)

#### Steps to Set Up Locally
1. Clone the repository:
   ```bash
   git clone https://github.com/your-repo/medical_Appointment.git
   cd medical_Appointment
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install Node.js dependencies:
   ```bash
   npm install
   npm run dev # or npm run build for production
   ```
4. Copy `.env.example` and configure your environment:
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
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Run database migrations:
   ```bash
   php artisan migrate
   ```
7. Seed the database (optional, for demo data):
   ```bash
   php artisan db:seed
   ```
8. Link storage to public (for profile images, etc.):
   ```bash
   php artisan storage:link
   ```
9. Start the development server:
   ```bash
   php artisan serve
   ```
   The application will be accessible at `http://127.0.0.1:8000`.

#### Additional Information
- **Admin Panel:** Access at `/admin/dashboard` (default credentials can be found in database seeds or created manually).
- **Doctor Panel:** Access at `/doctor/dashboard`.
- **Patient Panel:** Access at `/user/dashboard`.
- **Appointment Booking:** Available on the frontend.

### Troubleshooting & FAQ

#### Common Issues

1. **Database Migration Errors**
   - **Issue:** Errors during database migration.
   - **Solution:** Check database credentials in `.env` file, ensure the database server is running, and verify migration files for syntax errors.

2. **Payment Processing Issues**
   - **Issue:** Payment fails or is not processed.
   - **Solution:** Verify Paystack API keys in `.env` file, check the Paystack dashboard for transaction status, and ensure the payment gateway is properly configured.

3. **Daily.co Video Call Issues**
   - **Issue:** Video call fails to connect or drops frequently.
   - **Solution:** Check Daily.co API key in `.env` file, ensure a stable internet connection, and verify browser permissions for camera and microphone access.

4. **Email Not Sending**
   - **Issue:** Emails (e.g., password reset, notifications) are not being sent.
   - **Solution:** Verify email configuration in `.env` file, check spam/junk folders, and ensure the email service (e.g., SMTP) is properly configured.

5. **Appointment Booking Errors**
   - **Issue:** Unable to book an appointment.
   - **Solution:** Check if the selected time slot is available, verify doctor's availability settings, and ensure all required fields are filled during booking.

#### Frequently Asked Questions

1. **Q: How do I reset my password?**
   A: Use the "Forgot Password" link on the login page to reset your password.

2. **Q: How do I book an appointment?**
   A: Navigate to the doctor's profile, select an available time slot, and follow the booking process.

3. **Q: How do I join a video consultation?**
   A: Go to your appointment details, click on the "Join Video Call" button, and allow browser permissions for camera and microphone access.

4. **Q: What payment methods are accepted?**
   A: We accept various payment methods through Paystack, including credit/debit cards and bank transfers.

5. **Q: How do I contact support?**
   A: Use the contact form on our website or email us at support@example.com.
