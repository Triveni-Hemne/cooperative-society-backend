@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Audit Trial Balance')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">🧾 Trial Balance Report</h2>

    <form method="GET" action="{{ route('trial-balance.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="as_on_date" class="form-label">As on Date:</label>
                <input type="date" name="as_on_date" id="as_on_date" value="{{ request('as_on_date') ?? date('Y-m-d') }}" class="form-control" required>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </div>
        </div>
    </form>

    @isset($trialBalance)
        <div class="d-flex justify-content-between mt-5">
            <h5 class="">As on: {{ \Carbon\Carbon::parse($asOnDate)->format('d M, Y') }}</h5>
            <!-- Export PDF Button -->
            <form action="{{ route('trial-balance.pdf') }}" method="GET">
                <input type="hidden" name="as_on_date" value="{{ $asOnDate }}">
                <button type="submit" class="btn btn-success">Export PDF</button>
            </form>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Ledger Name</th>
                        <th class="text-end">Debit Amount</th>
                        <th class="text-end">Credit Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trialBalance as $row)
                        <tr>
                            <td>{{ $row['ledger_name'] }}</td>
                            <td class="text-end">{{ number_format($row['debit'], 2) }}</td>
                            <td class="text-end">{{ number_format($row['credit'], 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="table-info fw-bold">
                        <td class="text-end">Total</td>
                        <td class="text-end">{{ number_format($totalDebit, 2) }}</td>
                        <td class="text-end">{{ number_format($totalCredit, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endisset
</div>
@endsection
