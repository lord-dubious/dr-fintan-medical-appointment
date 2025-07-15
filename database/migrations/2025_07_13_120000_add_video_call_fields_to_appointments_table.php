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
            $table->string('video_room_name')->nullable()->after('consultation_type');
            $table->timestamp('video_call_started_at')->nullable()->after('video_room_name');
            $table->timestamp('video_call_ended_at')->nullable()->after('video_call_started_at');
            $table->json('video_call_metadata')->nullable()->after('video_call_ended_at');
            $table->string('recording_id')->nullable()->after('video_call_metadata');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'video_room_name',
                'video_call_started_at',
                'video_call_ended_at',
                'video_call_metadata',
                'recording_id',
            ]);
        });
    }
};
