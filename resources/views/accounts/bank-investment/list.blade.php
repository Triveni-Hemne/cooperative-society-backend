@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Bank Investment</h3>
    <div class="row">
        <div class="col-5">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col">   
            @include('layouts.branchFilterInput', [
                'action' => route('bank-investments.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#bankInvestmentModal',
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
                    <th scope="col">Ledger</th>
                    <th scope="col">Account</th>
                    <th scope="col">Member Name</th>
                    <th scope="col">Investment Type</th>
                    <th scope="col">Interest Rate</th>
                    <th scope="col">Opening Date</th>
                    <th scope="col">Opening Balance</th>
                    <th scope="col">Current Balance</th>
                    <th scope="col">Maturity Date</th>
                    <th scope="col">Deposit Term Days</th>
                    <th scope="col">Months</th>
                    <th scope="col">Years</th>
                    <th scope="col">FD Amount</th>
                    <th scope="col">Monthly Deposit</th>
                    <th scope="col">RD Term Months</th>
                    <th scope="col">Maturity Amount</th>
                    <th scope="col">Interest</th>
                    <th scope="col">Interest Receivable</th>
                    <th scope="col">Interest Frequency</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @isset($bankInvestments)
                @if ($bankInvestments->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($bankInvestments as $bankInvestment)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$bankInvestment->id}}</td>
                    <td>{{$bankInvestment->ledger->name}}</td>
                    <td>{{ optional($bankInvestment->account)->account_no ?? optional($bankInvestment->depositAccount)->acc_no }}</td>
                    <td>{{$bankInvestment->name}}</td>
                    <td>{{$bankInvestment->investment_type}}</td>
                    <td>{{$bankInvestment->interest_rate}}</td>
                    <td>{{$bankInvestment->opening_date}}</td>
                    <td>{{$bankInvestment->opening_balance}}</td>
                    <td>{{$bankInvestment->current_balance}}</td>
                    <td>{{$bankInvestment->maturity_date}}</td>
                    <td>{{$bankInvestment->deposit_term_days}}</td>
                    <td>{{$bankInvestment->months}}</td>
                    <td>{{$bankInvestment->years}}</td>
                    <td>{{$bankInvestment->fd_amount}}</td>
                    <td>{{$bankInvestment->monthly_deposit}}</td>
                    <td>{{$bankInvestment->rd_term_months}}</td>
                    <td>{{$bankInvestment->maturity_amount}}</td>
                    <td>{{$bankInvestment->interest}}</td>
                    <td>{{$bankInvestment->interest_receivable}}</td>
                    <td>{{$bankInvestment->interest_frequency}}</td>
                    <td>
                        <a href="#" data-id="{{$bankInvestment->id }}" data-ledger-id="{{$bankInvestment->ledger_id}}" data-account-id="{{$bankInvestment->account_id  ?? '' }}" data-depo-account-id="{{$bankInvestment->depo_account_id  ?? '' }}" data-name="{{$bankInvestment->name  ?? '' }}" data-investment-type="{{$bankInvestment->investment_type  ?? '' }}" data-interest-rate="{{$bankInvestment->interest_rate   ?? '' }}" data-opening-date="{{$bankInvestment->opening_date   ?? '' }}" data-opening-balance="{{$bankInvestment->opening_balance  ?? '' }}" data-current-balance="{{$bankInvestment->current_balance  ?? '' }}" 
                            
                        data-fd-maturity-date="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->maturity_date : '' }}" 
                        data-fd-deposit-term-days="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->deposit_term_days : '' }}" 
                        data-fd-months="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->months : '' }}" 
                        data-fd-years="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->years : '' }}" 
                        data-fd-monthly-deposit="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->monthly_deposit : '' }}" 
                        data-fd-maturity-amount="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->maturity_amount : '' }}" 
                        data-fd-interest-receivable="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->interest_receivable : '' }}" 
                        data-fd-interest-frequency="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->interest_frequency : '' }}" 
                        data-fd-amount="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->fd_amount : '' }}" 
                        data-fd-interest="{{ $bankInvestment->investment_type === 'FD' ? $bankInvestment->interest : '' }}"

                        data-rd-maturity-date="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->maturity_date : '' }}" 
                        data-rd-deposit-term-days="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->deposit_term_days : '' }}" 
                        data-rd-months="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->months : '' }}" 
                        data-rd-years="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->years : '' }}" 
                        data-rd-monthly-deposit="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->monthly_deposit : '' }}" 
                        data-rd-term-months="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->rd_term_months : '' }}" 
                        data-rd-maturity-amount="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->maturity_amount : '' }}" 
                        data-rd-interest-receivable="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->interest_receivable : '' }}" 
                        data-rd-interest-frequency="{{ $bankInvestment->investment_type === 'RD' ? $bankInvestment->interest_frequency : '' }}"
                                                        
                        data-route="{{ route('bank-investments.update', $bankInvestment->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                        data-bs-target="#bankInvestmentModal">
                            <i class="fa fa-edit text-primary " style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$bankInvestment->id }}" data-route="{{ route('bank-investments.destroy', $bankInvestment->id) }}" data-name="{{$bankInvestment->name ?? ''}}"  class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a>
                    </td>
                </tr>
                 @php $i++ @endphp
                 @endforeach
                 @endisset
                 @else
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No bank investments added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr> 
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
        @include('layouts.pagination', ['paginationVariable' => 'bankInvestments'])
    </div>
