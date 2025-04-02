<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit & Loss Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .profit { background-color: #c8e6c9; }
        .loss { background-color: #ffccbc; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Profit & Loss Report</h2>
    <p><strong>Period:</strong> {{ $fromDate }} to {{ $toDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Income</td>
                <td>{{ number_format($totalIncome, 2) }}</td>
            </tr>
            <tr>
                <td>Total Expense</td>
                <td>{{ number_format($totalExpense, 2) }}</td>
            </tr>
            <tr class="{{ $netProfit >= 0 ? 'profit' : 'loss' }}">
                <td><strong>Net {{ $netProfit >= 0 ? 'Profit' : 'Loss' }}</strong></td>
                <td><strong>{{ number_format(abs($netProfit), 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
