<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->json('emergency_contact')->nullable()->after('user_id');
            $table->json('medical_history')->nullable()->after('emergency_contact');
            $table->json('insurance_info')->nullable()->after('medical_history');
            $table->json('preferences')->nullable()->after('insurance_info');
            $table->string('blood_type', 10)->nullable()->after('preferences');
            $table->text('allergies')->nullable()->after('blood_type');
            $table->text('current_medications')->nullable()->after('allergies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'emergency_contact',
                'medical_history',
                'insurance_info',
                'preferences',
                'blood_type',
                'allergies',
                'current_medications',
            ]);
        });
    }
};
