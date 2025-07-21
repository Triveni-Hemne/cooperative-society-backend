@include('layouts.session')

@extends('layouts.app')
@section('title', 'Deposit Maturity Report')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container mt-4">
        <h3 class="mb-4 text-center">📜 Deposit Maturity Report - From: {{ $fromDate }} To:{{ $toDate }}</h3>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('deposit-maturity.index') }}" method="GET" class="d-flex form-outline input-group">
                    @if(!empty($ledgers))
                    <select name="ledger_id" class="form-select">
                        <option value="">All Ledgers</option>
                        @foreach($ledgers as $ledger)
                        <option value="{{ $ledger->id }}" {{ request('ledger_id') == $ledger->id ? 'selected' : '' }}>
                            {{ $ledger->name }}
                        </option>
                        @endforeach
                    </select>
                    @endif
                    <input type="date" name="fromDate" title="From Date" class="form-control" value="{{ $fromDate }}" required>
                    <input type="date" name="toDate" title="To Date" class="form-control" value="{{ $toDate }}" required>
                     @if(!empty($branches))
                    {{-- Branch --}}
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @endif
                    <button type="submit" class="btn btn-primary fs-5" data-mdb-ripple-init><i class="bi bi-search text-light"></i></button>
                </form>
            </div>
        </div>

        {{-- Summary Cards --}}
        {{-- <div class="row text-white">
            <div class="col-md-4">
                <div class="card bg-info-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Maturing Deposits</h5>
                        <h3>{{ count($maturingDeposits) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Maturity Amount</h5>
                        <h3>₹ {{ number_format($totalMaturityAmount, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- Export & Transactions Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>💰 Maturing Deposits Details</h4>
                <div class="d-flex">
                    <form action="{{ route('deposit-maturity.pdf') }}" method="GET" target="_blank">
                        <input type="hidden" name="ledger_id" required  value="{{ $ledgerId }}">
                        <input type="date" name="fromDate" required hidden value="{{ $fromDate }}">
                        <input type="date" name="toDate" required hidden value="{{ $toDate }}">
                        <input type="text" name="type" value="stream" required hidden>
                        <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i>Print</button>
                    </form>
                     <form action="{{ route('deposit-maturity.pdf') }}" method="GET" target="">
                        <input type="hidden" name="ledger_id" required  value="{{ $ledgerId }}">
                        <input type="date" name="fromDate" required hidden value="{{ $fromDate }}">
                        <input type="date" name="toDate" required hidden value="{{ $toDate }}">
                        <input type="text" name="type" value="download" required hidden>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i>Export PDF</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-sm text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>SrNo</th>
                            <th>A/cNo</th>
                            <th>Name</th>
                            <th>Opening Date</th>
                            <th>Period</th>
                            <th>Rate</th>
                            <th>Closing.Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($maturingDeposits as $index => $deposit)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $deposit->acc_no }}</td>
                                <td>{{ $deposit->account_holder_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($deposit->start_date)->format('d/m/Y') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($deposit->start_date)->diffInMonths($deposit->maturity_date) }} Months
                                </td>
                                <td>{{ number_format($deposit->interest_rate, 2) }}%</td>
                                <td>{{ \Carbon\Carbon::parse($deposit->maturity_date)->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7">No matured deposits found for selected date.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td colspan="6" class="text-right">Total Maturity Amount</td>
                            <td class="text-success">{{ number_format($totalMaturityAmount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customeJs')
@endsection
