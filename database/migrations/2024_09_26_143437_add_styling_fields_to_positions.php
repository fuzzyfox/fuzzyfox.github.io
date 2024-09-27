<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->string('header_color')->nullable()->after('logo');
            $table->string('header_image')->nullable()->after('logo');
        });
    }

    public function down(): void
    {
        Schema::dropColumns('positions', ['header_color', 'header_image']);
    }
};
