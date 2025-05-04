@extends('layouts.app')
@section('title', 'Interest Summary Report')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Interest Summary Report - {{ $date }}</h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-5 offset-md-3">
                <form action="{{ route('interest-summary.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                    @if(!empty($branches))
                    {{-- Branch --}}
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

        {{-- Summary Table --}}
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Interest Rate Range</th>
                        <th>Total Deposits (₹)</th>
                        <th>Total Interest Earned (₹)</th>
                        <th>Total Maturity Amount (₹)</th>
                        <th>Number of Accounts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summaryData as $range => $data)
                        <tr>
                            <td>{{ $range }}</td>
                            <td>₹ {{ number_format($data['total_deposits'], 2) }}</td>
                            <td>₹ {{ number_format($data['total_interest_earned'], 2) }}</td>
                            <td>₹ {{ number_format($data['total_maturity_amount'], 2) }}</td>
                            <td>{{ $data['accounts_count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Export Buttons --}}
        <div class="d-flex justify-content-between mt-4">
            <h4>Export Report</h4>
            <div class="d-flex">
                <form action="{{ route('interest-summary.pdf') }}" method="GET" target="_blank">
                    <input type="date" name="date" hidden value="{{ $date }}">
                    <input type="text" name="type" hidden value="stream">
                    <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
                </form>
                <form action="{{ route('interest-summary.pdf') }}" method="GET" target="">
                    <input type="date" name="date" hidden value="{{ $date }}">
                    <input type="text" name="type" hidden value="download">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export to PDF</button>
                </form>
            </div>
        </div>
    </div>
@endsection