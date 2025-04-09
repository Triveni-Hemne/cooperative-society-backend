@include('layouts.session')

@extends('layouts.app')
@section('title', 'Deposit Maturity Report')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">📜 Deposit Maturity Report - {{ $date }}</h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <form action="{{ route('deposit-maturity.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                    <button type="submit" class="btn btn-primary fs-5" data-mdb-ripple-init><i class="bi bi-search text-light"></i></button>
                </form>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row text-white">
            <div class="col-md-4">
                <div class="card bg-info-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Maturing Deposits</h5>
                        <h3>{{ count($maturingDeposits) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Maturity Amount</h5>
                        <h3>₹ {{ number_format($totalMaturityAmount, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Export & Transactions Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>💰 Maturing Deposits Details</h4>
                <div class="d-flex">
                    <form action="{{ route('deposit-maturity.pdf') }}" method="GET" target="_blank">
                        <input type="date" name="date" required hidden value="{{ $date }}">
                        <button type="submit" class="btn btn-danger">Export PDF</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Account Number</th>
                            <th>Account Holder</th>
                            <th>Deposit Type</th>
                            <th>Start Date</th>
                            <th>Maturity Date</th>
                            <th>Principal Amount</th>
                            <th>Interest Rate</th>
                            <th>Maturity Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maturingDeposits as $deposit)
                        <tr>
                            <td>{{ $deposit->acc_no }}</td>
                            <td>{{ $deposit->account_holder_name }}</td>
                            <td>{{ ucfirst($deposit->deposit_type) }}</td>
                            <td>{{ $deposit->start_date }}</td>
                            <td>{{ $deposit->maturity_date }}</td>
                            <td>₹ {{ number_format($deposit->principal_amount, 2) }}</td>
                            <td>{{ $deposit->interest_rate }}%</td>
                            <td>₹ {{ number_format($deposit->maturity_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $deposit->status == 'Matured' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $deposit->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customeJs')
@endsection
