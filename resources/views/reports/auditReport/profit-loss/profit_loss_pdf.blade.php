<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profit & Loss Statement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { height: 50px; }
        .report-title { font-size: 18px; font-weight: bold; margin-top: 10px; }
        .period { font-size: 14px; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 6px 8px; border: 1px solid #444; }
        th { background: #f0f0f0; text-align: left; }

        .section-title { font-size: 16px; margin: 15px 0 5px; border-bottom: 1px solid #ccc; }
        .total-row td { font-weight: bold; background: #fafafa; }
        .net-summary { font-size: 16px; font-weight: bold; text-align: center; margin-top: 20px; }

        .signature-section { margin-top: 60px; display: flex; justify-content: space-between; }
        .signature-line { width: 200px; text-align: center; border-top: 1px solid #000; padding-top: 5px; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        {{-- Logo --}}
        <img src="{{ public_path('images/logo.png') }}" alt="Organization Logo" class="logo">
        <div class="report-title">Profit & Loss Statement</div>
        <div class="period">
            Period: {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}
        </div>
    </div>

    {{-- Income --}}
    <div class="section-title">Income</div>
    <table>
        <thead>
            <tr>
                <th>Ledger Name</th>
                <th class="text-right">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incomeLedgers as $ledger)
                <tr>
                    <td>{{ $ledger['ledger_name'] }}</td>
                    <td class="text-right">{{ number_format($ledger['amount'], 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">No Income Records</td></tr>
            @endforelse
            <tr class="total-row">
                <td>Total Income</td>
                <td class="text-right">{{ number_format($totalIncome, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Expenses --}}
    <div class="section-title">Expenses</div>
    <table>
        <thead>
            <tr>
                <th>Ledger Name</th>
                <th class="text-right">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenseLedgers as $ledger)
                <tr>
                    <td>{{ $ledger['ledger_name'] }}</td>
                    <td class="text-right">{{ number_format($ledger['amount'], 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">No Expense Records</td></tr>
            @endforelse
            <tr class="total-row">
                <td>Total Expenses</td>
                <td class="text-right">{{ number_format($totalExpense, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Net Profit/Loss --}}
    <div class="net-summary">
        Net {{ $netProfit >= 0 ? 'Profit' : 'Loss' }}: ₹{{ number_format(abs($netProfit), 2) }}
    </div>

    {{-- Signature Lines --}}
    <div class="signature-section">
        <div class="signature-line">Prepared By</div>
        <div class="signature-line">Checked By</div>
        <div class="signature-line">Approved By</div>
    </div>

</body>
</html>
