<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:51
 */

namespace App\Application\Events\Bank;

use App\Application\Dto\Bank\BankDto;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class BankCreated extends ShouldBeStored
{
    public function __construct(private BankDto $dto)
    {

    }

    /**
     * @return BankDto
     */
    public function getDto(): BankDto
    {
        return $this->dto;
    }
}
