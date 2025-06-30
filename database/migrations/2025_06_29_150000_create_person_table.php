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
        Schema::create('person', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('national_id', 20)->unique();
            $table->date('date_of_birth');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('religion_id');
            $table->string('address', 255);
            $table->string('contact_number', 20);
            $table->string('email_address', 100);
            $table->timestamps();

            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('restrict');
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person');
    }
};
