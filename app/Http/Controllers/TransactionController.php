<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function showDepositForm()
    {
        return view('deposit.create');
    }
    public function showWithdrawalForm()
    {
        return view('withdrawal.create');
    }

    public function showTransactions()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        $currentBalance = $user->balance + $transactions->sum('amount');

        return view('transactions', compact('transactions', 'currentBalance'));
    }

    public function deposit(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $user->balance += $validatedData['amount'];
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'transaction_type' => 'deposit',
            'amount' => $validatedData['amount'],
            'fee' => 0,
            'date' => now(),
        ]);

        return redirect()->route('show-deposits')->with('success', 'Deposit successful');
    }

    public function showDeposits()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $deposits = Transaction::where('user_id', $user->id)
            ->where('transaction_type', 'deposit')
            ->orderBy('date', 'desc')
            ->get();

            $currentBalance = $user->balance;
    
            return view('deposit.index', compact('deposits', 'currentBalance'));
         }

    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        $currentBalance = $user->balance;

        return view('transactions.index', compact('transactions', 'currentBalance'));
    }

    public function showWithdrawalTransactions()
    {
        $user = Auth::user();
        $withdrawalTransactions = Transaction::where('user_id', $user->id)
            ->where('transaction_type', 'withdrawal')
            ->orderBy('date', 'desc')
            ->get();
    
        $currentBalance = $user->balance;
    
        return view('withdrawal.index', compact('withdrawalTransactions', 'currentBalance'));
    }

    

    public function withdrawal(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $accountType = $user->account_type;
        $withdrawalRate = ($accountType === 'individual') ? 0.015 : 0.025;

        $withdrawalFee = $validatedData['amount'] * $withdrawalRate;

        if ($accountType === 'individual') {
            $today = now();

            if ($today->isFriday()) {
                $withdrawalFee = 0;
            } elseif ($validatedData['amount'] <= 1000) {
                $withdrawalFee = 0;
            } elseif ($user->withdrawalThisMonth() <= 5000) {
                $withdrawalFee = 0;
            }
        }

        if ($accountType === 'business' && $user->totalWithdrawal() > 50000) {
            $withdrawalFee = $validatedData['amount'] * 0.015;
        }

        $totalAmount = $validatedData['amount'] + $withdrawalFee;

        if ($user->balance >= $totalAmount) {
            $user->balance -= $totalAmount;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'transaction_type' => 'withdrawal',
                'amount' => $validatedData['amount'],
                'fee' => $withdrawalFee,
                'date' => now(),
            ]);

            return redirect()->route('show-withdrawals')->with('success', 'Withdrawal successful');
        } else {
            return redirect()->route('show-withdrawals')->with('error', 'Insufficient balance for withdrawal');
        }
    }
}
