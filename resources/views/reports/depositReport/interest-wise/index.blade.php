@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">📊 Interest-wise RD Report - {{ $date }}</h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <form action="{{ route('interestwise-reccuring.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="date" class="form-control" value="" required>
                    <button type="submit" class="btn btn-primary fs-5">
                        <i class="bi bi-search text-light"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row text-white">
            <div class="col-md-4">
                {{-- <div class="card bg-info-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Deposits</h5>
                        <h3>₹ {{ number_format($totalDeposits, 2) }}</h3>
                    </div>
                </div> --}}
            </div>
            <div class="col-md-4">
                {{-- <div class="card bg-primary-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Interest Earned</h5>
                        <h3>₹ {{ number_format($totalInterestEarned, 2) }}</h3>
                    </div>
                </div> --}}
            </div>
            <div class="col-md-4">
                {{-- <div class="card bg-warning-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Maturity Amount</h5>
                        <h3>₹ {{ number_format($totalMaturityAmount, 2) }}</h3>
                    </div>
                </div> --}}
            </div>
        </div>

        {{-- Export & Interest-wise Summary Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>📈 Interest-wise RD Summary</h4>
                <div class="d-flex">
                    <form action="{{ route('interestwise-reccuring.pdf') }}" method="GET">
                        <input type="date" name="date" required hidden value="{{ $date }}">
                        <button type="submit" class="btn btn-danger">Export PDF</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Interest Rate (%)</th>
                            <th>Total Deposits (₹)</th>
                            <th>Total Interest Earned (₹)</th>
                            <th>Total Maturity Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interestRateGroups as $rate => $group)
                        <tr>
                            <td>{{ $rate }}%</td>
                            <td>₹ {{ number_format($group['total_deposits'], 2) }}</td>
                            <td>₹ {{ number_format($group['total_interest_earned'], 2) }}</td>
                            <td>₹ {{ number_format($group['total_maturity_amount'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Detailed Account Table --}}
        <div class="mt-5">
            <h4>💼 Account-wise Details</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Account Number</th>
                            <th>Account Holder</th>
                            <th>Interest Rate (%)</th>
                            <th>Monthly Deposit (₹)</th>
                            <th>Maturity Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interestRateGroups as $rate => $group)
                            @foreach($group['accounts'] as $account)
                            <tr>
                                <td>{{ $account->acc_no }}</td>
                                <td>{{ $account->account_holder_name }}</td>
                                <td>{{ $account->interest_rate }}%</td>
                                <td>₹ {{ number_format($account->monthly_deposit, 2) }}</td>
                                <td>₹ {{ number_format($account->maturity_amount, 2) }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')

@endsection

@section('customeJs')
@endsection
