<?php

namespace Database\Factories;

use App\DiscountType;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    protected $model = Discount::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->bothify('DISCOUNT##??')),
            'type' => $this->faker->randomElement([DiscountType::Fixed, DiscountType::Percentage]),
            'value' => $this->faker->numberBetween(5, 50),
            'max_usage' => $this->faker->numberBetween(10, 100),
            'used_count' => $this->faker->numberBetween(0, 10),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
