<?php

namespace App\Application\Repositories;

use App\Infrastructure\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface BankRepository.
 *
 * @package namespace App\Application\Repositories;
 */
interface BankRepository extends RepositoryInterface
{
    /**
     * @return Collection
     */
    public function active(): Collection;
}
