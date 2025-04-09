<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Maturity Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .container { width: 100%; padding: 20px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; }
        .summary { margin-bottom: 20px; }
        .summary p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">📜 Deposit Maturity Report - {{ $date }}</div>
        
        <div class="summary">
            <p><strong>Total Matured Deposits:</strong> {{ count($maturingDeposits) }}</p>
            <p><strong>Total Maturity Amount:</strong> ₹ {{ number_format($totalMaturityAmount, 2) }}</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Account Number</th>
                    <th>Account Holder</th>
                    <th>Deposit Type</th>
                    <th>Start Date</th>
                    <th>Maturity Date</th>
                    <th>Principal Amount</th>
                    <th>Interest Rate (%)</th>
                    <th>Maturity Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maturingDeposits as $deposit)
                <tr>
                    <td>{{ $deposit->acc_no }}</td>
                    <td>{{ $deposit->account_holder_name }}</td>
                    <td>{{ ucfirst($deposit->deposit_type) }}</td>
                    <td>{{ $deposit->start_date }}</td>
                    <td>{{ $deposit->maturity_date }}</td>
                    <td>₹ {{ number_format($deposit->principal_amount, 2) }}</td>
                    <td>{{ $deposit->interest_rate }}</td>
                    <td>₹ {{ number_format($deposit->maturity_amount, 2) }}</td>
                    <td>{{ $deposit->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
