<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 11:17
 */

namespace App\Domain\User\Services;

use App\Application\Dto\Expense\ExpenseDto;
use App\Application\Events\Expense\ExpenseCreated;
use App\Application\Exceptions\ExpenseException;
use App\Application\Repositories\BankRepository;
use App\Application\Repositories\CategoryCouplingRepository;
use App\Application\Services\Expense\ExpenseServiceContract;
use App\Domain\Bank\Entities\Bank;
use App\Domain\Bank\Reports\Dto\TransactionDto;
use App\Domain\Bank\Reports\ReportService;
use App\Domain\Bank\Reports\TransactionListModifier;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 *
 */
class ExpenseService implements ExpenseServiceContract
{
    /**
     * @param BankRepository $bankRepository
     * @param CategoryCouplingRepository $categoryCouplingRepository
     */
    public function __construct(
        private BankRepository $bankRepository,
        private CategoryCouplingRepository $categoryCouplingRepository
    ) {

    }

    /**
     * @param string $userId
     * @param string $bankId
     * @param UploadedFile $file
     */
    public function storeFromUploadedFile(string $userId, string $bankId, UploadedFile $file): void
    {
        DB::transaction(function () use ($userId, $bankId, $file) {
            /**
             * @var Bank $bank
             */
            $bank = $this->bankRepository->find($bankId);
            $reportService = new ReportService($bank->getReportStrategy());
            $transactions = TransactionListModifier::getExpenses($reportService->getTransactions(
                $reportService->decode(
                    $file->getContent(),
                    strtolower($file->getClientOriginalExtension())
                )
            ));

            if (count($transactions->getTransactions()) === 0) {
                throw new ExpenseException(__('No new expenses found!'));
            }

            $categories = $reportService->getCategories($transactions);
            $couplings = $this
                ->categoryCouplingRepository
                ->findByNames($categories);

            /**
             * @var TransactionDto $transaction
             */
            foreach ($transactions->getTransactions() as $transaction) {
                $dto = new ExpenseDto(
                    (string)Str::uuid(),
                    $transaction->getName(),
                    abs($transaction->getAmount()),
                    $userId, $bankId,
                    $transaction->getDate()
                );
                $dto->setData($transaction->toArray());

                if ($coupling = $couplings->where('name', $transaction->getCategory())->first()) {
                    $dto->setCategoryId($coupling->category_id);
                }

                event(
                    new ExpenseCreated($dto)
                );
            }
        });
    }
}
