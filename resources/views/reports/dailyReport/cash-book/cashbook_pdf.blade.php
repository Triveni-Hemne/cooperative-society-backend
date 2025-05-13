<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Book Report - {{ $date }}</title>
     <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/DejaVuSans.ttf') }}") format('truetype');
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
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

    <div class="title">Cash Book Report - {{ $date }}</div>

    <p><strong>Opening Balance:</strong>&#8377;{{ number_format($openingBalance, 2) }}</p>

    <table>
        <thead>
            <tr>
               <th>Date</th>
                <th>Account Number</th>
                <th>Account Holder</th>
                <th>Transaction Type</th>
                <th>Amount (&#8377;)</th>
                <th>Payment Mode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->date }}</td>
                            <td>{{ $transaction->account->account_no ?? $transaction->memberDepositAccount->acc_no ?? $transaction->memberLoanAccount->acc_no ?? 'N/A' }}</td>
                            <td>{{ $transaction->account->name ?? $transaction->memberDepositAccount->name ?? $transaction->memberLoanAccount->name ?? 'N/A' }}</td>
                            <td>
                                @if($transaction->transaction_type == 'Deposit')
                                    <span class="badge bg-success">{{ $transaction->transaction_type }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $transaction->transaction_type }}</span>
                                @endif
                            </td>
                            <td>₹ {{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ $transaction->payment_mode }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="totals"><strong>Total Receipts:</strong>&#8377;{{ number_format($cashReceipts, 2) }}</p>
    <p class="totals"><strong>Total Payments:</strong>&#8377;{{ number_format($cashPayments, 2) }}</p>
    <p class="totals"><strong>Closing Balance:</strong>&#8377;{{ number_format($closingBalance, 2) }}</p>

</body>
</html>
