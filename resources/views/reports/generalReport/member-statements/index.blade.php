@extends('layouts.app')
@section('title', 'Member Statement')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container">
    <h3 class="mb-4">Member Statement</h3>

    <!-- Filter Form -->
    <form action="{{ route('member-statement.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label>Member:</label>
                <select name="member_id" id="memberId" class="form-select" required>
                    <option value="">---Select Member---</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}" {{ $memberId == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                @if($transactions->isNotEmpty())
                    <a href="{{ route('member-statement.export-pdf', ['member_id' => $memberId, 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                        class="btn btn-danger ms-2">Export PDF</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Member Transactions Table -->
    @if($transactions->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Transaction Type</th>
                        <th>Amount</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Status</th>
                        <th>Narration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $txn)
                        <tr>
                            <td>{{ $txn->date }}</td>
                            <td>{{ $txn->voucher_num }}</td>
                            <td>{{ $txn->transaction_type }}</td>
                            <td>{{ number_format($txn->amount, 2) }}</td>
                            <td>{{ number_format($txn->debit_amount, 2) }}</td>
                            <td>{{ number_format($txn->credit_amount, 2) }}</td>
                            <td>{{ $txn->status }}</td>
                            <td>{{ $txn->narration }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="mt-3">
            <h5>Total Deposits: ₹{{ number_format($totalDeposits, 2) }}</h5>
            <h5>Total Withdrawals: ₹{{ number_format($totalWithdrawals, 2) }}</h5>
            <h5>Total Loans: ₹{{ number_format($totalLoans, 2) }}</h5>
        </div>
    @else
        <p class="text-muted text-center mt-4">No transactions found for the selected member and date range.</p>
    @endif
</div>
@endsection
