@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Ledger Statement')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container mt-4">
       <h2 class="mb-4 text-center">
            📜 Ledger Statement ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})
        </h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('gl-statement-checking.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="start_date" class="form-control" required placeholder="Start Date" value="{{ request('start_date') }}">
                    <input type="date" name="end_date" class="form-control" required placeholder="End Date" value="{{ request('end_date') }}">
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
        {{-- <div class="row text-white">
            <div class="col-md-4">
                <div class="card bg-primary-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Debit</h5>
                        <h3>₹ {{ number_format($totalDebits, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Credit</h5>
                        <h3>₹ {{ number_format($totalCredits, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Closing Balance</h5>
                        <h3>₹ {{ number_format($closingBalance, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- Export & Transactions Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>📑 Ledger Transactions</h4>
                <div class="d-flex">
                    <form action="{{ route('gl-statement-checking.pdf') }}" method="GET" target="_blank">
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                        <input type="text" name="type" required hidden value="stream">
                        <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
                    </form>
                    <form action="{{ route('gl-statement-checking.pdf') }}" method="GET" target="">
                        @csrf
                        <input type="date" name="start_date" required hidden value="{{ $startDate }}">
                        <input type="date" name="end_date" required hidden value="{{ $endDate }}">
                        <input type="text" name="type" required hidden value="download">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SrNo</th>
                            <th>GLID</th>
                            <th>Name</th>
                            <th>Credit Trans</th>
                            <th>Debit Trans</th>
                            <th>Difference</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ledgers as $index => $ledger)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ledger['gl_id'] }}</td>
                                <td>{{ $ledger['name'] }}</td>
                                <td>{{ number_format($ledger['credit'], 2) }}</td>
                                <td>{{ number_format($ledger['debit'], 2) }}</td>
                                <td>{{ number_format($ledger['difference'], 2) }}</td>
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
