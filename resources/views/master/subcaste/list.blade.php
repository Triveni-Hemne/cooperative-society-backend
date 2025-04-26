@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Sub-Caste's</h3>
    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1 ms-auto" data-bs-toggle="modal"
            data-bs-target="#subcasteModal">
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
                    <th scope="col">नाव</th>
                    <th scope="col">Description</th>
                    <th scope="col">वर्णन</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                 @if ($subcastes->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($subcastes as $subcaste)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$subcaste->id}}</td>
                    <td>{{$subcaste->name}}</td>
                    <td>{{$subcaste->naav}}</td>
                    <td>{{$subcaste->description}}</td>
                    <td>{{$subcaste->marathi_description}}</td>
                    <td>
                        <a href="#" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal" data-id="{{$subcaste->id}}" data-name="{{$subcaste->name}}" data-naav="{{$subcaste->naav}}"  data-description="{{$subcaste->description}}" data-marathi-description="{{$subcaste->marathi_description}}" data-route="{{ route('subcastes.update', $subcaste->id) }}"
                            data-bs-target="#subcasteModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$subcaste->id}}" data-route="{{ route('subcastes.destroy', $subcaste->id) }}" data-name="{{ $subcaste->name }}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No sub-caste's added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>    
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
         @include('layouts.pagination', ['paginationVariable' => 'subcastes'])
    </div>
</div>

<!-- Form Model -->
@include('master.subcaste.subcaste')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('subcasteModal'));
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
            let naav = this.getAttribute("data-naav");
            let description = this.getAttribute("data-description");
            let marathiDescription = this.getAttribute("data-marathi-description");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("subcasteModal");

            // Update modal title
            document.getElementById("subcasteModalLabel").textContent = "Edit Center";

            // Populate form fields
            document.getElementById("subcasteId").value = id;
            document.getElementById("name").value = name;
            document.getElementById("marathiName").value = naav;
            document.getElementById("description").value = description;
            document.getElementById("marathiDescription").value = marathiDescription;

            // Change form action to update route and set PUT method
            let form = document.getElementById("subcasteForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#subcasteModal .btn-primary").textContent = "Update Center";
        });
    });

    // Reset modal when it's closed
    document.getElementById("subcasteModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("subcasteForm");

        // Reset form fields
        form.reset();

        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('sub-divisions.store') }}");

        // Reset modal title & button text
        document.getElementById("subcasteModalLabel").textContent = "Add Center";
        document.querySelector("#subcasteModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
@endsection
