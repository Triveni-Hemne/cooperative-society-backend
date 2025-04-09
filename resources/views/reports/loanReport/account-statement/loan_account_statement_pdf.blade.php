<!DOCTYPE html>
<html>
<head>
    <title>Loan Account Statement</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="header">Loan Account Statement</div>

    <p><strong>Loan Account No:</strong> {{ $loan->acc_no }}</p>
    <p><strong>Borrower Name:</strong> {{ $loan->name }}</p>
    <p><strong>Loan Amount:</strong> ₹{{ number_format($loan->loan_amount, 2) }}</p>
    <p><strong>Interest Rate:</strong> {{ $loan->interest_rate }}%</p>
    <p><strong>Loan Tenure:</strong> {{ $loan->tenure }} months</p>
    <p><strong>Total Paid:</strong> ₹{{ number_format($totalPaid, 2) }}</p>
    <p><strong>Outstanding Balance:</strong> ₹{{ number_format($outstandingBalance, 2) }}</p>
    <p><strong>Interest Accrued:</strong> ₹{{ number_format($interestAccrued, 2) }}</p>

    <hr>
    <h4>Transaction History</h4>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>₹{{ number_format($transaction->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
