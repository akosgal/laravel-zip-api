<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\County;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\County>
 */
class CountyFactory extends Factory
{
    use RefreshDatabase;
		
    protected $model = County::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }
}
