<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Loan Register - {{ $date }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Overdue Loan Register - {{ $date }}</h2>
        @if(count($overdueLoans))
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>SrNo</th>
                            <th>Name</th>
                            <th>A/C No</th>
                            <th>Loan Date</th>
                            <th>Sanction Amount</th>
                            <th>Overdue Amount</th>
                            <th>Interest</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overdueLoans as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['account_no'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($row['loan_date'])->format('d-m-Y') }}</td>
                            <td>{{ number_format($row['sanction_amount'], 2) }}</td>
                            <td>{{ number_format($row['overdue_amount'], 2) }}</td>
                            <td>{{ number_format($row['interest'], 2) }}</td>
                            <td>{{ number_format($row['total'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="alert alert-info mt-4">No overdue loans found for selected filters.</div>
            @endif
    </div>
</body>
</html>