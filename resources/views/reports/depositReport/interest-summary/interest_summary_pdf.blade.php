<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Summary Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #343a40; color: white; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">📊 Interest Summary Report - {{ $date }}</h2>

    <table>
        <thead>
            <tr>
                <th>Deposit Type</th>
                <th>Interest Rate Range</th>
                <th>Total Deposits (₹)</th>
                <th>Total Interest Earned (₹)</th>
                <th>Total Maturity Amount (₹)</th>
                <th>Number of Accounts</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summaryData as $rateRange => $group)
                <tr>
                    <td>{{ $rateRange }}</td>
                    <td>₹ {{ number_format($group['total_deposits'], 2) }}</td>
                    <td>₹ {{ number_format($group['total_interest_earned'], 2) }}</td>
                    <td>₹ {{ number_format($group['total_maturity_amount'], 2) }}</td>
                    <td>{{ $group['accounts_count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
