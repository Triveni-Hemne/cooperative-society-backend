@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Branches</h3>
    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1" data-bs-toggle="modal"
            data-bs-target="#branchModal">
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
                    <th scope="col">Branch Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Location</th>
                    {{-- <th scope="col">Manager</th> --}}
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($branches->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($branches as $branch)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$branch->id}}</td>
                    <td>{{$branch->branch_code}}</td>
                    <td>{{$branch->name}}</td>
                    <td>{{$branch->location}}</td>
                    {{-- <td>{{$branch->manager->member->name}}</td> --}}
                    <td>
                        <a href="#" data-id="{{$branch->id }}" data-name="{{$branch->name ?? ''}}" data-branch-code="{{$branch->branch_code ?? ''}}" data-branch-location="{{$branch->location ?? ''}}"  data-route="{{ route('branches.update', $branch->id) }}"  class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#branchModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$branch->id }}" data-route="{{ route('branches.destroy', $branch->id) }}" data-name="{{ $branch->name ?? ''}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No branches added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr> 
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
       @include('layouts.pagination', ['paginationVariable' => 'branches'])
    </div>
</div>

<!-- Form Model -->
@include('master.branch.branch')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('branchModal'));
            modal.show();
        });
    </script>
@endif
{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let name = this.getAttribute("data-name");
            let branchCode = this.getAttribute("data-branch-code");
            let location = this.getAttribute("data-branch-location"); 
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("branchModal");

            // Update modal title
            document.getElementById("branchModalLabel").textContent = "Edit Branch";

            // Populate form fields
            document.getElementById("branchId").value = id;
            document.getElementById("branchName").value = name;
            console.log("branchName"+name);
            
            document.getElementById("branchCode").value = branchCode;
            document.getElementById("location").value = location;
            // Change form action to update route and set PUT method
            let form = document.getElementById("branchForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#branchModal .btn-primary").textContent = "Update Branch";
        });
    });

    // Reset modal when it's closed
    document.getElementById("branchModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("branchForm");

        // Reset form fields
        form.reset();

        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('branches.store') }}");

        // Reset modal title & button text
        document.getElementById("branchModalLabel").textContent = "Add Branch";
        document.querySelector("#branchModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
@endsection
