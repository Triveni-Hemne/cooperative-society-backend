@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">📜 Day Book Report - {{ $date }}</h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <form action="{{ route('day-book.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="date" class="form-control" value="{{ $date }}" required>
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

        {{-- Export & Transactions Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>💰 Transaction Details</h4>
                <div class="d-flex">
                    <form action="{{ route('day-book.pdf') }}" method="GET" target="_blank">
                        <input type="date" hidden required name="date" value="{{ $date }}">
                        <input type="text" name="type" value="stream" hidden required >
                        <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
                    </form>
                    <form action="{{ route('day-book.pdf') }}" method="GET" target="">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="text" name="type" value="download" hidden required >
                        <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive mt-3" style="height: 35vh">
                <table class="table table-bordered table-striped text-center">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">SrNo</th>
                <th rowspan="2">Ledger Id</th>
                <th rowspan="2">A/c Id</th>
                <th colspan="3">Credit</th>
                <th colspan="3">Debit</th>
            </tr>
            <tr>
                <th>Cash</th>
                <th>Transfer</th>
                <th>Total</th>
                <th>Cash</th>
                <th>Transfer</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
           @php
                $srNo = 1;
                $totalCreditCash = 0;
                $totalCreditTransfer = 0;
                $totalDebitCash = 0;
                $totalDebitTransfer = 0;
            @endphp

            @foreach($grouped as $ledgerName => $transactionTypes)
                @foreach(['Receipt', 'Payment'] as $type)
                    @php
                        $entries = $transactionTypes[$type] ?? ['voucher_entries' => collect(), 'transfer_entries' => collect()];
                    @endphp

                    {{-- Voucher Entries (Cash) --}}
                    @foreach($entries['voucher_entries'] as $entry)
                        @php
                            $accountName = $entry->account->name
                                ?? $entry->memberDepositAccount->name
                                ?? $entry->memberLoanAccount->name
                                ?? $entry->member->name
                                ?? 'N/A';

                            $isReceipt = $type === 'Receipt';

                            $amount = $entry->amount ?? 0;

                            if ($isReceipt) {
                                $totalCreditCash += $amount;
                            } else {
                                $totalDebitCash += $amount;
                            }
                        @endphp
                        <tr>
                            <td>{{ $srNo++ }}</td>
                            <td>{{ $ledgerName }}</td>
                            <td>{{ $accountName }}</td>
                            <td>{{ $isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                            <td>0.00</td>
                            <td>{{ $isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                            <td>{{ !$isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                            <td>0.00</td>
                            <td>{{ !$isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                        </tr>
                    @endforeach

                    {{-- Transfer Entries --}}
                    @foreach($entries['transfer_entries'] as $entry)
                        @php
                            $accountName = $entry->account->name
                                ?? $entry->memberDepositAccount->name
                                ?? $entry->memberLoanAccount->name
                                ?? $entry->member->name
                                ?? 'N/A';

                            $isReceipt = $type === 'Receipt';

                            $amount = $entry->amount ?? 0;

                            if ($isReceipt) {
                                $totalCreditTransfer += $amount;
                            } else {
                                $totalDebitTransfer += $amount;
                            }
                        @endphp
                        <tr>
                            <td>{{ $srNo++ }}</td>
                            <td>{{ $ledgerName }}</td>
                            <td>{{ $accountName }}</td>
                            <td>0.00</td>
                            <td>{{ $isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                            <td>{{ $isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                            <td>0.00</td>
                            <td>{{ !$isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                            <td>{{ !$isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach

            {{-- Totals --}}
            <tr class="font-weight-bold bg-light">
                <td colspan="3">Total</td>
                <td>{{ number_format($totalCreditCash, 2) }}</td>
                <td>{{ number_format($totalCreditTransfer, 2) }}</td>
                <td>{{ number_format($totalCreditCash + $totalCreditTransfer, 2) }}</td>
                <td>{{ number_format($totalDebitCash, 2) }}</td>
                <td>{{ number_format($totalDebitTransfer, 2) }}</td>
                <td>{{ number_format($totalDebitCash + $totalDebitTransfer, 2) }}</td>
            </tr>

            <tr class="font-weight-bold">
                <td colspan="3">Opening Balance</td>
                <td colspan="3">{{ number_format($openingBalance, 2) }}</td>
                <td colspan="3">--</td>
            </tr>

            <tr class="font-weight-bold text-success">
                <td colspan="3">Grand Total</td>
                <td colspan="3">{{ number_format($openingBalance + $totalCreditCash + $totalCreditTransfer, 2) }}</td>
                <td colspan="3">{{ number_format($totalDebitCash + $totalDebitTransfer, 2) }}</td>
            </tr>
        </tbody>
    </table>
    </div>
            {{-- Summary Cards --}}
        <div class="row text-white">
            <div class="col-md-6">
                <div class="card bg-primary-subtle shadow">
                    <div class="card-body">
                        <h6 class="card-title">Total Receipts</h6>
                        <h5>₹ {{ number_format($totalReceipts, 2) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-danger-subtle shadow">
                    <div class="card-body">
                        <h6 class="card-title">Total Payments</h6>
                        <h5>₹ {{ number_format($totalPayments, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@section('customeJs')
@endsection