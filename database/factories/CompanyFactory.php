<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory()->create(),
            'name' => $this->faker->unique()->name(),
            'phone' => $this->faker->unique()->numberBetween(1000000000, 9999999999),
            'whatsapp' => $this->faker->unique()->numberBetween(1000000000, 9999999999),
            'email' => $this->faker->unique()->email()
        ];
    }
}
