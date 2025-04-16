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
            <!-- Search Bar -->
            <div class="col">
                <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
            </div>
            <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
            <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1 ms-auto" data-bs-toggle="modal"
                data-bs-target="#dayBeginsModal">
                <p class="d-block d-md-none my-bg-primary rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 30px; height: 30px;">
                    <i class="fa fa-plus text-white" style="font-size:20px"></i>
                </p>
                <p class="d-none d-md-block btn my-bg-primary text-light">
                    <i class="fa fa-plus me-1" style=""></i>Add New
                </p> <!-- Hidden on small screens -->
            </a>
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
                    <th scope="col">Member</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Status</th>
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
                    <td>{{$dayBegin->member->name}}</td>
                    <td>{{$dayBegin->created_by ??''}}</td>
                    <td>{{$dayBegin->status}}</td>  
                    <td>
                        <a href="#" data-id="{{$dayBegin->id }}" data-date="{{$dayBegin->date}}" data-member-id="{{$dayBegin->member->id}}" data-status="{{$dayBegin->status}}" data-created-by="{{$entry->created_by->name ?? ''}}" data-route="{{ route('day-begins.update', $dayBegin->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#dayBeginsModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$dayBegin->id }}" data-route="{{ route('day-begins.destroy', $dayBegin->id) }}" data-name="{{$dayBegin->member->name}}"  class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
            let memberId = this.getAttribute("data-member-id");
            let createdBy = this.getAttribute("data-created-by");
            let status = this.getAttribute("data-status");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("dayBeginsModal");

            // Update modal title
            document.getElementById("dayBeginsModalLabel").textContent = "Edit Day Begin";

            // Populate form fields
            document.getElementById("dayBeginId").value = id;
            document.getElementById("date").value = date;
            document.getElementById("memberId").value = memberId;
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