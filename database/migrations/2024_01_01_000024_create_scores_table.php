<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->enum('score_type', ['assignment', 'quiz', 'project', 'test', 'class_participation', 'other']);
            $table->string('title');
            $table->integer('score_obtained');
            $table->integer('max_score')->default(100);
            $table->decimal('percentage', 5, 2);
            $table->string('grade')->nullable(); // A, B, C, etc.
            $table->text('remarks')->nullable();
            $table->date('score_date');
            $table->timestamps();
            $table->softDeletes();

            $table->index('student_id');
            $table->index('enrollment_id');
            $table->index('score_type');
            $table->index('score_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
