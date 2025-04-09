<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Transaction Type</th>
            <th>Account Holder</th>
            <th>Account Number</th>
            <th>Amount</th>
            <th>Payment Mode</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->transaction_date }}</td>
            <td>{{ $transaction->transaction_type }}</td>
            <td>{{ $transaction->account_holder_name }}</td>
            <td>{{ $transaction->account_number }}</td>
            <td>{{ number_format($transaction->amount, 2) }}</td>
            <td>{{ $transaction->payment_mode }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
