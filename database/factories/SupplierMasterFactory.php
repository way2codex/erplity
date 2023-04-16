<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierMasterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail,
            'city'  => $this->faker->city,
            'pincode' => rand(111111,999999)
        ];
    }
}
