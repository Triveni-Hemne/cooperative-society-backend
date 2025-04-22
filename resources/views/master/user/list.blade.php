@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <!-- Heading -->
    <h3>Users</h3>

    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1 ms-auto" data-bs-toggle="modal"
            data-bs-target="#userModal">
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
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Employee Code</th>
                    <th scope="col">Designation</th>
                    {{-- <th scope="col">Status</th> --}}
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->branch->name ?? ''}}</td>
                    <td>{{$user->employee->emp_code ?? ''}}</td>
                    <td>{{$user->employee->designation_id ?? ''}}</td>
                    {{-- <td>{{$user->status}}</td> --}}
                    <td>
                        <a href="#" data-id="{{$user->id }}" data-employee="{{$user->employee_id }}" data-name="{{$user->name}}" data-email="{{$user->email}}" data-branch="{{$user->branch_id}}" data-route="{{ route('users.update', $user->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#userModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                    </td>
                </tr>
                @php $i++ @endphp
                 @endforeach
                 @else
                      <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No users added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>   
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
       @include('layouts.pagination', ['paginationVariable' => 'users'])
    </div>
</div>

<!-- Form Model -->
@include('master.user.user')

@endsection

@section('customeJs')
@endsection

{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let employee = this.getAttribute("data-employee");
            let name = this.getAttribute("data-name");
            let email = this.getAttribute("data-email");
            let branch = this.getAttribute("data-branch");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("userModal");

            // Update modal title
            document.getElementById("userModalLabel").textContent = "Edit User";

            // Populate form fields
            document.getElementById("userId").value = id;
            document.getElementById("employee").value = employee;
            document.getElementById("userName").value = name;
            document.getElementById("userEmail").value = email;
            document.getElementById("branch").value = branch;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("userModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#userModal .btn-primary").textContent = "Update User";
        });
    });

    // Reset modal when it's closed
    document.getElementById("userModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("userModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('users.store') }}");

        // Reset modal title & button text
        document.getElementById("userModalLabel").textContent = "Add User";
        document.querySelector("#userModal .btn-primary").textContent = "Save Changes";
    });
});

</script>