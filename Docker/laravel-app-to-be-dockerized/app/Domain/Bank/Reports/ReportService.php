<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 13:14
 */

namespace App\Domain\Bank\Reports;

use App\Domain\Bank\Reports\Contracts\ReportStrategyContract;
use App\Domain\Bank\Reports\Strategies\IpkoStrategy;
use App\Domain\Bank\Reports\Strategies\MbankStrategy;
use App\Infrastructure\Support\MoneyParser;
use Illuminate\Support\Facades\Validator;
use NumberFormatter;

/**
 *
 */
class ReportService implements ReportStrategyContract
{
    /**
     * @var array|string[]
     */
    public static array $strategies = [
        'mbank' => MbankStrategy::class,
        'ipko' => IpkoStrategy::class
    ];

    /**
     * @param ReportStrategyContract $strategy
     */
    public function __construct(private ReportStrategyContract $strategy)
    {

    }

    /**
     * @param ReportStrategyContract $strategy
     */
    public function setStrategy(ReportStrategyContract $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * @param string $data
     * @param string $format
     * @return array
     */
    public function decode(string $data, string $format): array
    {
        return $this->strategy->decode($data, $format);
    }

    /**
     * @return array
     */
    public function getAvailableDecoders(): array
    {
        return $this->strategy->getAvailableDecoders();
    }

    /**
     * @return array
     */
    public function getIgnored(): array
    {
        return $this->strategy->getIgnored();
    }

    /**
     * @param array $data
     * @return TransactionList
     */
    public function getTransactions(array $data): TransactionList
    {
        return $this->strategy->getTransactions($data);
    }

    /**
     * @param TransactionList $transactions
     * @return array
     */
    public function getCategories(TransactionList $transactions): array
    {
        return $this->strategy->getCategories($transactions);
    }

    /**
     * @param string $value
     * @return int
     */
    public static function parseAmount(string $value): int
    {
        $numberFormatter = new NumberFormatter('pl_PL', NumberFormatter::DECIMAL);
        $number = $numberFormatter->parse($value);

        return MoneyParser::fromFloat($number);
    }
}
