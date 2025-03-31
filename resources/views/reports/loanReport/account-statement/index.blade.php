@extends('layouts.app')

@section('title', 'Loan Account Statements')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Loan Account Statement</h2>

    <form method="GET" action="{{ route('loan-statements.index') }}">
        <div class="mb-3">
            <label for="loan_acc_no" class="form-label">Loan Account Number</label>
            <input type="text" class="form-control" id="loan_acc_no" name="loan_acc_no" required>
        </div>
        <button type="submit" class="btn btn-primary">Get Statement</button>
    </form>

    @if(isset($loan))
        <hr>
        <h4>Account Details</h4>
        <p><strong>Loan Account No:</strong> {{ $loan->acc_no }}</p>
        <p><strong>Borrower Name:</strong> {{ $loan->name }}</p>
        <p><strong>Loan Amount:</strong> ₹{{ number_format($loan->loan_amount, 2) }}</p>
        <p><strong>Interest Rate:</strong> {{ $loan->interest_rate }}%</p>
        <p><strong>Loan Tenure:</strong> {{ $loan->tenure }} months</p>
        <p><strong>Total Paid:</strong> ₹{{ number_format($totalPaid, 2) }}</p>
        <p><strong>Outstanding Balance:</strong> ₹{{ number_format($outstandingBalance, 2) }}</p>
        <p><strong>Interest Accrued:</strong> ₹{{ number_format($interestAccrued, 2) }}</p>

        <a href="{{ route('loan-statements.pdf', ['loan_acc_no' => $loan->acc_no]) }}" class="btn btn-danger mb-3">Export PDF</a>

        <hr>
        <h4>Transaction History</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at }}</td>
                        <td>{{ $transaction->transaction_type }}</td>
                        <td>₹{{ number_format($transaction->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</div>
@endsection
