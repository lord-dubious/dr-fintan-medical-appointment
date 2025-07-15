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
        Schema::table('doctors', function (Blueprint $table) {
            $table->json('specializations')->nullable()->after('department');
            $table->json('qualifications')->nullable()->after('specializations');
            $table->integer('experience_years')->nullable()->after('qualifications');
            $table->text('bio')->nullable()->after('experience_years');
            $table->decimal('consultation_fee', 10, 2)->nullable()->after('bio');
            $table->json('languages')->nullable()->after('consultation_fee');
            $table->string('license_number')->nullable()->after('languages');
            $table->json('working_hours')->nullable()->after('license_number');
            $table->boolean('is_verified')->default(false)->after('working_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'specializations',
                'qualifications',
                'experience_years',
                'bio',
                'consultation_fee',
                'languages',
                'license_number',
                'working_hours',
                'is_verified',
            ]);
        });
    }
};
