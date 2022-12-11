<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 19:28
 */

namespace App\Domain\User\Providers;

use App\Domain\User\Entities\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

/**
 *
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return url(route('password.reset', [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ]));
        });
    }
}
