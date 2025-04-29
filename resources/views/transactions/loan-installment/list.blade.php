@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Loan Installments</h3>
    <div class="row">
        <div class="col-5">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col">   
            @include('layouts.branchFilterInput', [
                'action' => route('loan-installments.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#loanInstallmentModal',
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
                    <th scope="col">Loan Account</th>
                    <th scope="col">Installment Type</th>
                    <th scope="col">Mature Date</th>
                    <th scope="col">First Installment Date</th>
                    <th scope="col">Total Installments</th>
                    <th scope="col">Installment Amount</th>
                    <th scope="col">Installment With Interest</th>
                    <th scope="col">Total Installment</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($LoanInstallments->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($LoanInstallments as $LoanInstallment)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <th scope="row">{{$LoanInstallment->id}}</th>
                    <th scope="row">{{$LoanInstallment->loan->acc_no}}</th>
                    <th scope="row">{{$LoanInstallment->installment_type}}</th>
                    <th scope="row">{{$LoanInstallment->mature_date ?? ''}}</th>
                    <th scope="row">{{$LoanInstallment->first_installment_date  ?? ''}}</th>
                    <th scope="row">{{$LoanInstallment->total_installments  ?? ''}}</th>
                    <th scope="row">{{$LoanInstallment->installment_amount  ?? ''}}</th>
                    <th scope="row">{{$LoanInstallment->installment_with_interest  ?? ''}}</th>
                    <th scope="row">{{$LoanInstallment->total_installments_paid  ?? ''}}</th>
                    <th scope="row">{{$LoanInstallment->user->name  ?? ''}}</th>
                    <td>
                        <a href="#" 
                        data-id="{{$LoanInstallment->id}}" 
                        data-loan-id="{{$LoanInstallment->loan_id}}" 
                        data-installment-type="{{$LoanInstallment->installment_type}}" 
                        data-mature-date="{{$LoanInstallment->mature_date ?? ''}}" 
                        data-first-installment-date="{{$LoanInstallment->first_installment_date ?? ''}}" 
                        data-total-installments="{{$LoanInstallment->total_installments ?? ''}}" 
                        data-installment-amount="{{$LoanInstallment->installment_amount ?? ''}}"  
                        data-installment-with-interest="{{$LoanInstallment->installment_with_interest ?? ''}}"  
                        data-total-installments-paid="{{$LoanInstallment->total_installments_paid ?? ''}}"  
                        
                        data-route="{{ route('loan-installments.update', $LoanInstallment->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#loanInstallmentModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$LoanInstallment->id }}" data-route="{{ route('loan-installments.destroy', $LoanInstallment->id) }}" data-name="{{$LoanInstallment->id}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No day ends added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>   
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
               @include('layouts.pagination', ['paginationVariable' => 'LoanInstallments'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.loan-installment.loan-installment')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('loanInstallmentModal'));
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
            let loanId = this.getAttribute("data-loan-id");
            let installmentType = this.getAttribute("data-installment-type");            
            let matureDate = this.getAttribute("data-mature-date");
            let firstInstallmentDate = this.getAttribute("data-first-installment-date");
            let totalInstallments = this.getAttribute("data-total-installments");
            let installmentAmount = this.getAttribute("data-installment-amount");
            let installmentWithInterest = this.getAttribute("data-installment-with-interest");
            let totalInstallmentsPaid = this.getAttribute("data-total-installments-paid");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("loanInstallmentModal");

            // Update modal title
            document.getElementById("loanInstallmentModalLabel").textContent = "Edit Loan Installment";

            // Populate form fields
            document.getElementById("loanInstallmentId").value = id;
            document.getElementById("loanId").value = loanId;            
            document.getElementById("installmentType").value = installmentType;
            document.getElementById("matureDate").value = matureDate;
            document.getElementById("firstInstallmentDate").value = firstInstallmentDate;
            document.getElementById("totalInstallments").value = totalInstallments;
            document.getElementById("installmentAmount").value = installmentAmount;
            document.getElementById("installmentWithInterest").value = installmentWithInterest;
            document.getElementById("totalInstallmentsPaid").value = totalInstallmentsPaid;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("loanInstallmentModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#loanInstallmentModal .btn-primary").textContent = "Update Loan Installment";
        });
    });

    // Reset modal when it's closed
    document.getElementById("loanInstallmentModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("loanInstallmentModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('loan-installments.store') }}");

        // Reset modal title & button text
        document.getElementById("loanInstallmentModalLabel").textContent = "Add Loan Installment";
        document.querySelector("#loanInstallmentModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
@endsection
