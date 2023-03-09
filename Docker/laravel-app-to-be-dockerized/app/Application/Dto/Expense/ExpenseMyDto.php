<?php
/**
 * User: gmatk
 * Date: 26.06.2022
 * Time: 12:15
 */

namespace App\Application\Dto\Expense;

use Carbon\Carbon;

/**
 *
 */
class ExpenseMyDto
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     */
    public function __construct(private Carbon $from, private Carbon $to){

    }

    /**
     * @return Carbon
     */
    public function getFrom(): Carbon
    {
        return $this->from;
    }

    /**
     * @return Carbon
     */
    public function getTo(): Carbon
    {
        return $this->to;
    }
}
