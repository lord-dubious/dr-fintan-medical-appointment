<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Clear existing data (PostgreSQL compatible)
        DB::table('doctors')->delete();
        DB::table('users')->where('role', 'doctor')->delete();

        // Create Dr. Fintan Ekochin - the only doctor
        $email = 'dr.fintan@medical.com';

        // First create the user account for Dr. Fintan
        $userId = DB::table('users')->insertGetId([
            'email' => $email,
            'password' => Hash::make('fintan123'), // Default password
            'role' => 'doctor',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Then create Dr. Fintan's doctor record
        DB::table('doctors')->insert([
            'user_id' => $userId,
            'name' => 'Dr. Fintan Ekochin',
            'mobile' => '+1 (555) 123-4567',
            'email' => $email,
            'department' => 'Integrative Medicine & Neurology',
            'availability' => 'available',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
