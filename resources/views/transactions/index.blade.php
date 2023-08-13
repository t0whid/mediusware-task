@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center my-4">
        <h2 class="font-weight-bold" style="font-family: 'Roboto', sans-serif; color: #333;">Transaction Details</h2>
        <hr style="border-color: #333; margin: 10px auto;">
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p style="font-size: 18px; font-weight: bold;">Current Balance: {{ $currentBalance }}</p>
        </div>
       
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Transaction Type</th>
                <th>Amount</th>
                <th>Fee</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $index => $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaction->transaction_type }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->fee }}</td>
                <td>{{ $transaction->date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
