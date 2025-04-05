@extends('layouts.app')

@section('title', 'Balance Sheet')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Balance Sheet</h4>
        <a href="{{ route('balance-sheet.pdf', ['as_on_date' => $asOnDate]) }}" class="btn btn-sm btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('balance-sheet.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <label for="as_on_date" class="form-label">As on Date</label>
            <input type="date" id="as_on_date" name="as_on_date" value="{{ $asOnDate }}" class="form-control" required>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>

    <div class="row">
        <!-- Assets -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Assets</div>
                <div class="card-body p-0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Ledger Name</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assets as $asset)
                                <tr>
                                    <td>{{ $asset['ledger_name'] }}</td>
                                    <td class="text-end">{{ number_format($asset['amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">No assets found.</td></tr>
                            @endforelse
                            <tr class="fw-bold bg-light">
                                <td>Total Assets</td>
                                <td class="text-end">{{ number_format($totalAssets, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Liabilities and Equity -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light fw-bold">Liabilities</div>
                <div class="card-body p-0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Ledger Name</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($liabilities as $liability)
                                <tr>
                                    <td>{{ $liability['ledger_name'] }}</td>
                                    <td class="text-end">{{ number_format($liability['amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">No liabilities found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Equity</div>
                <div class="card-body p-0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Ledger Name</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($equity as $eq)
                                <tr>
                                    <td>{{ $eq['ledger_name'] }}</td>
                                    <td class="text-end">{{ number_format($eq['amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">No equity found.</td></tr>
                            @endforelse
                            <tr class="fw-bold bg-light">
                                <td>Total Liabilities & Equity</td>
                                <td class="text-end">{{ number_format($totalLiabilitiesEquity, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="text-center mt-4">
        <h5>
            <span class="me-3">Total Assets: ₹{{ number_format($totalAssets, 2) }}</span>
            <span class="ms-3">Liabilities + Equity: ₹{{ number_format($totalLiabilitiesEquity, 2) }}</span>
        </h5>
        <p class="{{ $totalAssets === $totalLiabilitiesEquity ? 'text-success' : 'text-danger' }}">
            {{ $totalAssets === $totalLiabilitiesEquity ? 'Balanced Sheet ✅' : 'Not Balanced ❌' }}
        </p>
    </div>
</div>
@endsection
