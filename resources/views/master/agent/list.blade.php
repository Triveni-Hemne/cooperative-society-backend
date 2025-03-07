@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div style="height: 18%">
    <!-- Heading -->
    <div class="mb-4 heading">
        <h3>Agents</h3>
    </div>

    <!-- Search Bar and Add New Button -->
    <div class="d-flex justify-content-between mb-3">
        <input type="search" id="searchInput" placeholder="Search Here..." class="w-50 px-3 py-1 rounded">

        <div>
            <a href="#" class="d-flex justify-content-between gap-2 text-decoration-none d-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#agentModal">
                <p style="width: 30px; height: 30px"
                    class="bg-success rounded-circle d-flex justify-content-center align-items-center">
                    <i class="fa fa-plus text-white" style="font-size:20px"></i>
                </p>
                <p>Add New</p>
            </a>
        </div>
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
                    <th scope="col">User/Agent Name</th>
                    <th scope="col">Agent Code</th>
                    <th scope="col">Commition Rate</th>
                    <th scope="col">Status</th>
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
                    <td>{{$agent->user->name}}</td>
                    <td>{{$agent->agent_code}}</td>
                    <td>{{$agent->commition_rate}}</td>
                    <td>{{$agent->status}}</td>
                    <td>
                        <a href="#" data-id="{{$agent->id }}" data-user-id="{{$agent->user->id}}" data-agent-code="{{$agent->agent_code}}" data-commition-rate="{{$agent->commition_rate}}" data-route="{{ route('agents.update', $agent->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#agentModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$agent->id }}" data-route="{{ route('agents.destroy', $agent->id) }}" data-name="{{$agent->user->name}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
       @include('layouts.pagination', ['paginationVariable' => 'agents'])
    </div>
</div>

<!-- Form Model -->
@include('master.agent.agent')

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
            let userId = this.getAttribute("data-user-id");
            let agentCode = this.getAttribute("data-agent-code");
            let commitionRate = this.getAttribute("data-commition-rate");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("agentModal");

            // Update modal title
            document.getElementById("agentModalLabel").textContent = "Edit Agent";

            // Populate form fields
            document.getElementById("agentId").value = id;
            document.getElementById("userId").value = userId;
            document.getElementById("agentCode").value = agentCode;
            document.getElementById("commitionRate").value = commitionRate;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("agentModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#agentModal .btn-primary").textContent = "Update Agent";

            // Set the selected division
            let userSelect = document.getElementById("userId");
            
            if (userSelect) {
                userSelect.value = userId; // Pre-select the correct division
            }
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