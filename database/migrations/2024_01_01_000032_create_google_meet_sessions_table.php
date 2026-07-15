<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('google_meet_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_session_id')->constrained('class_sessions')->cascadeOnDelete();
            $table->string('meeting_code')->unique();
            $table->string('meeting_url');
            $table->string('meeting_id')->nullable();
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end');
            $table->dateTime('actual_start')->nullable();
            $table->dateTime('actual_end')->nullable();
            $table->integer('participant_count')->default(0);
            $table->string('recording_url')->nullable();
            $table->boolean('is_recorded')->default(false);
            $table->enum('status', ['created', 'started', 'ended', 'cancelled'])->default('created');
            $table->timestamps();
            $table->softDeletes();

            $table->index('class_session_id');
            $table->index('meeting_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('google_meet_sessions');
    }
};
