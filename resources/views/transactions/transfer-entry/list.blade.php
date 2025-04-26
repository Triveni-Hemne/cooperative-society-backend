@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Transfer Entry</h3>
       <div class="row">
        <div class="col-5">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col">   
            @include('layouts.branchFilterInput', [
                'action' => route('transfer-entry.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#transferEntryModal',
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
                    <th scope="col">Sr.No.</th>
                    <th scope="col">#</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Transation Type</th>
                    <th scope="col">Date</th>
                    <th scope="col">Receipt No. </th>
                    <th scope="col">Payment No. </th>
                    <th scope="col">Ledger</th>
                    <th scope="col">Opening Balance</th>
                    <th scope="col">Current Balance</th>
                    <th scope="col">Narration</th>
                    <th scope="col">M. Narration No. </th>
                    <th scope="col">Created By</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($transferEntries->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($transferEntries as $entry)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <th scope="row">{{$entry->id}}</th>
                    <th scope="row">{{$entry->branch->name ?? ''}}</th>
                    <th scope="row">{{$entry->transaction_type}}</th>
                    <th scope="row">{{$entry->date}}</th>
                    <th scope="row">{{$entry->receipt_id ?? ''}}</th>
                    <th scope="row">{{$entry->payment_id  ?? ''}}</th>
                    <th scope="row">{{$entry->ledger->name }}</th>
                    <th scope="row">{{$entry->opening_balance  ?? ''}}</th>
                    <th scope="row">{{$entry->current_balance  ?? ''}}</th>
                    <th scope="row">{{$entry->narration  ?? ''}}</th>
                    <th scope="row">{{$entry->m_narration  ?? ''}}</th>
                    <th scope="row">{{$entry->created_by  ?? ''}}</th>
                    <td>
                        <a href="#" data-id="{{$entry->id }}" data-transaction-type="{{$entry->transaction_type}}" data-date="{{$entry->date}}" data-receipt-id="{{$entry->receipt_id ?? ''}}" data-payment-id="{{$entry->payment_id ?? ''}}" data-ledger-id="{{$entry->ledger_id}}" data-opening-balance="{{$entry->opening_balance ?? ''}}" data-current-balance="{{$entry->current_balance ?? ''}}" data-narration="{{$entry->narration ?? ''}}" data-m-narration="{{$entry->m_narration ?? ''}}" data-created-by="{{$entry->created_by->name ?? ''}}" data-route="{{ route('transfer-entry.update', $entry->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#transferEntryModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$entry->id }}" data-route="{{ route('transfer-entry.destroy', $entry->id) }}" data-name="{{$entry->id}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No transfer entries added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr> 
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
               @include('layouts.pagination', ['paginationVariable' => 'transferEntries'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.transfer-entry.transferEntry')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('transferEntryModal'));
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
            let transactionType = this.getAttribute("data-transaction-type");
            let date = this.getAttribute("data-date");
            let receiptId = this.getAttribute("data-receipt-id");
            let paymentId = this.getAttribute("data-payment-id");
            let ledgerId = this.getAttribute("data-ledger-id");
            let openingBalance = this.getAttribute("data-opening-balance");
            let currentBalance = this.getAttribute("data-current-balance");
            let narration = this.getAttribute("data-narration");
            let mNarration = this.getAttribute("data-m-narration");
            let createdBy = this.getAttribute("data-created-by");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("transferEntryModal");

            // Update modal title
            document.getElementById("transferEntryModalLabel").textContent = "Edit Transfer Entry";

            // Populate form fields
            document.getElementById("transferEntryId").value = id;
            document.getElementById("transactionType").value = transactionType;
            document.getElementById("date").value = date;
            document.getElementById("receiptId").value = receiptId;
            document.getElementById("paymentId").value = paymentId;
            document.getElementById("ledgerId").value = ledgerId;
            document.getElementById("openingBalance").value = openingBalance;
            document.getElementById("currentBalance").value = currentBalance;
            document.getElementById("narration").value = narration;
            document.getElementById("mNarration").value = mNarration;
            document.getElementById("createdBy").value = createdBy;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("transferEntryModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#transferEntryModal .btn-primary").textContent = "Update Transfer Entry";
        });
    });

    // Reset modal when it's closed
    document.getElementById("transferEntryModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("transferEntryModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('transfer-entry.store') }}");

        // Reset modal title & button text
        document.getElementById("transferEntryModalLabel").textContent = "Add Transfer Entry";
        document.querySelector("#transferEntryModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
@endsection
