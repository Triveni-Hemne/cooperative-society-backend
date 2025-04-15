@extends('layouts.app')
@section('title', 'General Ledger Statement')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">General Ledger Statement</h2>
    
    <form method="GET" action="{{ route('gl-statements.index') }}" class="row g-3 mb-4 border rounded p-3">
        <div class="col-md-4">
            <label for="ledger_id" class="form-label">Select Ledger:</label>
            <select name="ledger_id" id="ledger_id" class="form-select" required>
                <option value="">-- Select Ledger --</option>
                @foreach($ledgers as $ledger)
                    <option value="{{ $ledger->id }}" {{ request('ledger_id') == $ledger->id ? 'selected' : '' }}>
                        {{ $ledger->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-3">
            <label for="from_date" class="form-label">From Date:</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date', now()->startOfMonth()->toDateString()) }}" required>
        </div>

        <div class="col-md-3">
            <label for="to_date" class="form-label">To Date:</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date', now()->endOfMonth()->toDateString()) }}" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="text-end mb-3">
        <a href="{{ route('gl-statements.pdf', ['ledger_id' => request('ledger_id'), 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'type' => 'stream']) }}" class="btn btn-secondary" target="_blank">
            <i class="bi bi-printer"></i> Print
        </a>
        <a href="{{ route('gl-statements.pdf', ['ledger_id' => request('ledger_id'), 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'type'=> 'download']) }}" class="btn btn-danger" target="">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </a>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Debit (₹)</th>
                <th>Credit (₹)</th>
                <th>Running Balance (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ledgerStatement as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction['date'])->format('d-m-Y') }}</td>
                    <td>{{ $transaction['description'] }}</td>
                    <td class="text-end">{{ number_format($transaction['debit'], 2) }}</td>
                    <td class="text-end">{{ number_format($transaction['credit'], 2) }}</td>
                    <td class="text-end">{{ number_format($transaction['balance'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
