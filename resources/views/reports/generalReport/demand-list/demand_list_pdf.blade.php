<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Demand List PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        h3 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h3>Demand List Report</h3>
    <p>From: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}</strong> To: <strong>{{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>SL No.</th>
                <th>Member Name</th>
                <th>Account No.</th>
                <th>Installment Date</th>
                <th>Installment Amount</th>
                <th>With Interest</th>
            </tr>
        </thead>
        <tbody>
            @foreach($demandList as $i => $loan)
                @foreach($loan->loanInstallments as $installment)
                    <tr>
                        <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td>{{ $loan->member->name ?? '-' }}</td>
                        <td>{{ $loan->acc_no ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($installment->installment_due_date)->format('d-m-Y') }}</td>
                        <td>{{ number_format($installment->installment_amount, 2) }}</td>
                        <td>{{ number_format($installment->installment_with_interest, 2) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>
</html>
