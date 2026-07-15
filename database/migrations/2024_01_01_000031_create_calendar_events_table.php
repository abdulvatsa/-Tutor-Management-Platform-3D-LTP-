<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->nullable()->constrained('enrollments')->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('google_calendar_event_id')->nullable();
            $table->string('location')->nullable();
            $table->enum('event_type', ['class', 'holiday', 'exam', 'meeting', 'training', 'other'])->default('class');
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_rule')->nullable(); // RRULE format
            $table->boolean('sync_with_google')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('enrollment_id');
            $table->index('teacher_id');
            $table->index('start_date');
            $table->index('event_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
