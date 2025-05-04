@include('layouts.session')

@extends('layouts.app')
@section('title', 'MIS Report')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Management Information System (MIS) Report</h2>
    <form method="GET" action="{{ route('mis-report.index') }}" class="row g-3 d-flex align-items-end border rounded p-3 mb-4 ">
        <div class="col-md-4">
            <label for="date" class="form-label">As on Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ request('date', now()->toDateString()) }}">
        </div>
        @if(!empty($branches))
            <div class="col-md-3">
                <label class="form-label">Branch:</label>
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
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Generate</button>
        </div>
    </form>
    <div class="export-btns">
            <a href="{{ route('mis-report.pdf', ['date' => request('date'), 'type' => 'steam', 'branch_id' => request('branch_id')]) }}" target="_blank" class="btn btn-secondary"><i class="bi bi-printer"></i> Print</a>
            <a href="{{ route('mis-report.pdf', ['date' => request('date'), 'type' => 'download', 'branch_id' => request('branch_id')]) }}" target="" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Category</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-primary">
                    <td><strong>Total Deposits Collected</strong></td>
                    <td>{{ number_format($totalDeposits, 2) }}</td>
                </tr>
                <tr class="table-success">
                    <td><strong>Total Loans Disbursed</strong></td>
                    <td>{{ number_format($totalLoansDisbursed, 2) }}</td>
                </tr>
                <tr class="table-info">
                    <td><strong>Total Loans Outstanding</strong></td>
                    <td>{{ number_format($totalLoansOutstanding, 2) }}</td>
                </tr>
                <tr class="table-warning">
                    <td><strong>Total Interest Earned</strong></td>
                    <td>{{ number_format($totalInterestEarned, 2) }}</td>
                </tr>
                <tr class="table-danger">
                    <td><strong>Total Interest Paid</strong></td>
                    <td>{{ number_format($totalInterestPaid, 2) }}</td>
                </tr>
                <tr class="table-secondary">
                    <td><strong>Total Members</strong></td>
                    <td>{{ $totalMembers }}</td>
                </tr>
                <tr class="table-secondary">
                    <td><strong>Total Accounts</strong></td>
                    <td>{{ $totalAccounts }}</td>
                </tr>
                <tr class="table-danger">
                    <td><strong>Loan Overdue Amount</strong></td>
                    <td>{{ number_format($loanOverdue, 2) }}</td>
                </tr>
                <tr class="table-dark text-white">
                    <td><strong>NPA Loans</strong></td>
                    <td>{{ number_format($totalNPALoans, 2) }}</td>
                </tr>
                <tr class="table-danger">
                    <td><strong>NPA Ratio (%)</strong></td>
                    <td>{{ number_format($npaRatio, 2) }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
