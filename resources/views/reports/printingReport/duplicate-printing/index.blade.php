@extends('layouts.app')
@section('title', 'Duplicate Receipts')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Duplicate Receipt / Voucher Printing</h2>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('duplicate-printing.index') }}" class="card p-3 mb-4 shadow-sm">
        <div class="row">
            <div class="col-md-3">
                <label>Voucher Number</label>
                <select name="voucher_num" class="form-select">
                    <option value="">-- Select Voucher No --</option>
                    @foreach($voucherNumbers as $number)
                        <option value="{{ $number }}" {{ request('voucher_num') == $number ? 'selected' : '' }}>
                            {{ $number }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Member</label>
                <select name="member_id" class="form-select">
                    <option value="">-- Select Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            @if(!empty($branches))
            <div class="col-md-3">
                <label class="pt-2">Branch</label>
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
        </div>
        <div class="mt-3 text-end">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>

    <div class="mt-3 p-3 mb-4 shadow-sm d-flex border justify-content-end rounded">
    <form method="GET" action="{{ route('duplicate-printing.pdf.all') }}" target="_blank" class="me-1">
            <input type="hidden" name="type" value="stream">
            <input type="hidden" name="voucher_num" value="{{ request('voucher_num')}}">
            <input type="hidden" name="branch_id" value="{{ request('branch_id')}}">
            <input type="hidden" name="start_date" value="{{ request('start_date')}}">
            <input type="hidden" name="end_date" value="{{ request('end_date')}}">
            <input type="hidden" name="member_id" value="{{ request('member_id')}}">
            <button class="btn btn-secondary"><i class="bi bi-printer"></i> Print</button>
    </form>
    <form method="GET" action="{{ route('duplicate-printing.pdf.all') }}" >
        <input type="hidden" name="type" value="download">
        <input type="hidden" name="voucher_num" value="{{ request('voucher_num')}}">
        <input type="hidden" name="branch_id" value="{{ request('branch_id')}}">
        <input type="hidden" name="start_date" value="{{ request('start_date')}}">
        <input type="hidden" name="end_date" value="{{ request('end_date')}}">
        <input type="hidden" name="member_id" value="{{ request('member_id')}}">
            <button class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Download PDF</button>
        </form>
    </div>
        
    {{-- Results --}}
    @if($entries->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Search Results ({{ $entries->count() }})</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Voucher No</th>
                            <th>Member</th>
                            <th>Account Type</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Narration</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($entry->date)->format('d-m-Y') }}</td>
                                <td>{{ $entry->voucher_num }}</td>
                                <td>
                                    {{ optional($entry->memberDepositAccount)->name  
                                        ?? optional($entry->memberLoanAccount)->name 
                                        ?? optional($entry->account)->name 
                                        ?? '-' }}
                                </td>

                                <td>
                                    @if ($entry->member_depo_account_id) Deposit
                                    @elseif ($entry->member_loan_account_id) Loan
                                    @else General @endif
                                </td>
                                <td>{{ number_format($entry->amount, 2) ?? 0 }}</td>
                                <td>{{ $entry->payment_mode ?? "-"}}</td>
                                <td>{{ $entry->narration ?? "-"}}</td>
                                <td>
                                    <a href="{{ route('duplicate-printing.pdf.single', $entry->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="fa fa-download"></i> PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            No entries found for given criteria.
        </div>
    @endif
</div>
@endsection
