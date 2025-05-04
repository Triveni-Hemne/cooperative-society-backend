<!-- resources/views/reports/dividend/index.blade.php -->
@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Dividend Calcuation')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Dividend Calculation Report - {{ $date }}</h2>
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('dividend-calculation.index') }}" method="GET" class="d-flex form-outline input-group">
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
    <div class="export-btns d-flex justify-content-end">
        <a href="{{ route('dividend-calculation.pdf', ['date' => $date, 'type' => 'stream', 'branch_id' => request('branch_id') ]) }}" class="btn btn-secondary mb-3" target="_blank"><i class="bi bi-printer"></i> Print</a>
        <a href="{{ route('dividend-calculation.pdf', ['date' => $date, 'type' => 'download', 'branch_id' => request('branch_id')]) }}" class="btn btn-danger mb-3" target=""><i class="bi bi-file-earmark-pdf"></i> Downloa d PDF</a>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Member ID</th>
                    <th>Member Name</th>
                    <th>Share ID</th>
                    <th>Share Type</th>
                    <th>Number of Shares</th>
                    <th>Dividend Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shareholders as $shareholder)
                    <tr>
                        <td>{{ $shareholder->member_id }}</td>
                        <td>{{ $shareholder->member_name }}</td>
                        <td>{{ $shareholder->share_id }}</td>
                        <td>{{ $shareholder->share_type }}</td>
                        <td>{{ $shareholder->number_of_shares }}</td>
                        <td>₹ {{ number_format($shareholder->dividend_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <h5>Total Dividend Distributed: ₹ {{ number_format($totalDividendDistributed, 2) }}</h5>
</div>
@endsection
