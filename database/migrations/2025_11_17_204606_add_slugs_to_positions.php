<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->string('slug')
                ->unique()
                ->nullable()
                ->after('title');
        });

        DB::transaction(fn () => DB::table('positions')
            ->get(['id', 'title'])
            ->each(
                fn (object $record) => DB::table('positions')
                    ->where('id', $record->id)
                    ->update(['slug' => Str::slug($record->title)])
            )
        );

        Schema::table('positions', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
