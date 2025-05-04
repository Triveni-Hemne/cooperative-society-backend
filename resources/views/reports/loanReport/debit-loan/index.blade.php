@extends('layouts.app')
@section('title', 'Debit Loan Report')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Debit Loan Report</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('debit-laon.index') }}" class="mb-4 border p-3 rounded">
        <div class="row g-3">
            <div class="col-md-3">
                <label>From Date:</label>
                <input type="date" name="from_date" value="{{ request('from_date', $fromDate) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label>To Date:</label>
                <input type="date" name="to_date" value="{{ request('to_date', $toDate) }}" class="form-control">
            </div>
            @if(!empty($branches))
            <div class="col-md-3">
                <label>Branch:</label>
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
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Export PDF Button -->
    <div class="export-btns d-flex justify-content-end">
    <a href="{{ route('debit-laon.pdf', ['from_date' => $fromDate, 'to_date' => $toDate, 'type' => 'stream']) }}" class="btn btn-secondary mb-3 me-1" target="_blank"><i class="bi bi-printer"></i> Print</a>
    <a href="{{ route('debit-laon.pdf', ['from_date' => $fromDate, 'to_date' => $toDate, 'type' => 'download']) }}" class="btn btn-danger mb-3" target=""> <i class="bi bi-file-earmark-pdf"></i>Export PDF</a>
    </div>

    <!-- Loan Report Table -->
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-dark">
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
</div>
@endsection
