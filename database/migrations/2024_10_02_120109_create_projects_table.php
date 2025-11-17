<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();

            $table->string('name');
            $table->string('slug');
            $table->string('url')->nullable();
            $table->text('description')->nullable();

            $table->string('feature_image')->nullable();

            $table->string('header_image')->nullable();
            $table->string('header_color')->nullable();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->timestamps();
        });

        Schema::create('project_skill', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');

            $table->timestamps();

            $table->unique(['project_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_skill');
        Schema::dropIfExists('projects');
    }
};
