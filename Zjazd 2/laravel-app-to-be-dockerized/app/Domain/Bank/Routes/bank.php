<?php

use App\Domain\Bank\Http\Controllers\BankController;

Route::get('available', [BankController::class, 'available'])->name('bank.available');
