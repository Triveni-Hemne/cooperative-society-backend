<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Day Book Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Day Book Report - {{ $date }}</h2>
    <table>
         <thead class="">
            <tr>
                <th rowspan="2">SrNo</th>
                <th rowspan="2">Ledger Id</th>
                <th rowspan="2">A/c Id</th>
                <th colspan="3">Credit</th>
                <th colspan="3">Debit</th>
            </tr>
            <tr>
                <th>Cash</th>
                <th>Transfer</th>
                <th>Total</th>
                <th>Cash</th>
                <th>Transfer</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
           @php
            $srNo = 1;
            $totalCreditCash = 0;
            $totalCreditTransfer = 0;
            $totalDebitCash = 0;
            $totalDebitTransfer = 0;
        @endphp

        @foreach($grouped as $ledgerName => $transactionTypes)
            @foreach(['Receipt', 'Payment'] as $type)
                @php
                    $entries = $transactionTypes[$type] ?? ['voucher_entries' => collect(), 'transfer_entries' => collect()];
                @endphp

                {{-- Voucher Entries (Cash) --}}
                @foreach($entries['voucher_entries'] as $entry)
                    @php
                        $accountName = $entry->account->name
                            ?? $entry->memberDepositAccount->name
                            ?? $entry->memberLoanAccount->name
                            ?? $entry->member->name
                            ?? 'N/A';

                        $isReceipt = $type === 'Receipt';

                        $amount = $entry->amount ?? 0;

                        if ($isReceipt) {
                            $totalCreditCash += $amount;
                        } else {
                            $totalDebitCash += $amount;
                        }
                    @endphp
                    <tr>
                        <td>{{ $srNo++ }}</td>
                        <td>{{ $ledgerName }}</td>
                        <td>{{ $accountName }}</td>
                        <td>{{ $isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                        <td>0.00</td>
                        <td>{{ $isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                        <td>{{ !$isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                        <td>0.00</td>
                        <td>{{ !$isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                    </tr>
                @endforeach

                {{-- Transfer Entries --}}
                @foreach($entries['transfer_entries'] as $entry)
                    @php
                        $accountName = $entry->account->name
                            ?? $entry->memberDepositAccount->name
                            ?? $entry->memberLoanAccount->name
                            ?? $entry->member->name
                            ?? 'N/A';

                        $isReceipt = $type === 'Receipt';

                        $amount = $entry->amount ?? 0;

                        if ($isReceipt) {
                            $totalCreditTransfer += $amount;
                        } else {
                            $totalDebitTransfer += $amount;
                        }
                    @endphp
                    <tr>
                        <td>{{ $srNo++ }}</td>
                        <td>{{ $ledgerName }}</td>
                        <td>{{ $accountName }}</td>
                        <td>0.00</td>
                        <td>{{ $isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                        <td>{{ $isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                        <td>0.00</td>
                        <td>{{ !$isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                        <td>{{ !$isReceipt ? number_format($amount, 2) : '0.00' }}</td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach

        {{-- Totals --}}
        <tr class="font-weight-bold bg-light">
            <td colspan="3">Total</td>
            <td>{{ number_format($totalCreditCash, 2) }}</td>
            <td>{{ number_format($totalCreditTransfer, 2) }}</td>
            <td>{{ number_format($totalCreditCash + $totalCreditTransfer, 2) }}</td>
            <td>{{ number_format($totalDebitCash, 2) }}</td>
            <td>{{ number_format($totalDebitTransfer, 2) }}</td>
            <td>{{ number_format($totalDebitCash + $totalDebitTransfer, 2) }}</td>
        </tr>

        <tr class="font-weight-bold">
            <td colspan="3">Opening Balance</td>
            <td colspan="3">{{ number_format($openingBalance, 2) }}</td>
            <td colspan="3">--</td>
        </tr>

        <tr class="font-weight-bold text-success">
            <td colspan="3">Grand Total</td>
            <td colspan="3">{{ number_format($openingBalance + $totalCreditCash + $totalCreditTransfer, 2) }}</td>
            <td colspan="3">{{ number_format($totalDebitCash + $totalDebitTransfer, 2) }}</td>
        </tr>
        </tbody>
    </table>
    <h3>Total Receipts: {{ number_format($totalReceipts, 2) }}</h3>
    <h3>Total Payments: {{ number_format($totalPayments, 2) }}</h3>
</body>
</html>
