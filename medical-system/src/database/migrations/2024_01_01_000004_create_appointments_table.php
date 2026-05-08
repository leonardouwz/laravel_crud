<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinical_history_id')->constrained('clinical_histories')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->datetime('appointment_date');
            $table->text('reason');
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->datetime('created');
            $table->datetime('modified');
            $table->integer('status')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};