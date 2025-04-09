<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trial Balance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .totals {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Trial Balance Report</h2>
        <p>From: {{ $fromDate }} To: {{ $toDate }}</p>

        <table>
            <thead>
                <tr>
                    <th>Ledger ID</th>
                    <th>Ledger Name</th>
                    <th>Opening Balance</th>
                    <th>Debits</th>
                    <th>Credits</th>
                    <th>Closing Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ledgers as $ledger)
                    <tr>
                        <td>{{ $ledger->ledger_id }}</td>
                        <td>{{ $ledger->ledger_name }}</td>
                        <td>{{ number_format($ledger->opening_balance, 2) }}</td>
                        <td>{{ number_format($ledger->total_debit, 2) }}</td>
                        <td>{{ number_format($ledger->total_credit, 2) }}</td>
                        <td>{{ number_format($ledger->closing_balance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td colspan="3">Total</td>
                    <td>{{ number_format($totalDebit, 2) }}</td>
                    <td>{{ number_format($totalCredit, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
