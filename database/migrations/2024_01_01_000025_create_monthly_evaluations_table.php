<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->year('evaluation_year');
            $table->integer('evaluation_month'); // 1-12
            $table->integer('academic_progress')->nullable(); // 1-5 rating
            $table->text('academic_progress_comments')->nullable();
            $table->integer('behaviour_rating')->nullable(); // 1-5 rating
            $table->text('behaviour_comments')->nullable();
            $table->integer('participation_rating')->nullable(); // 1-5 rating
            $table->text('participation_comments')->nullable();
            $table->integer('homework_completion')->nullable(); // 1-5 rating
            $table->text('homework_comments')->nullable();
            $table->integer('communication_rating')->nullable(); // 1-5 rating
            $table->text('communication_comments')->nullable();
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('goals_for_next_month')->nullable();
            $table->text('teacher_recommendations')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->boolean('sent_to_parent')->default(false);
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('student_id');
            $table->index('teacher_id');
            $table->index('enrollment_id');
            $table->index(['evaluation_year', 'evaluation_month']);
            $table->unique(['student_id', 'teacher_id', 'enrollment_id', 'evaluation_year', 'evaluation_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_evaluations');
    }
};
