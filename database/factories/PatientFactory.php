<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'dob' => $this->faker->date(),
            'risk_category' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'appointment_time' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
        ];
    }
}
