@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <!-- Heading -->
    <h3>Directors</h3>
    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1" data-bs-toggle="modal"
            data-bs-target="#directorModal">
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
                    <th scope="col">contact no. 1</th>
                    <th scope="col">contact no. 2</th>
                    <th scope="col">Email</th>
                    <th scope="col">Designation</th>
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($directors->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($directors as $director)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$director->id}}</td>
                    <td>{{$director->name}}</td>
                    @foreach(explode(',', $director->contact_nos) as $contact)
                        <td>{{ $contact }}</td>
                    @endforeach
                    <td>{{$director->email}}</td>
                    <td>{{$director->designation->name}}</td>
                    <td>{{$director->from_date}}</td>
                    <td>{{$director->to_date}}</td>
                    <td>
                        <a href="#" data-id="{{$director->id }}" data-member-id="{{$director->member_id }}" data-name="{{$director->name}}" data-email="{{$director->email}}" data-designation-id="{{$director->designation_id}}"
                            @foreach(explode(',', $director->contact_nos) as $index => $contact) 
                                data-mob{{ $index }}="{{ trim($contact) }}" 
                            @endforeach
                             data-from-date="{{$director->from_date}}"  data-to-date="{{$director->to_date}}"  data-route="{{ route('directors.update', $director->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#directorModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$director->id }}" data-route="{{ route('directors.destroy', $director->id) }}" data-name="{{$director->name}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No directors added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>  
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
        @include('layouts.pagination', ['paginationVariable' => 'directors'])
    </div>
</div>

<!-- Form Model -->
@include('master.director.director')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')

@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('directorModal'));
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
            let memberId = this.getAttribute("data-member-id");
            let name = this.getAttribute("data-name");
            let email = this.getAttribute("data-email");
            let designationId = this.getAttribute("data-designation-id");
            let mob0 = this.getAttribute("data-mob0");
            let mob1 = this.getAttribute("data-mob1");
            let fromDate = this.getAttribute("data-from-date");
            let toDate = this.getAttribute("data-to-date");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("directorModal");

            // Update modal title
            document.getElementById("directorModalLabel").textContent = "Edit Agent";

            // Populate form fields
            document.getElementById("directorId").value = id;
            document.getElementById("memberId").value = memberId;
            document.getElementById("name").value = name;
            document.getElementById("email").value = email;
            document.getElementById("designationId").value = designationId;
            document.getElementById("mob0").value = mob0;
            document.getElementById("mob1").value = mob1;
            document.getElementById("fromDate").value = fromDate;
            document.getElementById("toDate").value = toDate;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("directorsForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#directorModal .btn-primary").textContent = "Update Director";
        });
    });

    // Reset modal when it's closed
    document.getElementById("directorModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("directorModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('directors.store') }}");

        // Reset modal title & button text
        document.getElementById("directorModalLabel").textContent = "Add Director";
        document.querySelector("#directorModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
<script>
const memberData = @json($members);
</script>
<script src="{{asset('assets\js\autofil-content-director.js')}}"></script>
@endsection
