<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 15:19
 */

namespace App\Domain\User\Http\Controllers\User;

use App\Application\Dto\User\UserUpdateDto;
use App\Application\Events\User\UserUpdated;
use App\Domain\User\Entities\User;
use App\Domain\User\Http\Requests\UpdateRequest;
use App\Domain\User\Http\Resources\UserResource;
use App\Interfaces\Http\Controllers\Controller;

/**
 *
 */
class UserController extends Controller
{
    /**
     * @param UpdateRequest $request
     * @return UserResource
     */
    public function update(UpdateRequest $request): UserResource
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        $dto = new UserUpdateDto(
            $user->getKey(),
            $request->input('first_name'),
            $request->input('last_name')
        );

        event(
            new UserUpdated($dto)
        );

        return new UserResource($user->fresh());
    }
}
