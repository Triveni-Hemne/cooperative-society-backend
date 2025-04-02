<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Sheet</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Balance Sheet</h2>
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
                <td><strong>Assets</strong></td>
                <td>{{ number_format($totalAssets, 2) }}</td>
            </tr>
            @foreach($assets as $asset)
            <tr>
                <td>{{ $asset->ledger_name }}</td>
                <td>{{ number_format($asset->balance, 2) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><strong>Liabilities</strong></td>
                <td>{{ number_format($totalLiabilities, 2) }}</td>
            </tr>
            @foreach($liabilities as $liability)
            <tr>
                <td>{{ $liability->ledger_name }}</td>
                <td>{{ number_format($liability->balance, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
