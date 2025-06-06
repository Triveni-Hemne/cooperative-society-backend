@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Categories's</h3>
    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1 ms-auto" data-bs-toggle="modal"
            data-bs-target="#categoryModal">
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
                 @if ($categories->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->naav}}</td>
                    <td>{{$category->description}}</td>
                    <td>{{$category->marathi_description}}</td>
                    <td>
                        <a href="#" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal" data-id="{{$category->id}}" data-name="{{$category->name}}" data-naav="{{$category->naav}}"  data-description="{{$category->description}}" data-marathi-description="{{$category->marathi_description}}" data-route="{{ route('categories.update', $category->id) }}"
                            data-bs-target="#categoryModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        {{-- <a href="#" data-id="{{$category->id}}" data-route="{{ route('categories.destroy', $category->id) }}" data-name="{{ $category->name }}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a> --}}
                    </td>
                </tr>
                @php $i++ @endphp
                @endforeach
                @else
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No categories added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>    
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
         @include('layouts.pagination', ['paginationVariable' => 'categories'])
    </div>
</div>

<!-- Form Model -->
@include('master.category.category')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('categoryModal'));
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
            let naav = this.getAttribute("data-naav");
            let description = this.getAttribute("data-description");
            let marathiDescription = this.getAttribute("data-marathi-description");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("categoryModal");

            // Update modal title
            document.getElementById("categoryModalLabel").textContent = "Edit Center";

            // Populate form fields
            document.getElementById("categoryId").value = id;
            document.getElementById("Name").value = name;
            document.getElementById("marathiName").value = naav;
            document.getElementById("description").value = description;
            document.getElementById("marathiDescription").value = marathiDescription;

            // Change form action to update route and set PUT method
            let form = document.getElementById("categoryForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#categoryModal .btn-success").textContent = "Update Category";
        });
    });

    // Reset modal when it's closed
    document.getElementById("categoryModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("categoryForm");

        // Reset form fields
        form.reset();

        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('categories.store') }}");

        // Reset modal title & button text
        document.getElementById("categoryModalLabel").textContent = 'Add Category';
        document.querySelector("#categoryModal .btn-success").textContent = "Save Changes";
    });
});
</script>
@endsection
