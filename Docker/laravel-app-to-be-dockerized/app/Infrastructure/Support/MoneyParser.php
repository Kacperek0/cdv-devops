<?php
/**
 * User: gmatk
 * Date: 22.02.2021
 * Time: 08:51
 */

namespace App\Infrastructure\Support;


use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;

/**
 * Class MoneyParser
 * @package App\Infrastructure\Support
 */
class MoneyParser
{
    /**
     * @param float $amount
     * @param Currency|null $currency
     * @return int
     */
    public static function fromFloat(float $amount, Currency $currency = null): int
    {
        $currency = $currency ?? new Currency('PLN');

        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);
        return $moneyParser->parse((string)$amount, $currency)->getAmount();
    }

    /**
     * @param int $money
     * @return float
     */
    public static function toFloat(int $money): float
    {
        return $money / 100;
    }
}
