@extends('layouts.app')

@section('title', 'Profit and Loss Statement')
@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('profit-loss.index')}}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control"
                        value="{{ request('from_date', $fromDate) }}" required>
                </div>

                <div class="col-md-4">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control"
                        value="{{ request('to_date', $toDate) }}" required>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Profit and Loss Statement</h4>
      <div class="export-btns">
          <a href="{{ route('profit-loss.pdf',['from_date' => $fromDate, 'to_date' => $toDate, 'type' => 'stream']) }}" target="_blank" class="btn btn-sm btn-secondary">
            <i class="bi bi-printer"></i> Print
        </a>
        <a href="{{ route('profit-loss.pdf', ['from_date' => $fromDate, 'to_date' => $toDate, 'type' => 'download']) }}"  class="btn btn-sm btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
      </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="text-center mb-4">
                Period: {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Income</h5>
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Ledger Name</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incomeLedgers as $ledger)
                                <tr>
                                    <td>{{ $ledger['ledger_name'] }}</td>
                                    <td class="text-end">{{ number_format($ledger['amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">No income entries</td></tr>
                            @endforelse
                            <tr class="fw-bold">
                                <td>Total Income</td>
                                <td class="text-end">{{ number_format($totalIncome, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Expenses</h5>
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Ledger Name</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenseLedgers as $ledger)
                                <tr>
                                    <td>{{ $ledger['ledger_name'] }}</td>
                                    <td class="text-end">{{ number_format($ledger['amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">No expense entries</td></tr>
                            @endforelse
                            <tr class="fw-bold">
                                <td>Total Expenses</td>
                                <td class="text-end">{{ number_format($totalExpense, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 p-3 bg-light border text-center">
                <h4>
                    Net {{ $netProfit >= 0 ? 'Profit' : 'Loss' }}:
                    <span class="{{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                        ₹{{ number_format(abs($netProfit), 2) }}
                    </span>
                </h4>
            </div>
        </div>
    </div>
</div>
@endsection
