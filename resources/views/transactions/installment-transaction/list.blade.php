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
        <h3>Installment Transaction</h3>
    </div>

    <!-- Search Bar and Add New Button -->
    <div class="d-flex justify-content-between mb-3">
        <input type="search" id="searchInput" placeholder="Search Here..." class="w-50 px-3 py-1 rounded">

        <div>
            <a href="#" class="d-flex justify-content-between gap-2 text-decoration-none d-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#installmentTransactionModal">
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
                    <th scope="col">Deposit Account</th>
                    <th scope="col">Installment No</th>
                    <th scope="col">Amount Paid</th>
                    <th scope="col">Payment Date</th>
                    <th scope="col">Interest Earned</th>
                    <th scope="col">Total Balance</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($transactions->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($transactions as $transaction)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <th scope="row">{{$transaction->id}}</th>
                    <th scope="row">{{$transaction->depositAccount->name}}</th>
                    <th scope="row">{{$transaction->installment_no}}</th>
                    <th scope="row">{{$transaction->amount_paid ?? ''}}</th>
                    <th scope="row">{{$transaction->payment_date  ?? ''}}</th>
                    <th scope="row">{{$transaction->interest_earned  ?? ''}}</th>
                    <th scope="row">{{$transaction->total_balance  ?? ''}}</th>
                    <td>
                        <a href="#" 
                        data-id="{{$transaction->id}}" 
                        data-deposit-account-id="{{$transaction->deposit_account_id}}" data-installment-no="{{$transaction->installment_no}}" data-amount-paid="{{$transaction->amount_paid ?? ''}}" data-payment-date="{{$transaction->payment_date ?? ''}}" data-interest-earned="{{$transaction->interest_earned ?? ''}}" data-total-balance="{{$transaction->total_balance ?? ''}}"  data-route="{{ route('installment-transactions.update', $transaction->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#installmentTransactionModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$transaction->id }}" data-route="{{ route('installment-transactions.destroy', $transaction->id) }}" data-name="{{$transaction->installment_no}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
               @include('layouts.pagination', ['paginationVariable' => 'transactions'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.installment-transaction.installment-transaction')

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
            let depositAccountId = this.getAttribute("data-deposit-account-id");
            let installmentNo = this.getAttribute("data-installment-no");
            let amountPaid = this.getAttribute("data-amount-paid");
            let paymentDate = this.getAttribute("data-payment-date");
            let interestEarned = this.getAttribute("data-interest-earned");
            let totalBalance = this.getAttribute("data-total-balance");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("installmentTransactionModal");

            // Update modal title
            document.getElementById("installmentTransactionModalLabel").textContent = "Edit Installment Transaction";

            // Populate form fields
            document.getElementById("installmentTransactionId").value = id;
            document.getElementById("depositAccountId").value = depositAccountId;
            document.getElementById("installmentNo").value = installmentNo;
            document.getElementById("amountPaid").value = amountPaid;
            document.getElementById("paymentDate").value = paymentDate;
            document.getElementById("interestEarned").value = interestEarned;
            document.getElementById("totalBalance").value = totalBalance;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("installmentTransactionModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#installmentTransactionModal .btn-primary").textContent = "Update Installment Transaction";
        });
    });

    // Reset modal when it's closed
    document.getElementById("installmentTransactionModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("installmentTransactionModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('transfer-entry.store') }}");

        // Reset modal title & button text
        document.getElementById("installmentTransactionModalLabel").textContent = "Add Installment Transaction";
        document.querySelector("#installmentTransactionModal .btn-primary").textContent = "Save Changes";
    });
});

</script>