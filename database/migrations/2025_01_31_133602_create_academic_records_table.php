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
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id('academic_record_id');
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('class_id')->constrained('classes', 'class_id')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('final_grade',5,2)->default(0);
            $table->string('semester');
            $table->string('school_year');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_records');
    }
};
