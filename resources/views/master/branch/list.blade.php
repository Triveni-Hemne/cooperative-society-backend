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
            data-bs-target="#designationModal">
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
                    <th scope="col">Naav</th>
                    <th scope="col">Division</th>
                    <th scope="col">Sub Division</th>
                </tr>
            </thead>
            <tbody>
                @if ($branches->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($branches as $branch)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$branch->id}}</td>
                    <td>{{$branch->name}}</td>
                    <td>{{$branch->naav}}</td>
                    <td>{{$branch->division->name}}</td>
                    <td>{{$branch->subdivision->name}}</td>
                    <td>
                        <a href="#" data-id="{{$branch->id }}" data-name="{{$branch->name ?? ''}}" data-naav="{{$branch->naav ?? ''}}" data-route="{{ route('designations.update', $designation->id) }}"  class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#designationModal">
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
@endsection

{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let name = this.getAttribute("data-name");
            let naav = this.getAttribute("data-naav");
            let route = this.getAttribute("data-route");
            let divisionId = this.getAttribute("data-division-id"); 
            let subDivisionId = this.getAttribute("data-sub-division-id"); 
            let centerId = this.getAttribute("data-center-id"); 

            let modal = document.getElementById("designationModal");

            // Update modal title
            document.getElementById("designationModalLabel").textContent = "Edit Designation";

            // Populate form fields
            document.getElementById("designationId").value = id;
            document.getElementById("name").value = name;
            document.getElementById("marathiName").value = naav;

            // Change form action to update route and set PUT method
            let form = document.getElementById("designationForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#designationModal .btn-primary").textContent = "Update Designation Center";

            // Set the selected division
            let divisionSelect = document.getElementById("division_id");
            let subDivisionSelect = document.getElementById("subdivision_id");
            let centerSelect = document.getElementById("center_id");
            
            if (divisionSelect) {
                divisionSelect.value = divisionId; // Pre-select the correct division
            }
            if (subDivisionSelect) {
                subDivisionSelect.value = subDivisionId; // Pre-select the correct sub-division
            } 
            if (centerSelect) {
                centerSelect.value = centerId; // Pre-select the correct center
            }
        });
    });

    // Reset modal when it's closed
    document.getElementById("designationModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("designationForm");

        // Reset form fields
        form.reset();

        // Reset the division dropdown properly
        let divisionSelect = document.getElementById("division_id");
        let subDivisionSelect = document.getElementById("subdivision_id");
        let centerSelect = document.getElementById("center_id");
        if (divisionSelect) {
            divisionSelect.value = ""; // Reset dropdown
        }
        if (subDivisionSelect) {
            subDivisionSelect.value = ""; // Reset dropdown
        }
         if (centerSelect) {
            centerSelect.value = ""; // Reset dropdown
        }

        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('sub-divisions.store') }}");

        // Reset modal title & button text
        document.getElementById("designationModalLabel").textContent = "Add Branch";
        document.querySelector("#designationModal .btn-primary").textContent = "Save Changes";
    });
});

</script>