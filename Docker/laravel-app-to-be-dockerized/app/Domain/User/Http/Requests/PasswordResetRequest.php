<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 18:23
 */

namespace App\Domain\User\Http\Requests;

use App\Domain\User\Entities\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasswordResetRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists(User::class)
            ],
            'token' => [
                'required'
            ]
        ];
    }
}
