@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Voucher Entry</h3>
    <div class="row">
        <div class="col-8 col-lg-5 mb-3">
            {{-- Search Input --}}
            @include('layouts.tableSearchInput')
        </div>
        <div class="col-8 col-lg-5"> 
         @if(Auth::user()->role === 'Admin')  
            @include('layouts.branchFilterInput', [
                'action' => route('voucher-entry.index')
            ])
        @endif
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#voucherEntryModal',
                'text' => 'Add New',
                'id' => 'voucherAddBtn'
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
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Date</th>
                    <th scope="col">Receipt No.</th>
                    <th scope="col">Payment No.</th>
                    <th scope="col">Ledger</th>
                    <th scope="col">Account</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Opening Balance</th>
                    <th scope="col">Current Balance</th>
                    <th scope="col">Approved By</th>
                    <th scope="col">Entered By</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Naration</th>
                    <th scope="col">M_Naration</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($voucherEntries->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($voucherEntries as $entry)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$entry->id}}</td>
                    <td>{{$entry->transaction_type}}</td>
                    <td>{{$entry->date}}</td>
                    <td>{{$entry->receipt_id }}</td>
                    <td>{{$entry->payment_id }}</td>
                    <td>{{$entry->ledger->name }}</td>
                      <td> @if (optional($entry->account)->name)
                            General A/C: {{ $entry->account->name }}
                        @elseif (optional($entry->memberDepositAccount)->name)
                            Depo A/C: {{ $entry->memberDepositAccount->name }}
                        @elseif (optional($entry->memberLoanAccount)->name)
                            Loan A/C: {{ $entry->memberLoanAccount->name }}
                        @else
                            -
                        @endif</td>
                    <td>{{$entry->amount ?? '' }}</td>
                    <td>{{$entry->opening_balance ?? '' }}</td>
                    <td>{{$entry->current_balance ?? '' }}</td>
                    <td>{{$entry->approvedBy->name ?? '' }}</td>
                    <td>{{$entry->enteredBy->name ?? '' }}</td>
                    <td>{{$entry->branch->name ?? '' }}</td>
                    <td>{{$entry->narration  ?? ''}}</td>
                    <td>{{$entry->m_narration ?? '' }}</td>
                    <td>
                        <a href="#" data-id="{{$entry->id }}" data-transaction-type="{{$entry->transaction_type}}" data-voucher-num="{{$entry->voucher_num ?? ''}}" data-token-number="{{$entry->token_number ?? ''}}" data-serial-no="{{$entry->serial_no ?? ''}}" data-date="{{$entry->date ?? ''}}" data-receipt-id="{{$entry->receipt_id ?? ''}}" data-payment-id="{{$entry->payment_id ?? ''}}" data-ledger-id="{{$entry->ledger_id ?? ''}}" data-account-id="{{$entry->account_id ?? ''}}" data-member-depo-account-id="{{$entry->member_depo_account_id ?? ''}}" data-member-loan-account-id="{{$entry->member_loan_account_id ?? ''}}" data-amount="{{$entry->amount ?? ''}}" data-debit-amount="{{$entry->debit_amount ?? ''}}" data-credit-amount="{{$entry->credit_amount ?? ''}}" data-from-date="{{$entry->from_date ?? ''}}" data-to-date="{{$entry->to_date ?? ''}}" data-opening-balance="{{$entry->opening_balance ?? ''}}" data-current-balance="{{$entry->current_balance ?? ''}}" data-transaction-mode="{{$entry->transaction_mode ?? ''}}" data-payment-mode="{{$entry->payment_mode ?? ''}}"  data-reference-no="{{$entry->reference_number ?? ''}}" data-is-reversed="{{$entry->is_reversed ?? ''}}" data-approved-by="{{$entry->approved_by ?? ''}}"  data-entered-by-id="{{$entry->entered_by ?? Auth::user()->id}}" data-entered-by="{{$entry->enteredBy->name ?? Auth::user()->name}}"   data-branch-id="{{$entry->branch->id ?? ''}}"  data-narration="{{$entry->narration ?? ''}}" data-m-narration="{{$entry->m_narration ?? ''}}" data-status="{{$entry->status}}" data-member-id="{{$entry->member_id}}" data-cheque-no="{{$entry->cheque_no}}" data-balance="{{$entry->balance}}" data-interest="{{$entry->interest}}" data-penal="{{$entry->penal}}" data-post-court="{{$entry->post_court}}" data-insurance="{{$entry->insurance}}" data-notice-fee="{{$entry->notice_fee}}" data-other="{{$entry->other}}" data-trans-chargs="{{$entry->trans_chargs}}" data-int-payable="{{$entry->int_payable}}" data-penal-interest="{{$entry->penal_interest}}" data-paid-interest="{{$entry->int_paid}}" data-total-amount="{{$entry->total_amount}}"  data-route="{{ route('voucher-entry.update', $entry->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#voucherEntryModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        {{-- <a href="#" data-id="{{$entry->id }}" data-route="{{ route('voucher-entry.destroy', $entry->id) }}" data-name="{{$entry->id}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a> --}}
                    </td>
                </tr>
                @php $i++ @endphp
                 @endforeach
                 @else
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No voucher entries added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr> 
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
        @include('layouts.pagination', ['paginationVariable' => 'voucherEntries'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.voucher-entry.voucherEntry')

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
            let transactionType = this.getAttribute("data-transaction-type");
            let date = this.getAttribute("data-date");
            let receiptId = this.getAttribute("data-receipt-id");
            let paymentId = this.getAttribute("data-payment-id");
            let ledgerId = this.getAttribute("data-ledger-id");
            let accountId = this.getAttribute("data-account-id");
            let memberDepoAccountId = this.getAttribute("data-member-depo-account-id");
            let memberLoanAccountId = this.getAttribute("data-member-loan-account-id");
            let selectedAccountId = '';
            let selectedAccountName = 'member_id';
            if(accountId){
                selectedAccountId = accountId;
                selectedAccountName = 'account_id';
            }
            if(memberDepoAccountId){
                selectedAccountId = memberDepoAccountId;
                selectedAccountName = 'member_depo_account_id';
            }
            if(memberLoanAccountId){
                selectedAccountId = memberLoanAccountId;
                selectedAccountName = 'member_loan_account_id';
            }
            
            let amount = this.getAttribute("data-amount");            
            let openingBalance = this.getAttribute("data-opening-balance");
            let currentBalance = this.getAttribute("data-current-balance");
            let approvedBy = this.getAttribute("data-approved-by");
            let enteredBy = this.getAttribute("data-entered-by");
            let enteredById = this.getAttribute("data-entered-by-id");
            let branchId = this.getAttribute("data-branch-id");
            let narration = this.getAttribute("data-narration");
            let mNarration = this.getAttribute("data-m-narration");
            let memberId = this.getAttribute("data-member-id");
            let chequeNo = this.getAttribute("data-cheque-no");
            let balance = this.getAttribute("data-balance");
            let interest = this.getAttribute("data-interest");
            let postCourt = this.getAttribute("data-post-court");
            let insurance = this.getAttribute("data-insurance");
            let noticeFee = this.getAttribute("data-notice-fee");
            let other = this.getAttribute("data-other");
            let transChargs = this.getAttribute("data-trans-chargs");
            let intPayable = this.getAttribute("data-int-payable");
            let interestPaid = this.getAttribute("data-paid-interest");
            let penalInterest = this.getAttribute("data-penal-interest");
            let totalAmount = this.getAttribute("data-total-amount");
            let route = this.getAttribute("data-route");
            
            fetch(`/get-accounts-by-ledger/${ledgerId}`)
            .then(response => response.json())
            .then(data => {

                const ledgerName = data.ledger_name?.toLowerCase(); // assumes backend sends ledger name
                const isMasikVargani = ledgerName === 'masik vargani';

                if (isMasikVargani) {
                    // Only show member dropdown
                    document.getElementById('selectMember')?.classList.remove('d-none');
                    // updateSelect('memberId', data.members, data.group);
                }
                // else {
                    // document.getElementById('selectMember')?.classList.add('d-none');
                    if (data.general_accounts.length > 0 && accountId) {
                        // updateSelect('accountId', data.general_accounts, data.group);
                        document.getElementById('accountId')?.closest('.accountField')?.classList.remove('d-none');
                    }
                    // else {
                    //     document.getElementById('accountId')?.closest('.accountField')?.classList.add('d-none');
                    // }

                    if (data.deposit_accounts.length > 0 && memberDepoAccountId) {
                        // updateSelect('memberDepoAccountId', data.deposit_accounts, data.group);
                        document.getElementById('memberDepoAccountId')?.closest('.accountField')?.classList.remove('d-none');
                    }
                    // else {
                    //     document.getElementById('memberDepoAccountId')?.closest('.accountField')?.classList.add('d-none');
                    // }

                    if (data.loan_accounts.length > 0 && memberLoanAccountId) {
                        // updateSelect('memberLoanAccountId', data.loan_accounts, data.group);
                        document.getElementById('memberLoanAccountId')?.closest('.accountField')?.classList.remove('d-none');
                    }
                    // else {
                    //     document.getElementById('memberLoanAccountId')?.closest('.accountField')?.classList.add('d-none');
                    // }
                // }

                selectedLedgerGroup = data.group;

                // Step 4: Hide all detail field groups
               handleAccountSelection(data.group);
               
                fetchAccountDetails(selectedAccountId, selectedAccountName, data.group); // fetch selected account's details
            })
            .catch(error => console.error('Error fetching accounts:', error))
            .finally(() => {
                document.getElementById('loadingSpinner').classList.add('d-none');
            });

            let modal = document.getElementById("voucherEntryModal");

            // Update modal title
            document.getElementById("voucherEntryModalLabel").textContent = "Edit Voucher Entry";

            // Populate form fields
            document.getElementById("voucherEntryId").value = id;
            document.getElementById("transactionType").value = transactionType;
            document.getElementById("date").value = date;
            document.getElementById("receiptId").value = receiptId;
            document.getElementById("paymentId").value = paymentId;
            document.getElementById("ledgerId").value = ledgerId;
            document.getElementById("accountId").value = accountId;
            document.getElementById("memberDepoAccountId").value = memberDepoAccountId;
            document.getElementById("memberLoanAccountId").value = memberLoanAccountId;
            if(document.getElementById("amount")){
            }  
            document.getElementById("openingBalance").value = openingBalance;
            document.getElementById("currentBalance").value = currentBalance;
            document.getElementById("approvedBy").value = approvedBy;
            document.getElementById("enteredById").value = enteredById;
            document.getElementById("enteredBy").value = enteredBy;
            document.getElementById("branchId").value = branchId;
            document.getElementById("narration").value = narration;
            document.getElementById("mNarration").value = mNarration;
            
            if(document.getElementById("memberId")){
                document.getElementById("memberId").value = memberId;
            }
            document.getElementById("cheque_no").value = chequeNo;
            document.getElementById("balance").value = balance;
            document.getElementById("amount").value = amount;
            if(document.getElementById("interest")){
                document.getElementById("interest").value = interest;
            }
             if(document.getElementById("penal")){
                 document.getElementById("penal").value = penal;
            } if(document.getElementById("post_court")){
                document.getElementById("post_court").value = postCourt;
            } if(document.getElementById("insurance")){
                document.getElementById("insurance").value = insurance;
            } if(document.getElementById("notice_fee")){
                document.getElementById("notice_fee").value = noticeFee;
            } if(document.getElementById("other")){
                document.getElementById("other").value = other;
            } if(document.getElementById("trans_chargs")){
                document.getElementById("trans_chargs").value = transChargs;
            } if(document.getElementById("int_payable")){
                document.getElementById("int_payable").value = intPayable;
            } if(document.getElementById("int_paid")){
                document.getElementById("int_paid").value = interestPaid;
            }if(document.getElementById("penal_interest")){
                document.getElementById("penal_interest").value = penalInterest;
            }if(document.getElementById("total_amount")){
                document.getElementById("total_amount").value = totalAmount;
            }
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("voucherEntryModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#voucherEntryModal .btn-success").textContent = "Update Voucher Entry";

            // Set the selected division
            let userSelect = document.getElementById("userId");
            
            if (userSelect) {
                userSelect.value = enteredById; // Pre-select the correct division
            }
        });
    });

    // Reset modal when it's closed
    document.getElementById("voucherEntryModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("voucherEntryModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('voucher-entry.store') }}");

        // Reset modal title & button text
        document.getElementById("voucherEntryModalLabel").textContent = "Add Voucher Entry";
        document.querySelector("#voucherEntryModal .btn-success").textContent = "Save Changes";
    });
    
});

</script>
<script>
    const accountsData = @json($accounts);
    const loanAccountsData = @json($loanAccounts);
    const depoAccountsData = @json($depoAccounts);
</script>
<script src="{{asset('assets\js\autofil-content-voucherEntry.js')}}"></script>
<script>
    const oldValues = @json(old());
    const validationErrors = @json($errors->toArray());
</script>       
<script src="{{asset('assets\js\voucher-transfer-entry-dynamic-fields.js')}}"></script>
<script>
   

</script>
@endsection