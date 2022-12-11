<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 14:09
 */

namespace App\Domain\Category\Projectors;

use App\Domain\Category\Entities\CategoryCoupling;
use App\Application\Events\CategoryCoupling\CategoryCouplingCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

/**
 *
 */
class CategoryCouplingProjector extends Projector
{
    /**
     * @param CategoryCouplingCreated $event
     */
    public function onCategoryCoupling(CategoryCouplingCreated $event): void
    {
        $categoryCoupling = new CategoryCoupling();
        $categoryCoupling->id = $event->getDto()->getUuid();
        $categoryCoupling->name = $event->getDto()->getName();
        $categoryCoupling->category()->associate($event->getDto()->getCategoryId());
        $categoryCoupling->save();
    }

    /**
     *
     */
    public function onStartingEventReplay(): void
    {
        CategoryCoupling::truncate();
    }
}
