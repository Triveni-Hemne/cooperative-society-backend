<table>
    <thead>
        <tr>
            <th colspan="5" style="text-align: center; font-size: 16px;">
                Sub Day Book Report - {{ $date }}
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">Account Type: {{ $accountType ?? 'All' }}</th>
        </tr>
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
            <td>{{ $transaction->transaction_type }}</td>
            <td>{{ number_format($transaction->amount, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" style="text-align: right;">Total Deposits (₹)</th>
            <th>{{ number_format($totalDeposits, 2) }}</th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: right;">Total Withdrawals (₹)</th>
            <th>{{ number_format($totalWithdrawals, 2) }}</th>
        </tr>
    </tfoot>
</table>
