<?php

namespace App\Domain\Category\Database\Factories;

use App\Domain\Category\Entities\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 *
 */
class CategoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Category::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'color' => $this->faker->hexColor()
        ];
    }
}
