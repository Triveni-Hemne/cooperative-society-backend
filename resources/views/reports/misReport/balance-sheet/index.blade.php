@include('layouts.session')

@extends('layouts.app')
@section('title', 'Balance Sheet Report')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Balance Sheet Report</h2>
    <form method="GET" action="{{ route('balance-sheet.index') }}" class="row g-3 align-items-center">
        <div class="col-md-4">
            <label for="date" class="form-label">As on Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ request('date', now()->toDateString()) }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Generate</button>
            <a href="{{ route('balance-sheet.pdf', ['date' => request('date')]) }}" class="btn btn-danger">Download PDF</a>
        </div>
    </form>

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
