
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt & Payment Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Receipt & Payment Report</h2>
        <p>From: {{ $fromDate }} To: {{ $toDate }}</p>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Cash Amount</th>
                    <th>Bank Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Receipts</td>
                    <td>{{ number_format($receipts->cash_receipts, 2) }}</td>
                    <td>{{ number_format($receipts->bank_receipts, 2) }}</td>
                    <td>{{ number_format($receipts->total_receipts, 2) }}</td>
                </tr>
                <tr>
                    <td>Payments</td>
                    <td>{{ number_format($payments->cash_payments, 2) }}</td>
                    <td>{{ number_format($payments->bank_payments, 2) }}</td>
                    <td>{{ number_format($payments->total_payments, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
