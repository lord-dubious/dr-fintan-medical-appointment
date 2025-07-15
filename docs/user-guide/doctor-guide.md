# Doctor Guide

## Profile Management

### Overview
The doctor profile section allows you to manage your professional information, working hours, and account settings.

### Navigation
To access your profile, navigate to the "My Profile" section in the doctor dashboard.

### Profile Tabs
The profile management is divided into several tabs:

1. **Basic Information**
   - Update your personal details such as name, email, phone number, and address.
   - Add a bio to provide more information about yourself.

2. **Professional Information**
   - List your specializations and qualifications.
   - Update your years of experience and license number.
   - Set your consultation fee.
   - List the languages you speak.

3. **Working Hours**
   - Define your weekly schedule in JSON format.

4. **Profile Image**
   - Upload a professional profile image.

5. **Security**
   - Update your account password.

### How to Use

1. **Updating Basic Information**
   - Navigate to the "Basic Information" tab.
   - Fill in the required fields.
   - Click "Save Changes" to update your information.

2. **Updating Professional Information**
   - Navigate to the "Professional Information" tab.
   - Add or edit your specializations, qualifications, years of experience, license number, and consultation fee.
   - Click "Save Professional Information" to update your details.

3. **Setting Working Hours**
   - Navigate to the "Working Hours" tab.
   - Enter your weekly schedule in JSON format. Example:
```json
{
  "monday": [
    {"start": "09:00", "end": "12:00"},
    {"start": "13:00", "end": "17:00"}
  ],
  "tuesday": [
    {"start": "09:00", "end": "12:00"},
    {"start": "13:00", "end": "17:00"}
  ]
}
```
   - Click "Save Working Hours" to update your availability.

4. **Uploading Profile Image**
   - Navigate to the "Profile Image" tab.
   - Click on the camera icon to upload a new image.
   - Select the image file from your device.

5. **Updating Password**
   - Navigate to the "Security" tab.
   - Enter your current password, new password, and confirm the new password.
   - Click "Update Password" to change your account password.

## Best Practices
- Ensure all information is accurate and up-to-date.
- Use a professional profile image.
- Regularly review and update your working hours to reflect your availability.

By following these instructions, you can effectively manage your profile and provide the best experience for your patients.