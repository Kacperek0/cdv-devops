<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 19:58
 */

namespace App\Domain\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 *
 */
class ChangePasswordRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'current_password:api'
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
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'current_password' => __('Current Password'),
            'password' => __('Password'),
            'password_confirmation' => __('Confirm Password'),
        ];
    }
}
