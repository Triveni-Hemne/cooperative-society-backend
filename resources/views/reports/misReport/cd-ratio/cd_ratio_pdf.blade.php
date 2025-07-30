<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CD Ratio Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Credit-Deposit Ratio (CD Ratio) Report</h2>
    <p><strong>As on:</strong> {{ $date }}</p>

   <div class="table-responsive mt-4" style="height: 45vh; overflow:scroll">
        @if(isset($data))
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 10%;">GL Id</th>
                        <th style="width: 60%;">Ledger Name</th>
                        <th style="width: 30%;" class="text-end">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $group => $ledgers)
                        {{-- Group Header Row --}}
                        <tr class="table-primary fw-semibold">
                            <td colspan="3" class="text-start">{{ strtoupper($group) }}</td>
                        </tr>

                        @php $total = 0; @endphp

                        {{-- Ledgers under Group --}}
                        @foreach($ledgers as $ledger)
                            <tr>
                                <td class="text-center">{{ $ledger['id'] }}</td>
                                <td>{{ $ledger['name'] }}</td>
                                <td class="text-end">{{ number_format($ledger['total_amount'], 2) }}</td>
                            </tr>
                            @php $total += $ledger['total_amount']; @endphp
                        @endforeach

                        {{-- Group Total --}}
                        <tr class="table-secondary fw-bold">
                            <td></td>
                            <td class="text-end">Group Total:</td>
                            <td class="text-end">{{ number_format($total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
