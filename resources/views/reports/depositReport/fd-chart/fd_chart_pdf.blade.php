<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FD Chart Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #333; color: white; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>📊 Fixed Deposit Chart - {{ $date }}</h2>

    <table>
        <thead>
            <tr>
                <th>Account No</th>
                <th>Account Holder</th>
                <th>Deposit Amount</th>
                <th>Interest Rate (%)</th>
                <th>Start Date</th>
                <th>Duration (Months)</th>
                <th>Interest Accrued</th>
                <th>Total Balance</th>
                <th>Maturity Date</th>
                <th>Maturity Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fdAccounts as $account)
            <tr>
                <td>{{ $account->acc_no }}</td>
                <td>{{ $account->account_holder_name }}</td>
                <td>₹{{ number_format($account->deposit_amount, 2) }}</td>
                <td>{{ $account->interest_rate }}%</td>
                <td>{{ $account->start_date }}</td>
                <td>{{ $account->duration_months }}</td>
                <td>₹{{ number_format($account->interest_accrued, 2) }}</td>
                <td>₹{{ number_format($account->total_balance, 2) }}</td>
                <td>{{ $account->maturity_date }}</td>
                <td>₹{{ number_format($account->maturity_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
