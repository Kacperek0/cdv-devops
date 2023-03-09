<?php

namespace App\Domain\Bank\Database\Factories;

use App\Domain\Bank\Entities\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 *
 */
class BankFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Bank::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true)
        ];
    }
}
