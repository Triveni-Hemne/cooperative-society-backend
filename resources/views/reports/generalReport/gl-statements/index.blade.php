@include('layouts.session')
@extends('layouts.app')
@section('title', 'Ledger stament')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container">
    <h2 class="mb-4">General Ledger Statement</h2>
    <div class="card  my-3 p-3">
        <!-- Filter Form -->
        <form action="{{ route('gl-statement.index') }}" method="GET" class="mb-3">
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
                @if(!empty($branches))
                <div class="col-md-3">
                    <label class="">Branch:</label>
                    {{-- Branch --}}
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-3 d-flex align-items-end mt-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class=" my-3 p-3" >
        <!-- Export to PDF Button -->
        <div class="export-btns d-flex">
            <a href="{{ route('gl-statement.pdf', ['ledger_id' => request('ledger_id'), 'start_date' => request('start_date'), 'end_date' => request('end_date'), 'type'=>'stream', 'branch_id' => request('branch_id')]) }}"
        class="btn btn-secondary mb-3" target="_blank"><i class="bi bi-printer"></i> Print</a>
            <a href="{{ route('gl-statement.pdf', ['ledger_id' => request('ledger_id'), 'start_date' => request('start_date'), 'end_date' => request('end_date'), 'type'=>'download', 'branch_id' => request('branch_id')]) }}"
        class="btn btn-danger mb-3" target=""><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
        </div>

        <!-- General Ledger Transactions Table -->
        <div class="table-responsive">
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
    </div>
</div>
@endsection
