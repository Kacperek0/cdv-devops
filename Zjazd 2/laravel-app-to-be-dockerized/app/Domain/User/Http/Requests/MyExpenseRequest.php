<?php
/**
 * User: gmatk
 * Date: 26.06.2022
 * Time: 12:13
 */

namespace App\Domain\User\Http\Requests;

use App\Infrastructure\Requests\ListingRequest;

/**
 *
 */
class MyExpenseRequest extends ListingRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'from' => [
                'required',
                'date',
                'before_or_equal:to'
            ],
            'to' => [
                'required',
                'date',
                'after_or_equal:from'
            ]
        ]);
    }
}
