<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Passbook PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h4 { margin-bottom: 5px; }
    </style>
</head>
<body>

<h4 class="mb-4">Passbook - {{ ucfirst($accountType) }} Account</h4>

@if(isset($account->member))
    <p><strong>Member:</strong> {{ $account->member->name }}</p>
@endif

<p><strong>Account ID:</strong> {{ $accountId }}</p>

@if($fromDate && $toDate)
    <p><strong>From:</strong> {{ $fromDate }} &nbsp;&nbsp; <strong>To:</strong> {{ $toDate }}</p>
@endif

<table>
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
            <tr><td colspan="5" style="text-align: center;">No transactions found</td></tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
