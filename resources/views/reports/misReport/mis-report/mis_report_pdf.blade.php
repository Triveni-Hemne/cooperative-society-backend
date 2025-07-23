<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Management Information System (MIS) Report</h2>
    <p><strong>As on:</strong> {{ $date }}</p>

    <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Category</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-primary">
                    <td><strong>Total Deposits Collected</strong></td>
                    <td>₹{{ number_format($totalDeposits, 2) }}</td>
                </tr>
                <tr class="table-success">
                    <td><strong>Total Loans Disbursed</strong></td>
                    <td>₹{{ number_format($totalLoansDisbursed, 2) }}</td>
                </tr>
                <tr class="table-info">
                    <td><strong>Total Loans Outstanding</strong></td>
                    <td>₹{{ number_format($totalLoansOutstanding, 2) }}</td>
                </tr>
                <tr class="table-success">
                    <td><strong>Total Interest Earned</strong></td>
                    <td>₹{{ number_format($totalInterestEarned, 2) }}</td>
                </tr>
                <tr class="table-warning">
                    <td><strong>Total Interest Paid</strong></td>
                    <td>₹{{ number_format($totalInterestPaid, 2) }}</td>
                </tr>
                <tr class="table-secondary">
                    <td><strong>Total Members</strong></td>
                    <td>{{ $totalMembers }}</td>
                </tr>
                <tr class="table-secondary">
                    <td><strong>Total Accounts</strong></td>
                    <td>{{ $totalAccounts }}</td>
                </tr>
                <tr class="table-danger">
                    <td><strong>Loan Overdue Amount</strong></td>
                    <td>₹{{ number_format($loanOverdue, 2) }}</td>
                </tr>
                <tr class="table-danger text-white">
                    <td><strong>NPA Loans</strong></td>
                    <td>₹{{ number_format($totalNPALoans, 2) }}</td>
                </tr>
                <tr class="table-danger">
                    <td><strong>NPA Ratio (%)</strong></td>
                    <td>{{ number_format($npaRatio, 2) }}%</td>
                </tr>
                <tr class="table-primary">
                    <td><strong>Share Capital Amount</strong></td>
                    <td>{{ number_format($shareCapitalAmount, 2) }}%</td>
                </tr>
                <tr class="table-warning">
                    <td><strong>Cd Ratio</strong></td>
                    <td>{{ number_format($cdRatio, 2) }}%</td>
                </tr>
                <tr class="table-light">
                    <td><strong>Total Credit</strong></td>
                    <td>₹{{ number_format($totalCredit, 2) }}</td>
                </tr>
                <tr class="table-light">
                    <td><strong>Total Debit</strong></td>
                    <td>₹{{ number_format($totalDebit, 2) }}</td>
                </tr>
                <tr class="table-success">
                    <td><strong>Profit</strong></td>
                    <td>₹{{ number_format($profit, 2) }}</td>
                </tr>
                <tr class="table-danger">
                    <td><strong>Loss</strong></td>
                    <td>₹{{ number_format($loss, 2) }}</td>
                </tr>
                <tr class="table-warning">
                    <td><strong>Overdue Percent</strong></td>
                    <td>{{ number_format($overduePercent, 2) }}%</td>
                </tr>
            </tbody>
        </table>
</body>
</html>
