<?php

use App\Domain\User\Http\Controllers\User\UserController;
use App\Domain\User\Http\Controllers\User\PasswordController;
use Illuminate\Routing\Router;

Route::group(['middleware' => ['auth:api']], function (Router $route) {
    $route->patch('/', [UserController::class, 'update'])
        ->name('user.update');

    $route->post('password', [PasswordController::class, 'change'])
        ->name('user.password');
});
