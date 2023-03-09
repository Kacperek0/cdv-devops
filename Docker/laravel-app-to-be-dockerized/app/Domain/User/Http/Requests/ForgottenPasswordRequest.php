<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 18:07
 */

namespace App\Domain\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class ForgottenPasswordRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email'
            ]
        ];
    }
}
