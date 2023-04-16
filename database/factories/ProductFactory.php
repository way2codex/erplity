<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(15),
            'rate' => rand(700,1500),
            'category_id' => 1,
            'unit_type_id' => 1,
            'main_image' => $this->faker->imageUrl(200,200),
            'description' => $this->faker->realTextBetween(1,200)
        ];
    }
}
