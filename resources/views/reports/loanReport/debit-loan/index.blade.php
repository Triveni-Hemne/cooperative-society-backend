@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Debit Loan Report</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('debit-laon.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label>From Date:</label>
                <input type="date" name="from_date" value="{{ request('from_date', $fromDate) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label>To Date:</label>
                <input type="date" name="to_date" value="{{ request('to_date', $toDate) }}" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Export PDF Button -->
    <a href="{{ route('debit-laon.pdf', ['from_date' => $fromDate, 'to_date' => $toDate]) }}" class="btn btn-danger mb-3">Export PDF</a>

    <!-- Loan Report Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Loan Account No</th>
                <th>Borrower Name</th>
                <th>Disbursement Date</th>
                <th>Loan Amount</th>
                <th>Interest Rate (%)</th>
                <th>Tenure (Months)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($debitLoans as $loan)
                <tr>
                    <td>{{ $loan->loan_account_no }}</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td>{{ $loan->disbursement_date }}</td>
                    <td>{{ number_format($loan->loan_amount_disbursed, 2) }}</td>
                    <td>{{ $loan->interest_rate }}%</td>
                    <td>{{ $loan->tenure }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No loan disbursements found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
