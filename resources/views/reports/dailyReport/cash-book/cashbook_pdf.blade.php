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
                <tr class="table-dark">
                    <th>Sr.No.</th>
                    <th colspan="2">Credit</th>
                    <th></th>
                    <th>Ledger</th>
                    <th colspan="3">Debit</th>
                </tr>
                <tr class="table-secondary">
                    <th></th>
                    <th>Cash</th>
                    <th>Trans.</th>
                    <th>Total</th>
                    <th></th>
                    <th>Cash</th>
                    <th>Trans.</th>
                    <th>Total</th>
                </tr>
            </thead>
        <tbody>
            @php $nos = 1; @endphp
                @foreach($grouped as $ledgerName => $transactionTypes)
                        @php
                        // Totals for each ledger group
                        $creditCashTotal = 0;
                        $creditTransTotal = 0;
                        $debitCashTotal = 0;
                        $debitTransTotal = 0;
                    @endphp

                    @foreach(['Receipt', 'Payment'] as $type)
                        @php
                            $entries = $transactionTypes[$type] ?? ['voucher_entries' => collect(), 'transfer_entries' => collect()];
                            $voucherEntries = $entries['voucher_entries'];
                            $transferEntries = $entries['transfer_entries'];
                        @endphp

                        @foreach($voucherEntries as $entry)
                            <tr>
                                <td>{{ $nos++ }}</td>
                                <td>{{ $type === 'Receipt' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                <td>0.00</td>
                                <td>{{ $type === 'Receipt' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                <td>{{ $ledgerName }}</td>
                                <td>{{ $type === 'Payment' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                <td>0.00</td>
                                <td>{{ $type === 'Payment' ? number_format($entry->amount, 2) : '0.00' }}</td>
                            </tr>

                            @php
                                if ($type === 'Receipt') {
                                    $creditCashTotal += $entry->amount;
                                } elseif ($type === 'Payment') {
                                    $debitCashTotal += $entry->amount;
                                }
                            @endphp
                        @endforeach

                        @foreach($transferEntries as $entry)
                            <tr>
                                <td>{{ $nos++ }}</td>
                                <td>0.00</td>
                                <td>{{ $type === 'Receipt' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                <td>{{ $type === 'Receipt' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                <td>{{ $ledgerName }}</td>
                                <td>0.00</td>
                                <td>{{ $type === 'Payment' ? number_format($entry->amount, 2) : '0.00' }}</td>
                                <td>{{ $type === 'Payment' ? number_format($entry->amount, 2) : '0.00' }}</td>
                            </tr>

                            @php
                                if ($type === 'Receipt') {
                                    $creditTransTotal += $entry->amount;
                                } elseif ($type === 'Payment') {
                                    $debitTransTotal += $entry->amount;
                                }
                            @endphp
                        @endforeach
                    @endforeach

                    {{-- Totals row for this ledger --}}
                    <tr style="font-weight: bold; background-color: #f8f9fa;">
                        <td></td>
                        <td>{{ number_format($creditCashTotal, 2) }}</td>
                        <td>{{ number_format($creditTransTotal, 2) }}</td>
                        <td>{{ number_format($creditCashTotal + $creditTransTotal, 2) }}</td>
                        <td>{{ $ledgerName }}</td>
                        <td>{{ number_format($debitCashTotal, 2) }}</td>
                        <td>{{ number_format($debitTransTotal, 2) }}</td>
                        <td>{{ number_format($debitCashTotal + $debitTransTotal, 2) }}</td>
                    </tr>
                @endforeach
        </tbody>
    </table>

    <p class="totals"><strong>Total Receipts:</strong>&#8377;{{ number_format($totalReceipts, 2) }}</p>
    <p class="totals"><strong>Total Payments:</strong>&#8377;{{ number_format($totalPayments, 2) }}</p>
    <p class="totals"><strong>Closing Balance:</strong>&#8377;{{ number_format($closingBalance, 2) }}</p>

</body>
</html>
