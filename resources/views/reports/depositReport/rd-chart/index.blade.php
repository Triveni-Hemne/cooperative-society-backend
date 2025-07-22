@extends('layouts.app')

@section('title', 'RD Chart Report')
@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container mt-0">
    <h3 class="text-center">📊 Recurring Deposit Scheme</h3>

    <div class="    ">
             <form action="{{ route('rd-chart.index') }}" method="GET" class="row align-items-end">
                    <div class="col-md-3">
                        <label for="opening_date" class="form-label">Opening Date</label>
                        <input type="date" name="opening_date" id="opening_date" class="form-control" value="{{ request('opening_date') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="closing_date" class="form-label">Closing Date</label>
                        <input type="date" name="closing_date" id="closing_date" class="form-control" value="{{ request('closing_date') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label for="interest_rate" class="form-label">Interest Rate (%)</label>
                        <input type="number" step="0.01" name="interest_rate" id="interest_rate" class="form-control" value="{{ request('interest_rate') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label for="no_of_installments" class="form-label">No. of Installments</label>
                        <input type="number" name="no_of_installments" id="no_of_installments" class="form-control" value="{{ request('no_of_installments') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label for="installment_amount" class="form-label">Installment Amount</label>
                        <input type="number" step="0.01" name="installment_amount" id="installment_amount" class="form-control" value="{{ request('installment_amount') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="interest_frequency" class="form-label">Interest Frequency</label>
                        <select name="interest_frequency" id="interest_frequency" class="form-select">
                            <option value="monthly" {{ request('interest_frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="quarterly" {{ request('interest_frequency') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="half-yearly" {{ request('interest_frequency') == 'half-yearly' ? 'selected' : '' }}>Half-Yearly</option>
                            <option value="yearly" {{ request('interest_frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>
                {{-- Branch --}}
                {{-- @if(!empty($branches))
                <select name="branch_id" class="form-select">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                @endif --}}
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">🔍 Search</button>
                </div>
            </form>
    </div>

    @if(!empty($installments))
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('rd-chart.pdf') }}" method="GET" target="_blank" class="me-2">
                <input type="hidden" name="opening_date" value="{{ request('opening_date') }}">
                <input type="hidden" name="closing_date" value="{{ request('closing_date') }}">
                <input type="hidden" name="interest_rate" value="{{ request('interest_rate') }}">
                <input type="hidden" name="installment_amount" value="{{ request('installment_amount') }}">
                <input type="hidden" name="no_of_installments" value="{{ request('no_of_installments') }}">
                <input type="hidden" name="interest_frequency" value="{{ request('interest_frequency') }}">
                <input type="hidden" name="type" value="stream">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-printer"></i> Print
                </button>
            </form>

            <form action="{{ route('rd-chart.pdf') }}" method="GET">
                <input type="hidden" name="opening_date" value="{{ request('opening_date') }}">
                <input type="hidden" name="closing_date" value="{{ request('closing_date') }}">
                <input type="hidden" name="interest_rate" value="{{ request('interest_rate') }}">
                <input type="hidden" name="installment_amount" value="{{ request('installment_amount') }}">
                <input type="hidden" name="no_of_installments" value="{{ request('no_of_installments') }}">
                <input type="hidden" name="interest_frequency" value="{{ request('interest_frequency') }}">
                <input type="hidden" name="type" value="download">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
            </form>
        </div>
    @endif

    {{-- <div class="table-responsive mt-3">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Account No</th>
                    <th>Account Holder</th>
                    <th>Installment Amount</th>
                    <th>Start Date</th>
                    <th>Duration (Months)</th>
                    <th>Interest Rate (%)</th>
                    <th>Interest Earned</th>
                    <th>Total Balance</th>
                    <th>Maturity Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rdAccounts as $account)
                <tr>
                    <td>{{ $account->acc_no }}</td>
                    <td>{{ $account->account_holder_name }}</td>
                    <td>₹{{ number_format($account->installment_amount, 2) }}</td>
                    <td>{{ $account->start_date }}</td>
                    <td>{{ $account->duration_months }}</td>
                    <td>{{ $account->interest_rate }}%</td> --}}
                    {{-- <td>₹{{ number_format($account->interest_earned, 2) }}</td> --}}
                    {{-- <td>₹{{ $account->interest_earned }}</td> --}}
                    {{-- <td>₹{{ number_format($account->total_balance, 2) }}</td> --}}
                    {{-- <td>₹{{ $account->total_balance }}</td>
                    <td>{{ $account->maturity_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}

     @if(!empty($installments))
    <div class="table-responsive" style="overflow: scroll; height:45vh">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Installment</th>
                    <th>Interest</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($installments as $row)
                <tr>
                    <td>{{ $row['sno'] }}</td>
                    <td>{{ $row['date'] }}</td>
                    <td>₹{{ $row['installment'] }}</td>
                    <td>₹{{ $row['interest'] }}</td>
                    <td>₹{{ $row['balance'] }}</td>
                </tr>
                @endforeach
                <tr class="table-secondary fw-bold">
                    <td colspan="3">Total</td>
                    <td>₹{{ $totalInterest }}</td>
                    <td>₹{{ $finalBalance }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
