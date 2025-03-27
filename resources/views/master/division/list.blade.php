@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Heading -->
        <h3>Division</h3>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="d-flex gap-2 text-decoration-none align-items-center" data-bs-toggle="modal"
            data-bs-target="#divisionModal">
            <p class="bg-success rounded-circle d-flex justify-content-center align-items-center"
                style="width: 30px; height: 30px;">
                <i class="fa fa-plus text-white" style="font-size:20px"></i>
            </p>
            <p class="d-none d-md-block">Add New</p> <!-- Hidden on small screens -->
        </a>
    </div>

    <!-- Search Bar -->
    <div>
        <input type="search" id="searchInput" placeholder="Search Here..." class="px-3 py-2 rounded search-bar">
    </div>
</div>

<div class="d-flex flex-column justify-content-between" style="height: 82%">
    <!-- List of Directors -->
    <div class="border overflow-auto" style="height: 88%">
        <table id="tableFilter" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sr.no</th>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">नाव</th>
                    <th scope="col">Description</th>
                    <th scope="col">वर्णन</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                 @if ($divisions->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($divisions as $division)
                <tr>
                    <th scope="row" >{{$i}}</th>
                    <th>{{$division->id}}</th>
                    <td>{{$division->name}}</td>
                    <td>{{$division->naav}}</td>
                    <td>{{$division->description}}</td>
                    <td>{{$division->marathi_description}}</td>
                    <td>
                        <a data-id="{{$division->id}}" data-name="{{$division->name}}" data-naav="{{$division->naav}}" data-description="{{$division->description}}" data-marathi_description="{{$division->marathi_description}}" data-route="{{ route('divisions.update', $division->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#divisionModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a class="text-decoration-none" data-id="{{$division->id}}" data-route="{{ route('divisions.destroy', $division->id) }}" data-name="{{ $division->name }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
       @include('layouts.pagination', ['paginationVariable' => 'divisions'])

    </div>
</div>

<!-- Form Model -->
@include('master.division.division')

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
            let name = this.getAttribute("data-name");
            let naav = this.getAttribute("data-naav");
            let description = this.getAttribute("data-description");
            let marathiDescription = this.getAttribute("data-marathi_description");
            let route = this.getAttribute("data-route");

            // Update modal title
            document.getElementById("divisionModalLabel").textContent = "Edit Division";

            // Populate form fields
            document.getElementById("divisionId").value = id;
            document.getElementById("name").value = name;
            document.getElementById("marathiName").value = naav;
            document.getElementById("description").value = description;
            document.getElementById("marathiDescription").value = marathiDescription;

            // Change form action to update route and set PUT method
            let form = document.getElementById("divisionForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#divisionModal .btn-primary").textContent = "Update Division";

        });
    });

    // Reset modal when it's closed
    document.getElementById("divisionModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("divisionForm");

        // Reset fields
        form.reset();
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('divisions.store') }}");

        // Reset modal title & button text
        document.getElementById("divisionModalLabel").textContent = "Add Division";
        document.querySelector("#divisionModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
