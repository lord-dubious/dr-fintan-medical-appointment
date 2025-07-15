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
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('consultation_type', ['video', 'audio'])->default('video')->after('appointment_time');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('consultation_type');
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->decimal('amount', 10, 2)->nullable()->after('payment_reference');
            $table->string('currency', 3)->default('USD')->after('amount');
            $table->json('payment_metadata')->nullable()->after('currency');
            $table->timestamp('payment_completed_at')->nullable()->after('payment_metadata');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'consultation_type',
                'payment_status',
                'payment_reference',
                'amount',
                'currency',
                'payment_metadata',
                'payment_completed_at',
            ]);
        });
    }
};
