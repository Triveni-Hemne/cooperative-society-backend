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
    <a href="{{ route('dividend-calculation.pdf', ['date' => $date]) }}" class="btn btn-danger mb-3" target="_blank">Download PDF</a>
    <table class="table table-bordered">
        <thead>
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
    <h5>Total Dividend Distributed: ₹ {{ number_format($totalDividendDistributed, 2) }}</h5>
</div>
@endsection
