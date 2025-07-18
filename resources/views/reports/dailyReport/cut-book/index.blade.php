@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Ledger Statement')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-4">Cut Book Report</h4>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('cut-book.index') }}" class="border rounded p-3 mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" class="form-control " value="{{request('date')}}" required>
            </div>
            <div class="col-md-3">
                <label for="ledgerId">Ledger:</label>
               <select name="ledger_id" id="ledgerId" class="form-select">
                    <option value="">All Ledgers</option>
                    @foreach($ledgers as $ledger)
                        <option value="{{ $ledger->id }}" {{ $ledger->id == $ledger_id ? 'selected' : '' }}>{{ $ledger->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="col-md-3">
                <label for="loan_account">Loan Account:</label>
                <select name="loan_account" id="loan_account" class="form-control">
                    <option value="">All Accounts</option>
                    @foreach($loanAccounts as $id => $account)
                        <option value="{{ $id }}" {{ $id == $loanAccountId ? 'selected' : '' }}>{{ $account }}</option>
                    @endforeach
                </select>
            </div> --}}
            @if(!empty($branches))
            <div class="col-md-3">
                <label for="">Branch:</label>
            {{-- Branch --}}
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
            </div>
                @endif
            <div class="col-md-2 mt-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Export PDF Button -->
    <div class="d-flex justify-content-end my-3 ">
        <form action="{{ route('cut-book.pdf') }}" method="GET" target="_blank">
             @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="ledger_id" value="{{ $ledger_id }}">
            <input type="hidden" name="type" value="stream" required>
            {{-- <input type="hidden" name="loan_account" value="{{ $loanAccountId }}"> --}}
            <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
        </form>
        <form action="{{ route('cut-book.pdf') }}" method="GET" target="">
             @csrf
           <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="ledger_id" value="{{ $ledger_id }}">
            <input type="hidden" name="type" value="download" required>
            {{-- <input type="hidden" name="loan_account" value="{{ $loanAccountId }}"> --}}
            <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
        </form>
    </div>

    <!-- Cut Book Report Table -->
        @if(isset($data) && count($data))
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Sr No</th>
                            <th>Account No</th>
                            <th>Member Name</th>
                            <th class="text-end">Credit Balance</th>
                            <th class="text-end">Debit Balance</th>
                            <th>Opening Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row['account_no'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td class="text-end">{{ number_format($row['credit_balance'], 2) }}</td>
                                <td class="text-end">{{ number_format($row['debit_balance'], 2) }}</td>
                                <td>{{ $row['opening_date'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif(request()->has('ledger_id'))
            <div class="alert alert-warning mt-4">No data found for the selected ledger and date.</div>
        @endif
</div>
@endsection

@section('customeJs')
@endsection

