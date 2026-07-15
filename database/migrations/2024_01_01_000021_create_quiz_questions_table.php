<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->enum('question_type', ['multiple_choice', 'true_false', 'short_answer', 'essay', 'matching'])->default('multiple_choice');
            $table->text('question_text');
            $table->json('options')->nullable(); // For multiple choice
            $table->string('correct_answer')->nullable();
            $table->integer('points')->default(1);
            $table->text('explanation')->nullable();
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('quiz_id');
            $table->index('sequence');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
