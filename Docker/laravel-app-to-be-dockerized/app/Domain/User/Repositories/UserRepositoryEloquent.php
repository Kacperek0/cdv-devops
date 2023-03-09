<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Application\Repositories\UserRepository;
use App\Application\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Temp\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->findByField('email', $email)->first();
    }
}
