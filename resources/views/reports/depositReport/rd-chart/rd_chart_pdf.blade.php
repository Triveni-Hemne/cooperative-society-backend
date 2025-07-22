<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RD Chart Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #333; color: white; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>📊 Recurring Deposit Chart</h2>

    @if(!empty($installments))
    <div class="table-responsive" style="overflow: scroll; height:45vh">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Installment</th>
                    <th>Interest</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($installments as $row)
                <tr>
                    <td>{{ $row['sno'] }}</td>
                    <td>{{ $row['date'] }}</td>
                    <td>₹{{ $row['installment'] }}</td>
                    <td>₹{{ $row['interest'] }}</td>
                    <td>₹{{ $row['balance'] }}</td>
                </tr>
                @endforeach
                <tr class="table-secondary fw-bold">
                    <td colspan="3">Total</td>
                    <td>₹{{ $totalInterest }}</td>
                    <td>₹{{ $finalBalance }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
</body>
</html>
