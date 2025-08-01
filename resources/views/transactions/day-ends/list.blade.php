@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Day Ends</h3>
    <div class="row">
        <div class="col-8 col-lg-5 mb-3">
            {{-- Search Input --}}
            @include('layouts.tableSearchInput')
        </div>
        <div class="col-8 col-lg-5">   
            @include('layouts.branchFilterInput', [
                'action' => route('day-end.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#dayEndsModal',
                'text' => 'Add New',
                'id' => 'addNewDayEnd',
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
                    <th scope="col">Date</th>
                    <th scope="col">User</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Closing Cash Balance</th>
                    <th scope="col">Total Receipt</th>
                    <th scope="col">Total Payments</th>
                    <th scope="col">System Closing Balance</th>
                    <th scope="col">Difference Amount</th>
                    <th scope="col">Is Day Closed</th>
                    <th scope="col">Total Credit Rs.</th>
                    <th scope="col">Total Credit Chalans</th>
                    <th scope="col">Total Debit Rs.</th>
                    <th scope="col">Total Debit Chalans</th>
                    <th scope="col">Remarks</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($dayEnds->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($dayEnds as $dayEnd)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$dayEnd->id}}</td>
                    <td>{{$dayEnd->date ?? ''}}</td>
                    <td>{{$dayEnd->user->name ?? ''}}</td>
                    <td>{{$dayEnd->branch->name ?? ''}}</td>
                    <td>{{$dayEnd->closing_cash_balance ?? ''}}</td>
                    <td>{{$dayEnd->total_receipts ?? ''}}</td>
                    <td>{{$dayEnd->total_payments ?? ''}}</td>
                    <td>{{$dayEnd->system_closing_balance ?? ''}}</td>
                    <td>{{$dayEnd->difference_amount ?? ''}}</td>
                    <td>{{$dayEnd->is_day_closed ?? ''}}</td>
                    <td>{{$dayEnd->opening_cash ?? ''}}</td>
                    <td>{{$dayEnd->total_credit_rs ?? ''}}</td>
                    <td>{{$dayEnd->total_credit_chalans}}</td>
                    <td>{{$dayEnd->total_debit_rs ?? ''}}</td>
                    <td>{{$dayEnd->total_debit_challans ?? ''}}</td>
                    <td>{{$dayEnd->remarks ?? ''}}</td>
                    <td>
                        <a href="#"  data-id="{{$dayEnd->id}}" 
                            data-date="{{$dayEnd->date}}" 
                            data-user-id="{{$dayEnd->user_id}}" 
                            data-created-by-id="{{$dayEnd->created_by}}" 
                            data-created-by="{{$dayEnd->user->name}}" 
                            data-branch-id="{{$dayEnd->branch_id}}" 
                            data-closing-cash-balance="{{$dayEnd->closing_cash_balance}}" 
                            data-total-receipts="{{$dayEnd->total_receipts}}" 
                            data-total-payments="{{$dayEnd->total_payments}}" 
                            data-system-closing-balance="{{$dayEnd->system_closing_balance}}" 
                            data-difference-amount="{{$dayEnd->difference_amount}}" 
                            data-is-day-closed="{{$dayEnd->is_day_closed}}" 
                            data-remarks="{{$dayEnd->remarks}}" 
                            data-opening-cash="{{$dayEnd->opening_cash}}" data-total-credit-rs="{{$dayEnd->total_credit_rs}}" data-total-credit-chalans="{{$dayEnd->total_credit_chalans}}" 
                            data-total-debit-rs="{{$dayEnd->total_debit_rs}}" data-total-debit-challans="{{$dayEnd->total_debit_challans}}" data-route="{{ route('day-end.update', $dayEnd->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#dayEndsModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$dayEnd->id }}" data-route="{{ route('day-end.destroy', $dayEnd->id)}}" data-name="{{$dayEnd->id}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
       @include('layouts.pagination', ['paginationVariable' => 'dayEnds'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.day-ends.dayEnds')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('dayEndsModal'));
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
            let date = this.getAttribute("data-date").split(" ")[0];
            let userId = this.getAttribute("data-user-id");
            let createdBy = this.getAttribute("data-created-by");
            let createdById = this.getAttribute("data-created-by-id");
            let branchId = this.getAttribute("data-branch-id");
            let closingCashBalance = this.getAttribute("data-closing-cash-balance");
            let totalReceipts = this.getAttribute("data-total-receipts");
            let totalPayments = this.getAttribute("data-total-payments");
            let systemClosingBalance = this.getAttribute("data-system-closing-balance");
            let differenceAmount = this.getAttribute("data-difference-amount");
            let isDayClosed = this.getAttribute("data-is-day-closed");
            let remarks = this.getAttribute("data-remarks");
            let openingCash = this.getAttribute("data-opening-cash");
            let totalCreditRs = this.getAttribute("data-total-credit-rs");
            let totalCreditChalans = this.getAttribute("data-total-credit-chalans");
            let totalDebitRs = this.getAttribute("data-total-debit-rs");
            let totalDebitChallans = this.getAttribute("data-total-debit-challans");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("dayEndsModal");

            // Update modal title
            document.getElementById("dayEndsModalLabel").textContent = "Edit Day End";

            // Populate form fields
            document.getElementById("dayEndsId").value = id;
            document.getElementById("date").value = date;
            document.getElementById("userId").value = userId;
            
            document.getElementById("createdBy").value = createdBy;
            document.getElementById("createdById").value = createdById;
            document.getElementById("branchId").value = branchId;
            document.getElementById("ClosingCashBalance").value = closingCashBalance;
            document.getElementById("totalReceipts").value = totalReceipts;
            document.getElementById("totalPayments").value = totalPayments;
            document.getElementById("systemClosingBalance").value = systemClosingBalance;
            document.getElementById("differenceAmount").value = differenceAmount;
            document.getElementById("isDayClosed").value = isDayClosed;
            document.getElementById("remarks").value = remarks;
            // document.getElementById("openingCash").value = openingCash;
            document.getElementById("totalCreditRs").value = totalCreditRs;
            document.getElementById("totalCreditChalans").value = totalCreditChalans;
            document.getElementById("totalDebitRs").value = totalDebitRs;
            document.getElementById("totalDebitChallans").value = totalDebitChallans;
            console.log(document.getElementById("date").value = date);
            
                
            // Change form action to update route and set PUT method
            let form = document.getElementById("dayEndsModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#dayEndsModal .btn-success").textContent = "Update Day End";
        });
    });

    // Reset modal when it's closed
    document.getElementById("dayEndsModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("dayEndsModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('day-end.store') }}");

        // Reset modal title & button text
        document.getElementById("dayEndsModalLabel").textContent = "Add Day End";
        document.querySelector("#dayEndsModal .btn-success").textContent = "Save Changes";
    });
});
</script>
@endsection
