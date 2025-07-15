@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container">
        <h2 class="mb-3 text-center">📜 Cash Book Report - {{ $date }}</h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <form action="{{ route('cash-book.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="date" class="form-control " value="{{old('date')}}" required>
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
                    <button type="submit" class="btn btn-primary fs-5" data-mdb-ripple-init><i class="bi bi-search text-light" ></i></i></button>
                </form>
            </div>
        </div>
       {{-- Export & Transactions Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>💰 Transaction Details</h4>
                <div class="d-flex">
                    <form action="{{ route('cash-book.pdf') }}" method="GET" target="_blank">
                        <input type="date" name="date" required hidden value="{{$date}}">
                        <input type="text" name="type" required hidden value="stream">
                        <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i>Print</button>
                    </form>
                     <form action="{{ route('cash-book.pdf') }}" method="GET" target="">
                        <input type="date" name="date" required hidden value="{{$date}}">
                        <input type="text" name="type" required hidden value="download">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i>Export PDF</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-3" style="height: 35vh">
                <table class="table table-striped table-bordered text-center">
                    <thead >
                        <tr class="table-dark">
                            <th>Sr.No.</th>
                            <th colspan="2">Credit</th>
                            <th></th>
                            <th>Ledger</th>
                            {{-- <th >Description</th> --}}
                            <th colspan="3">Debit</th>
                        </tr>
                        <tr class="table-secondary">
                            <th></th>
                            <th>Cash</th>
                            <th>Trans.</th>
                            <th>Total</th>
                            {{-- <th></th> --}}
                            <th></th>
                            <th>Cash</th>
                            <th>Trans.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody style="">
                        @php $nos = 1; @endphp
                        @foreach($grouped as $ledgerName => $transactionTypes)
                             @php
                                // Totals for each ledger group
                                $creditCashTotal = 0;
                                $creditTransTotal = 0;
                                $debitCashTotal = 0;
                                $debitTransTotal = 0;
                            @endphp

                            @foreach(['Receipt', 'Payment'] as $type)
                                @php
                                    $entries = $transactionTypes[$type] ?? ['voucher_entries' => collect(), 'transfer_entries' => collect()];
                                    $voucherEntries = $entries['voucher_entries'];
                                    $transferEntries = $entries['transfer_entries'];
                                @endphp

                                @foreach($voucherEntries as $entry)
                                    <tr>
                                        <td>{{ $nos++ }}</td>
                                        <td>{{ $type === 'Receipt' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                        <td>0.00</td>
                                        <td>{{ $type === 'Receipt' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                        <td>{{ $ledgerName }}</td>
                                        <td>{{ $type === 'Payment' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                        <td>0.00</td>
                                        <td>{{ $type === 'Payment' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                    </tr>

                                    @php
                                        if ($type === 'Receipt') {
                                            $creditCashTotal += $entry->amount;
                                        } elseif ($type === 'Payment') {
                                            $debitCashTotal += $entry->amount;
                                        }
                                    @endphp
                                @endforeach

                                @foreach($transferEntries as $entry)
                                    <tr>
                                        <td>{{ $nos++ }}</td>
                                        <td>0.00</td>
                                        <td>{{ $type === 'Receipt' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                        <td>{{ $type === 'Receipt' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                        <td>{{ $ledgerName }}</td>
                                        <td>0.00</td>
                                        <td>{{ $type === 'Payment' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                        <td>{{ $type === 'Payment' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                    </tr>

                                    @php
                                        if ($type === 'Receipt') {
                                            $creditTransTotal += $entry->amount;
                                        } elseif ($type === 'Payment') {
                                            $debitTransTotal += $entry->amount;
                                        }
                                    @endphp
                                @endforeach
                            @endforeach

                            {{-- Totals row for this ledger --}}
                            <tr style="font-weight: bold; background-color: #f8f9fa;">
                                <td></td>
                                <td>{{ number_format($creditCashTotal, 2) }}</td>
                                <td>{{ number_format($creditTransTotal, 2) }}</td>
                                <td>{{ number_format($creditCashTotal + $creditTransTotal, 2) }}</td>
                                <td>{{ $ledgerName }}</td>
                                <td>{{ number_format($debitCashTotal, 2) }}</td>
                                <td>{{ number_format($debitTransTotal, 2) }}</td>
                                <td>{{ number_format($debitCashTotal + $debitTransTotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        {{-- Summary Cards --}}
        <div class="row text-white mt-1">
            <div class="col-md-3">
                <div class="card bg-info-subtle shadow">
                    <div class="card-body">
                        <h6 class="card-title">Opening Balance</h6>
                        <h5>₹ {{ number_format($openingBalance, 2) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary-subtle shadow">
                    <div class="card-body">
                        <h6 class="card-title">Total Receipts</h6>
                        <h5>₹ {{ number_format($totalReceipts, 2) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger-subtle shadow">
                    <div class="card-body">
                        <h6 class="card-title">Total Payments</h6>
                        <h5>₹ {{ number_format($totalPayments, 2) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning-subtle shadow">
                    <div class="card-body">
                        <h6 class="card-title">Closing Balance</h6>
                        <h5>₹ {{ number_format($closingBalance, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>

<!-- Form Model -->
{{-- @include('master.agent.agent') --}}

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@endsection

