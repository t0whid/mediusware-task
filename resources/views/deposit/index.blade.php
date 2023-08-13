@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center my-4">
        <h2 class="font-weight-bold" style="font-family: 'Roboto', sans-serif; color: #333;">Deposit Details</h2>
        <hr style="border-color: #333; margin: 10px auto;">
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <p class="font-weight-bold mr-2" style="font-family: 'Roboto', sans-serif;">Current Balance:</p>
            <p>{{ $currentBalance }}</p>
        </div>
        <a href="{{ route('deposit.form') }}" class="btn btn-info">Deposit</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>

                <th>#</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deposits as $deposit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $deposit->amount }}</td>
                <td>{{ $deposit->date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
