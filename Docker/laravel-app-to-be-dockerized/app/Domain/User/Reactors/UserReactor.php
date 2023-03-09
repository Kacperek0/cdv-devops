<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 14:43
 */

namespace App\Domain\User\Reactors;

use App\Application\Events\User\PasswordReseted;
use App\Application\Events\User\UserCreated;
use App\Application\Repositories\UserRepository;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\User\Notifications\NewPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

/**
 *
 */
class UserReactor extends Reactor implements ShouldQueue
{
    /**
     * @param UserRepository $repository
     */
    public function __construct(private UserRepository $repository)
    {

    }

    /**
     * @param UserCreated $event
     */
    public function onUserCreated(UserCreated $event): void
    {
        /**
         * @var User $user
         */
        if (!$user = $this->repository->find($event->getDto()->getUuid())) {
            return;
        }

        if ($user->hasRole([Role::AMIN_ROLE])) {
            return;
        }

        event(new Registered($user));
    }

    /**
     * @param PasswordReseted $event
     */
    public function onPasswordResetedEvent(PasswordReseted $event): void
    {
        if (!($user = $this->repository->findByEmail($event->getEmail())) || !$user->hasVerifiedEmail()) {
            return;
        }

        $user->notify(
            new NewPassword($event->getPassword())
        );

    }
}
