<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 18:24
 */

namespace App\Application\Events\User;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class PasswordReseted extends ShouldBeStored
{
    /**
     * @param string $email
     * @param string $token
     * @param string $password
     */
    public function __construct(private string $email, private string $token, private string $password){

    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
