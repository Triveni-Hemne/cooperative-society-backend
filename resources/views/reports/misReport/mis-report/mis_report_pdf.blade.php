<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Management Information System (MIS) Report</h2>
    <p><strong>As on:</strong> {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Total Deposits Collected</td><td>{{ number_format($totalDeposits, 2) }}</td></tr>
            <tr><td>Total Loans Disbursed</td><td>{{ number_format($totalLoansDisbursed, 2) }}</td></tr>
            <tr><td>Total Loans Outstanding</td><td>{{ number_format($totalLoansOutstanding, 2) }}</td></tr>
        </tbody>
    </table>
</body>
</html>
