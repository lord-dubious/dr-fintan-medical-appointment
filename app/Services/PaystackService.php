<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    private $secretKey;
    private $publicKey;
    private $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
        $this->publicKey = config('services.paystack.public_key');
    }

    /**
     * Initialize a payment transaction
     */
    public function initializePayment(array $data)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/transaction/initialize', [
                'email' => $data['email'],
                'amount' => $data['amount'] * 100, // Convert to kobo
                'reference' => $data['reference'],
                'callback_url' => $data['callback_url'],
                'metadata' => $data['metadata'] ?? [],
                'currency' => $data['currency'] ?? 'NGN',
            ]);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json()['data'],
                    'message' => 'Payment initialized successfully'
                ];
            }

            return [
                'status' => false,
                'message' => $response->json()['message'] ?? 'Payment initialization failed',
                'data' => null
            ];

        } catch (\Exception $e) {
            Log::error('Paystack initialization error: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Payment service unavailable',
                'data' => null
            ];
        }
    }

    /**
     * Verify a payment transaction
     */
    public function verifyPayment($reference)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
            ])->get($this->baseUrl . '/transaction/verify/' . $reference);

            if ($response->successful()) {
                $data = $response->json()['data'];
                return [
                    'status' => true,
                    'data' => $data,
                    'message' => 'Payment verification successful'
                ];
            }

            return [
                'status' => false,
                'message' => $response->json()['message'] ?? 'Payment verification failed',
                'data' => null
            ];

        } catch (\Exception $e) {
            Log::error('Paystack verification error: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Payment verification failed',
                'data' => null
            ];
        }
    }

    /**
     * Get payment URL for frontend
     */
    public function getPaymentUrl($reference, $amount, $email)
    {
        $result = $this->initializePayment([
            'email' => $email,
            'amount' => $amount,
            'reference' => $reference,
            'callback_url' => route('appointment.payment.callback'),
            'metadata' => [
                'appointment_reference' => $reference,
                'custom_fields' => [
                    [
                        'display_name' => 'Appointment Type',
                        'variable_name' => 'appointment_type',
                        'value' => 'Medical Consultation'
                    ]
                ]
            ]
        ]);

        if ($result['status']) {
            return $result['data']['authorization_url'];
        }

        return null;
    }

    /**
     * Validate webhook signature
     */
    public function validateWebhook($payload, $signature)
    {
        $computedSignature = hash_hmac('sha512', $payload, $this->secretKey);
        return hash_equals($signature, $computedSignature);
    }

    /**
     * Get public key for frontend
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Format amount for display
     */
    public function formatAmount($amount, $currency = 'NGN')
    {
        switch ($currency) {
            case 'NGN':
                return '₦' . number_format($amount, 2);
            case 'USD':
                return '$' . number_format($amount, 2);
            case 'GHS':
                return 'GH₵' . number_format($amount, 2);
            default:
                return $currency . ' ' . number_format($amount, 2);
        }
    }

    /**
     * Generate unique payment reference
     */
    public static function generateReference($prefix = 'PAY')
    {
        return $prefix . '_' . time() . '_' . strtoupper(substr(md5(uniqid()), 0, 8));
    }
}
