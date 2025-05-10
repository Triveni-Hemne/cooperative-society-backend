@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Standing Instruction Master</h3>
    <div class="row">
        <div class="col-8 col-lg-5 mb-3">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col-8 col-lg-5">   
            @include('layouts.branchFilterInput', [
                'action' => route('standing-instructions.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#standingInstructionModal',
                'text' => 'Add New'
            ])
        </div>    
    </div>
</div>

<div class="d-flex flex-column justify-content-between" style="height: 82%">
    <div class="border overflow-auto" style="height: 88%">
        <table id="tableFilter" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sr.No.</th>
                    <th scope="col">#</th>
                    <th scope="col">Credit Ledger</th>
                    <th scope="col">Credit Account</th>
                    <th scope="col">Credit Transfer</th>
                    <th scope="col">Debit Ledger</th>
                    <th scope="col">Debit Account</th>
                    <th scope="col">Debit Transfer</th>
                    <th scope="col">Date</th>
                    <th scope="col">Frequency</th>
                    <th scope="col">No. of Times</th>
                    <th scope="col">Balance Installment</th>
                    <th scope="col">Execution Date</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                 @if ($standingInstructions->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($standingInstructions as $standingInstruction)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$standingInstruction->id}}</td>
                    <td>{{$standingInstruction->creditLedger->name ?? ''}}</td>
                    <td>{{$standingInstruction->creditAccount->name ?? ''}}</td>
                    <td>{{$standingInstruction->credit_transfer ?? ''}}</td>
                     <td>{{$standingInstruction->debitLedger->name ?? ''}}</td>
                    <td>{{$standingInstruction->debitAccount->name ?? ''}}</td>
                    <td>{{$standingInstruction->debit_transfer ?? ''}}</td>
                    <td>{{$standingInstruction->date ?? ''}}</td>
                    <td>{{$standingInstruction->frequency ?? ''}}</td>
                    <td>{{$standingInstruction->no_of_times ?? ''}}</td>
                    <td>{{$standingInstruction->bal_installment ?? ''}}</td>
                    <td>{{$standingInstruction->execution_date ?? ''}}</td>
                    <td>{{$standingInstruction->amount ?? ''}}</td>
                    <td>
                        <a href="#"  data-id="{{$standingInstruction->id }}" data-credit-ledger-id="{{$standingInstruction->credit_ledger_id ?? ''}}" data-created-by="{{$standingInstruction->user->name ?? Auth::user()->name}}" data-created-by-id="{{$standingInstruction->user->id ?? Auth::user()->id}}" data-branch-id="{{$standingInstruction->branch->id ?? ''}}" data-credit-account-id="{{$standingInstruction->credit_account_id}}" data-credit-transfer="{{$standingInstruction->credit_transfer ?? ''}}" data-debit-ledger-id="{{$standingInstruction->debit_ledger_id ?? ''}}" data-debit-account-id="{{$standingInstruction->debit_account_id ?? ''}}" data-debit-transfer="{{$standingInstruction->debit_transfer ?? ''}}" data-date="{{$standingInstruction->date ?? ''}}" data-frequency="{{$standingInstruction->frequency ?? ''}}" data-no-of-times="{{$standingInstruction->no_of_times ?? ''}}" data-bal-installment="{{$standingInstruction->bal_installment ?? ''}}"  data-execution-date="{{$standingInstruction->execution_date ?? ''}}"  data-amount="{{$standingInstruction->amount ?? ''}}" data-route="{{ route('standing-instructions.update', $standingInstruction->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#standingInstructionModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$standingInstruction->id }}" data-route="{{ route('standing-instructions.destroy', $standingInstruction->id) }}" data-name="{{$standingInstruction->id}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No stading instructions added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>   
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
       @include('layouts.pagination', ['paginationVariable' => 'standingInstructions'])
    </div>
</div>

<!-- Form Model -->
@include('accounts.standing-instruction.standingInstruction')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('standingInstructionModal'));
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
            let creditLedgerId = this.getAttribute("data-credit-ledger-id");
            let creditAccountId = this.getAttribute("data-credit-account-id");
            let createdBy = this.getAttribute("data-created-by");
            let createdById = this.getAttribute("data-created-by-id");
            let branchId = this.getAttribute("data-branch-id");
            let creditTransfer = this.getAttribute("data-credit-transfer");
            let debitLedgerId = this.getAttribute("data-debit-ledger-id");
            let debitAccountId = this.getAttribute("data-debit-account-id");
            let debitTransfer = this.getAttribute("data-debit-transfer");
            let date = this.getAttribute("data-date");
            let frequency = this.getAttribute("data-frequency");
            let noOfTimes = this.getAttribute("data-no-of-times");
            let balInstallment = this.getAttribute("data-bal-installment");
            let executionDate = this.getAttribute("data-execution-date");
            let amount = this.getAttribute("data-amount");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("standingInstructionModal");

            // Update modal title
            document.getElementById("standingInstructionModalLabel").textContent = "Edit Standing Instruction";

            // Populate form fields
            document.getElementById("standingInstructionId").value = id;
            document.getElementById("creditLedgerId").value = creditLedgerId;
            document.getElementById("createdBy").value = createdBy;          
            document.getElementById("createdById").value = createdById;
            document.getElementById("branchId").value = branchId;
            document.getElementById("creditAccountId").value = creditAccountId;
            document.getElementById("creditTransfer").value = creditTransfer;
            document.getElementById("debitLedgerId").value = debitLedgerId;
            document.getElementById("debitAccountId").value = debitAccountId;
            document.getElementById("debitTransfer").value = debitTransfer;
            document.getElementById("date").value = date;
            document.getElementById("frequency").value = frequency;
            document.getElementById("noOfTimes").value = noOfTimes;
            document.getElementById("balInstallment").value = balInstallment;
            document.getElementById("executionDate").value = executionDate;
            document.getElementById("amount").value = amount;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("standingInstructionForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#standingInstructionModal .btn-success").textContent = "Update Standing Instruction";

        });
    });

    // Reset modal when it's closed
    document.getElementById("standingInstructionModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("standingInstructionForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('standing-instructions.store') }}");

        // Reset modal title & button text
        document.getElementById("standingInstructionModalLabel").textContent = "Add Standing Instruction";
        document.querySelector("#standingInstructionModal .btn-success").textContent = "Save Changes";
    });
});
</script>
{{-- <script src="{{asset('assets\js\autofill-calc-standing-instruction.js')}}"></script> --}}
@endsection
