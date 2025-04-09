<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dividend Calculation Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Dividend Calculation Report - {{ $date }}</h2>
    <table>
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Member Name</th>
                <th>Share ID</th>
                <th>Share Type</th>
                <th>Number of Shares</th>
                <th>Dividend Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shareholders as $shareholder)
                <tr>
                    <td>{{ $shareholder->member_id }}</td>
                    <td>{{ $shareholder->member_name }}</td>
                    <td>{{ $shareholder->share_id }}</td>
                    <td>{{ $shareholder->share_type }}</td>
                    <td>{{ $shareholder->number_of_shares }}</td>
                    <td>₹ {{ number_format($shareholder->dividend_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h4 style="text-align: right;">Total Dividend Distributed: ₹ {{ number_format($totalDividendDistributed, 2) }}</h4>
</body>
</html>