@extends('layouts.app')
@section('title', 'Loan Guarantor')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container">
    <h3 class="mb-4">Loan Guarantor Report</h3>

    <form method="GET" action="{{ route('loan-garantor.index') }}" class="mb-4 card p-4">
        <div class="row">
            <div class="col-md-3">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            @if(!empty($branches))
            <div class="col-md-3">
                <label class="">Branch:</label>
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
                <button class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
     <div class="d-flex align-items-end justify-content-end">
        <a href="{{ route('loan-garantor.pdf', ['start_date' => $startDate, 'end_date' => $endDate, 'type' => 'stream', 'branch_id'=>request('branch_id')]) }}" target="_blank" class="btn btn-secondary">
            <i class="bi bi-printer"></i> Print
        </a>
        <a href="{{ route('loan-garantor.pdf', ['start_date' => $startDate, 'end_date' => $endDate, 'type' => 'download', 'branch_id'=>request('branch_id')]) }}" target="" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Loan ID</th>
                <th>Borrower Name</th>
                <th>Guarantor Name</th>
                <th>Loan Amount</th>
                <th>Guaranteed Amount</th>
                <th>Loan Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guarantors as $index => $g)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $g->loan->id ?? '-' }}</td>
                    <td>{{ $g->loan->member->name ?? '-' }}</td>
                    <td>{{ $g->member->name ?? '-' }}</td>
                    <td>{{ number_format($g->loan->loan_amount ?? 0, 2) }}</td>
                    <td>{{ number_format($g->guaranteed_amount, 2) }}</td>
                    <td>{{ ucfirst($g->loan->status ?? '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No records found for the selected date range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
