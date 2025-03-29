<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cut Book Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Cut Book Report</h2>
    <p><strong>From:</strong> {{ $startDate }} <strong>To:</strong> {{ $endDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Loan Account No</th>
                <th>Borrower Name</th>
                <th>Loan Type</th>
                <th>EMI Amount</th>
                <th>Interest Paid</th>
                <th>Principal Paid</th>
                <th>Balance Due</th>
            </tr>
        </thead>
        <tbody>
            @if(is_array($transactions) || is_object($transactions))
             @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->loan_account_no }}</td>
                    <td>{{ $transaction->borrower_name }}</td>
                    <td>{{ $transaction->loan_type }}</td>
                    <td>{{ number_format($transaction->emi_amount, 2) }}</td>
                    <td>{{ number_format($transaction->interest_paid, 2) }}</td>
                    <td>{{ number_format($transaction->principal_paid, 2) }}</td>
                    <td>{{ number_format($transaction->balance_due, 2) }}</td>
                </tr>
             @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">No transactions available.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
