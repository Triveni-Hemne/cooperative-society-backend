@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Sub Day Book Report')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">📜 Sub Day Book Report - {{ $date }}</h2>

        {{-- Filters for Date & Account Type --}}
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('sub-day-book.index') }}" method="GET" class="d-flex">
                    <input type="date" name="date" class="form-control me-2" value="{{ $date }}" required>
                    <select name="account_type" class="form-control me-2">
                        <option value="">All Accounts</option>
                        @foreach($accountTypes as $type)
                            <option value="{{ $type }}" {{ $accountType == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search text-light"></i></button>
                </form>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row text-white">
            <div class="col-md-6">
                <div class="card bg-success-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Deposits</h5>
                        <h3>₹ {{ number_format($totalDeposits, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-warning-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Withdrawals</h5>
                        <h3>₹ {{ number_format($totalWithdrawals, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Export & Transactions Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>💰 Category-Wise Transactions</h4>
                <div class="d-flex">
                    <form action="{{ route('sub-day-book.pdf') }}" method="GET" target="_blank">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="account_type" value="{{ $accountType }}">
                        <button type="submit" class="btn btn-danger">Export PDF</button>
                    </form>
                    {{-- <form action="{{ route('sub-day-book.excel') }}" method="GET" class="ms-2">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="account_type" value="{{ $accountType }}">
                        <button type="submit" class="btn btn-success">Export Excel</button>
                    </form> --}}
                </div>
            </div>
            
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Account Type</th>
                            <th>Account Holder</th>
                            <th>Transaction Type</th>
                            <th>Payment Mode</th>
                            <th>Amount</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date }}</td>
                            <td>{{ $transaction->account_type }}</td>
                            <td>{{ $transaction->memberLoanAccount ? $transaction->memberLoanAccount->name : 'N/A' }}</td>
                            <td>
                                @if($transaction->transaction_type == 'Deposit')
                                    <span class="badge bg-success">{{ $transaction->transaction_type }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $transaction->transaction_type }}</span>
                                @endif
                            </td>
                            <td>{{ $transaction->payment_mode }}</td>
                            <td>₹ {{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ $transaction->description }}</td>
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
