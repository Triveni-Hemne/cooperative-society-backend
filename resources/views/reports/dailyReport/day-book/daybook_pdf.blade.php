<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Day Book Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Day Book Report - {{ $date }}</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction Type</th>
                <th>Payment Mode</th>
                <th>Amount</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ $transaction->payment_mode }}</td>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total Receipts: {{ number_format($totalReceipts, 2) }}</h3>
    <h3>Total Payments: {{ number_format($totalPayments, 2) }}</h3>
</body>
</html>
