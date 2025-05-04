<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Member Statement PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header, .footer { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; }
        .summary { margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        .totals td { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Member Statement</h2>
        <p>Period: {{ $startDate }} to {{ $endDate }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <th>Total Deposits (₹)</th>
                <th>Total Withdrawals (₹)</th>
                <th>Total Loan Payments (₹)</th>
            </tr>
            <tr class="totals">
                <td>{{ number_format($totalDeposits, 2) }}</td>
                <td>{{ number_format($totalWithdrawals, 2) }}</td>
                <td>{{ number_format($totalLoans, 2) }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Voucher No</th>
                <th>Transaction Type</th>
                <th>Debit (₹)</th>
                <th>Credit (₹)</th>
                <th>Amount (₹)</th>
                <th>Status</th>
                <th>Narration</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</td>
                    <td>{{ $transaction->voucher_num }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ number_format($transaction->debit_amount, 2) }}</td>
                    <td>{{ number_format($transaction->credit_amount, 2) }}</td>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>{{ $transaction->narration }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No transactions found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Generated on {{ now()->format('d-m-Y H:i') }}</p>
    </div>

</body>
</html>
