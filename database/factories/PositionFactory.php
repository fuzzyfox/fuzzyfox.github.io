<?php

namespace Database\Factories;

use App\Enums\PositionType;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'description' => $this->faker->text(),

            'type' => Arr::random(PositionType::cases()),

            'locality' => $this->faker->city(),
            'region' => $this->faker->countryCode(),

            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
