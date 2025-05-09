@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div style="">
    <!-- Heading -->
    <div class="mb-4 heading">
        <h3>Deparments</h3>
    </div>
    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1" data-bs-toggle="modal"
            data-bs-target="#departmentModal">
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
                    <th scope="col">Name</th>
                    <th scope="col">Head of Department</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($departments->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($departments as $department)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$department->id}}</td>
                    <td>{{$department->name}}</td>
                    <td>{{$department->head->name ?? ''}}</td>
                    <td>
                        <a href="#" data-id="{{$department->id }}" data-name="{{$department->name ?? ''}}" data-head-id="{{ optional($department->head)->id }}"  data-route="{{ route('departments.update', $department->id) }}"class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#departmentModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$department->id }}" data-route="{{ route('departments.destroy', $department->id) }}" data-name="{{ $department->name ?? ''}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No departments added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr> 
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
       @include('layouts.pagination', ['paginationVariable' => 'departments'])
    </div>
</div>

<!-- Form Model -->
@include('master.department.department')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('departmentModal'));
            modal.show();
        });
    </script>
@endif --}}
{{-- Script to send data to the edit modal --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                let name = this.getAttribute("data-name");
                let route = this.getAttribute("data-route");
                let headId = this.getAttribute("data-head-id"); 

                let modal = document.getElementById("departmentModal");

                // Update modal title
                document.getElementById("departmentModalLabel").textContent = "Edit Designation";

                // Populate form fields
                document.getElementById("departmentId").value = id;
                document.getElementById("Name").value = name;
                document.getElementById("departmentId").value = departmentId;

                // Change form action to update route and set PUT method
                let form = document.getElementById("departmentForm");
                form.setAttribute("action", route);
                document.getElementById("formMethod").value = "PUT";

                // Change submit button text
                document.querySelector("#departmentModal .btn-success").textContent = "Update Designation Center";

                // Set the selected division
                let headSelect = document.getElementById("headId");
                
                if (headSelect) {
                    headSelect.value = headId; // Pre-select the correct division
                }
            });
        });

        // Reset modal when it's closed
        document.getElementById("departmentModal").addEventListener("hidden.bs.modal", function () {
            let form = document.getElementById("departmentForm");

            // Reset form fields
            form.reset();

            // Reset the division dropdown properly
            let headSelect = document.getElementById("headId");
            if (headSelect) {
                headSelect.value = ""; // Reset dropdown
            }

            // Reset method and form action
            document.getElementById("formMethod").value = "POST";
            form.setAttribute("action", "{{ route('departments.store') }}");

            // Reset modal title & button text
            document.getElementById("departmentModalLabel").textContent = "Add Department";
            document.querySelector("#departmentModal .btn-success").textContent = "Save Changes";
        });
    });
</script>
@endsection