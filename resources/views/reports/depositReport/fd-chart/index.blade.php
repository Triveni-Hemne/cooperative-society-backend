@extends('layouts.app')

@section('title', 'FD Chart Report')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container mt-4">
    <h2 class="text-center">📊 Fixed Deposit Chart - {{ $date }}</h2>

    <div class="row mb-4">
        <div class="col-md-4 offset-md-4">
            <form action="{{ route('fd-chart.index') }}" method="GET" class="d-flex">
                <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                <button type="submit" class="btn btn-primary">🔍 Search</button>
            </form>
        </div>
    </div>

    <div class="text-end">
        <form action="{{ route('fd-chart.pdf') }}" method="GET">
            <input type="hidden" name="date" value="{{ $date }}">
            <button type="submit" class="btn btn-danger">Export PDF</button>
        </form>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Account No</th>
                    <th>Account Holder</th>
                    <th>Deposit Amount</th>
                    <th>Interest Rate (%)</th>
                    <th>Start Date</th>
                    <th>Duration (Months)</th>
                    <th>Interest Accrued</th>
                    <th>Total Balance</th>
                    <th>Maturity Date</th>
                    <th>Maturity Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fdAccounts as $account)
                <tr>
                    <td>{{ $account->acc_no }}</td>
                    <td>{{ $account->account_holder_name }}</td>
                    <td>₹{{ number_format($account->deposit_amount, 2) }}</td>
                    <td>{{ $account->interest_rate }}%</td>
                    <td>{{ $account->start_date }}</td>
                    <td>{{ $account->duration_months }}</td>
                    <td>₹{{ number_format($account->interest_accrued, 2) }}</td>
                    <td>₹{{ number_format($account->total_balance, 2) }}</td>
                    <td>{{ $account->maturity_date }}</td>
                    <td>₹{{ number_format($account->maturity_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
