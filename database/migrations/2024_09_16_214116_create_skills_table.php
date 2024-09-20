<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parent_id')->nullable()->constrained('skills');

            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->integer('start_year')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('level')->nullable();

            $table->string('icon')->nullable();
            $table->string('color')->nullable();

            $table->boolean('is_promoted')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
