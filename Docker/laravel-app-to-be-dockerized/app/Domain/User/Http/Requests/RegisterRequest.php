<?php
/**
 * User: gmatk
 * Date: 22.06.2022
 * Time: 17:36
 */

namespace App\Domain\User\Http\Requests;

use App\Domain\User\Entities\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 *
 */
class RegisterRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique(User::class)
            ],
            'password' => [
                'required',
                'confirmed',
                Password::defaults()
            ],
            'password_confirmation' => [
                'required',
                Password::defaults()
            ],
            'first_name' => [
                'required',
                'min:3'
            ],
            'last_name' => [
                'required',
                'min:3'
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'password' => __('Password'),
            'password_confirmation' => __('Confirm Password'),
            'first_name' => __('First name'),
            'last_name' => __('Last name'),
        ];
    }
}
