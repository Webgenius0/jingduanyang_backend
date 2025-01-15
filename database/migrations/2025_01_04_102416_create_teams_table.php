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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialty');
            $table->string('experience');
            $table->string('phone_one');
            $table->string('phone_two')->nullable();
            $table->text('location')->nullable();
            $table->text('specializes')->nullable();
            $table->text('about')->nullable();
            $table->string('consult_duration')->nullable();
            $table->integer('total_fees');
            $table->string('image_url')->nullable();
            $table->integer('views')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
