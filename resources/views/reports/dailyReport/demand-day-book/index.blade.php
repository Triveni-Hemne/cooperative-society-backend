@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Ledger Statement')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container">
    <h3 class="mb-3">Demand Day Book Report - {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h3>

    <div class="d-flex justify-content-center mb-3">
        <form action="{{ route('demand-day-book.index') }}" method="GET" class="d-flex">
            <input type="date" name="date" class="form-control" value="{{ $date }}" required>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>       
    </div>
    <div class="d-flex justify-content-end mb-3">
         <form action="{{ route('demand-day-book.pdf') }}" method="GET" target="_blank">
            <input type="date" name="date" value="{{ $date }}" required hidden>
            <input type="text" name="type" value="stream" required hidden>
            <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
        </form>
        <form action="{{ route('demand-day-book.pdf') }}" method="GET" target="">
            <input type="date" name="date" value="{{ $date }}" required hidden>
            <input type="text" name="type" value="download" required hidden>
            <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
        </form>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark"> 
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
</div>
@endsection

@section('customeJs')
@endsection
