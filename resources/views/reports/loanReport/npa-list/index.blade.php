@extends('layouts.app')
@section('title', 'NPA List')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📜 NPA List - {{ $date }}</h2>

    {{-- Date Filter --}}
    <div class="row mb-4">
        <div class="col-md-4 offset-md-4">
            <form action="{{ route('npa-list.index') }}" method="GET" class="d-flex form-outline input-group">
                <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                <button type="submit" class="btn btn-primary fs-5" data-mdb-ripple-init>
                    <i class="bi bi-search text-light"></i>
                </button>
            </form>
        </div>
    </div>
    
    {{-- Export Button --}}
    <div class="d-flex justify-content-between mb-3">
        <h4>🏦 NPA Loan Details</h4>
        <form action="{{ route('npa-list.pdf') }}" method="GET">
            <input type="hidden" name="date" value="{{ $date }}">
            <button type="submit" class="btn btn-danger">Export PDF</button>
        </form>
    </div>
    
    {{-- Loan Details Table --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Loan Account No</th>
                    <th>Borrower Name</th>
                    <th>Loan Amount</th>
                    <th>First Default Date</th>
                    <th>Outstanding Balance</th>
                    <th>Days Overdue</th>
                    <th>NPA Classification</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($overdueLoans as $loan)
                <tr>
                    <td>{{ $loan->acc_no }}</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td>₹ {{ number_format($loan->loan_amount, 2) }}</td>
                    <td>{{ $loan->first_default_date }}</td>
                    <td>₹ {{ number_format($loan->outstanding_balance, 2) }}</td>
                    <td>{{ $loan->days_overdue }}</td>
                    <td>{{ $loan->npa_classification }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('customeJs')
@endsection