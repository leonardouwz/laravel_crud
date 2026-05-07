<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('names', 155);
            $table->string('father_surname', 155);
            $table->string('mother_surname', 155);
            $table->string('dni', 20)->unique();
            $table->date('birth_date');
            $table->string('gender', 1);
            $table->text('address');
            $table->string('phone', 20);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};