{{-- resources/views/reports/passbook/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Passbook Result')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container">
    <h4 class="mb-4">Passbook - {{ ucfirst($accountType) }} Account</h4>

    @if(isset($account->member))
        <p><strong>Member:</strong> {{ $account->member->name }}</p>
    @endif

    <p><strong>Account ID:</strong> {{ $accountId }}</p>
    @if($fromDate && $toDate)
        <p><strong>From:</strong> {{ $fromDate }} | <strong>To:</strong> {{ $toDate }}</p>
    @endif

    <div class="mb-3">
        <a href="{{ route('passbook.printing.pdf', ['account_type' => $accountType, 'account_id' => $accountId, 'from_date' => $fromDate, 'to_date' => $toDate]) }}" target="_blank" class="btn btn-success">Download PDF</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Particulars</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->date)->format('d-m-Y') }}</td>
                    <td>{{ $t->narration ?? '-' }}</td>
                    <td>{{ number_format($t->debit_amount, 2) }}</td>
                    <td>{{ number_format($t->credit_amount, 2) }}</td>
                    <td>{{ number_format($t->running_balance, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No transactions found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
