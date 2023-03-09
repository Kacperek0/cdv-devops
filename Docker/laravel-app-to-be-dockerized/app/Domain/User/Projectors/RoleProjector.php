<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 09:43
 */

namespace App\Domain\User\Projectors;

use App\Domain\User\Entities\Role;
use App\Application\Events\Role\RoleCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

/**
 *
 */
class RoleProjector extends Projector
{

    /**
     * @param RoleCreated $event
     */
    public function onRoleCreated(RoleCreated $event): void
    {
        Role::create(array_filter([
            'name' => $event->getDto()->getName(),
            'guard_name' => $event->getDto()->getGuardName()
        ]));
    }

    /**
     *
     */
    public function onStartingEventReplay()
    {
        Role::truncate();
    }
}
