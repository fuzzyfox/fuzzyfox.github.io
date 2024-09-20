<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'icon' => (function () {
                $set = Arr::random(app(\BladeUI\Icons\Factory::class)->all());

                return $set['prefix'].'-'.Arr::random(File::files(Arr::random($set['paths'])))->getFilenameWithoutExtension();
            })(),
            'description' => $this->faker->text(),
            'start_year' => $this->faker->year(),
            'years_of_experience' => fn (array $attributes) => $this->faker->numberBetween(0, today()->year - ((int) $attributes['year'])) ?: null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
