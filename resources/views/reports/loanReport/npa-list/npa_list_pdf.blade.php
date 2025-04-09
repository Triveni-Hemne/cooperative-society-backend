<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NPA List Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid black; padding: 8px; text-align: center; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>📋 NPA List Report</h2>
        <p><strong>Date:</strong> {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Loan Account No</th>
                <th>Borrower Name</th>
                <th>Loan Amount</th>
                <th>First Default Date</th>
                <th>Days Overdue</th>
                <th>Outstanding Balance</th>
                <th>NPA Classification</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($overdueLoans as $loan)
            <tr>
                <td>{{ $loan->acc_no }}</td>
                <td>{{ $loan->borrower_name }}</td>
                <td>₹ {{ number_format($loan->loan_amount, 2) }}</td>
                <td>{{ $loan->first_default_date }}</td>
                <td>{{ $loan->days_overdue }}</td>
                <td>₹ {{ number_format($loan->outstanding_balance, 2) }}</td>
                <td>{{ $loan->npa_classification }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
