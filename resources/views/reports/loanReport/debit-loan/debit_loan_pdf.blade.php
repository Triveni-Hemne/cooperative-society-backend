<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Debit Loan Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-date-range {
            margin-bottom: 10px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 10px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Debit Loan Report</h2>
    <div class="report-date-range">
        <strong>From:</strong> {{ \Carbon\Carbon::parse($fromDate)->format('d-m-Y') }} 
        <strong>To:</strong> {{ \Carbon\Carbon::parse($toDate)->format('d-m-Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Loan Account No</th>
                <th>Borrower Name</th>
                <th>Disbursement Date</th>
                <th>Loan Amount</th>
                <th>Interest Rate (%)</th>
                <th>Tenure (Months)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($debitLoans as $loan)
                <tr>
                    <td>{{ $loan->loan_account_no }}</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->disbursement_date)->format('d-m-Y') }}</td>
                    <td>{{ number_format($loan->loan_amount_disbursed, 2) }}</td>
                    <td>{{ $loan->interest_rate }}%</td>
                    <td>{{ $loan->tenure }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No loan disbursements found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
