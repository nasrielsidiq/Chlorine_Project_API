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
        Schema::create('vacancy_recommendations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('job_vacancies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancy_recommendations');
    }
};
