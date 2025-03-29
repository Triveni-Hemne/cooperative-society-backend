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
        <h2 class="mb-4 text-center">📜 Cash Book Report - {{ $date }}</h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <form action="{{ route('cash-book.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="date" class="form-control " value="" required >
                    <button type="submit" class="btn btn-primary fs-5" data-mdb-ripple-init><i class="bi bi-search text-light" ></i></i></button>
                </form>
            </div>
        </div>
     

        {{-- Summary Cards --}}
        <div class="row text-white">
            <div class="col-md-3">
                <div class="card bg-info-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Opening Balance</h5>
                        <h3>₹ {{ number_format($openingBalance, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Receipts</h5>
                        <h3>₹ {{ number_format($cashReceipts, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Payments</h5>
                        <h3>₹ {{ number_format($cashPayments, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
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
                <h4>💰 Transaction Details</h4>
                <div class="d-flex">
                    <form action="{{ route('cash-book.pdf') }}" method="GET">
                        <input type="date" name="date" required hidden value="{{$date}}">
                        <button type="submit" class="btn btn-danger">Export PDF</button>
                    </form>

                    {{-- <form action="{{ route('cash-book.excel') }}" method="GET">
                        <input type="date" name="date" required hidden value="{{$date}}">
                        <button type="submit" class="btn btn-success">Export Excel</button>
                    </form> --}}
                </div>
            </div>
            
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Account Number</th>
                            <th>Account Holder</th>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date }}</td>
                            <td>{{ $transaction->memberLoanAccount ? $transaction->memberLoanAccount->acc_no : 'N/A' }}</td>
                            <td>{{ $transaction->memberLoanAccount ? $transaction->memberLoanAccount->name : 'N/A' }}</td>
                            <td>
                                @if($transaction->transaction_type == 'Deposit')
                                    <span class="badge bg-success">{{ $transaction->transaction_type }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $transaction->transaction_type }}</span>
                                @endif
                            </td>
                            <td>₹ {{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ $transaction->payment_mode }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   
</div>

<!-- Form Model -->
@include('master.agent.agent')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@endsection

