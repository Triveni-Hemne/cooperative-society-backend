@include('layouts.session')

@extends('layouts.app')
@section('title', 'Overdue Loan Register')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📜 Overdue Loan Register - {{ $date }}</h2>

    {{-- Date Filter --}}
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('overdue-register.index') }}" method="GET" class="d-flex form-outline input-group">
                @if(!empty($ledgers))
                <select name="ledger_id" class="form-select">
                    <option value="">All Ledgers</option>
                    @foreach($ledgers as $ledger)
                    <option value="{{ $ledger->id }}" {{ request('ledger_id') == $ledger->id ? 'selected' : '' }}>
                        {{ $ledger->name }}
                    </option>
                    @endforeach
                </select>
                @endif
                <input type="number" name="months" class="form-control" value="{{ request('months')}}" placeholder="Months" required>
                <input type="date" name="date" class="form-control" value="{{ request('date')}}" required>
                <select name="type" class="form-select">
                            <option value="with_interest" {{ request('with interest') == $type ? 'selected' : '' }}>
                                With Interest
                            </option>
                            <option value="without_interest" {{ request('without interest') == $type ? 'selected' : '' }}>
                                Without Interest
                            </option>
                </select>
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
                    
                <button type="submit" class="btn btn-primary fs-5" data-mdb-ripple-init>
                    <i class="bi bi-search text-light"></i>
                </button>
            </form>
        </div>
    </div>
    
    {{-- Summary Cards --}}
    {{-- <div class="row text-white">
        <div class="col-md-3">
            <div class="card bg-info-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Overdue Loans</h5>
                    <h3>{{ count($overdueLoans) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Overdue Amount</h5>
                    <h3>₹ {{ number_format($totalOverdueAmount, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Penalty</h5>
                    <h3>₹ {{ number_format($totalPenalty, 2) }}</h3>
                </div>
            </div>
        </div>
    </div> --}}
    
    {{-- Export & Transactions Table --}}
    <div class="mt-4">
        <div class="d-flex justify-content-between">
            <h4>💰 Overdue Loan Details</h4>
            <div class="d-flex">
                <form action="{{ route('overdue-register.pdf') }}" method="GET" target="_blank">
                    <input type="hidden" name="ledger_id" required  value="{{$ledgerId ?? ''}}" style="display: none;">
                    <input type="text" name="months" required hidden value="{{$months ?? ''}}">
                    <input type="text" name="type" required hidden value="{{$type ?? ''}}" >
                    <input type="hidden" name="branch_id" required  value="{{$branchId ?? ''}}" style="display: none;">
                    <input type="date" name="date" required hidden value="{{$date}}">
                    <input type="text" name="type" required hidden value="stream">
                    <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
                </form>
                <form action="{{ route('overdue-register.pdf') }}" method="GET" target="">
                    <input type="text" name="ledger_id" required value="{{$ledgerId ?? ''}}" style="display: none;">
                    <input type="text" name="months" required hidden value="{{$months ?? ''}}">
                    <input type="text" name="type" required hidden value="{{$type ?? ''}}">
                    <input type="text" name="branch_id" required  value="{{$branchId ?? ''}}" style="display: none;">
                    <input type="date" name="date" required hidden value="{{$date}}">
                    <input type="text" name="type" required hidden value="download">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                </form>
            </div>
        </div>
        
        <div class="table-responsive mt-3">
            @if(count($overdueLoans))
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>SrNo</th>
                            <th>Name</th>
                            <th>A/C No</th>
                            <th>Loan Date</th>
                            <th>Sanction Amount</th>
                            <th>Overdue Amount</th>
                            <th>Interest</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overdueLoans as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['account_no'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($row['loan_date'])->format('d-m-Y') }}</td>
                            <td>{{ number_format($row['sanction_amount'], 2) }}</td>
                            <td>{{ number_format($row['overdue_amount'], 2) }}</td>
                            <td>{{ number_format($row['interest'], 2) }}</td>
                            <td>{{ number_format($row['total'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="alert alert-info mt-4">No overdue loans found for selected filters.</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('customeJs')
@endsection
