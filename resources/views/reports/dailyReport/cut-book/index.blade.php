@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Ledger Statement')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-4">Cut Book Report</h4>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('cut-book.index') }}" class="border rounded p-3 mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', $startDate) }}">
            </div>
            <div class="col-md-3">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', $endDate) }}">
            </div>
            <div class="col-md-4">
                <label for="loan_account">Loan Account:</label>
                <select name="loan_account" id="loan_account" class="form-control">
                    <option value="">All Accounts</option>
                    @foreach($loanAccounts as $id => $account)
                        <option value="{{ $id }}" {{ $id == $loanAccountId ? 'selected' : '' }}>{{ $account }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Export PDF Button -->
    <div class="d-flex justify-content-end my-3 ">
        <form action="{{ route('cut-book.pdf') }}" method="GET" target="_blank">
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            <input type="text" name="type" value="stream" hidden required>
            <input type="hidden" name="loan_account" value="{{ $loanAccountId }}">
            <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
        </form>
        <form action="{{ route('cut-book.pdf') }}" method="GET" target="">
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            <input type="text" name="type" value="download" hidden required>
            <input type="hidden" name="loan_account" value="{{ $loanAccountId }}">
            <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
        </form>
    </div>

    <!-- Cut Book Report Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Loan Account No</th>
                    <th>Borrower Name</th>
                    <th>Loan Type</th>
                    <th>EMI Amount</th>
                    <th>Interest Paid</th>
                    <th>Principal Paid</th>
                    <th>Balance Due</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->loan_account_no }}</td>
                        <td>{{ $transaction->borrower_name }}</td>
                        <td>{{ $transaction->loan_type }}</td>
                        <td>{{ number_format($transaction->emi_amount, 2) }}</td>
                        <td>{{ number_format($transaction->interest_paid, 2) }}</td>
                        <td>{{ number_format($transaction->principal_paid, 2) }}</td>
                        <td>{{ number_format($transaction->balance_due, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="table-primary">
                    <th colspan="5" class="text-right">Total:</th>
                    <th>{{ number_format($totalInterestPaid, 2) }}</th>
                    <th>{{ number_format($totalPrincipalPaid, 2) }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('customeJs')
@endsection

