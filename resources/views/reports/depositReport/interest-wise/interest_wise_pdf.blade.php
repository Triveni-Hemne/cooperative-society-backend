<!DOCTYPE html>
<html>
<head>
    <title>Interest-wise RD Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3>Interest-wise Recurring Deposit Report - {{ $date }}</h3>
    <table>
        <thead>
            <tr>
                <th>Interest Rate (%)</th>
                <th>Total Deposits (₹)</th>
                <th>Total Interest Earned (₹)</th>
                <th>Total Maturity Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($interestRateGroups as $rate => $group)
                <tr>
                    <td>{{ $rate }}%</td>
                    <td>₹{{ number_format($group['total_deposits'], 2) }}</td>
                    <td>₹{{ number_format($group['total_interest_earned'], 2) }}</td>
                    <td>₹{{ number_format($group['total_maturity_amount'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
