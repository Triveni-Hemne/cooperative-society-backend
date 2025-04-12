<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ledger Statement - {{ $date }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        .summary {
            margin: 20px 0;
            text-align: center;
        }
        .summary div {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        .small-text {
            font-size: 11px;
        }
    </style>
</head>
<body>

    <h2>📜 Ledger Statement</h2>
    <h4>Date: {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h4>

    <div class="summary">
        <div><strong>Total Debit:</strong> ₹ {{ number_format($totalDebits, 2) }}</div>
        <div><strong>Total Credit:</strong> ₹ {{ number_format($totalCredits, 2) }}</div>
        <div><strong>Closing Balance:</strong> ₹ {{ number_format($closingBalance, 2) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Ledger Account</th>
                <th>Transaction Type</th>
                <th>Debit (₹)</th>
                <th>Credit (₹)</th>
                <th>Balance (₹)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</td>
                    <td>{{ $transaction->ledger ? $transaction->ledger->name : 'N/A' }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ number_format($transaction->debit_amount, 2) }}</td>
                    <td>{{ number_format($transaction->credit_amount, 2) }}</td>
                    <td>{{ number_format($transaction->current_balance, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No transactions found for {{ $date }}.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
