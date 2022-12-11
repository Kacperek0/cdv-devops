<?php

namespace App\Application\Repositories;

use App\Domain\Category\Entities\CategoryCoupling;
use App\Infrastructure\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CategoryCouplingRepository.
 *
 * @package namespace App\Application\Repositories;
 */
interface CategoryCouplingRepository extends RepositoryInterface
{
    /**
     * @param string $name
     * @return CategoryCoupling|null
     */
    public function findByName(string $name): ?CategoryCoupling;

    /**
     * @param array $names
     * @return Collection
     */
    public function findByNames(array $names): Collection;
}
