<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('behaviour_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->nullable()->constrained('enrollments')->nullOnDelete();
            $table->enum('incident_type', ['positive', 'negative', 'neutral'])->default('neutral');
            $table->string('title');
            $table->text('description');
            $table->date('incident_date');
            $table->string('action_taken')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('parent_notified')->default(false);
            $table->dateTime('notified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('student_id');
            $table->index('teacher_id');
            $table->index('incident_type');
            $table->index('incident_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('behaviour_reports');
    }
};
