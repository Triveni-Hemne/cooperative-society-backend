<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Duplicate Receipts List</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2, h4 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: right;
            font-style: italic;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h2>Cooperative Society</h2>
    <h4>Duplicate Receipts / Vouchers List</h4>

    @if($startDate && $endDate)
        <p><strong>Date Range:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Voucher No</th>
                <th>Member Name</th>
                <th>Account Type</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Narration</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entries as $index => $entry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($entry->date)->format('d-m-Y') }}</td>
                    <td>{{ $entry->voucher_num }}</td>
                    <td>
                        {{ optional($entry->memberDepositAccount->member)->name 
                            ?? optional($entry->memberLoanAccount->member)->name 
                            ?? '-' }}
                    </td>
                    <td>
                        @if ($entry->member_depo_account_id) Deposit
                        @elseif ($entry->member_loan_account_id) Loan
                        @else General @endif
                    </td>
                    <td>{{ number_format($entry->amount, 2) }}</td>
                    <td>{{ $entry->payment_mode }}</td>
                    <td>{{ $entry->narration }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Printed on: {{ now()->format('d-m-Y H:i:s') }}
    </div>

</body>
</html>
