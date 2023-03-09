<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 10:30
 */

namespace App\Application\Events\User;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserVerified extends ShouldBeStored
{
    public function __construct(private string $userId)
    {

    }

    /**
     * @return array
     */
    public function getMetaData(): array
    {
        return $this->metaData;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
