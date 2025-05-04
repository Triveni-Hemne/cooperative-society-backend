@include('layouts.session')

@extends('layouts.app')
@section('title', 'Overdue Loan Register')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📜 Overdue Loan Register - {{ $date }}</h2>

    {{-- Date Filter --}}
    <div class="row mb-4">
        <div class="col-md-4 offset-md-4">
            <form action="{{ route('overdue-register.index') }}" method="GET" class="d-flex form-outline input-group">
                <input type="date" name="date" class="form-control" value="" required>
                {{-- Branch --}}
                    @if(!empty($branches))
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @endif
                <button type="submit" class="btn btn-primary fs-5" data-mdb-ripple-init>
                    <i class="bi bi-search text-light"></i>
                </button>
            </form>
        </div>
    </div>
    
    {{-- Summary Cards --}}
    <div class="row text-white">
        <div class="col-md-3">
            <div class="card bg-info-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Overdue Loans</h5>
                    <h3>{{ count($overdueLoans) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Overdue Amount</h5>
                    <h3>₹ {{ number_format($totalOverdueAmount, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Penalty</h5>
                    <h3>₹ {{ number_format($totalPenalty, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Export & Transactions Table --}}
    <div class="mt-4">
        <div class="d-flex justify-content-between">
            <h4>💰 Overdue Loan Details</h4>
            <div class="d-flex">
                <form action="{{ route('overdue-register.pdf') }}" method="GET" target="_blank">
                    <input type="date" name="date" required hidden value="{{$date}}">
                    <input type="text" name="type" required hidden value="stream">
                    <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
                </form>
                <form action="{{ route('overdue-register.pdf') }}" method="GET" target="">
                    <input type="date" name="date" required hidden value="{{$date}}">
                    <input type="text" name="type" required hidden value="download">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                </form>
            </div>
        </div>
        
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Loan Account No</th>
                        <th>Borrower Name</th>
                        <th>Sanction Date</th>
                        <th>Loan Amount</th>
                        <th>EMI Amount</th>
                        <th>Due Date</th>
                        <th>Days Overdue</th>
                        <th>Overdue Amount</th>
                        <th>Penalty</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($overdueLoans as $loan)
                    <tr>
                        <td>{{ $loan->acc_no }}</td>
                        <td>{{ $loan->borrower_name }}</td>
                        <td>{{ $loan->loan_sanction_date }}</td>
                        <td>₹ {{ number_format($loan->loan_amount, 2) }}</td>
                        <td>₹ {{ number_format($loan->emi_amount, 2) }}</td>
                        <td>{{ $loan->due_date }}</td>
                        <td>{{ $loan->days_overdue }}</td>
                        <td>₹ {{ number_format($loan->overdue_amount, 2) }}</td>
                        <td>₹ {{ number_format($loan->penalty_amount, 2) }}</td>
                        <td>₹ {{ number_format($loan->balance, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('customeJs')
@endsection
