@include('layouts.session')

@extends('layouts.app')
@section('title', 'Balance Sheet Report')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container mt-4 ">
    <h2 class="mb-4">Balance Sheet Report</h2>
    <form method="GET" action="{{ route('mis-balance-sheet.index') }}" class="row g-3 align-items-center border p-3 rounded mb-4">
        <div class="row">
        <div class="col-md-4">
            <label for="date" class="form-label">As on Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ request('date', now()->toDateString()) }}">
        </div>
        @if(!empty($branches))
            <div class="col-md-3">
                <label class="form-label">Branch:</label>
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
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Generate</button>
        </div>
        </div>
    </form>
<div class="export-btns d-flex justify-content-end">
    <a href="{{ route('balance-sheet.pdf', ['date' => request('date'), 'type' => 'stream', 'branch_id' => request('branch_id')]) }}" class="btn btn-secondary me-1" target="_blank"><i class="bi bi-printer"></i> Print</a>
    <a href="{{ route('balance-sheet.pdf', ['date' => request('date'), 'type' => 'download', 'branch_id' => request('branch_id')]) }}" class="btn btn-danger" target=""><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
</div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Category</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-primary">
                    <td><strong>Assets</strong></td>
                    <td>{{ number_format($totalAssets, 2) }}</td>
                </tr>
                @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->ledger_name }}</td>
                    <td>{{ number_format($asset->balance, 2) }}</td>
                </tr>
                @endforeach

                <tr class="table-danger">
                    <td><strong>Liabilities</strong></td>
                    <td>{{ number_format($totalLiabilities, 2) }}</td>
                </tr>
                @foreach($liabilities as $liability)
                <tr>
                    <td>{{ $liability->ledger_name }}</td>
                    <td>{{ number_format($liability->balance, 2) }}</td>
                </tr>
                @endforeach

                <tr class="table-success">
                    <td><strong>Equity</strong></td>
                    <td>{{ number_format($totalEquity, 2) }}</td>
                </tr>
                @foreach($equity as $eq)
                <tr>
                    <td>{{ $eq->ledger_name }}</td>
                    <td>{{ number_format($eq->balance, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
