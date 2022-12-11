<?php

namespace App\Domain\Category\Database\Factories;

use App\Domain\Category\Entities\Category;
use App\Domain\Category\Entities\CategoryCoupling;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 *
 */
class CategoryCouplingFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = CategoryCoupling::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'category_id' => Category::factory()
        ];
    }
}
