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
        Schema::create('psychologist_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('qualification')->nullable();
            $table->string('ahpra_registration_number')->nullable();
            $table->enum('therapy_mode', ['online', 'offline', 'both'])->default('both');
            $table->string('client_age')->nullable();
            $table->string('session_length')->nullable();
            $table->float('cust_per_session', 8, 2)->nullable();
            $table->float('medicare_rebate_amount', 8, 2)->nullable();
            $table->string('areas_of_expertise')->nullable();
            $table->string('aphra_certificate')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychologist_information');
    }
};
