<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 11:09
 */

namespace App\Domain\User\Validators;

use App\Domain\User\Entities\User;
use Illuminate\Validation\Rule;

class UserRules
{
    public static function get(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique(User::class)
            ],
            'password' => [
                'required',
                'min:8',
                'confirmed'
            ],
            'password_confirmation' => [
                'required',
                'min:8'
            ]
        ];
    }
}
