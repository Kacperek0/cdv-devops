<?php
/**
 * User: gmatk
 * Date: 22.06.2022
 * Time: 17:39
 */

namespace App\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

/**
 *
 */
class PasswordServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8)->letters()->numbers()->symbols();
        });

    }
}
