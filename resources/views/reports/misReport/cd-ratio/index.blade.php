@include('layouts.session')

@extends('layouts.app')
@section('title', 'CD Ratio Report')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container ">
    <h3 class="mb-4">Credit-Deposit Ratio (CD Ratio) Report</h3>
    <form method="GET" action="{{ route('cd-ratio.index') }}" class="row g-3 align-items-center border p-3 mb-4 rounded">
        <div class="row">
        <div class="col-md-4 mb-3">
            <label for="date" class="form-label">As on Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ request('date', now()->toDateString()) }}">
        </div>
         @if(!empty($branches))
            <div class="col-md-3 mb-3">
                <label class="form-label">Branch</label>
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
        <div class="col-md-4 d-flex align-items-end mb-3">
            <button type="submit" class="btn btn-primary me-2">Generate</button>
        </div>
        </div>
    </form>

    <div class="export-btns">
            <a href="{{ route('cd-ratio.pdf', ['date' => request('date'), 'type' => 'stream', 'branch_id' => request('branch_id')]) }}" class="btn btn-secondary" target="_blank"><i class="bi bi-printer"></i> Print</a>
            <a href="{{ route('cd-ratio.pdf', ['date' => request('date'), 'type' => 'download', 'branch_id' => request('branch_id')]) }}" class="btn btn-danger" target=""><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
    </div>

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

</div>
@endsection
