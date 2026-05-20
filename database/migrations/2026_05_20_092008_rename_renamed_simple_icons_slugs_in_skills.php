<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('skills')->where('icon', 'si-d3dotjs')->update(['icon' => 'si-d3']);
        DB::table('skills')->where('icon', 'si-heroku')->update(['icon' => null]);
    }

    public function down(): void
    {
        DB::table('skills')->where('icon', 'si-d3')->update(['icon' => 'si-d3dotjs']);
    }
};
