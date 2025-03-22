@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div>
    <!-- Heading -->
    <div class="mb-4 heading">
        <h3>Loan Account Opening</h3>
    </div>

    <!-- Search Bar and Add New Button -->
    <div class="d-flex justify-content-between mb-3">
        <input type="search" id="searchInput" placeholder="Search Here..." class="w-50 px-3 py-1 rounded">

        <div>
            <a href="#" class="d-flex justify-content-between gap-2 text-decoration-none d-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#loanAccOpeningModal">
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
                    <th scope="col">Ledger</th>
                    <th scope="col">member</th>
                    <th scope="col">Account No. </th>
                    <th scope="col">Loan Type</th>
                    <th scope="col">name</th>
                    <th scope="col">Acc Start Date</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                 @if ($loanAccounts->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($loanAccounts as $account)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$account->id}}</td>
                    <td>{{$account->ledger->name}}</td>
                    <td>{{$account->member->name}}</td>
                    <td>{{$account->acc_no}}</td>
                    <td>{{$account->loan_type}}</td>
                    <td>{{$account->name}}</td>
                    <td>{{$account->ac_start_date}}</td>
                    <td>{{$account->balance}}</td>
                    <td>
                        <a href="#" data-id="{{$account->id }}" data-ledger-id="{{$account->ledger_id ?? ''}}" data-member-id="{{$account->member_id ?? ''}}" data-account-id="{{$account->account_id ?? ''}}" data-acc-no="{{$account->acc_no ?? ''}}" data-loan-type="{{$account->loan_type ?? ''}}" data-name="{{$account->name ?? ''}}"data-ac-start-date="{{$account->ac_start_date ?? ''}}" data-open-balance="{{$account->open_balance ?? ''}}" data-purpose="{{$account->purpose ?? ''}}" data-principal-amount="{{$account->principal_amount ?? ''}}" data-interest-rate="{{$account->interest_rate ?? ''}}" data-tenure="{{$account->tenure ?? ''}}" data-emi-amount="{{$account->emi_amount ?? ''}}" data-start-date="{{$account->start_date ?? ''}}" data-end-date="{{$account->end_date ?? ''}}" data-balance="{{$account->balance ?? ''}}" data-priority="{{$account->priority ?? ''}}" data-loan-amount="{{$account->loan_amount ?? ''}}" data-collateral-type="{{$account->collateral_type ?? ''}}" data-collateral-value="{{$account->collateral_value ?? ''}}" data-status="{{$account->status ?? ''}}" data-add-to-demand="{{$account->add_to_demand ?? ''}}" data-is-loss-asset="{{$account->is_loss_asset ?? ''}}" data-case-flag="{{$account->case_flag ?? ''}}" data-page-no="{{$account->page_no ?? ''}}" data-interest="{{$account->interest ?? ''}}" data-postage="{{$account->postage ?? ''}}" data-insurance="{{$account->insurance ?? ''}}" data-open-interest="{{$account->open_interest ?? ''}}" data-penal-interest="{{$account->penal_interest ?? ''}}" data-notice-fee="{{$account->notice_fee ?? ''}}" data-insurance-date="{{$account->insurance_date ?? ''}}" 

                        @php $j = 1; @endphp 
                        @foreach($account->nominees as $nominee)
                        data-nominee-name{{$j}}="{{$nominee->nominee_name}}" data-nominee-naav{{$j}}="{{$nominee->nominee_naav ?? ''}}" data-nominee-age{{$j}}="{{$nominee->nominee_age}}" data-nominee-gender{{$j}}="{{$nominee->nominee_gender}}" data-relation{{$j}}="{{$nominee->relation}}" 
                        @php $j++; @endphp 
                        @endforeach

                        data-gold-weight="{{$account->goldLoanDtl->gold_weight ?? ''}}" data-gold-purity="{{$account->goldLoanDtl->gold_purity ?? ''}}" data-market-value="{{$account->goldLoanDtl->market_value ?? ''}}" data-pledged-date="{{$account->goldLoanDtl->pledged_date ?? ''}}" data-release-status="{{$account->goldLoanDtl->release_status ?? ''}}" data-release-date="{{$account->goldLoanDtl->release_date ?? ''}}"
                        
                         data-gr-member-id="{{$account->loanGarantor->member_id ?? ''}}" data-guarantor-type="{{$account->loanGarantor->guarantor_type ?? ''}}"   data-added-on="{{$account->loanGarantor->added_on ?? ''}}"   data-released-on="{{$account->loanGarantor->released_on  ?? ''}}" 

                        data-installment-type="{{$account->loanInstallment->installment_type  ?? ''}}" data-mature-date="{{$account->loanInstallment->mature_date ?? ''}}" data-first_installment_date="{{$account->loanInstallment->first_installment_date ?? ''}}" data-total-installments="{{$account->loanInstallment->total_installments ?? ''}}" data-installment-amount="{{$account->loanInstallment->installment_amount ?? ''}}" data-installment-with-interest="{{$account->loanInstallment->installment_with_interest	?? ''}}" data-total-installments-paid="{{$account->loanInstallment->total_installments_paid ?? ''}}" 
                        
                        data-resolution-no="{{$account->loanResolutionDtl->resolution_no ?? ''}}" data-resolution-date="{{$account->loanResolutionDtl->resolution_date ?? ''}}"

                        data-route="{{ route('member-loan-accounts.update', $account->id) }}" class="edit-btn text-decoration-none me-4" data-bs-toggle="modal"
                            data-bs-target="#loanAccOpeningModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$account->id }}" data-route="{{ route('member-loan-accounts.destroy', $account->id) }}" data-name="{{$account->name}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
            @include('layouts.pagination', ['paginationVariable' => 'loanAccounts'])
    </div>
