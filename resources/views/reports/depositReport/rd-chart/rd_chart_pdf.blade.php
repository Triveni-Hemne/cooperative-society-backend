<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RD Chart Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #333; color: white; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>📊 Recurring Deposit Chart - {{ $date }}</h2>

    <table>
        <thead>
            <tr>
                <th>Account No</th>
                <th>Account Holder</th>
                <th>Installment Amount</th>
                <th>Start Date</th>
                <th>Duration (Months)</th>
                <th>Interest Rate (%)</th>
                <th>Interest Earned</th>
                <th>Total Balance</th>
                <th>Maturity Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rdAccounts as $account)
            <tr>
                <td>{{ $account->acc_no }}</td>
                <td>{{ $account->account_holder_name }}</td>
                <td>₹{{ number_format($account->installment_amount, 2) }}</td>
                <td>{{ $account->start_date }}</td>
                <td>{{ $account->duration_months }}</td>
                <td>{{ $account->interest_rate }}%</td>
                <td>₹{{ number_format($account->interest_earned, 2) }}</td>
                <td>₹{{ number_format($account->total_balance, 2) }}</td>
                <td>{{ $account->maturity_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
