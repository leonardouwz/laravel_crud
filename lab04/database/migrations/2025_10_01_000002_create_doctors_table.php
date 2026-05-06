<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('father_name', 155);
            $table->string('mother_name', 155);
            $table->string('father_surname', 155);
            $table->string('mother_surname', 155);
            $table->string('phone', 20);
            $table->string('specialty', 100);
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};