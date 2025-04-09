<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dividend Balance Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <h2 class="text-center">Dividend Balance Report</h2>
    <p class="text-center">Date: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Member Name</th>
                <th>Share ID</th>
                <th>Share Type</th>
                <th>Number of Shares</th>
                <th>Entitled Dividend (₹)</th>
                <th>Distributed Dividend (₹)</th>
                <th>Remaining Balance (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shareholders as $shareholder)
            <tr>
                <td>{{ $shareholder->member_id }}</td>
                <td>{{ $shareholder->member_name }}</td>
                <td>{{ $shareholder->share_id }}</td>
                <td>{{ $shareholder->share_type }}</td>
                <td>{{ $shareholder->number_of_shares }}</td>
                <td>₹ {{ number_format($shareholder->entitled_dividend, 2) }}</td>
                <td>₹ {{ number_format($shareholder->distributed_dividend, 2) }}</td>
                <td>₹ {{ number_format($shareholder->remaining_dividend, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-bold">
                <td colspan="5">Total</td>
                <td>₹ {{ number_format($totalDividendPool, 2) }}</td>
                <td>₹ {{ number_format($totalDistributed, 2) }}</td>
                <td>₹ {{ number_format($totalRemaining, 2) }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
