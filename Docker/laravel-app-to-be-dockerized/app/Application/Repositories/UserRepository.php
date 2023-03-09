<?php

namespace App\Application\Repositories;

use App\Domain\User\Entities\User;
use App\Infrastructure\Interfaces\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Application\Repositories;
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;
}
