@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Dividend Balance')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container" >
    <h2 class="mb-4">Dividend Balance Report ({{ $date }})</h2>
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('dividend-balance.index') }}" method="GET" class="d-flex form-outline input-group">
                    <input type="date" name="date" class="form-control " value="{{ $date }}" required >
                      @if(!empty($branches))
                    {{-- Branch --}}
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @endif
                    <button type="submit" class="btn btn-primary fs-5" data-mdb-ripple-init><i class="bi bi-search text-light" ></i></button>
                </form>
            </div>
        </div>
    <div class="mb-3">
        <div class="export-btns d-flex justify-content-end">
            <a href="{{ route('dividend-balance.pdf', ['date' => $date, 'type' => 'stream', 'branch_id' => request('branch_id') ]) }}" class="btn btn-secondary me-1" target="_blank"><i class="bi bi-printer"></i> Print</a>
            <a href="{{ route('dividend-balance.pdf', ['date' => $date, 'type' => 'download', 'branch_id' => request('branch_id') ]) }}" class="btn btn-primary" target=""><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
        </div>
    </div>
<div style="overflow-x: scroll">
    <table class="table table-bordered" >
        <thead class="table-dark">
            <tr>
                <th>Member ID</th>
                <th>Member Name</th>
                <th>Share ID</th>
                <th>Share Type</th>
                <th>Number of Shares</th>
                <th>Entitled Dividend (₹)</th>
                <th>Distributed Dividend (₹)</th>
                <th>Remaining Balance (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shareholders as $shareholder)
            <tr>
                <td>{{ $shareholder->member_id }}</td>
                <td>{{ $shareholder->member_name }}</td>
                <td>{{ $shareholder->share_id }}</td>
                <td>{{ $shareholder->share_type }}</td>
                <td>{{ $shareholder->number_of_shares }}</td>
                <td>₹ {{ number_format($shareholder->entitled_dividend, 2) }}</td>
                <td>₹ {{ number_format($shareholder->distributed_dividend, 2) }}</td>
                <td>₹ {{ number_format($shareholder->remaining_dividend, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-weight-bold">
                <td colspan="5">Total</td>
                <td>₹ {{ number_format($totalDividendPool, 2) }}</td>
                <td>₹ {{ number_format($totalDistributed, 2) }}</td>
                <td>₹ {{ number_format($totalRemaining, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    
</div>
</div>
@endsection
