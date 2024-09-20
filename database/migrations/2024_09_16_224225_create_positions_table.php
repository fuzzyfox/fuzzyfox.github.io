<?php

use App\Enums\PositionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->text('description')->nullable();

            $table->string('type')->default(PositionType::DEFAULT->name);

            $table->string('locality')->nullable();
            $table->char('region', 2)->nullable();

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->timestamps();
        });

        Schema::create('position_skill', function (Blueprint $table) {
            $table->id();

            $table->foreignId('position_id')->constrained()->onDelete('cascade'); // Foreign key to positions table
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');    // Foreign key to skills table

            $table->timestamps();

            $table->unique(['position_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('position_skill');
        Schema::dropIfExists('positions');
    }
};
