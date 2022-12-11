<?php

namespace App\Domain\Category\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Application\Repositories\CategoryCouplingRepository;
use App\Domain\Category\Entities\CategoryCoupling;
use App\Application\Validators\CategoryCouplingValidator;

/**
 * Class CategoryCouplingRepositoryEloquent.
 *
 * @package namespace App\Temp\Repositories;
 */
class CategoryCouplingRepositoryEloquent extends BaseRepository implements CategoryCouplingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return CategoryCoupling::class;
    }

    /**
     * @param string $name
     * @return CategoryCoupling|null
     */
    public function findByName(string $name): ?CategoryCoupling
    {
        return $this->findByField('name', $name)->first();
    }

    /**
     * @param array $names
     * @return Collection
     */
    public function findByNames(array $names): Collection
    {
        return $this->findWhereIn('name', $names);
    }
}
