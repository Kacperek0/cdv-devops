<?php

namespace App\Application\Repositories;

use App\Domain\Category\Entities\Category;
use App\Infrastructure\Interfaces\RepositoryInterface;

/**
 * Interface CategoryRepository.
 *
 * @package namespace App\Application\Repositories;
 */
interface CategoryRepository extends RepositoryInterface
{
    public function findByName(string $name): ?Category;
}
