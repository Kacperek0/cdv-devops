<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 21:25
 */

namespace App\Application\Rules;

use App\Application\Repositories\BankRepository;
use App\Domain\Bank\Entities\Bank;
use App\Domain\Bank\Reports\ReportService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

/**
 *
 */
class IsValidBankFile implements Rule
{
    /**
     * @param string|null $bankId
     */
    public function __construct(private ?string $bankId)
    {

    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!$value instanceof UploadedFile || !$this->bankId) {
            return false;
        }

        $extension = strtolower($value->getClientOriginalExtension());

        /**
         * @var Bank $bank
         */
        if (!$bank = app(BankRepository::class)->find($this->bankId)) {
            return false;
        }

        $reportService = new ReportService($bank->getReportStrategy());

        return in_array($extension, $reportService->getAvailableDecoders(), true);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('Invalid file type');
    }

}
