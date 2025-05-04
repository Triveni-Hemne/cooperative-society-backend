@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Trial Balance')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection


@section('content')
    <div class="container">
        <h3 class="mb-4">Trial Balance Report ({{ $fromDate }} to {{ $toDate }})</h3>
        <form method="GET" action="{{ route('mis-trial-balance.index') }}" class="mb-4 border p-3 rounded">
        <div class="row g-3">
            <div class="col-md-3">
                <label>From Date:</label>
                <input type="date" name="from_date" value="{{ request('from_date', $fromDate) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label>To Date:</label>
                <input type="date" name="to_date" value="{{ request('to_date', $toDate) }}" class="form-control">
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
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
        <div class="export-btns d-flex justify-content-end mb-3">
            <a href="{{ route('mis-trial-balance.pdf', ['from_date' => $fromDate, 'to_date' => $toDate, 'type' => 'stream', 'branch_id' => request('branch_id')]) }}" target="_blank" class="btn btn-secondary"><i class="bi bi-printer"></i> Print</a>
            <a href="{{ route('mis-trial-balance.pdf', ['from_date' => $fromDate, 'to_date' => $toDate, 'type' => 'download', 'branch_id' => request('branch_id')]) }}" target="_blank" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
       </div>
       <div class="table-responsive">
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>Ledger ID</th>
                    <th>Ledger Name</th>
                    <th>Opening Balance</th>
                    <th>Debits</th>
                    <th>Credits</th>
                    <th>Closing Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ledgers as $ledger)
                    <tr>
                        <td>{{ $ledger->ledger_id }}</td>
                        <td>{{ $ledger->ledger_name }}</td>
                        <td>{{ number_format($ledger->opening_balance, 2) }}</td>
                        <td>{{ number_format($ledger->total_debit, 2) }}</td>
                        <td>{{ number_format($ledger->total_credit, 2) }}</td>
                        <td>{{ number_format($ledger->closing_balance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
        <h4>Total Debits: ₹{{ number_format($totalDebit, 2) }}</h4>
        <h4>Total Credits: ₹{{ number_format($totalCredit, 2) }}</h4>

    </div>
@endsection
