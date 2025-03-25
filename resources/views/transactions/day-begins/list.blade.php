@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div style="height: 18%">
    <!-- Heading -->
    <div class="mb-4 heading">
        <h3>Day Begins</h3>
    </div>

    <!-- Search Bar and Add New Button -->
    <div class="d-flex justify-content-between mb-3">
        <input type="search" id="searchInput" placeholder="Search Here..." class="w-50 px-3 py-1 rounded">

        <div>
            <a href="#" class="d-flex justify-content-between gap-2 text-decoration-none d-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#dayBeginsModal">
                <p style="width: 30px; height: 30px"
                    class="bg-success rounded-circle d-flex justify-content-center align-items-center">
                    <i class="fa fa-plus text-white" style="font-size:20px"></i>
                </p>
                <p>Add New</p>
            </a>
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
                    <th scope="col">Member</th>
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
                    <td>{{$dayBegin->status}}</td>  
                    <td>
                        <a href="#" data-id="{{$dayBegin->id }}" data-date="{{$dayBegin->date}}" data-member-id="{{$dayBegin->member->id}}" data-status="{{$dayBegin->status}}" data-route="{{ route('day-begins.update', $dayBegin->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
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
                    <tr><td colspan="15" class="text-center"><h5>Data Not Found !</h5></td></tr>   
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
            let status = this.getAttribute("data-status");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("dayBeginsModal");

            // Update modal title
            document.getElementById("dayBeginsModalLabel").textContent = "Edit Day Begin";

            // Populate form fields
            document.getElementById("dayBeginId").value = id;
            document.getElementById("date").value = date;
            document.getElementById("memberId").value = memberId;
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