<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->year('timesheet_year');
            $table->integer('timesheet_month'); // 1-12
            $table->integer('total_hours')->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected', 'paid'])->default('draft');
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('approval_notes')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('teacher_id');
            $table->index('status');
            $table->index(['timesheet_year', 'timesheet_month']);
            $table->unique(['teacher_id', 'timesheet_year', 'timesheet_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_timesheets');
    }
};
