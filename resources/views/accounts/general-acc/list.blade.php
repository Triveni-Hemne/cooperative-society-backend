@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>General Account</h3>
    <div class="row"> 
        <div class="col-8 col-lg-5 mb-3">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col-8 col-lg-5">   
            @include('layouts.branchFilterInput', [
                'action' => route('accounts.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#generalAccModal',
                'text' => 'Add New',
                'id' => 'addNewGeneralAcc',
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
                    <th scope="col">Ledger</th>
                    <th scope="col">Member Name</th>
                    <th scope="col">Account No.</th>
                    <th scope="col">Account Name</th>
                    <th scope="col">Account Type </th>
                    <th scope="col">Interest Rate </th>
                    <th scope="col">Start Date</th>
                    <th scope="col">Opening Balance</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Closing Flag</th>
                    <th scope="col">Add To Demand</th>
                    <th scope="col">Agent</th>
                    <th scope="col">Installment Type</th>
                    <th scope="col">Installment Amount </th>
                    <th scope="col">Total Installment Paid</th>
                    <th scope="col">Closing Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($accounts->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($accounts as $account)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$account->id}}</td>
                    <td>{{$account->ledger->name  ?? ''}}</td>
                    <td>{{$account->name  ?? ''}}</td>
                    <td>{{$account->account_no  ?? ''}}</td>
                    <td>{{$account->account_name  ?? ''}}</td>
                    <td>{{$account->account_type  ?? ''}}</td>
                    <td>{{$account->interest_rate  ?? ''}}</td>
                    <td>{{$account->start_date  ?? ''}}</td>
                    <td>{{$account->open_balance  ?? ''}}</td>
                    <td>{{$account->balance  ?? ''}}</td>
                    <td>{{$account->closing_flag  ?? ''}}</td>
                    <td>{{$account->add_to_demand  ?? ''}}</td>
                    <td>{{$account->agent->user->name ?? ''}}</td>
                    <td>{{$account->installment_type ?? ''}}</td>
                    <td>{{$account->installment_amount ?? ''}}</td>
                    <td>{{$account->total_installments_paid  ?? ''}}</td>
                    <td>{{$account->closing_date ?? ''}}</td>
                    <td>
                        <a href="#" data-id="{{$account->id }}" data-ledger-id ="{{$account->ledger_id}}" data-member-id="{{$account->member_id}}" data-account-no="{{$account->account_no}}" data-account-name="{{$account->account_name}}" data-name="{{$account->name}}" data-account-type="{{$account->account_type}}" data-interest-rate="{{$account->interest_rate}}" data-start-date="{{$account->start_date}}" data-open-balance="{{$account->open_balance}}" data-balance="{{$account->balance}}" data-closing-flag="{{$account->closing_flag}}" data-add-to-demand="{{$account->add_to_demand}}" data-agent-id="{{$account->agent_id}}"data-installment-type="{{$account->installment_type}}" data-installment-amount="{{$account->installment_amount}}" data-total-installments-paid="{{$account->total_installments_paid}}" data-closing-date="{{$account->closing_date}}" data-route="{{ route('accounts.update', $account->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#generalAccModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$account->id }}" data-route="{{ route('accounts.destroy', $account->id) }}" data-name="{{$account->name}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            No general accounts added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>  
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>       
        @include('layouts.pagination', ['paginationVariable' => 'accounts'])
    </div>
</div>

<!-- Form Model -->
@include('accounts.general-acc.generalAcc')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('generalAccModal'));
            modal.show();
        });
    </script>
@endif --}}

{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let genAccId = this.getAttribute("data-id");
            let ledgerId = this.getAttribute("data-ledger-id");
            let memberId = this.getAttribute("data-member-id");
            let accountNo = this.getAttribute("data-account-no");
            let accountName = this.getAttribute("data-account-name");
            let name = this.getAttribute("data-name");
            let accountType = this.getAttribute("data-account-type");
            let interestRate = this.getAttribute("data-interest-rate");
            let startDate = this.getAttribute("data-start-date");
            let openBalance = this.getAttribute("data-open-balance");
            let balance = this.getAttribute("data-balance");
            let closingFlag = this.getAttribute("data-closing-flag");
            let addToDemand = this.getAttribute("data-add-to-demand");
            let agentId = this.getAttribute("data-agent-id");
            let installmentType = this.getAttribute("data-installment-type");
            let installmentAmount = this.getAttribute("data-installment-amount");
            let totalInstallmentsPaid = this.getAttribute("data-total-installments-paid");
            let closingDate = this.getAttribute("data-closing-date");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("generalAccModal");

            // Update modal title
            document.getElementById("generalAccModalLabel").textContent = "Edit Account";

            // Populate form fields
            document.getElementById("genAccId").value = genAccId;
            document.getElementById("ledgerId").value = ledgerId;
            document.getElementById("memberId").value = memberId;
            document.getElementById("accountNo").value = accountNo;
            document.getElementById("accountName").value = accountName;
            document.getElementById("Name").value = name;
            document.getElementById("accountType").value = accountType;
            document.getElementById("interestRate").value = interestRate;
            document.getElementById("startDate").value = startDate;
            document.getElementById("openBalance").value = openBalance;
            document.getElementById("balance").value = balance;
            document.getElementById("closingFlag").checked = closingFlag == 1;
            document.getElementById("addToDemand").checked = addToDemand == 1;
            document.getElementById("agentId").value = agentId;
            document.getElementById("installmentType").value = installmentType;
            document.getElementById("installmentAmount").value = installmentAmount;
            document.getElementById("totalInstallmentsPaid").value = totalInstallmentsPaid;
            document.getElementById("closingDate").value = closingDate;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("generalAccForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#generalAccModal .btn-success").textContent = "Update Account";
            
        });
    });

    // Reset modal when it's closed
    document.getElementById("generalAccModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("generalAccForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('accounts.store') }}");

        // Reset modal title & button text
        document.getElementById("generalAccModalLabel").textContent = "Add General Account";
        document.querySelector("#generalAccModal .btn-success").textContent = "Save Changes";
    });
});

</script>
<script>
    const memberData = @json($members);
</script>
<script src="{{asset('assets\js\autofill-content-generalAcc.js')}}"></script>
@endsection

