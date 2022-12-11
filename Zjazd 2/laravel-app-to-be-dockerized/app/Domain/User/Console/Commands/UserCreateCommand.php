<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 08:49
 */

namespace App\Domain\User\Console\Commands;

use App\Application\Repositories\RoleRepository;
use App\Application\Aggregations\User\UserAggregate;
use App\Application\Dto\User\UserDto;
use App\Domain\User\Validators\UserRules;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 *
 */
class UserCreateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:create';
    /**
     * @var string
     */
    protected $description = 'Create user from console';

    /**
     *
     */
    public function handle(RoleRepository $roleRepository): void
    {
        /**
         * @var Collection $roles
         */
        $roles = $roleRepository->all();

        $email = $this->ask('Email?');
        $password = $this->ask('Password?');
        $first_name = $this->ask('First name?');
        $last_name = $this->ask('Last name?');
        $role = $this->choice('Role?', $roles->pluck('name')->toArray());

        $params = compact(['email', 'password', 'first_name', 'last_name']);
        $params['password_confirmation'] = $password;

        $validator = Validator::make($params, UserRules::get());
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        $uuid = (string)Str::uuid();

        $dto = new UserDto($uuid, $email, $password);
        $dto->setLastName($last_name);
        $dto->setFirstName($first_name);
        $dto->setRoleId($roles->where('name', $role)->first()->getKey());

        UserAggregate::retrieve($uuid)->create($dto)->persist();

        $this->info('User created');
    }
}
