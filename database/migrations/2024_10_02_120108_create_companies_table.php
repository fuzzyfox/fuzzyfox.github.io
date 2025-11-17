<?php

use App\Models\Company;
use App\Models\Position;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('url')->nullable();

            $table->string('locality')->nullable();
            $table->char('region', 2)->nullable();

            $table->string('logo')->nullable();

            $table->timestamps();
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id');
        });

        Position::lazyById()
            ->each(function (Position $position) {
                $company = Company::firstOrCreate(
                    ['name' => $position->company],
                    [
                        'slug' => \Illuminate\Support\Str::slug($position->company),
                        'url' => null,
                        'logo' => $position->logo,

                        'locality' => $position->locality,
                        'region' => $position->region,
                    ]
                );

                $position->company_id = $company->id;
                $position->save();
            });

        Schema::table('positions', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable(false)->change();
            $table->dropColumn('company');
            $table->dropColumn('logo');
        });
    }

    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->string('company')->nullable()->after('title');
            $table->string('logo')->nullable()->after('company');
        });

        Position::query()
            ->lazyById()
            ->each(function (Position $position) {
                $company = Company::findOrFail($position->company_id);

                DB::table((new Position)->getTable())
                    ->where('id', $position->id)
                    ->update([
                        'logo' => $company->logo,
                        'company' => $company->name,
                    ]);
            });

        Schema::table('positions', function (Blueprint $table) {
            $table->string('company')->nullable(false)->change();
        });

        Schema::dropColumns('positions', ['company_id']);

        Schema::dropIfExists('companies');
    }
};
