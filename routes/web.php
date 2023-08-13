<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', [UserController::class, 'showLoginForm']);



Route::get('/users', [UserController::class, 'showCreateForm']);
Route::post('/users', [UserController::class, 'createUser'])->name('users.create');

Route::get('/login', [UserController::class, 'showLoginForm']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {    
    Route::get('/dashboard', [TransactionController::class, 'dashboard'])->name('dashboard');
    Route::get('/deposit', [TransactionController::class, 'showDepositForm'])->name('deposit.form');
    Route::post('/deposit', [TransactionController::class, 'deposit'])->name('deposit');
    Route::get('/show-deposits', [TransactionController::class, 'showDeposits'])->name('show-deposits');
    Route::get('/show-withdrawals', [TransactionController::class, 'showWithdrawalTransactions'])->name('show-withdrawals');
    Route::get('/withdrawal', [TransactionController::class, 'showWithdrawalForm'])->name('withdrawal.form');
    Route::post('/withdrawal', [TransactionController::class, 'withdrawal'])->name('withdrawal.submit');
    
});