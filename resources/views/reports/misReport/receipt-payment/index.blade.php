@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Trial Balance')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Receipt & Payment Report</h2>
    <form method="GET" action="{{ route('receipt-payment.index') }}" class="row g-3 align-items-center border p-3 rounded mb-4 ">
        <div class="col-md-3">
            <label for="from_date" class="form-label">From Date:</label>
            <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date', now()->startOfMonth()->toDateString()) }}">
        </div>
        <div class="col-md-3">
            <label for="to_date" class="form-label">To Date:</label>
            <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date', now()->endOfMonth()->toDateString()) }}">
        </div>
        @if(!empty($branches))
            <div class="col-md-3">
                <label>Branch:</label>
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
        <div class="col-md-3 pt-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
        </div>
    </form>

    <div class="export-btns d-flex justify-content-end">
        <a href="{{ route('receipt-payment.pdf', ['from_date' => request('from_date'), 'to_date' => request('to_date'), 'type' => 'stream', 'branch_id' => request('branch_id')])}}" class="btn btn-secondary" target="_blank"><i class="bi bi-printer"></i> Print</a>
        <a href="{{ route('receipt-payment.pdf', ['from_date' => request('from_date'), 'to_date' => request('to_date'), 'type' => 'download', 'branch_id' => request('branch_id')])}}" class="btn btn-danger" target=""><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Type</th>
                    <th>Cash Amount</th>
                    <th>Bank Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Receipts</td>
                    <td>{{ number_format($receipts->cash_receipts, 2) }}</td>
                    <td>{{ number_format($receipts->bank_receipts, 2) }}</td>
                    <td>{{ number_format($receipts->total_receipts, 2) }}</td>
                </tr>
                <tr>
                    <td>Payments</td>
                    <td>{{ number_format($payments->cash_payments, 2) }}</td>
                    <td>{{ number_format($payments->bank_payments, 2) }}</td>
                    <td>{{ number_format($payments->total_payments, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection