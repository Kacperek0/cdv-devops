<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 09:57
 */

namespace App\Domain\Bank\Reports;

use Illuminate\Support\Facades\Validator;

/**
 *
 */
class TransactionValidator
{
    /**
     * @param array $transaction
     * @return bool
     */
    public function validate(array $transaction): bool
    {
        $validator = Validator::make($transaction, [
            'date' => [
                'required',
                'date'
            ],
            'description' => [
                'required',
            ],
            'category' => [
                'required',
            ],
            'amount' => [
                'required',
            ]
        ]);

        return !$validator->fails();
    }
}
