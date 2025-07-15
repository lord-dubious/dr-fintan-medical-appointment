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
        Schema::create('media_library', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('original_name');
            $table->string('file_path', 500);
            $table->integer('file_size');
            $table->string('mime_type', 100);
            $table->string('alt_text')->nullable();
            $table->string('category', 50)->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['category', 'is_public']);
            $table->index('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_library');
    }
};
