<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    protected $model = \App\Models\University::class;

    public function definition(): array
    {
        $unis = [
            ['name' => 'Cadi Ayyad University', 'city' => 'Marrakech'],
            ['name' => 'Mohammed V University', 'city' => 'Rabat'],
            ['name' => 'Hassan II University', 'city' => 'Casablanca'],
            ['name' => 'Ibn Zohr University', 'city' => 'Agadir'],
            ['name' => 'Sidi Mohamed Ben Abdellah University', 'city' => 'Fes'],
        ];

        return $this->faker->randomElement($unis);
    }
}

