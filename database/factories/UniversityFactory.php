<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        $universityName = $this->faker->company . ' University';
        return [
            'name' => $universityName,
            'website' => 'https://'.$this->faker->domainName,
            'country_id' => random_int(1,20),
        ];
    }
}
