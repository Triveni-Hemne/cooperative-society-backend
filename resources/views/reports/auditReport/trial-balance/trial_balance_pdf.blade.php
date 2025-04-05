<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Trial Balance - {{ $asOnDate }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .header {
            margin-bottom: 20px;
            text-align: center;
        }
        .logo {
            height: 60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #555;
            padding: 6px 8px;
            text-align: right;
        }
        th {
            background-color: #f0f0f0;
        }
        td:first-child, th:first-child {
            text-align: left;
        }
        .group-header {
            background-color: #dfe6e9;
            font-weight: bold;
        }
        .totals {
            font-weight: bold;
            background-color: #b2bec3;
        }
        .footer {
            margin-top: 30px;
            font-size: 11px;
            text-align: center;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 30%;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 4px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Bank Logo" class="logo">
        <h2>Cooperative Society Bank</h2>
        <p><strong>Trial Balance</strong> as on <strong>{{ \Carbon\Carbon::parse($asOnDate)->format('d-m-Y') }}</strong></p>
    </div>

    @php
        $grouped = collect($trialBalance)->groupBy('ledger_type');
    @endphp

    <table>
        <thead>
            <tr>
                <th>Ledger Name</th>
                <th>Debit Amount (₹)</th>
                <th>Credit Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grouped as $type => $ledgers)
                <tr class="group-header">
                    <td colspan="3">{{ strtoupper($type) }}</td>
                </tr>

                @foreach($ledgers as $row)
                    <tr>
                        <td>{{ $row['ledger_name'] }}</td>
                        <td>{{ number_format($row['debit'], 2) }}</td>
                        <td>{{ number_format($row['credit'], 2) }}</td>
                    </tr>
                @endforeach
            @endforeach

            <tr class="totals">
                <td>Total</td>
                <td>{{ number_format($totalDebit, 2) }}</td>
                <td>{{ number_format($totalCredit, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">Prepared By</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">Verified By</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">Authorized By</div>
        </div>
    </div>

    <div class="footer">
        Printed on {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>

</body>
</html>
