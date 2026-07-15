<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('academic_level_id')->constrained('academic_levels')->cascadeOnDelete();
            $table->string('reference_number')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_hours');
            $table->integer('sessions_per_week');
            $table->enum('session_duration', ['30', '45', '60', '90'])->default('60'); // minutes
            $table->enum('class_type', ['one_on_one', 'small_group', 'online'])->default('one_on_one');
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->decimal('total_fees', 12, 2)->nullable();
            $table->text('learning_goals')->nullable();
            $table->text('special_requirements')->nullable();
            $table->enum('status', ['active', 'paused', 'completed', 'cancelled'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('reference_number');
            $table->index('student_id');
            $table->index('teacher_id');
            $table->index('subject_id');
            $table->index('status');
            $table->index('start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
