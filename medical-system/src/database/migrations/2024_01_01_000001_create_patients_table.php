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
            $table->string('names');
            $table->string('father_surname');
            $table->string('mother_surname');
            $table->string('dni')->unique();
            $table->date('birth_date');
            $table->string('gender');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('note')->nullable();
            $table->datetime('created');
            $table->datetime('modified');
            $table->integer('status')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};