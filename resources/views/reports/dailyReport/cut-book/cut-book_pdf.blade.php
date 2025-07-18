<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cut Book Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Cut Book Report</h2>
    <p><strong>Date:</strong> {{ $date }}</p>

   @if(isset($data) && count($data))
                <table class="table table-bordered table-striped table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Sr No</th>
                            <th>Account No</th>
                            <th>Member Name</th>
                            <th class="text-end">Credit Balance</th>
                            <th class="text-end">Debit Balance</th>
                            <th>Opening Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row['account_no'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td class="text-end">{{ number_format($row['credit_balance'], 2) }}</td>
                                <td class="text-end">{{ number_format($row['debit_balance'], 2) }}</td>
                                <td>{{ $row['opening_date'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        @elseif(request()->has('ledger_id'))
            <div class="alert alert-warning mt-4">No data found for the selected ledger and date.</div>
        @endif
</body>
</html>
