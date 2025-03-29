<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Day Book Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 5px; text-align: center; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2 class="text-center">Sub Day Book Report - {{ $date }}</h2>

    <p><strong>Account Type:</strong> {{ $accountType ?? 'All' }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Account Type</th>
                <th>Account Holder</th>
                <th>Transaction Type</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->date }}</td>
                <td>{{ $transaction->account_type }}</td>
                <td>{{ $transaction->memberLoanAccount ? $transaction->memberLoanAccount->name : 'N/A' }}</td>
                <td>
                    @if($transaction->transaction_type == 'Deposit')
                        <span style="color: green;">{{ $transaction->transaction_type }}</span>
                    @else
                        <span style="color: red;">{{ $transaction->transaction_type }}</span>
                    @endif
                </td>
                <td>{{ number_format($transaction->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total Deposits (₹)</th>
                <th>{{ number_format($totalDeposits, 2) }}</th>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Total Withdrawals (₹)</th>
                <th>{{ number_format($totalWithdrawals, 2) }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>
