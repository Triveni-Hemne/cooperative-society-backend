<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CD Ratio Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Credit-Deposit Ratio (CD Ratio) Report</h2>
    <p><strong>As on:</strong> {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Total Loans Given</strong></td>
                <td>{{ number_format($totalLoans, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Deposits Collected</strong></td>
                <td>{{ number_format($totalDeposits, 2) }}</td>
            </tr>
            <tr>
                <td><strong>CD Ratio (%)</strong></td>
                <td>{{ number_format($cdRatio, 2) }}%</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
