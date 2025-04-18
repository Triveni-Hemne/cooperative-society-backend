@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Day Ends</h3>
    <div class="row">
        <div class="col-5">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col">   
            @include('layouts.branchFilterInput', [
                'action' => route('day-end.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#dayEndsModal',
                'text' => 'Add New'
            ])
        </div>
    </div>
</div>

<div class="d-flex flex-column justify-content-between" style="height: 82%">
    <!-- List of Directors -->
    <div class="border overflow-auto" style="height: 88%">
        <table id="tableFilter" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sr.No.</th>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Opening Cash</th>
                    <th scope="col">Total Credit Rs.</th>
                    <th scope="col">Total Credit Chalans</th>
                    <th scope="col">Total Debit Rs.</th>
                    <th scope="col">Total Debit Chalans</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($dayEnds->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($dayEnds as $dayEnd)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$dayEnd->id}}</td>
                    <td>{{$dayEnd->date}}</td>
                    <td>{{$dayEnd->opening_cash}}</td>
                    <td>{{$dayEnd->total_credit_rs}}</td>
                    <td>{{$dayEnd->total_credit_chalans}}</td>
                    <td>{{$dayEnd->total_debit_rs}}</td>
                    <td>{{$dayEnd->total_debit_challans}}</td>
                    <td>
                        <a href="#"  data-id="{{$dayEnd->id}}" data-date="{{$dayEnd->date}}" data-opening-cash="{{$dayEnd->opening_cash}}" data-total-credit-rs="{{$dayEnd->total_credit_rs}}" data-total-credit-chalans="{{$dayEnd->total_credit_chalans}}" data-total-debit-rs="{{$dayEnd->total_debit_rs}}" data-total-debit-challans="{{$dayEnd->total_debit_challans}}" data-route="{{ route('day-end.update', $dayEnd->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#dayEndsModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$dayEnd->id }}" data-route="{{ route('day-end.destroy', $dayEnd->id)}}" data-name="{{$dayEnd->id}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a>
                    </td>
                </tr>
                @php $i++ @endphp
                 @endforeach
                 @else
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No day ends added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>    
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
       @include('layouts.pagination', ['paginationVariable' => 'dayEnds'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.day-ends.dayEnds')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@endsection
{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let date = this.getAttribute("data-date").split(" ")[0];;
            let openingCash = this.getAttribute("data-opening-cash");
            let totalCreditRs = this.getAttribute("data-total-credit-rs");
            let totalCreditChalans = this.getAttribute("data-total-credit-chalans");
            let totalDebitRs = this.getAttribute("data-total-debit-rs");
            let totalDebitChallans = this.getAttribute("data-total-debit-challans");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("dayEndsModal");

            // Update modal title
            document.getElementById("dayEndsModalLabel").textContent = "Edit Day End";

            // Populate form fields
            document.getElementById("dayEndsId").value = id;
            document.getElementById("date").value = date;
            document.getElementById("openingCash").value = openingCash;
            document.getElementById("totalCreditRs").value = totalCreditRs;
            document.getElementById("totalCreditChalans").value = totalCreditChalans;
            document.getElementById("totalDebitRs").value = totalDebitRs;
            document.getElementById("totalDebitChallans").value = totalDebitChallans;
            console.log(document.getElementById("date").value = date);
            
                
            // Change form action to update route and set PUT method
            let form = document.getElementById("dayEndsModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#dayEndsModal .btn-primary").textContent = "Update Day End";
        });
    });

    // Reset modal when it's closed
    document.getElementById("dayEndsModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("dayEndsModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('day-end.store') }}");

        // Reset modal title & button text
        document.getElementById("dayEndsModalLabel").textContent = "Add Day End";
        document.querySelector("#dayEndsModal .btn-primary").textContent = "Save Changes";
    });
});

</script>