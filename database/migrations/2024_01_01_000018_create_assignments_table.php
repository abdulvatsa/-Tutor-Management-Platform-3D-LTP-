<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->text('instructions')->nullable();
            $table->dateTime('assigned_at');
            $table->dateTime('due_date');
            $table->dateTime('late_submission_deadline')->nullable();
            $table->integer('max_score')->default(100);
            $table->text('rubric')->nullable(); // JSON
            $table->string('attachment')->nullable();
            $table->enum('status', ['draft', 'published', 'due', 'submitted', 'graded', 'archived'])->default('draft');
            $table->boolean('allows_late_submission')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('enrollment_id');
            $table->index('teacher_id');
            $table->index('status');
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
