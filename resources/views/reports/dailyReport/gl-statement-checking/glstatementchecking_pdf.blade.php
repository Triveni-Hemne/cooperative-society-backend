<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ledger Statement - From: {{ $startDate }} To: {{ $endDate }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        .summary {
            margin: 20px 0;
            text-align: center;
        }
        .summary div {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        .small-text {
            font-size: 11px;
        }
    </style>
</head>
<body>

    <h2>📜 Ledger Statement</h2>
    <h4><strong>From:</strong> {{ $startDate }} <strong>To:</strong> {{ $endDate }}</h4>

    {{-- <div class="summary">
        <div><strong>Total Debit:</strong> ₹ {{ number_format($totalDebits, 2) }}</div>
        <div><strong>Total Credit:</strong> ₹ {{ number_format($totalCredits, 2) }}</div>
        <div><strong>Closing Balance:</strong> ₹ {{ number_format($closingBalance, 2) }}</div>
    </div> --}}

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SrNo</th>
                <th>GLID</th>
                <th>Name</th>
                <th>Credit Trans</th>
                <th>Debit Trans</th>
                <th>Difference</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ledgers as $index => $ledger)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ledger['gl_id'] }}</td>
                    <td>{{ $ledger['name'] }}</td>
                    <td>{{ number_format($ledger['credit'], 2) }}</td>
                    <td>{{ number_format($ledger['debit'], 2) }}</td>
                    <td>{{ number_format($ledger['difference'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
