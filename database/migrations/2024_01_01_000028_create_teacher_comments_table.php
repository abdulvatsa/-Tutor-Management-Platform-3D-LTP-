<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->text('comment');
            $table->enum('comment_type', ['general', 'academic', 'behaviour', 'attendance', 'progress'])->default('general');
            $table->boolean('visible_to_parent')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('student_id');
            $table->index('teacher_id');
            $table->index('enrollment_id');
            $table->index('comment_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_comments');
    }
};
