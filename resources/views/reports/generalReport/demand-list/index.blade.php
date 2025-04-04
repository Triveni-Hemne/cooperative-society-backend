@extends('layouts.app')
@section('title', 'Demand List')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container">
    <h3 class="mb-4">Demand List Report</h3>

    <form method="GET" action="{{ route('demand-list.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('demand-list.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-danger ms-2">Export PDF</a>
            </div>
        </div>
    </form>

    @if($demandList->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Member Name</th>
                    <th>Account No.</th>
                    <th>Installment Date</th>
                    <th>Installment Amount</th>
                    <th>With Interest</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demandList as $i => $loan)
                    @foreach($loan->loanInstallments as $installment)
                        <tr>
                            <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                            <td>{{ $loan->member->name ?? '-' }}</td>
                            <td>{{ $loan->acc_no ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($installment->installment_due_date)->format('d-m-Y') }}</td>
                            <td>{{ number_format($installment->installment_amount, 2) }}</td>
                            <td>{{ number_format($installment->installment_with_interest, 2) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <p>No due installments found for the selected date range.</p>
    @endif
</div>
@endsection
