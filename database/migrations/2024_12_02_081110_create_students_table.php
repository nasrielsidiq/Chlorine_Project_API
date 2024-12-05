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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_id');
            $table->string('nisn',12)->unique();
            $table->string('profile_image')->default('default_image.png');
            $table->string('full_name');
            // $table->string('nisn', 12);
            $table->date('birth_day',);
            $table->text('address');
            //revisi ke bahasa inggris
            $table->string('major');
            $table->string('potency')->nullable();
            // $table->string('npsn',10);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
