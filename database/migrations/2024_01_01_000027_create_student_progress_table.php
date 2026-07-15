<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->decimal('average_score', 5, 2)->nullable();
            $table->integer('assignment_completion_rate')->nullable(); // percentage
            $table->integer('quiz_completion_rate')->nullable(); // percentage
            $table->decimal('attendance_percentage', 5, 2)->nullable();
            $table->integer('sessions_completed')->default(0);
            $table->integer('sessions_missed')->default(0);
            $table->text('overall_assessment')->nullable();
            $table->date('last_progress_update');
            $table->timestamps();
            $table->softDeletes();

            $table->index('student_id');
            $table->index('enrollment_id');
            $table->unique(['student_id', 'enrollment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_progress');
    }
};
