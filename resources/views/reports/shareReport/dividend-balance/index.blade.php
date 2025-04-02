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

    <div class="mb-3">
        <a href="{{ route('dividend-balance.pdf', ['date' => $date]) }}" class="btn btn-primary">Download PDF</a>
    </div>
<div style="overflow-x: scroll">
    <table class="table table-bordered" >
        <thead class="thead-dark">
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
