@extends('layouts.app')
@section('title', 'Account stament')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container">
    <h2 class="mb-4">Account Statement</h2>

    <!-- Filter Form -->
   <form action="{{ route('account-statement.index') }}" method="GET" class="mb-4">
    <div class="row">
        <!-- Account Selection -->
        <div class="col-md-3">
            <label for="accountId" class="form-label">Account ID:</label>
            <select name="account_id" id="accountId" class="form-select" required>
                <option value="">--- Select Account ---</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>
                        {{ $account->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Start Date -->
        <div class="col-md-3">
            <label for="startDate" class="form-label">Start Date:</label>
            <input type="date" id="startDate" name="start_date" class="form-control" 
                   value="{{ request('start_date', now()->subMonth()->toDateString()) }}">
        </div>

        <!-- End Date -->
        <div class="col-md-3">
            <label for="endDate" class="form-label">End Date:</label>
            <input type="date" id="endDate" name="end_date" class="form-control" 
                   value="{{ request('end_date', now()->toDateString()) }}">
        </div>

        <!-- Submit Button -->
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>

    <!-- Export to PDF Button -->
    <a href="{{ route('account-statement.pdf', ['account_id' => request('account_id'), 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
       class="btn btn-danger mb-3" target="_blank">
       Export to PDF
    </a>

    <!-- Account Transactions Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Voucher No</th>
                <th>Transaction Type</th>
                <th>Debit (₹)</th>
                <th>Credit (₹)</th>
                <th>Balance (₹)</th>
                <th>Mode</th>
                <th>Reference</th>
                <th>Narration</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $txn)
                <tr>
                    <td>{{ $txn->date }}</td>
                    <td>{{ $txn->voucher_num ?? '-' }}</td>
                    <td>{{ $txn->transaction_type }}</td>
                    <td class="text-danger">{{ number_format($txn->debit_amount, 2) }}</td>
                    <td class="text-success">{{ number_format($txn->credit_amount, 2) }}</td>
                    <td>{{ number_format($txn->current_balance, 2) }}</td>
                    <td>{{ $txn->transaction_mode }}</td>
                    <td>{{ $txn->reference_number ?? '-' }}</td>
                    <td>{{ $txn->narration ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No transactions found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection