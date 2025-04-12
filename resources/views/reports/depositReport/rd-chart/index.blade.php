@extends('layouts.app')

@section('title', 'RD Chart Report')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container mt-4">
    <h2 class="text-center">📊 Recurring Deposit Chart - {{ $date }}</h2>

    <div class="row mb-4">
        <div class="col-md-4 offset-md-4">
            <form action="{{ route('rd-chart.index') }}" method="GET" class="d-flex">
                <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                <button type="submit" class="btn btn-primary">🔍 Search</button>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <form action="{{ route('rd-chart.pdf') }}" method="GET" target="_blank">
            <input type="date" name="date" value="{{ $date }}" hidden>
            <input type="text" name="type" value="stream" hidden>
            <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
        </form>
        <form action="{{ route('rd-chart.pdf') }}" method="GET" target="">
            <input type="date" name="date" value="{{ $date }}" hidden>
            <input type="text" name="type" value="download" hidden>
            <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
        </form>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Account No</th>
                    <th>Account Holder</th>
                    <th>Installment Amount</th>
                    <th>Start Date</th>
                    <th>Duration (Months)</th>
                    <th>Interest Rate (%)</th>
                    <th>Interest Earned</th>
                    <th>Total Balance</th>
                    <th>Maturity Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rdAccounts as $account)
                <tr>
                    <td>{{ $account->acc_no }}</td>
                    <td>{{ $account->account_holder_name }}</td>
                    <td>₹{{ number_format($account->installment_amount, 2) }}</td>
                    <td>{{ $account->start_date }}</td>
                    <td>{{ $account->duration_months }}</td>
                    <td>{{ $account->interest_rate }}%</td>
                    <td>₹{{ number_format($account->interest_earned, 2) }}</td>
                    <td>₹{{ number_format($account->total_balance, 2) }}</td>
                    <td>{{ $account->maturity_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
