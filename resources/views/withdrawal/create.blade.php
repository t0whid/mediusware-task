@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Withdrawal') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('withdrawal.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Withdrawal Amount') }}</label>
                            <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror"
                                name="amount" value="{{ old('amount') }}" required autocomplete="amount" autofocus>
                            @error('amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Withdraw') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
