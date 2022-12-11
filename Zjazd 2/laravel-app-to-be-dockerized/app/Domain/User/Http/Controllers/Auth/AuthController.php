<?php
/**
 * User: gmatk
 * Date: 22.06.2022
 * Time: 12:29
 */

namespace App\Domain\User\Http\Controllers\Auth;

use App\Application\Events\User\UserVerified;
use App\Application\Repositories\UserRepository;
use App\Domain\User\Entities\User;
use App\Domain\User\Http\Resources\MeResource;
use App\Interfaces\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @return MeResource
     */
    public function me(): MeResource
    {
        return new MeResource(auth()->user());
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $token = auth()->user()->token();
        $token->revoke();

        return response()->json();
    }

    /**
     * @param string $id
     * @param string $token
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function verify(string $id, string $token, UserRepository $repository): JsonResponse
    {
        /**
         * @var User $user
         */
        if ((!$user = $repository->find($id)) || $user->hasVerifiedEmail()) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        if ($user->verification_token !== $token) {
            return response()->json(null, Response::HTTP_FORBIDDEN);
        }

        event(
            new UserVerified($user->getKey())
        );

        return response()->json();
    }
}
