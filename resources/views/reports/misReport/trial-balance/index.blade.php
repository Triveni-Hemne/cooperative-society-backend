@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Trial Balance')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection


@section('content')
    <div class="container">
        <h2 class="mb-4">Trial Balance Report ({{ $fromDate }} to {{ $toDate }})</h2>

        <table class="table table-bordered">
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

        <h4>Total Debits: ₹{{ number_format($totalDebit, 2) }}</h4>
        <h4>Total Credits: ₹{{ number_format($totalCredit, 2) }}</h4>

        <a href="{{ route('trial-balance.pdf', ['from_date' => $fromDate, 'to_date' => $toDate]) }}" class="btn btn-primary">Download PDF</a>
    </div>
@endsection
