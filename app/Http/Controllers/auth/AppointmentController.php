<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AppointmentController extends Controller
{
    //
    public function index()
    {
        // Fetch all departments and doctors from the database
        $doctors = Doctor::all();

        // Pass the data to the view
        return view('auth.appointment', compact('doctors'));
    }

    // Check Doctor`s availability
    public function checkAvailability(Request $request)
    {
        $doctorId = $request->query('doctor_id');
        $date = $request->query('date');
        $time = $request->query('time');

        $exists = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->where('appointment_time', $time)
            ->exists();

        if ($exists) {
            return response()->json([
                'available' => false,
                'message' => 'The selected doctor is not available at that time. Please choose another time.',
            ]);
        }

        return response()->json(['available' => true]);
    }

    public function store(Request $request)
    {
        // Validate the request
        try {
            $validatedData = $request->validate([
                'patient_name' => 'required|string',
                'phone' => 'required|string|unique:patients,mobile',
                'doctor' => 'required|exists:doctors,id',
                'date' => 'required|date',
                'time' => 'required|string',
                'email' => 'required|email|unique:users,email|unique:patients,email',
                'password' => 'required|string|min:8',
                'message' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }

        // 🛡️ Check if doctor is available
        $doctorIsTaken = Appointment::where('doctor_id', $request->doctor)
            ->where('appointment_date', $request->date)
            ->where('appointment_time', $request->time)
            ->exists();

        if ($doctorIsTaken) {
            return response()->json([
                'success' => false,
                'message' => 'The selected doctor is not available at this time. Please choose another time.',
            ], 409); // 409 Conflict
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a new user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
            ]);

            // Handle image upload
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'_'.$image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
            }

            // Create a new patient
            $patient = Patient::create([
                'name' => $request->patient_name,
                'mobile' => $request->phone,
                'email' => $request->email,
                'image' => $imageName,
                'user_id' => $user->id,
            ]);

            // Create the appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor,
                'appointment_date' => $request->date,
                'appointment_time' => $request->time,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'redirect' => '/login',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error booking appointment: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while booking the appointment. Please try again.',
            ], 500);
        }
    }

    /**
     * Initialize payment for appointment
     */
    public function initializePayment(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'patient_name' => 'required|string',
                'phone' => 'required|string',
                'doctor' => 'required|exists:doctors,id',
                'date' => 'required|date',
                'time' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string|min:8',
                'message' => 'nullable|string',
                'consultation_type' => 'required|in:video,audio',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Check if doctor is available
            $doctorIsTaken = Appointment::where('doctor_id', $request->doctor)
                ->where('appointment_date', $request->date)
                ->where('appointment_time', $request->time)
                ->where('payment_status', '!=', 'failed')
                ->exists();

            if ($doctorIsTaken) {
                return response()->json([
                    'success' => false,
                    'message' => 'The selected doctor is not available at this time. Please choose another time.',
                ], 409);
            }

            // Calculate amount based on consultation type
            $amount = $request->consultation_type === 'video' ? 75 : 45;

            // Generate payment reference
            $reference = PaystackService::generateReference('APPT');

            // Store appointment data in session for later use
            session([
                'appointment_data' => [
                    'patient_name' => $request->patient_name,
                    'phone' => $request->phone,
                    'doctor' => $request->doctor,
                    'date' => $request->date,
                    'time' => $request->time,
                    'email' => $request->email,
                    'password' => $request->password,
                    'message' => $request->message,
                    'consultation_type' => $request->consultation_type,
                    'amount' => $amount,
                    'reference' => $reference,
                    'image' => $request->hasFile('image') ? $request->file('image') : null,
                ],
            ]);

            // Initialize payment with Paystack
            $paystackService = new PaystackService;
            $paymentUrl = $paystackService->getPaymentUrl($reference, $amount, $request->email);

            if ($paymentUrl) {
                return response()->json([
                    'success' => true,
                    'payment_url' => $paymentUrl,
                    'reference' => $reference,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to initialize payment. Please try again.',
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Payment initialization error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while initializing payment. Please try again.',
            ], 500);
        }
    }

    /**
     * Handle payment callback from Paystack
     */
    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (! $reference) {
            return redirect()->route('appointment')->with('error', 'Invalid payment reference.');
        }

        $paystackService = new PaystackService;
        $verification = $paystackService->verifyPayment($reference);

        if ($verification['status'] && $verification['data']['status'] === 'success') {
            // Payment successful, create appointment
            $appointmentData = session('appointment_data');

            if (! $appointmentData || $appointmentData['reference'] !== $reference) {
                return redirect()->route('appointment')->with('error', 'Invalid session data.');
            }

            DB::beginTransaction();
            try {
                // Create user
                $user = User::create([
                    'email' => $appointmentData['email'],
                    'password' => Hash::make($appointmentData['password']),
                    'role' => 'patient',
                ]);

                // Handle image upload
                $imageName = null;
                if (isset($appointmentData['image']) && $appointmentData['image']) {
                    $image = $appointmentData['image'];
                    $imageName = time().'_'.$image->getClientOriginalName();
                    $image->storeAs('public/images', $imageName);
                }

                // Create patient
                $patient = Patient::create([
                    'name' => $appointmentData['patient_name'],
                    'mobile' => $appointmentData['phone'],
                    'email' => $appointmentData['email'],
                    'image' => $imageName,
                    'user_id' => $user->id,
                ]);

                // Create appointment
                $appointment = Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $appointmentData['doctor'],
                    'appointment_date' => $appointmentData['date'],
                    'appointment_time' => $appointmentData['time'],
                    'message' => $appointmentData['message'],
                    'consultation_type' => $appointmentData['consultation_type'],
                    'amount' => $appointmentData['amount'],
                    'currency' => 'USD',
                    'payment_status' => 'paid',
                    'payment_reference' => $reference,
                    'payment_metadata' => $verification['data'],
                    'payment_completed_at' => now(),
                    'status' => 'pending',
                ]);

                DB::commit();

                // Clear session data
                session()->forget('appointment_data');

                return redirect()->route('appointment')->with('success', 'Appointment booked successfully! Payment completed.');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Appointment creation error after payment: '.$e->getMessage());

                return redirect()->route('appointment')->with('error', 'Payment successful but appointment creation failed. Please contact support.');
            }
        } else {
            return redirect()->route('appointment')->with('error', 'Payment verification failed. Please try again.');
        }
    }

    /**
     * Handle Paystack webhook
     */
    public function paystackWebhook(Request $request)
    {
        $paystackService = new PaystackService;
        $signature = $request->header('X-Paystack-Signature');
        $payload = $request->getContent();

        if (! $paystackService->validateWebhook($payload, $signature)) {
            return response('Invalid signature', 400);
        }

        $event = json_decode($payload, true);

        if ($event['event'] === 'charge.success') {
            $reference = $event['data']['reference'];

            // Update appointment payment status
            $appointment = Appointment::where('payment_reference', $reference)->first();
            if ($appointment && $appointment->payment_status === 'pending') {
                $appointment->update([
                    'payment_status' => 'paid',
                    'payment_completed_at' => now(),
                    'payment_metadata' => $event['data'],
                ]);
            }
        }

        return response('OK', 200);
    }
}
