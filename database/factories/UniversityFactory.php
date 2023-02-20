<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company . ' University',
            'website' => $this->faker->safeEmailDomain,
            'country_id' => random_int(1,20),
        ];
    }
}
