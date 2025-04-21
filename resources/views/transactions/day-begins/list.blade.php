@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Day Begins</h3>
    <div class="row">
        <div class="col-5">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col">   
            @include('layouts.branchFilterInput', [
                'action' => route('day-begins.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#dayBeginsModal',
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
                    <th scope="col">User</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Opening Cash Balance</th>
                    <th scope="col">Status</th>
                    <th scope="col">Remarks</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                 @if ($dayBegins->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($dayBegins as $dayBegin)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$dayBegin->id}}</td>
                    <td>{{$dayBegin->date}}</td>
                    <td>{{$dayBegin->users->name ?? ''}}</td>
                    <td>{{$dayBegin->user->name ??''}}</td>
                    <td>{{$dayBegin->branch->name ??''}}</td>
                    <td>{{$dayBegin->opening_cash_balance ??''}}</td>
                    <td>{{$dayBegin->status}}</td>  
                    <td>{{$dayBegin->remarks}}</td>  
                    <td>
                        <a href="#" data-id="{{$dayBegin->id }}" data-date="{{$dayBegin->date}}" data-user-id="{{$dayBegin->user->id ?? ''}}" data-status="{{$dayBegin->status}}" data-created-by="{{$entry->created_by->name ?? ''}}" data-branch-id="{{$entry->branch_id ?? ''}}" data-opening-cash-balance="{{$entry->opening_cash_balance ?? ''}}"  data-remarks="{{$entry->remarks ?? ''}}" data-route="{{ route('day-begins.update', $dayBegin->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#dayBeginsModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$dayBegin->id }}" data-route="{{ route('day-begins.destroy', $dayBegin->id) }}" data-name="{{$dayBegin->user->name ?? ''}}"  class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No day begins added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr> 
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
           @include('layouts.pagination', ['paginationVariable' => 'dayBegins'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.day-begins.dayBegins')

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
            let date = this.getAttribute("data-date");
            let userId = this.getAttribute("data-user-id");
            let branchId = this.getAttribute("data-branch-id");
            let openingCashBalance = this.getAttribute("data-opening-cash-balance");
            let createdBy = this.getAttribute("data-created-by");
            let status = this.getAttribute("data-status");
            let remarks = this.getAttribute("data-remarks");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("dayBeginsModal");

            // Update modal title
            document.getElementById("dayBeginsModalLabel").textContent = "Edit Day Begin";

            // Populate form fields
            document.getElementById("dayBeginId").value = id;
            document.getElementById("date").value = date;
            document.getElementById("userId").value = userId;
            document.getElementById("branchId").value = branchId;
            document.getElementById("openingCashBalance").value = openingCashBalance;
            document.getElementById("remarks").value = remarks;
            document.getElementById("createdBy").value = createdBy;
            document.getElementById("status").value = status;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("dayBeginModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#dayBeginsModal .btn-primary").textContent = "Update Day Begin";
        });
    });

    // Reset modal when it's closed
    document.getElementById("dayBeginsModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("dayBeginModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('agents.store') }}");

        // Reset modal title & button text
        document.getElementById("dayBeginsModalLabel").textContent = "Add Day Begin";
        document.querySelector("#dayBeginsModal .btn-primary").textContent = "Save Changes";
    });
});

</script>