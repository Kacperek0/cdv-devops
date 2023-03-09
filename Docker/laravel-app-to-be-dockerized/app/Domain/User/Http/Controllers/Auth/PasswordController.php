<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 18:05
 */

namespace App\Domain\User\Http\Controllers\Auth;

use App\Application\Events\User\PasswordForgotten;
use App\Application\Events\User\PasswordReseted;
use App\Application\Exceptions\UserPasswordResetException;
use App\Application\Repositories\UserRepository;
use App\Domain\User\Http\Requests\ForgottenPasswordRequest;
use App\Domain\User\Http\Requests\PasswordResetRequest;
use App\Infrastructure\Support\Password;
use App\Interfaces\Http\Controllers\Controller;
use Hackzilla\PasswordGenerator\Exception\CharactersNotFoundException;
use Hackzilla\PasswordGenerator\Exception\ImpossibleMinMaxLimitsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 *
 */
class PasswordController extends Controller
{
    /**
     * @param ForgottenPasswordRequest $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function forgotten(ForgottenPasswordRequest $request, UserRepository $repository): JsonResponse
    {
        if (($user = $repository->findByEmail($request->input('email'))) && $user->hasVerifiedEmail()) {
            event(
                new PasswordForgotten(
                    $user->getKey(),
                    $user->email
                )
            );
        }

        return response()->json();
    }

    /**
     * @param PasswordResetRequest $request
     * @param UserRepository $repository
     * @return JsonResponse
     * @throws CharactersNotFoundException
     * @throws ImpossibleMinMaxLimitsException
     * @throws UserPasswordResetException
     */
    public function reset(PasswordResetRequest $request, UserRepository $repository): JsonResponse
    {

        try {
            if (!($user = $repository->findByEmail($request->input('email'))) || !$user->hasVerifiedEmail()) {
                return response()->json(null, Response::HTTP_FORBIDDEN);
            }

            event(
                new PasswordReseted(
                    $request->input('email'),
                    $request->input('token'),
                    Password::generate()
                )
            );
        } catch (UserPasswordResetException $exception) {
            return response()->json($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }

        return response()->json();
    }
}
