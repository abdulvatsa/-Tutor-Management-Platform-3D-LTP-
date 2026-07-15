<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('resource_type', ['document', 'video', 'image', 'link', 'audio', 'interactive'])->default('document');
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('duration_minutes')->nullable(); // For videos
            $table->integer('view_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('subject_id');
            $table->index('teacher_id');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_resources');
    }
};
