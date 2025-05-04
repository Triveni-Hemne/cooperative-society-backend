@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Ledger Statement')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container mt-4">
       <h2 class="mb-4 text-center">
            📜 Ledger Statement ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})
        </h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('gl-statement-checking.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="start_date" class="form-control" required placeholder="Start Date" value="{{ request('start_date') }}">
                    <input type="date" name="end_date" class="form-control" required placeholder="End Date" value="{{ request('end_date') }}">
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
                    <button type="submit" class="btn btn-primary fs-5"><i class="bi bi-search text-light"></i></button>
                </form>
            </div>
        </div>
     
        {{-- Summary Cards --}}
        <div class="row text-white">
            <div class="col-md-4">
                <div class="card bg-primary-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Debit</h5>
                        <h3>₹ {{ number_format($totalDebits, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Credit</h5>
                        <h3>₹ {{ number_format($totalCredits, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Closing Balance</h5>
                        <h3>₹ {{ number_format($closingBalance, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Export & Transactions Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>📑 Ledger Transactions</h4>
                <div class="d-flex">
                    <form action="{{ route('gl-statement-checking.pdf') }}" method="GET" target="_blank">
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                        <input type="text" name="type" required hidden value="stream">
                        <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
                    </form>
                    <form action="{{ route('gl-statement-checking.pdf') }}" method="GET" target="">
                        @csrf
                        <input type="date" name="start_date" required hidden value="{{ $startDate }}">
                        <input type="date" name="end_date" required hidden value="{{ $endDate }}">
                        <input type="text" name="type" required hidden value="download">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Ledger Account</th>
                            <th>Transaction Type</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</td>
                            <td>{{ $transaction->account_name }}</td>
                            <td>{{ $transaction->balance_type }}</td>
                            <td>₹ {{ number_format($transaction->debit, 2) }}</td>
                            <td>₹ {{ number_format($transaction->credit, 2) }}</td>
                            <td>₹ {{ number_format($transaction->running_balance, 2) }}</td>
                        </tr>
                        @endforeach
                        @if($transactions->isEmpty())
                        <tr>
                            <td colspan="6">No transactions found for selected criteria.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customeJs')
@endsection
