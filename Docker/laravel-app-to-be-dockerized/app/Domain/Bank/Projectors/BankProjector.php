<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:52
 */

namespace App\Domain\Bank\Projectors;

use App\Domain\Bank\Entities\Bank;
use App\Application\Events\Bank\BankCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

/**
 *
 */
class BankProjector extends Projector
{
    /**
     * @param BankCreated $event
     */
    public function onBankCreated(BankCreated $event): void
    {
        $bank = new Bank();
        $bank->id = $event->getDto()->getUuid();
        $bank->name = $event->getDto()->getName();
        $bank->logo = $event->getDto()->getLogo();
        $bank->active = $event->getDto()->isActive();
        $bank->save();
    }
}
