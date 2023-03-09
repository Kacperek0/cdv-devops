<?php

namespace App\Domain\Category\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Application\Repositories\CategoryRepository;
use App\Domain\Category\Entities\Category;
use App\Application\Validators\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Temp\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Category::class;
    }

    /**
     * @param string $name
     * @return Category|null
     */
    public function findByName(string $name): ?Category
    {
        return $this->findByField('name', $name)->first();
    }
}
