<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_timesheet_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_timesheet_id')->constrained('teacher_timesheets')->cascadeOnDelete();
            $table->foreignId('class_session_id')->constrained('class_sessions')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('hours_worked'); // stored as minutes in DB for precision
            $table->decimal('hourly_rate', 10, 2);
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'included', 'excluded'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('teacher_timesheet_id');
            $table->index('class_session_id');
            $table->index('session_date');
            $table->unique(['teacher_timesheet_id', 'class_session_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_timesheet_items');
    }
};
