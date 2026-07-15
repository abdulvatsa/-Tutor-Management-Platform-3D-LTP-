<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('designation')->nullable();
            $table->text('testimonial');
            $table->string('image')->nullable();
            $table->integer('rating')->default(5); // 1-5
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_approved');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
