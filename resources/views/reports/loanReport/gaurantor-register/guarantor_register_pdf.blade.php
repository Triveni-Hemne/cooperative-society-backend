<!DOCTYPE html>
<html>
<head>
    <title>Guarantor Register</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="header">Guarantor Register</div>

    <table>
        <thead>
            <tr>
                <th>Loan Account No</th>
                <th>Borrower Name</th>
                <th>Guarantor Name</th>
                <th>Contact</th>
                <th>Relationship</th>
                <th>Income</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guarantors as $guarantor)
                <tr>
                    <td>{{ $guarantor->loan_account_no }}</td>
                    <td>{{ $guarantor->borrower_name }}</td>
                    <td>{{ $guarantor->guarantor_name }}</td>
                    <td>{{ $guarantor->guarantor_contact ?? ''}}</td>
                    <td>{{ $guarantor->guarantor_relationship ?? '' }}</td>
                    <td>{{ number_format($guarantor->guarantor_income ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
