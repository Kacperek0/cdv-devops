<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 09:43
 */

namespace App\Domain\User\Projectors;

use App\Application\Events\Expense\ExpenseCreated;
use App\Domain\User\Entities\Expense;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

/**
 *
 */
class ExpenseProjector extends Projector
{

    /**
     *
     */
    public function onExpenseCreated(ExpenseCreated $event): void
    {
        $expense = new Expense();
        $expense->id = $event->getDto()->getUuid();
        $expense->name = Str::limit(Str::squish($event->getDto()->getName()), 64);
        $expense->amount = $event->getDto()->getAmount();
        $expense->user()->associate($event->getDto()->getUserId());
        $expense->bank()->associate($event->getDto()->getBankId());
        $expense->date_at = $event->getDto()->getDateAt();
        $expense->data = $event->getDto()->getData();

        if ($categoryId = $event->getDto()->getCategoryId()) {
            $expense->category()->associate($categoryId);
        }

        $expense->save();
    }

    /**
     *
     */
    public function onStartingEventReplay()
    {
        Expense::truncate();
    }
}
