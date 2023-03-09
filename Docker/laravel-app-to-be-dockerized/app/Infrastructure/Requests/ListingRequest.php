<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 13:50
 */

namespace App\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class ListingRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    public function rules(): array
    {
        return [
            'page' => [
                'required',
                'integer',
                'min:1'
            ],
            'perPage' => [
                'required',
                'integer',
                'min:1',
                'max:100'
            ]
        ];
    }
}
