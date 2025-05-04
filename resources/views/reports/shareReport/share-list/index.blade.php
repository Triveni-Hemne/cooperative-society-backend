@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank - Share List')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">📜 Share List Report - {{ $date }}</h2>

        {{-- Date Filter --}}
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('share-list.index') }}" method="GET" class="d-flex form-outline input-group">
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

        {{-- Summary Cards --}}
        <div class="row text-white">
            <div class="col-md-3">
                <div class="card bg-info-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Shares</h5>
                        <h3>₹ {{ number_format($totalShares, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary-subtle shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Members</h5>
                        <h3>{{ $totalMembers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Export & Share List Table --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h4>💰 Share List Details</h4>
                <div class="d-flex">
                    <form action="{{ route('share-list.pdf') }}" method="GET" target="_blank">
                        <input type="date" name="date" required hidden value="{{$date}}">
                        <input type="text" name="branch_id" hidden value="{{ request('branch_id') }}">
                        <input type="text" name="type" value="stream" required hidden>
                        <button type="submit" class="btn btn-secondary me-1"><i class="bi bi-printer"></i> Print</button>
                    </form>
                     <form action="{{ route('share-list.pdf') }}" method="GET" target="">
                        <input type="date" name="date" required hidden value="{{$date}}">
                        <input type="text" name="branch_id" hidden value="{{ request('branch_id') }}">
                        <input type="text" name="type" value="download" required hidden>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                    </form>
                </div>
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
                            <th>Share Amount</th>
                            <th>Total Share Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shareholders as $shareholder)
                        <tr>
                            <td>{{ $shareholder->member_id }}</td>
                            <td>{{ $shareholder->member_name }}</td>
                            <td>{{ $shareholder->share_id }}</td>
                            <td>{{ $shareholder->share_type }}</td>
                            <td>{{ $shareholder->number_of_shares ?? '' }}</td>
                            <td>₹ {{ number_format($shareholder->share_amount, 2) }}</td>
                            <td>₹ {{ number_format($shareholder->number_of_shares * $shareholder->share_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Form Model -->
@include('master.agent.agent')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@endsection
