<?php

use App\Domain\User\Http\Controllers\Expense\ExpenseController;
use Illuminate\Routing\Router;

Route::group(['middleware' => ['auth:api']], function (Router $route) {
    $route->post('/', [ExpenseController::class, 'store'])->name('expense.store');
    $route->get('user', [ExpenseController::class, 'user'])->name('expense.user');
    $route->group(['prefix' => 'chart'], function (Router $route) {
        $route->get('donut', [ExpenseController::class, 'donut'])->name('expense.chart.donut');
    });
});
