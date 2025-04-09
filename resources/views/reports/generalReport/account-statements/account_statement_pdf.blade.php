<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Statement</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 20px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Account Statement</h2>
        <p><strong>Account ID:</strong> {{ $accountId }}</p>
        <p><strong>Period:</strong> {{ $startDate }} to {{ $endDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Voucher No</th>
                <th>Transaction Type</th>
                <th>Debit (₹)</th>
                <th>Credit (₹)</th>
                <th>Balance (₹)</th>
                <th>Mode</th>
                <th>Reference</th>
                <th>Narration</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $txn)
                <tr>
                    <td>{{ $txn->date }}</td>
                    <td>{{ $txn->voucher_num ?? '-' }}</td>
                    <td>{{ $txn->transaction_type }}</td>
                    <td class="text-danger">{{ number_format($txn->debit_amount, 2) }}</td>
                    <td class="text-success">{{ number_format($txn->credit_amount, 2) }}</td>
                    <td>{{ number_format($txn->current_balance, 2) }}</td>
                    <td>{{ $txn->transaction_mode }}</td>
                    <td>{{ $txn->reference_number ?? '-' }}</td>
                    <td>{{ $txn->narration ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
