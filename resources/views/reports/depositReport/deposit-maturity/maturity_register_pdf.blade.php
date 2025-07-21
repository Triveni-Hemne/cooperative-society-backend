<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Maturity Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .container { width: 100%; padding: 20px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; }
        .summary { margin-bottom: 20px; }
        .summary p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">📜 Deposit Maturity Report - From: {{ $fromDate }} To: {{$toDate}}</div>
        
        {{-- <div class="summary">
            <p><strong>Total Matured Deposits:</strong> {{ count($maturingDeposits) }}</p>
            <p><strong>Total Maturity Amount:</strong> ₹ {{ number_format($totalMaturityAmount, 2) }}</p>
        </div> --}}
        
         <table class="table table-bordered table-sm text-center">
            <thead class="thead-dark">
                <tr>
                    <th>SrNo</th>
                    <th>A/cNo</th>
                    <th>Name</th>
                    <th>Opening Date</th>
                    <th>Period</th>
                    <th>Rate</th>
                    <th>Closing.Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($maturingDeposits as $index => $deposit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $deposit->acc_no }}</td>
                        <td>{{ $deposit->account_holder_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($deposit->start_date)->format('d/m/Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($deposit->start_date)->diffInMonths($deposit->maturity_date) }} Months
                        </td>
                        <td>{{ number_format($deposit->interest_rate, 2) }}%</td>
                        <td>{{ \Carbon\Carbon::parse($deposit->maturity_date)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">No matured deposits found for selected date.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="font-weight-bold">
                    <td colspan="6" class="text-right">Total Maturity Amount</td>
                    <td class="text-success">{{ number_format($totalMaturityAmount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
