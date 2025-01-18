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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('psychologist_information_id')->constrained('psychologist_information')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('consultant_type');
            $table->date('appointment_date');
            $table->string('appointment_time');
            $table->string('available_day')->nullable();
            $table->string('available_times')->nullable();
            $table->string('meting_link')->nullable();
            $table->text('note')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'accept', 'completed','cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
