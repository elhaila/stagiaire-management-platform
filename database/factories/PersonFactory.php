<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        $moroccanNames = ['Hamza','Youssef','Mohamed','Khalid','Omar','Fatima','Aicha','Zineb','Sara','Khadija'];
        $moroccanLastNames = ['El Amrani','Bennani','Belaid','Chakib','El Ghazali','Hassani','Jabari','Khalfi','Mansouri','Zouari'];

        return [
            'fullname' => $this->faker->randomElement($moroccanNames) . ' ' . $this->faker->randomElement($moroccanLastNames),
            'cin' => strtoupper($this->faker->bothify('??#####')),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('06########'),
        ];
    }
}
