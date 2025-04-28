@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <!-- Heading -->
    <h3>Agents</h3>

    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1 ms-auto" data-bs-toggle="modal"
            data-bs-target="#agentModal">
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
                    <th scope="col">User</th>
                    <th scope="col">Agent Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Joining Date</th>
                    <th scope="col">Resignation Date</th>
                    <th scope="col">Commission Rate</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Updated By</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($agents->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($agents as $agent)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$agent->id}}</td>
                    <td>{{$agent->user->name ?? ''}}</td>
                    <td>{{$agent->agent_code ?? ''}}</td>
                    <td>{{$agent->name ?? ''}}</td>
                    <td>{{$agent->email ?? ''}}</td>
                    <td>{{$agent->phone ?? ''}}</td>
                    <td>{{$agent->address ?? ''}}</td>
                    <td>{{$agent->joining_date ?? ''}}</td>
                    <td>{{$agent->resignation_date ?? ''}}</td>
                    <td>{{$agent->commission_rate ?? ''}}</td>
                    <td>{{$agent->status ?? ''}}</td>
                    <td>{{$agent->created_by ?? ''}}</td>
                    <td>{{$agent->updated_by ?? ''}}</td>
                    <td>
                        <a href="#" data-id="{{$agent->id}}" data-user-id="{{$agent->user->id ?? ''}}" data-agent-code="{{$agent->agent_code ?? ''}}" data-name="{{$agent->name ?? ''}}" data-email="{{$agent->email ?? ''}}" data-phone="{{$agent->phone ?? ''}}" data-address="{{$agent->address ?? ''}}" data-joining-date="{{$agent->joining_date ?? ''}}" data-resignation-date="{{$agent->resignation_date ?? ''}}" data-commission-rate="{{$agent->commission_rate ?? ''}}" data-status="{{$agent->status ?? ''}}" data-route="{{ route('agents.update', $agent->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#agentModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$agent->id }}" data-route="{{ route('agents.destroy', $agent->id) }}" data-name="{{$agent->name}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No agents added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>   
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
       @include('layouts.pagination', ['paginationVariable' => 'agents'])
    </div>
</div>

<!-- Form Model -->
@include('master.agent.agent')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('agentModal'));
            modal.show();
        });
    </script>
@endif
@endsection

{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let userId = this.getAttribute("data-user-id");
            let agentCode = this.getAttribute("data-agent-code");
            let Name = this.getAttribute("data-name");
            let email = this.getAttribute("data-email");            
            let phone = this.getAttribute("data-phone");
            let address = this.getAttribute("data-address");
            let joiningDate = this.getAttribute("data-joining-date");
            let resignationDate = this.getAttribute("data-resignation-date");
            let commissionRate = this.getAttribute("data-commission-rate");
            let status = this.getAttribute("data-status");            
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("agentModal");

            // Update modal title
            document.getElementById("agentModalLabel").textContent = "Edit Agent";

            // Populate form fields
            document.getElementById("agentId").value = id;
            document.getElementById("userId").value = userId;
            document.getElementById("agentCode").value = agentCode;
            document.getElementById("Name").value = Name;
            document.getElementById("Email").value = email;

            document.getElementById("phone").value = phone;
            document.getElementById("address").value = address;
            document.getElementById("joiningDate").value = joiningDate;
            document.getElementById("resignationDate").value = resignationDate;
            document.getElementById("commissionRate").value = commissionRate;

            document.getElementById("status").value = status;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("agentModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#agentModal .btn-primary").textContent = "Update Agent";
        });
    });

    // Reset modal when it's closed
    document.getElementById("agentModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("agentModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('agents.store') }}");

        // Reset modal title & button text
        document.getElementById("agentModalLabel").textContent = "Add Anget";
        document.querySelector("#agentModal .btn-primary").textContent = "Save Changes";
    });
});

</script>