</div>

<!-- Form Model -->
@include('accounts.bank-investment.bankInvestment')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let ledgerId = this.getAttribute("data-ledger-id");
            let accountId = this.getAttribute("data-account-id");
            let depoAccountId = this.getAttribute("data-depo-account-id");
            let name = this.getAttribute("data-name");
            let investmentType = this.getAttribute("data-investment-type");
            let interestRate = this.getAttribute("data-interest-rate");
            let openingDate = this.getAttribute("data-opening-date");
            let openingBalance = this.getAttribute("data-opening-balance");
            let currentBalance = this.getAttribute("data-current-balance");

            let fdMaturityDate = this.getAttribute("data-fd-maturity-date");
            let fdDepositTermDays = this.getAttribute("data-fd-deposit-term-days");
            let fdMonths = this.getAttribute("data-fd-months");
            let fdYears = this.getAttribute("data-fd-years");
            let fdMonthlyDeposit = this.getAttribute("data-fd-monthly-deposit");
            let fdMaturityAmount = this.getAttribute("data-fd-maturity-amount");
            let fdInterestReceivable = this.getAttribute("data-fd-interest-receivable");
            let fdInterestFrequency = this.getAttribute("data-fd-interest-frequency");
            let fdAmount = this.getAttribute("data-fd-amount");
            let fdInterest = this.getAttribute("data-fd-interest");
            
            let rdMaturityDate = this.getAttribute("data-rd-maturity-date");
            let rdDepositTermDays = this.getAttribute("data-rd-deposit-term-days");
            let rdMonths = this.getAttribute("data-rd-months");
            let rdYears = this.getAttribute("data-rd-years");
            let rdMonthlyDeposit = this.getAttribute("data-rd-monthly-deposit");
            let rdTermMonths = this.getAttribute("data-rd-term-months");
            let rdMaturityAmount = this.getAttribute("data-rd-maturity-amount");
            let rdInterestReceivable = this.getAttribute("data-rd-interest-receivable");
            let rdInterestFrequency = this.getAttribute("data-rd-interest-frequency");

            let route = this.getAttribute("data-route");

            let modal = document.getElementById("bankInvestmentModal");

            // Update modal title
            document.getElementById("bankInvestmentModalLabel").textContent = "Edit Bank Investment";

            // Populate form fields
            document.getElementById("bankInvestmentId").value = id;
            let ledgerInput = document.getElementById("ledgerId");
            if (ledgerInput) {
                ledgerInput.value = ledgerId;
            } else {
                console.warn("Element with ID 'ledgerId' not found.");
            }
            let accountInput = document.getElementById("accountId");
            if (accountInput) {
                accountInput.value = accountId;
            } else {
                console.warn("Element with ID 'ledgerId' not found.");
            }
            let depoAccountInput = document.getElementById("depoAccountId");
            if (depoAccountInput) {
                depoAccountInput.value = depoAccountId;
            } else {
                console.warn("Element with ID 'ledgerId' not found.");
            }
            document.getElementById("name").value = name;
            document.getElementById("investmentType").value = investmentType;
            document.getElementById("interestRate").value = interestRate;
            document.getElementById("openingDate").value = openingDate;
            document.getElementById("openingBalance").value = openingBalance;
            document.getElementById("currentBalance").value = currentBalance;

            document.getElementById("fdMaturityDate").value = fdMaturityDate;
            document.getElementById("fdDepositTermDays").value = fdDepositTermDays;
            document.getElementById("fdMonths").value = fdMonths;
            document.getElementById("fdYears").value = fdYears;
            document.getElementById("fdMonthlyDeposit").value = fdMonthlyDeposit;
            document.getElementById("fdMaturityAmount").value = fdMaturityAmount;
            document.getElementById("fdInterestReceivable").value = fdInterestReceivable;
            document.getElementById("fdInterestFrequency").value = fdInterestFrequency;
            document.getElementById("fdAmount").value = fdAmount;
            document.getElementById("fdInterest").value = fdInterest;
            document.getElementById("fdMaturityAmount").value = fdMaturityAmount;

            document.getElementById("rdMaturityDate").value = rdMaturityDate;
            document.getElementById("rdDepositTermDays").value = rdDepositTermDays;
            document.getElementById("rdMonths").value = rdMonths;
            document.getElementById("rdYears").value = rdYears;
            
            document.getElementById("rdMonthlyDeposit").value = rdMonthlyDeposit;
            document.getElementById("rdTermMonths").value = rdTermMonths;
            document.getElementById("rdMaturityAmount").value = rdMaturityAmount;
            document.getElementById("rdInterestReceivable").value = rdInterestReceivable;
            document.getElementById("rdInterestFrequency").value = rdInterestFrequency;

            
            // Change form action to update route and set PUT method
            let form = document.getElementById("bankInvestmentForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#bankInvestmentModal .btn-primary").textContent = "Update Bank Investment";
        });
    });

    // Reset modal when it's closed
    document.getElementById("bankInvestmentModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("bankInvestmentForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('bank-investments.store') }}");

        // Reset modal title & button text
        document.getElementById("bankInvestmentModalLabel").textContent = "Add Bank Investment";
        document.querySelector("#bankInvestmentModal .btn-primary").textContent = "Save Changes";
    });
});

</script>
<script src="{{asset('assets\js\autofill-calc-bank-investment.js')}}"></script>
@endsection
