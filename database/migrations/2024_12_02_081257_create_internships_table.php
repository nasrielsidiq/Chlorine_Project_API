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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->string('course')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('industry_id');
            $table->date('from');
            $table->date('to');
            $table->boolean('is_accepted')->default(false);
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('industry_id')->references('id')->on('industries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
