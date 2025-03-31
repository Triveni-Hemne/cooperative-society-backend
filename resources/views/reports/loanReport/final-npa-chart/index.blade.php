@extends('layouts.app')

@section('title', 'Final NPA Chart')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
@endsection

@section('content')
<div class="container mt-4" style="overflow: scroll; height:80vh">
    <h2 class="mb-4 text-center">📊 Final NPA Chart - {{ $npaData['date'] }}</h2>

    {{-- Summary Cards --}}
    <div class="row text-white">
        <div class="col-md-3">
            <div class="card bg-info-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Loans Issued</h5>
                    <h3>{{ $npaData['totalLoans'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">Total NPA Loans</h5>
                    <h3>{{ $npaData['totalNPALoans'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger-subtle shadow">
                <div class="card-body">
                    <h5 class="card-title">NPA Percentage</h5>
                    <h3>{{ $npaData['npaPercentage'] }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex">
    {{-- NPA Chart --}}
        <div class="mt-4 w-50"  >
            <canvas id="npaChart"></canvas>
        </div>

        {{-- Export PDF --}}
        <div class="mt-4 w-50 text-center d-flex justify-content-center align-items-center">
            <form action="{{ route('final-npa-chart.pdf') }}" method="GET">
                <input type="hidden" name="date" value="{{ $npaData['date'] }}">
                <button type="submit" class="btn btn-danger">Export PDF</button>
            </form>
        </div>
    </div>
    
</div>
@endsection

@section('customeJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('npaChart').getContext('2d');
    const npaChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Substandard', 'Doubtful', 'Loss'],
            datasets: [{
                label: 'NPA Categories',
                data: [
                    {{ $npaData['npaCounts']['substandard'] }},
                    {{ $npaData['npaCounts']['doubtful'] }},
                    {{ $npaData['npaCounts']['loss'] }}
                ],
                backgroundColor: ['#FFCE56', '#36A2EB', '#FF6384']
            }]
        }
    });
</script>
@endsection
