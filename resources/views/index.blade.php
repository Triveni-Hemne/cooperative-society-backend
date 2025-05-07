@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="" style="overflow-y: scroll; height:75vh">
   <div class="row mb-4">
      <div class="col">
         <!-- Greeting -->
         <h3 class="">Welcome back, {{ Auth::user()->name }} 👋</h3>
      </div>
      <div class="col ">
         @if(Auth::user()->role == 'Admin')
            @include('layouts.branchFilterInput', [
                  'action' => route('user.dashboard')
               ])
         @endif
      </div>
   </div>
   <!-- Quick Stats -->
   <div class="row g-3 mb-4">
      <div class="col-md-3">
            <div class="card shadow-sm">
               <div class="card-body">
                  <h6>Total Members</h6>
                  <h4 class="text-primary">{{$totalMembers ?? 0}}</h4>
               </div>
            </div>
      </div>
      <div class="col-md-3">
            <div class="card shadow-sm">
               <div class="card-body">
                  <h6>Total Deposits</h6>
                  <h4 class="text-success">₹ {{$totalDeposits ?? 0}}L</h4>
               </div>
            </div>
      </div>
      <div class="col-md-3">
            <div class="card shadow-sm">
               <div class="card-body">
                  <h6>Loan Disbursed</h6>
                  <h4 class="text-danger">₹ {{$totalLoans ?? 0}}L</h4>
               </div>
            </div>
      </div>
      <div class="col-md-3">
            <div class="card shadow-sm">
               <div class="card-body">
                  <h6>Today's Transactions</h6>
                  <h4 class="text-warning">{{$transactions ?? 0}}</h4>
               </div>
            </div>
      </div>
   </div>

   <!-- Charts Placeholder -->
   <div class="row mb-4">
      <div class="col-md-6">
            <div class="card shadow-sm">
               <div class="card-header">Monthly Deposits vs Withdrawals</div>
               <div class="card-body">
                  <canvas id="depositChart"></canvas>
               </div>
            </div>
      </div>
      <div class="col-md-6">
            <div class="card shadow-sm">
               <div class="card-header">Loan Performance</div>
               <div class="card-body">
                  <canvas id="loanChart"></canvas>
               </div>
            </div>
      </div>
   </div>

   <!-- Recent Activities -->
   <div class="card shadow-sm mb-4">
      <div class="card-header">Recent Activities</div>
      <div class="card-body">
            <!-- In Blade -->
            <ul class="list-group list-group-flush">
               @forelse($activities  as $activity)
                  <li class="list-group-item">
                    {!! $activity['message'] !!}
                     <span class="text-muted small float-end">{{ $activity['time']->diffForHumans() }}</span>
                  </li>
               @empty
                  <li class="list-group-item text-muted">No recent activity</li>
               @endforelse
            </ul>

      </div>
   </div>

   
</div>


@endsection

@section('customeJs')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('depositChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Deposits',
                    data: @json($depositData),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }, {
                    label: 'Withdrawals',
                    data: @json($withdrawalData),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                }]
            }
        });

        const ctx2 = document.getElementById('loanChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: @json($loanLabels),
                datasets: [{
                    label: 'Loans Disbursed',
                    data: @json($loanData),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.3
                }]
            }
        });
    </script>
@endsection