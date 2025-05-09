@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Centers</h3>
    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1" data-bs-toggle="modal"
            data-bs-target="#centerModal">
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
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">नाव</th>
                    <th scope="col">Address</th>
                    <th scope="col">पत्ता</th>
                    <th scope="col">Divsion</th>
                    <th scope="col">Sub Division</th>
                    <th scope="col">Description</th>
                    <th scope="col">वर्णन</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($centers->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($centers as $center)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$center->id}}</td>
                    <td>{{$center->name}}</td>
                    <td>{{$center->naav}}</td>
                    <td>{{$center->address}}</td>
                    <td>{{$center->marathi_address}}</td>
                    <td>{{$center->division->name}}</td>
                    <td>{{$center->subdivision->name}}</td>
                    <td>{{$center->description}}</td>
                    <td>{{$center->marathi_description}}</td>
                    <td>
                        <a href="#" data-id="{{$center->id}}" data-name="{{$center->name}}" data-naav="{{$center->naav}}" data-address="{{$center->address}}" data-marathi-address="{{$center->marathi_address}}" data-description="{{$center->description}}" data-marathi-description="{{$center->marathi_description}}" data-route="{{ route('centers.update', $center->id) }}" data-division-id="{{$center->division->id}}" data-sub-division-id="{{$center->subdivision->id}}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#centerModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$center->id}}" data-route="{{ route('centers.destroy', $center->id) }}" data-name="{{ $center->name }}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No centers added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>    
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
       @include('layouts.pagination', ['paginationVariable' => 'centers'])
    </div>
</div>

<!-- Form Model -->
@include('master.center.center')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('centerModal'));
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
            let address = this.getAttribute("data-address");
            let marathiAddress = this.getAttribute("data-marathi-address");
            let description = this.getAttribute("data-description");
            let marathiDescription = this.getAttribute("data-marathi-description");
            let route = this.getAttribute("data-route");
            let divisionId = this.getAttribute("data-division-id"); 
            let subDivisionId = this.getAttribute("data-sub-division-id"); 
            let modal = document.getElementById("subDivisionModal");

            // Update modal title
            document.getElementById("centerModalLabel").textContent = "Edit Center";

            // Populate form fields
            document.getElementById("centerId").value = id;
            document.getElementById("Name").value = name;
            document.getElementById("marathiName").value = naav;
            document.getElementById("address").value = address;
            document.getElementById("marathiAddress").value = marathiAddress;
            document.getElementById("description").value = description;
            document.getElementById("marathiDescription").value = marathiDescription;

            // Change form action to update route and set PUT method
            let form = document.getElementById("centerForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#centerModal .btn-success").textContent = "Update Center";

            // Set the selected division
            let divisionSelect = document.getElementById("division_id");
            let subDivisionSelect = document.getElementById("subdivision_id");

            if (divisionSelect) {
                divisionSelect.value = divisionId; // Pre-select the correct division
            }
            if (subDivisionSelect) {
                subDivisionSelect.value = subDivisionId; // Pre-select the correct sub-division
            }
        });
    });

    // Reset modal when it's closed
    document.getElementById("centerModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("centerForm");

        // Reset form fields
        form.reset();

        // Reset the division dropdown properly
        let divisionSelect = document.getElementById("division_id");
        let subDivisionSelect = document.getElementById("subdivision_id");
        if (divisionSelect) {
            divisionSelect.value = ""; // Reset dropdown
        }
        if (subDivisionSelect) {
            subDivisionSelect.value = ""; // Reset dropdown
        }

        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('centers.store') }}");

        // Reset modal title & button text
        document.getElementById("centerModalLabel").textContent = "Add Center";
        document.querySelector("#centerModal .btn-success").textContent = "Save Changes";
    });
});
</script>
@endsection
