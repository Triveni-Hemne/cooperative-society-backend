<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demand Day Book Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Demand Day Book Report - {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>Loan Account No.</th>
                <th>Borrower Name</th>
                <th>Demand Amount</th>
                <th>Amount Received</th>
                <th>Balance Due</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expectedPayments as $payment)
                <tr>
                    <td>{{ $payment->loan_account_no }}</td>
                    <td>{{ $payment->borrower_name }}</td>
                    <td>{{ number_format($payment->demand_amount, 2) }}</td>
                    <td>{{ number_format($payment->amount_received, 2) }}</td>
                    <td>{{ number_format($payment->balance_due, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No data available for this date.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
