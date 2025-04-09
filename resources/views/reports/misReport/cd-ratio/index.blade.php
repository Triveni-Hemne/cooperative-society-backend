@include('layouts.session')

@extends('layouts.app')
@section('title', 'CD Ratio Report')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Credit-Deposit Ratio (CD Ratio) Report</h2>
    <form method="GET" action="{{ route('cd-ratio.index') }}" class="row g-3 align-items-center">
        <div class="col-md-4">
            <label for="date" class="form-label">As on Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ request('date', now()->toDateString()) }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Generate</button>
            <a href="{{ route('cd-ratio.pdf', ['date' => request('date')]) }}" class="btn btn-danger" target="_blank">Download PDF</a>
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
                    <td><strong>Total Loans Given</strong></td>
                    <td>{{ number_format($totalLoans, 2) }}</td>
                </tr>

                <tr class="table-success">
                    <td><strong>Total Deposits Collected</strong></td>
                    <td>{{ number_format($totalDeposits, 2) }}</td>
                </tr>

                <tr class="table-warning">
                    <td><strong>CD Ratio (%)</strong></td>
                    <td>{{ number_format($cdRatio, 2) }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
