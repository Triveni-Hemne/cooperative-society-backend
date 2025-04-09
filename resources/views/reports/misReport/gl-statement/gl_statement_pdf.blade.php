<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Ledger Statement</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table, .table th, .table td { border: 1px solid black; padding: 8px; text-align: center; }
        .table th { background-color: #343a40; color: white; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">General Ledger Statement</h2>
    <p><strong>Ledger:</strong> {{ $ledgerName }}</p>
    <p><strong>Period:</strong> {{ $fromDate }} to {{ $toDate }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Debit (₹)</th>
                <th>Credit (₹)</th>
                <th>Running Balance (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ledgerStatement as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction['date'])->format('d-m-Y') }}</td>
                    <td>{{ $transaction['description'] }}</td>
                    <td class="text-end">{{ number_format($transaction['debit'], 2) }}</td>
                    <td class="text-end">{{ number_format($transaction['credit'], 2) }}</td>
                    <td class="text-end">{{ number_format($transaction['balance'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
