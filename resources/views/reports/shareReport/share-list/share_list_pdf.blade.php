<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share List Report - {{ $date }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        .summary {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }
        .summary div {
            width: 30%;
            padding: 10px;
            background-color: #f4f4f4;
            border-radius: 5px;
            text-align: center;
        }
        .summary div h5 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Share List Report - {{ $date }}</h2>

    {{-- Summary Cards --}}
    <div class="summary">
        <div>
            <h5>Total Shares</h5>
            <h3>₹ {{ number_format($totalShares, 2) }}</h3>
        </div>
        <div>
            <h5>Total Members</h5>
            <h3>{{ $totalMembers }}</h3>
        </div>
    </div>

    {{-- Share List Table --}}
    <table>
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Member Name</th>
                <th>Share ID</th>
                <th>Share Type</th>
                <th>Number of Shares</th>
                <th>Share Value</th>
                <th>Total Share Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shareholders as $shareholder)
            <tr>
                <td>{{ $shareholder->member_id }}</td>
                <td>{{ $shareholder->member_name }}</td>
                <td>{{ $shareholder->share_id }}</td>
                <td>{{ $shareholder->share_type }}</td>
                <td>{{ $shareholder->number_of_shares?? '' }}</td>
                <td>₹ {{ number_format($shareholder->share_amount, 2) }}</td>
                <td>₹ {{ number_format($shareholder->number_of_shares * $shareholder->share_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
