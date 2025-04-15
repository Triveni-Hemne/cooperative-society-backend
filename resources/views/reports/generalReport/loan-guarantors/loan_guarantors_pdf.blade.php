<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Loan Guarantor Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        .date-range {
            text-align: center;
            margin-top: 5px;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <h2>Loan Guarantor Report</h2>
    <div class="date-range">
        From <strong>{{ $startDate }}</strong> to <strong>{{ $endDate }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Loan ID</th>
                <th>Borrower Name</th>
                <th>Guarantor Name</th>
                <th>Loan Amount</th>
                <th>Guaranteed Amount</th>
                <th>Loan Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guarantors as $index => $g)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $g->loan->id ?? '-' }}</td>
                    <td>{{ $g->loan->member->name ?? '-' }}</td>
                    <td>{{ $g->guarantor->name ?? '-' }}</td>
                    <td>{{ number_format($g->loan->loan_amount ?? 0, 2) }}</td>
                    <td>{{ number_format($g->guaranteed_amount, 2) }}</td>
                    <td>{{ ucfirst($g->loan->status ?? '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No records found for the selected date range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Report generated on: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>

</body>
</html>
