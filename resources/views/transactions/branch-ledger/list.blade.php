@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Branch Ledger</h3>
    <div class="row">
        <div class="col-5">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col">   
            @include('layouts.branchFilterInput', [
                'action' => route('branch-ledger.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#branchLedgerModal',
                'text' => 'Add New'
            ])
        </div>
    </div>
</div>

<div class="d-flex flex-column justify-content-between" style="height: 82%">
    <!-- List of Directors -->
    <div class="border overflow-auto" style="height: 88%">
        <table id="tableFilter" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sr. No.</th>
                    <th scope="col">#</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Branch code</th>
                    <th scope="col">Ledger</th>
                    <th scope="col">Open Date</th>
                    <th scope="col">Open Balance</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Balance Type</th>
                    <th scope="col">Item Type</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($branchLedgers->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($branchLedgers as $ledger)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$ledger->id}}</td>
                    <td>{{$ledger->branch->name ?? ''}}</td>
                    <td>{{$ledger->branch_code}}</td>
                    <td>{{$ledger->ledger->name ?? ''}}</td>
                    <td>{{$ledger->open_date}}</td>
                    <td>{{$ledger->open_balance}}</td>
                    <td>{{$ledger->balance}}</td>
                    <td>{{$ledger->balance_type}}</td>
                    <td>{{$ledger->item_type}}</td>
                    <td>
                        <a href="#" data-id="{{$ledger->id }}" data-branch-code="{{$ledger->branch_code}}" data data-branch-id="{{$ledger->branch_id}}"-gl-id="{{$ledger->gl_id}}" data-open-date="{{$ledger->open_date}}" data-open-balance="{{$ledger->open_balance}}" data-balance="{{$ledger->balance}}" data-balance-type="{{$ledger->balance_type}}" data-item-type="{{$ledger->item_type}}"  data-route="{{ route('branch-ledger.update', $ledger->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#branchLedgerModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$ledger->id }}" data-route="{{ route('branch-ledger.destroy', $ledger->id) }}" data-name="{{$ledger->branch_code}}" class="text-decoration-none edit-btn" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No branch ledgers added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>   
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
         @include('layouts.pagination', ['paginationVariable' => 'branchLedgers'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.branch-ledger.branchLedger')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('branchLedgerModal'));
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
            let branchCode = this.getAttribute("data-branch-code");
            let branchId = this.getAttribute("data-branch-id");
            let glId = this.getAttribute("data-gl-id");
            let openDate = this.getAttribute("data-open-date");
            let openBalance = this.getAttribute("data-open-balance");
            let balance = this.getAttribute("data-balance");
            let balanceType = this.getAttribute("data-balance-type");
            let itemType = this.getAttribute("data-item-type");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("branchLedgerModal");

            // Update modal title
            document.getElementById("branchLedgerModalLabel").textContent = "Edit Branch Ledger";

            // Populate form fields
            document.getElementById("branchLedgerId").value = id;
            document.getElementById("branchCode").value = branchCode;
            document.getElementById("branchId").value = branchId;
            document.getElementById("glId").value = glId;
            document.getElementById("openDate").value = openDate;
            document.getElementById("openBalance").value = openBalance;
            document.getElementById("balance").value = balance;
            document.getElementById("balanceType").value = balanceType;
            document.getElementById("itemType").value = itemType;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("branchLedgerModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#branchLedgerModal .btn-primary").textContent = "Update Branch Ledger";
        });
    });

    // Reset modal when it's closed
    document.getElementById("branchLedgerModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("branchLedgerModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('branch-ledger.store') }}");

        // Reset modal title & button text
        document.getElementById("branchLedgerModalLabel").textContent = "Add Branch Ledger";
        document.querySelector("#branchLedgerModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
@endsection
