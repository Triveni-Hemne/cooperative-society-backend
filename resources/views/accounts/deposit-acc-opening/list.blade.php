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
        <h3>Deposit Account Opening</h3>
    </div>

    <!-- Search Bar and Add New Button -->
    <div class="d-flex justify-content-between mb-3">
        <input type="search" id="searchInput" placeholder="Search Here..." class="w-50 px-3 py-1 rounded">

        <div>
            <a href="#" class="d-flex justify-content-between gap-2 text-decoration-none d-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#depositAccOpeningModal">
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
                    <th scope="col">ledger</th>
                    <th scope="col">member</th>
                    <th scope="col">Account No.</th>
                    <th scope="col">Deposit Type</th>
                    <th scope="col">Interest Rate</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($depo_accounts->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($depo_accounts as $account)
                 <tr>
                    <th scope="row">{{$i}}</th>
                    <th scope="row">{{$account->id}}</th>
                    <th scope="row">{{$account->ledger->name}}</th>
                    <th scope="row">{{$account->member->name}}</th>
                    <th scope="row">{{$account->acc_no}}</th>
                    <th scope="row">{{$account->deposit_type}}</th>
                    <th scope="row">{{$account->interest_rate}}</th>
                    <th scope="row">{{$account->balance}}</th>
                
                    <td>
                        <a href="#"  data-id="{{$account->id }}" data-member-id="{{$account->member_id ?? ''}}" data-ledger-id="{{$account->ledger_id}}" data-account-id="{{$account->account_id ?? null}}" data-acc-no="{{$account->acc_no ?? ''}}" data-deposit-type="{{$account->deposit_type}}" data-name="{{$account->name ?? ''}}" data-interest-rate="{{$account->interest_rate ?? ''}}" data-ac-start-date="{{$account->ac_start_date ?? ''}}" data-open-balance="{{$account->open_balance ?? ''}}" data-balance="{{$account->balance ?? ''}}"data-closing-flag="{{$account->closing_flag ?? ''}}" data-add-to-demand="{{$account->add_to_demand ?? ''}}" data-agent-id="{{$account->agent_id ?? ''}}" data-page-no="{{$account->page_no ?? ''}}" data-installment-type="{{$account->installment_type ?? ''}}" data-installment-amount="{{$account->installment_amount ?? ''}}"data-total-installments="{{$account->total_installments ?? ''}}" data-total-payable-amount="{{$account->total_payable_amount ?? ''}}" data-total-installments-paid="{{$account->total_installments_paid ?? ''}}" data-acc-closing-date="{{$account->acc_closing_date}}" data-interest-payable="{{$account->interest_payable ?? ''}}" data-open-interest="{{$account->open_interest ?? ''}}" data-route="{{ route('member-depo-accounts.update', $account->id) }}"
                        @php $j = 1; @endphp 
                        @foreach($account->nominees as $nominee)
                        data-nominee-name{{$j}}="{{$nominee->nominee_name}}" data-nominee-naav{{$j}}="{{$nominee->nominee_naav ?? ''}}" data-nominee-age{{$j}}="{{$nominee->nominee_age}}" data-nominee-gender{{$j}}="{{$nominee->nominee_gender}}" data-relation{{$j}}="{{$nominee->relation}}" 
                        @php $j++; @endphp 
                        @endforeach
                        data-fd-term-months="{{$account->fixedDeposit->fd_term_months ?? '' }}" data-fd-open-interest="{{$account->fixedDeposit->open_interest ?? ''}}" data-fd-maturity-amount="{{$account->fixedDeposit->maturity_amount ?? ''}}" data-fd-balance="{{$account->fixedDeposit->balance ?? ''}}" data-interest-rate="{{$account->interest_rate ?? ''}}"
                        data-rd-term-months="{{$account->recurringDeposit->rd_term_months ?? '' }}" data-rd-open-interest="{{$account->recurringDeposit->open_interest ?? ''}}" data-rd-maturity-amount="{{$account->recurringDeposit->maturity_amount ?? ''}}"
                        data-sv-balance="{{$account->saveDeposit->balance ?? '' }}" data-sv-interest="{{$account->saveDeposit->interest_rate ?? ''}}"
                        class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                        data-bs-target="#depositAccOpeningModal">
                        <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$account->id }}" data-route="{{ route('member-depo-accounts.destroy', $account->id) }}" data-name="{{$account->name}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
              @include('layouts.pagination', ['paginationVariable' => 'depo_accounts'])
    </div>
</div>

<!-- Form Model -->
@include('accounts.deposit-acc-opening.depositAccOpening')

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
            let memberId = this.getAttribute("data-member-id");
            let ledgerId = this.getAttribute("data-ledger-id");
            let accountId = this.getAttribute("data-account-id");
            let accNo = this.getAttribute("data-acc-no");
            let depositType = this.getAttribute("data-deposit-type");
            let name = this.getAttribute("data-name");
            let interestRate = this.getAttribute("data-interest-rate");
            let acStartDate = this.getAttribute("data-ac-start-date");
            let openBalance = this.getAttribute("data-open-balance");
            let balance = this.getAttribute("data-balance");
            let closingFlag = this.getAttribute("data-closing-flag");
            let addToDemand = this.getAttribute("data-add-to-demand");
            let agentId = this.getAttribute("data-agent-id");
            let pageNo = this.getAttribute("data-page-no");
            let installmentType = this.getAttribute("data-installment-type");
            let installmentAmount = this.getAttribute("data-installment-amount");
            let totalInstallments = this.getAttribute("data-total-installments");
            let totalPayableAmount = this.getAttribute("data-total-payable-amount");
            let installmentsPaid = this.getAttribute("data-total-installments-paid");
            let accClosingDate = this.getAttribute("data-acc-closing-date");
            let interestPayable = this.getAttribute("data-interest-payable");
            let openInterest = this.getAttribute("data-open-interest");

            let nominee1Name = this.getAttribute("data-nominee-name1");
            let marathiNominee1Name = this.getAttribute("data-nominee-naav1");
            let nominee1Age = this.getAttribute("data-nominee-age1");
            let nominee1Gender = this.getAttribute("data-nominee-gender1");
            let nominee1Relation = this.getAttribute("data-relation1");

            let nominee2Name = this.getAttribute("data-nominee-name2");
            let marathiNominee2Name = this.getAttribute("data-nominee-naav2");
            let nominee2Age = this.getAttribute("data-nominee-age2");
            let nominee2Gender = this.getAttribute("data-nominee-gender2");
            let nominee2Relation = this.getAttribute("data-relation2");

            let fdTermMonths = this.getAttribute("data-fd-term-months");
            let fdMaturityAmount = this.getAttribute("data-fd-maturity-amount");

            let rdTermMonths = this.getAttribute("data-rd-term-months");
            let openingInterest = this.getAttribute("data-rd-open-interest");
            let rdMaturityAmount = this.getAttribute("data-rd-maturity-amount");
            
            let svBalance = this.getAttribute("data-sv-balance");
            let svInterestRate = this.getAttribute("data-sv-interest");
                  
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("agentModal");

            // Update modal title
            document.getElementById("depositAccOpeningModalLabel").textContent = "Edit Deposite Account";

            // Populate form fields
            document.getElementById("agentId").value = id;
            document.getElementById("memberId").value = memberId;
            document.getElementById("ledgerId").value = ledgerId;
            let accountInput = document.getElementById("accountId");
            if (accountInput) {
                accountInput.value = accountId;
            } else {
                console.warn("Element with ID 'accountId' not found.");
            }
            document.getElementById("accNo").value = accNo;
            document.getElementById("depositType").value = depositType;
            document.getElementById("name").value = name;
            document.getElementById("interestRate").value = interestRate;
            document.getElementById("acStartDate").value = acStartDate;
            document.getElementById("openBalance").value = openBalance;
            document.getElementById("balance").value = balance;
            document.getElementById("closingFlag").checked = closingFlag == 1;
            document.getElementById("addToDemand").checked = addToDemand == 1;
            document.getElementById("pageNo").value = pageNo;
            document.getElementById("agentId").value = agentId;
            document.getElementById("installmentType").value = installmentType;
            document.getElementById("installmentAmount").value = installmentAmount;
            document.getElementById("totalInstallments").value = totalInstallments;
            document.getElementById("totalPayableAmount").value = totalPayableAmount;
            document.getElementById("installmentsPaid").value = installmentsPaid;
            document.getElementById("accClosingDate").value = accClosingDate;
            document.getElementById("interestPayable").value = interestPayable;
            document.getElementById("openInterest").value = openInterest;

            document.getElementById("nominee1Name").value = nominee1Name;
            document.getElementById("marathiNominee1Name").value = marathiNominee1Name;
            document.getElementById("nominee1Age").value = nominee1Age;
            document.getElementById("nominee1Gender").value = nominee1Gender;
            document.getElementById("nominee1Relation").value = nominee1Relation;

            document.getElementById("nominee2Name").value = nominee2Name;
            document.getElementById("marathiNominee2Name").value = marathiNominee2Name;
            document.getElementById("nominee2Age").value = nominee2Age;
            document.getElementById("nominee2Gender").value = nominee2Gender;
            document.getElementById("nominee2Relation").value = nominee2Relation;

            document.getElementById("fdTermMonths").value = fdTermMonths;
            document.getElementById("fdMaturityAmount").value = fdMaturityAmount;

            document.getElementById("rdTermMonths").value = rdTermMonths;
            document.getElementById("openingInterest").value = openingInterest;
            document.getElementById("rdMaturityAmount").value = rdMaturityAmount;

            document.getElementById("svBalance").value = svBalance;
            document.getElementById("svInterestRate").value = svInterestRate;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("depositAccModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#depositAccOpeningModal .btn-primary").textContent = "Update Deposite Account";
        });
    });

    // Reset modal when it's closed
    document.getElementById("depositAccOpeningModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("depositAccModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('member-depo-accounts.store') }}");

        // Reset modal title & button text
        document.getElementById("depositAccOpeningModalLabel").textContent = "Add Anget";
        document.querySelector("#depositAccOpeningModal .btn-primary").textContent = "Save Changes";
    });
});

</script>