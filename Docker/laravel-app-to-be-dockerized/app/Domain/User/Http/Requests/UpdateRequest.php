<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 15:21
 */

namespace App\Domain\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class UpdateRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    public function rules(): array
    {
        return [
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
            'first_name' => __('First name'),
            'last_name' => __('Last name'),
        ];
    }
}
