<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $fillable = [
        'name', 'account_type', 'balance', 'email', 'password'
    ];

    public function withdrawalThisMonth()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        return Transaction::where('user_id', $this->id)
            ->where('transaction_type', 'withdrawal')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
    }

    public function totalWithdrawal()
    {
        return Transaction::where('user_id', $this->id)
            ->where('transaction_type', 'withdrawal')
            ->sum('amount');
    }
}
