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

        {{-- Summary Cards --}}
        <div class="row text-white">
            <div class="col-md-6">
                <div class="card bg-primary-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Receipts</h5>
                        <h3>₹ {{ number_format($totalReceipts, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-danger-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Payments</h5>
                        <h3>₹ {{ number_format($totalPayments, 2) }}</h3>
                    </div>
                </div>
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
            
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Transaction Type</th>
                            <th>Payment Mode</th>
                            <th>Amount</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date }}</td>
                            <td>
                                @if($transaction->transaction_type == 'Deposit')
                                    <span class="badge bg-success">{{ $transaction->transaction_type }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $transaction->transaction_type }}</span>
                                @endif
                            </td>
                            <td>{{ $transaction->payment_mode }}</td>
                            <td>₹ {{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ $transaction->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customeJs')
@endsection