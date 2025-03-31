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
        <table>
            <thead>
                <tr>
                    <th>Loan Account No</th>
                    <th>Borrower Name</th>
                    <th>Sanction Date</th>
                    <th>Loan Amount</th>
                    <th>EMI Amount</th>
                    <th>Due Date</th>
                    <th>Days Overdue</th>
                    <th>Overdue Amount</th>
                    <th>Penalty</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($overdueLoans as $loan)
                <tr>
                    <td>{{ $loan->acc_no }}</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td>{{ $loan->loan_sanction_date }}</td>
                    <td>{{ number_format($loan->loan_amount, 2) }}</td>
                    <td>{{ number_format($loan->emi_amount, 2) }}</td>
                    <td>{{ $loan->due_date }}</td>
                    <td>{{ $loan->days_overdue }}</td>
                    <td>{{ number_format($loan->overdue_amount, 2) }}</td>
                    <td>{{ number_format($loan->penalty_amount, 2) }}</td>
                    <td>{{ number_format($loan->balance, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>