</div>

<!-- Form Model -->
@include('accounts.loan-acc-opening.loanAccOpening')

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
            let ledgerId = this.getAttribute("data-ledger-id");
            let memberId = this.getAttribute("data-member-id");
            let accountId = this.getAttribute("data-account-id");
            let accNo = this.getAttribute("data-acc-no");
            let loanType = this.getAttribute("data-loan-type");
            let name = this.getAttribute("data-name");
            let acStartDate = this.getAttribute("data-ac-start-date");
            let openBalance = this.getAttribute("data-open-balance");
            let purpose = this.getAttribute("data-purpose");
            let principalAmount = this.getAttribute("data-principal-amount");
            let interestRate = this.getAttribute("data-interest-rate");
            let tenure = this.getAttribute("data-tenure");
            let emiAmount = this.getAttribute("data-emi-amount");
            let startDate = this.getAttribute("data-start-date");
            let endDate = this.getAttribute("data-end-date");
            let balance = this.getAttribute("data-balance");
            let priority = this.getAttribute("data-priority");
            let loanAmount = this.getAttribute("data-loan-amount");
            let collateralType = this.getAttribute("data-collateral-type");
            let collateralValue = this.getAttribute("data-collateral-value");
            let status = this.getAttribute("data-status");
            let addToDemand = this.getAttribute("data-add-to-demand");
            let isLossAsset = this.getAttribute("data-is-loss-asset");
            let caseFlag = this.getAttribute("data-case-flag");
            let pageNo = this.getAttribute("data-page-no");
            let interest = this.getAttribute("data-interest");
            let openInterest = this.getAttribute("data-open-interest");
            let penalInterest = this.getAttribute("data-penal-interest");
            let insurance = this.getAttribute("data-insurance");
            let postage = this.getAttribute("data-postage");
            let noticeFee = this.getAttribute("data-notice-fee");
            let insuranceDate = this.getAttribute("data-insurance-date");

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

            let goldWeight = this.getAttribute("data-gold-weight");
            let goldPurity = this.getAttribute("data-gold-purity");
            let marketValue = this.getAttribute("data-market-value");
            let pledgedDate = this.getAttribute("data-pledged-date");
            let releaseStatus = this.getAttribute("data-release-status");
            let releaseDate = this.getAttribute("data-release-date");

            let grMemberId = this.getAttribute("data-gr-member-id");
            let guarantorType = this.getAttribute("data-guarantor-type");
            let addedOn = this.getAttribute("data-added-on");
            let releasedOn = this.getAttribute("data-released-on");

            let installmentType = this.getAttribute("data-installment-type");
            let matureDate = this.getAttribute("data-mature-date");
            let firstInstallmentDate = this.getAttribute("data-first-installment-date");
            let totalInstallments = this.getAttribute("data-total-installments");
            let installmentAmount = this.getAttribute("data-installment-amount");
            let installmentWithInterest = this.getAttribute("data-installment-with-interest");
            let installmentsPaid = this.getAttribute("data-total-installments-paid");

            let resolutionNo = this.getAttribute("data-resolution-no");
            let resolutionDate = this.getAttribute("data-resolution-date");

            let route = this.getAttribute("data-route");

            let modal = document.getElementById("loanAccOpeningModal");

            // Update modal title
            document.getElementById("loanAccOpeningModalLabel").textContent = "Edit Loan Account";

            // Populate form fields
            document.getElementById("loanAccId").value = id;
            document.getElementById("memberId").value = memberId;
            document.getElementById("ledgerId").value = ledgerId;
            let accountInput = document.getElementById("accountId");
            if (accountInput) {
                accountInput.value = accountId;
            } else {
                console.warn("Element with ID 'accountId' not found.");
            }
            document.getElementById("accNo").value = accNo;
            document.getElementById("loanType").value = loanType;
            document.getElementById("name").value = name;
            document.getElementById("acStartDate").value = acStartDate;
            document.getElementById("openBalance").value = openBalance;
            document.getElementById("purpose").value = purpose;
            document.getElementById("principalAmount").value = principalAmount;
            document.getElementById("interestRate").value = interestRate;
            document.getElementById("tenure").value = tenure;
            document.getElementById("emiAmount").value = emiAmount;
            document.getElementById("startDate").value = startDate;
            document.getElementById("endDate").value = endDate;
            document.getElementById("balance").value = balance;
            document.getElementById("priority").value = priority;
            document.getElementById("loanAmount").value = loanAmount;
            document.getElementById("collateralType").value = collateralType;
            document.getElementById("collateralValue").value = collateralValue;
            // document.getElementById("status").value = status;
            document.getElementById("addToDemand").checked = addToDemand == 1;
            document.getElementById("isLossAsset").checked = isLossAsset == 1;
            document.getElementById("caseFlag").checked = caseFlag == 1;
            document.getElementById("pageNo").value = pageNo;
            document.getElementById("interest").value = interest;
            document.getElementById("openInterest").value = openInterest;
            document.getElementById("penalInterest").value = penalInterest;
            document.getElementById("insurance").value = insurance;
            document.getElementById("postage").value = postage;
            document.getElementById("noticeFee").value = noticeFee;
            document.getElementById("insuranceDate").value = insuranceDate;

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
           
            document.getElementById("goldWeight").value = goldWeight;
            document.getElementById("goldPurity").value = goldPurity;
            document.getElementById("marketValue").value = marketValue;
            document.getElementById("pledgedDate").value = pledgedDate;
            document.getElementById("releaseStatus").value = releaseStatus;
            document.getElementById("releaseDate").value = releaseDate;

            document.getElementById("grMemberId").value = grMemberId;
            document.getElementById("guarantorType").value = guarantorType;
            document.getElementById("addedOn").value = addedOn;
            document.getElementById("releasedOn").value = releasedOn;

            document.getElementById("installmentType").value = installmentType;
            document.getElementById("matureDate").value = matureDate;
            document.getElementById("firstInstallmentDate").value = firstInstallmentDate;
            document.getElementById("totalInstallments").value = totalInstallments;
            document.getElementById("installmentAmount").value = installmentAmount;
            document.getElementById("installmentWithInterest").value = installmentWithInterest;
            document.getElementById("installmentsPaid").value = installmentsPaid;

            document.getElementById("resolutionNo").value = resolutionNo;
            document.getElementById("resolutionDate").value = resolutionDate;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("memberLoanAccForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#loanAccOpeningModal .btn-primary").textContent = "Update Deposite Account";
        });
    });

    // Reset modal when it's closed
    document.getElementById("loanAccOpeningModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("memberLoanAccForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('member-loan-accounts.store') }}");

        // Reset modal title & button text
        document.getElementById("loanAccOpeningModalLabel").textContent = "Add Anget";
        document.querySelector("#loanAccOpeningModal .btn-primary").textContent = "Save Changes";
    });
});

</script>