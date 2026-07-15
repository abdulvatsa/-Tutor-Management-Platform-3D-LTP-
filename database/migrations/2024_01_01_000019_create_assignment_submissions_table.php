<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->text('submission_content')->nullable();
            $table->string('submission_file')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->boolean('is_late')->default(false);
            $table->integer('score')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('teachers')->nullOnDelete();
            $table->enum('status', ['draft', 'submitted', 'graded', 'returned'])->default('draft');
            $table->timestamps();
            $table->softDeletes();

            $table->index('assignment_id');
            $table->index('student_id');
            $table->index('status');
            $table->unique(['assignment_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
