@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center my-4">
        <h2 class="font-weight-bold" style="font-family: 'Roboto', sans-serif; color: #333;">Withdrawal Details</h2>
        <hr style="border-color: #333; margin: 10px auto;">
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <p class="font-weight-bold mr-2" style="font-family: 'Roboto', sans-serif;">Current Balance:</p>
            <p>{{ $currentBalance }}</p>
        </div>
        <a href="{{ route('withdrawal.form') }}" class="btn btn-info">Withdrawal</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Fee</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withdrawalTransactions as $index => $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->fee }}</td>
                <td>{{ $transaction->date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
