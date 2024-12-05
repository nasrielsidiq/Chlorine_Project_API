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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('industry_id');
            // $table->string('npsn');
            $table->string('name');
            $table->string('course');
            $table->date('date');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('industry_id')->references('id')->on('industries')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
