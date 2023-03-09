<?php
/**
 * User: gmatk
 * Date: 01.07.2022
 * Time: 10:08
 */

namespace App\Domain\User\Tests\Feature;

use App\Domain\User\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group Auth
     * @group User
     */
    public function test_me(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->getJson(route('auth.me'));

        $response->assertOk();
    }

    /**
     * @group Auth
     * @group User
     */
    public function test_me_unauthorized(): void
    {
        $response = $this->getJson(route('auth.me'));

        $response->assertUnauthorized();
    }
}
