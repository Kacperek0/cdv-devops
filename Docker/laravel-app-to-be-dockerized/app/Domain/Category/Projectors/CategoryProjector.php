<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:28
 */

namespace App\Domain\Category\Projectors;

use App\Domain\Category\Entities\Category;
use App\Application\Events\Category\CategoryCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

/**
 *
 */
class CategoryProjector extends Projector
{
    /**
     * @param CategoryCreated $event
     */
    public function onCategoryCreated(CategoryCreated $event): void
    {
        $category = new Category();
        $category->id = $event->getDto()->getUuid();
        $category->name = $event->getDto()->getName();
        $category->color = $event->getDto()->getColor();
        $category->save();
    }

    /**
     *
     */
    public function onStartingEventReplay(): void
    {
        Category::truncate();
    }
}
