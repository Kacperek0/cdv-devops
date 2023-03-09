<?php
/**
 * User: gmatk
 * Date: 22.06.2022
 * Time: 17:26
 */

namespace App\Domain\User\Http\Controllers\Auth;

use App\Application\Aggregations\User\UserAggregate;
use App\Application\Dto\User\UserDto;
use App\Application\Repositories\RoleRepository;
use App\Application\Repositories\UserRepository;
use App\Domain\User\Http\Requests\RegisterRequest;
use App\Domain\User\Http\Resources\UserResource;
use App\Interfaces\Http\Controllers\Controller;
use Illuminate\Support\Str;

/**
 *
 */
class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @return UserResource
     */
    public function register(
        RegisterRequest $request,
        UserRepository $userRepository,
        RoleRepository $roleRepository
    ): UserResource {
        $uuid = (string)Str::uuid();

        $dto = new UserDto($uuid, $request->input('email'), $request->input('password'));
        $dto->setFirstName($request->input('first_name'));
        $dto->setLastName($request->input('last_name'));
        $dto->setRoleId($roleRepository->getDefaultRole()->getKey());

        UserAggregate::retrieve($uuid)
            ->create($dto)
            ->persist();

        return new UserResource(
            $userRepository->findByEmail($dto->getEmail())
        );
    }
}
