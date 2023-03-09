<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 20:31
 */

namespace App\Domain\User\Http\Requests;

use App\Application\Rules\IsValidBankFile;
use App\Domain\Bank\Entities\Bank;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreExpensesRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'bank' => [
                'required',
                Rule::exists(Bank::class, 'id')
                    ->where('active', true)
            ],
            'file' => [
                'required',
                'file',
                new IsValidBankFile($this->input('bank'))
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'file' => __('Plik')
        ];
    }
}
