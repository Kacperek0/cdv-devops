<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 11:36
 */

namespace App\Application\Services\Expense;


use App\Application\Exceptions\ExpenseException;
use Illuminate\Http\UploadedFile;

/**
 *
 */
interface ExpenseServiceContract
{
    /**
     * @param string $userId
     * @param string $bankId
     * @param UploadedFile $file
     * @throws ExpenseException
     */
    public function storeFromUploadedFile(string $userId, string $bankId, UploadedFile $file): void;
}
