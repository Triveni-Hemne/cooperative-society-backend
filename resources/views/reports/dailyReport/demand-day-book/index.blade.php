@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Ledger Statement')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-3">Demand Day Book Report - {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h2>

    <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('demand-day-book.index') }}" method="GET">
            <input type="date" name="date" value="{{ $date }}" required>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <form action="{{ route('demand-day-book.pdf') }}" method="GET">
            <input type="date" name="date" value="{{ $date }}" required hidden>
            <button type="submit" class="btn btn-danger">Export PDF</button>
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Loan Account No.</th>
                <th>Borrower Name</th>
                <th>Demand Amount</th>
                <th>Amount Received</th>
                <th>Balance Due</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expectedPayments as $payment)
                <tr>
                    <td>{{ $payment->loan_account_no }}</td>
                    <td>{{ $payment->borrower_name }}</td>
                    <td>{{ number_format($payment->demand_amount, 2) }}</td>
                    <td>{{ number_format($payment->amount_received, 2) }}</td>
                    <td>{{ number_format($payment->balance_due, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No loan repayments due for this date.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('customeJs')
@endsection
