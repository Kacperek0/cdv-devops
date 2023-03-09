<?php
/**
 * User: gmatk
 * Date: 26.06.2022
 * Time: 12:18
 */

namespace App\Domain\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseChartRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
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
        ];
    }
}
