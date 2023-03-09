<?php
/**
 * User: gmatk
 * Date: 01.07.2022
 * Time: 10:08
 */

namespace App\Domain\User\Tests\Feature;

use App\Domain\User\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group User
     */
    public function test_update(): void
    {
        /**
         * @var User $model
         * @var User $user
         */
        $model = User::factory()->make();

        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->patchJson(route('user.update'), [
            'first_name' => $model->first_name,
            'last_name' => $model->last_name
        ]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $user->getKey(),
                'first_name' => $model->first_name,
                'last_name' => $model->last_name
            ]
        ]);
    }

    /**
     * @group User
     */
    public function test_update_unauthorized(): void
    {
        /**
         * @var User $model
         * @var User $user
         */
        $model = User::factory()->make();
        $response = $this->patchJson(route('user.update'), [
            'first_name' => $model->first_name,
            'last_name' => $model->last_name
        ]);

        $response->assertUnauthorized();
    }

    /**
     * @group User
     */
    public function test_change_password(): void
    {
        $password = 'Test12345##';
        $password_new = 'Test12345##_NEW';

        $user = User::factory()->create([
            'password' => $password
        ]);
        Passport::actingAs($user);

        $response = $this->postJson(route('user.password'), [
            'current_password' => $password,
            'password' => $password_new,
            'password_confirmation' => $password_new
        ]);

        $response->assertOk();
    }

    /**
     * @group User
     */
    public function test_change_password_wrong_old_password(): void
    {
        $password = 'Test12345##';
        $password_new = 'Test12345##_NEW';

        $user = User::factory()->create([
            'password' => $password
        ]);
        Passport::actingAs($user);

        $response = $this->postJson(route('user.password'), [
            'current_password' => Str::random(),
            'password' => $password_new,
            'password_confirmation' => $password_new
        ]);

        $response->assertUnprocessable();
    }

    /**
     * @group User
     */
    public function test_change_password_unauthorized(): void
    {
        $password = 'Test12345##';
        $password_new = 'Test12345##_NEW';

        $response = $this->postJson(route('user.password'), [
            'current_password' =>$password,
            'password' => $password_new,
            'password_confirmation' => $password_new
        ]);

        $response->assertUnauthorized();
    }
}
