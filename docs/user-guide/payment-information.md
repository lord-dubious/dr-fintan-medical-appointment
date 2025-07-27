# Payment Information

This section provides comprehensive information on how payments are handled in the application.

## Setting Up Payment Gateways

### Configuring Paystack

To configure Paystack as a payment gateway, follow these steps:

1. Obtain your Paystack API keys from your Paystack dashboard.
2. Add the following configuration to your `.env` file:
   ```
   PAYSTACK_PUBLIC_KEY=your_public_key
   PAYSTACK_SECRET_KEY=your_secret_key
   PAYSTACK_PAYMENT_URL=https://api.paystack.co
   ```
3. Ensure that the `config/services.php` file contains the Paystack configuration:
   ```php
   'paystack' => [
       'public_key' => env('PAYSTACK_PUBLIC_KEY'),
       'secret_key' => env('PAYSTACK_SECRET_KEY'),
       'payment_url' => env('PAYSTACK_PAYMENT_URL'),
       'merchant_email' => env('PAYSTACK_MERCHANT_EMAIL'),
   ],
   ```

The `PaystackService` class handles the interaction with the Paystack API. It is used in the `AppointmentController` to initialize and verify payments.

### Other Payment Gateways

Information on other available payment gateways and how to configure them will be added soon.

## Making Payments

1.  **Booking Appointments with Payment**: How patients can book appointments that require payment.
2.  **Payment Confirmation**: How payments are confirmed and receipts are generated.

## Managing Payments

1.  **Viewing Payment History**: How users can view their payment history.
2.  **Handling Payment Issues**: Troubleshooting common payment issues.
