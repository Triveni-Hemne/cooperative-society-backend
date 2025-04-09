<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final NPA Chart - {{ $npaData['date'] }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .title { text-align: center; font-size: 24px; font-weight: bold; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        .summary { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="title">📊 Final NPA Chart - {{ $npaData['date'] }}</div>

    <table>
        <tr>
            <th>Total Loans Issued</th>
            <th>Total NPA Loans</th>
            <th>NPA Percentage</th>
            <th>Substandard</th>
            <th>Doubtful</th>
            <th>Loss</th>
        </tr>
        <tr>
            <td>{{ $npaData['totalLoans'] }}</td>
            <td>{{ $npaData['totalNPALoans'] }}</td>
            <td>{{ $npaData['npaPercentage'] }}%</td>
            <td>{{ $npaData['npaCounts']['substandard'] }}</td>
            <td>{{ $npaData['npaCounts']['doubtful'] }}</td>
            <td>{{ $npaData['npaCounts']['loss'] }}</td>
        </tr>
    </table>
</body>
</html>