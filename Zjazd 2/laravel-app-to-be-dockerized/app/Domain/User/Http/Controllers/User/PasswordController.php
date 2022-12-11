<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 19:58
 */

namespace App\Domain\User\Http\Controllers\User;

use App\Application\Events\User\PasswordChanged;
use App\Domain\User\Http\Requests\ChangePasswordRequest;
use App\Interfaces\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class PasswordController extends Controller
{
    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function change(ChangePasswordRequest $request): JsonResponse
    {
        event(
            new PasswordChanged(
                $request->user()->getKey(),
                $request->input('password')
            )
        );

        return response()->json();
    }
}
