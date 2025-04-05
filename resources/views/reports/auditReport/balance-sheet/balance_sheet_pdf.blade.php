<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Balance Sheet (As on {{ \Carbon\Carbon::parse($asOnDate)->format('d M Y') }})</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            margin: 0 20px;
        }

        h2, h4 {
            text-align: center;
            margin: 10px 0;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-end {
            text-align: right;
        }

        .totals {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .row-flex {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 40px;
        }

        .column {
            flex: 1;
        }
    </style>
</head>
<body>

    <h2>Balance Sheet</h2>
    <h4>As on {{ \Carbon\Carbon::parse($asOnDate)->format('d M Y') }}</h4>

    <div class="row-flex">
        <div class="column">
            <div class="section-title">Assets</div>
            <table>
                <thead>
                    <tr>
                        <th>Ledger Name</th>
                        <th class="text-end">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                        <tr>
                            <td>{{ $asset['ledger_name'] }}</td>
                            <td class="text-end">{{ number_format($asset['amount'], 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2">No Asset entries</td></tr>
                    @endforelse
                    <tr class="totals">
                        <td>Total Assets</td>
                        <td class="text-end">{{ number_format($totalAssets, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="column">
            <div class="section-title">Liabilities & Equity</div>
            <table>
                <thead>
                    <tr>
                        <th>Ledger Name</th>
                        <th class="text-end">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($liabilities as $liability)
                        <tr>
                            <td>{{ $liability['ledger_name'] }}</td>
                            <td class="text-end">{{ number_format($liability['amount'], 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2">No Liability entries</td></tr>
                    @endforelse

                    @foreach($equity as $eq)
                        <tr>
                            <td>{{ $eq['ledger_name'] }}</td>
                            <td class="text-end">{{ number_format($eq['amount'], 2) }}</td>
                        </tr>
                    @endforeach

                    <tr class="totals">
                        <td>Total Liabilities + Equity</td>
                        <td class="text-end">{{ number_format($totalLiabilitiesEquity, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
