@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Trial Balance')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection


@section('content')
    <div class="container">
        <h3 class="mb-4">Trial Balance Report ({{ $fromDate }} to {{ $toDate }})</h3>
        <div class="export-btns d-flex justify-content-end mb-3">
            <a href="{{ route('mis-trial-balance.pdf', ['from_date' => $fromDate, 'to_date' => $toDate, 'type' => 'stream']) }}" target="_blank" class="btn btn-secondary"><i class="bi bi-printer"></i> Print</a>
            <a href="{{ route('mis-trial-balance.pdf', ['from_date' => $fromDate, 'to_date' => $toDate, 'type' => 'download']) }}" target="_blank" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
       </div>
       <div class="table-responsive">
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>Ledger ID</th>
                    <th>Ledger Name</th>
                    <th>Opening Balance</th>
                    <th>Debits</th>
                    <th>Credits</th>
                    <th>Closing Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ledgers as $ledger)
                    <tr>
                        <td>{{ $ledger->ledger_id }}</td>
                        <td>{{ $ledger->ledger_name }}</td>
                        <td>{{ number_format($ledger->opening_balance, 2) }}</td>
                        <td>{{ number_format($ledger->total_debit, 2) }}</td>
                        <td>{{ number_format($ledger->total_credit, 2) }}</td>
                        <td>{{ number_format($ledger->closing_balance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
        <h4>Total Debits: ₹{{ number_format($totalDebit, 2) }}</h4>
        <h4>Total Credits: ₹{{ number_format($totalCredit, 2) }}</h4>

    </div>
@endsection
