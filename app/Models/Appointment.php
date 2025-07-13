<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'department_id',
        'appointment_date',
        'appointment_time',
        'message',
        'status',
        'consultation_type',
        'payment_status',
        'payment_reference',
        'amount',
        'currency',
        'payment_metadata',
        'payment_completed_at'
    ];


    protected $casts = [
        'appointment_date' => 'date',  // Casts to Carbon instance
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'payment_metadata' => 'array',
        'payment_completed_at' => 'datetime',
        'amount' => 'decimal:2',
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
