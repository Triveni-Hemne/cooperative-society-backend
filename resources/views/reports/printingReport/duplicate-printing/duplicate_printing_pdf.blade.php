
<!DOCTYPE html>
<html>
<head>
    <title>Duplicate Receipt</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header, .footer { text-align: center; }
        .details, .table-data { width: 100%; margin-top: 10px; }
        .table-data th, .table-data td { padding: 6px; border: 1px solid #000; }
        .table-data { border-collapse: collapse; }
        .section-title { font-weight: bold; margin-top: 20px; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Cooperative Society</h2>
        <h4>Duplicate Receipt</h4>
    </div>

    <table class="details">
        <tr>
            <td><strong>Voucher No:</strong> {{ $entry->voucher_num }}</td>
            <td><strong>Date:</strong> {{ \Carbon\Carbon::parse($entry->date)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td><strong>Member Name:</strong> 
                {{ optional($entry->memberDepositAccount)->name  
                                        ?? optional($entry->memberLoanAccount)->name 
                                        ?? optional($entry->account)->name 
                                        ?? '-' }}
            </td>
            <td><strong>Account Type:</strong> 
                @if ($entry->member_depo_account_id) Deposit
                @elseif ($entry->member_loan_account_id) Loan
                @else General @endif
            </td>
        </tr>
        <tr>
            <td><strong>Transaction Type:</strong> {{ $entry->transaction_type }}</td>
            <td><strong>Payment Mode:</strong> {{ $entry->payment_mode ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Amount:</strong> ₹ {{ number_format($entry->amount, 2) }}</td>
        </tr>
    </table>

    <div class="section-title">Narration:</div>
    <p>{{ $entry->narration }}</p>

    <div class="signature">
        <table width="100%">
            <tr>
                <td align="left"><strong>Authorized By</strong></td>
                <td align="right"><strong>Member Signature</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>This is a system-generated duplicate receipt.</p>
    </div>

</body>
</html>
