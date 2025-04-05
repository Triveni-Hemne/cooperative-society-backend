@extends('layouts.app')
@section('title', 'Ledger stament')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container">
    <h2 class="mb-4">General Ledger Statement</h2>

    <!-- Filter Form -->
    <form action="{{ route('gl-statement.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label>Ledger:</label>
                <select name="ledger_id" class="form-select" required>
                    <option value="">--- Select Ledger ---</option>
                    @foreach ($ledgers as $ledger)
                        <option value="{{ $ledger->id }}" {{ request('ledger_id') == $ledger->id ? 'selected' : '' }}>
                            {{ $ledger->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}">
            </div>
            <div class="col-md-3">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->toDateString()) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Export to PDF Button -->
    <a href="{{ route('gl-statement.pdf', ['ledger_id' => request('ledger_id'), 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
       class="btn btn-danger mb-3" target="_blank">Export to PDF</a>

    <!-- General Ledger Transactions Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Voucher No</th>
                <th>Transaction Type</th>
                <th>Debit (₹)</th>
                <th>Credit (₹)</th>
                <th>Balance (₹)</th>
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
                    <td>{{ $txn->narration ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
