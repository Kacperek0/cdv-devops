<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:22
 */

namespace App\Domain\Category\Database\Seeders;

use App\Application\Repositories\CategoryRepository;
use App\Application\Aggregations\Category\CategoryAggregation;
use App\Application\Dto\Category\CategoryDto;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 *
 */
class CategorySeeder extends Seeder
{
    /**
     * @var array|\string[][]
     */
    protected array $categories = [
        [
            'name' => 'Bez kategorii'
        ],
        [
            'name' => 'Oszczędzanie'
        ],
        [
            'name' => 'Jedzenie na wynos'
        ],
        [
            'name' => 'Paliwo'
        ],
        [
            'name' => 'Zakupy codzienne'
        ],
        [
            'name' => 'Transport'
        ],
        [
            'name' => 'Sport i rekreacja'
        ],
        [
            'name' => 'Zdrowie i uroda'
        ],
        [
            'name' => 'Zakupy do domu/biura'
        ],
        [
            'name' => 'Imprezy i rozrywka'
        ],
        [
            'name' => 'Rachunki i opłaty'
        ],
        [
            'name' => 'Wypłaty z bankomatu'
        ],
        [
            'name' => 'Multimedia, książki i prasa'
        ],
        [
            'name' => 'Odzież i obuwie'
        ],
        [
            'name' => 'Prezenty i wsparcie'
        ],
        [
            'name' => 'Zwierzęta'
        ],
        [
            'name' => 'Alkohol'
        ],
        [
            'name' => 'Wynagrodzenia'
        ]
    ];

    /**
     * @param CategoryRepository $repository
     */
    public function __construct(private CategoryRepository $repository)
    {

    }

    /**
     *
     */
    public function run(): void
    {
        $faker = Factory::create(config('app.faker_locale'));

        foreach ($this->categories as $category) {
            if (!$this->repository->findByName($category['name'])) {
                $uuid = (string)Str::uuid();
                CategoryAggregation::retrieve($uuid)->create(
                    new CategoryDto(
                        $uuid,
                        $category['name'],
                        $category['color'] ?? $faker->unique()->hexColor()
                    )
                )->persist();
            }
        }

    }
}
