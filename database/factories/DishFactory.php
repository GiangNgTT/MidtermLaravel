<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'image' => '',
            'nameFood' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'price' => rand(100000, 10000000),  
            'category_id'=>rand(1, 3)
        ];
    }
}
