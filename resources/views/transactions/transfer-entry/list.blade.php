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
        <div class="col-8 col-lg-5 mb-3">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col-8 col-lg-5">   
            @include('layouts.branchFilterInput', [
                'action' => route('transfer-entry.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#transferEntryModal',
                'text' => 'Add New',
                'id' => 'transferAddBtn'
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
                @if ($transferEntries->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($transferEntries as $entry)
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
                        <a href="#" data-id="{{$entry->id }}" data-transaction-type="{{$entry->transaction_type}}" data-voucher-num="{{$entry->voucher_num ?? ''}}" data-token-number="{{$entry->token_number ?? ''}}" data-serial-no="{{$entry->serial_no ?? ''}}" data-date="{{$entry->date ?? ''}}" data-receipt-id="{{$entry->receipt_id ?? ''}}" data-payment-id="{{$entry->payment_id ?? ''}}" data-ledger-id="{{$entry->ledger_id ?? ''}}" data-account-id="{{$entry->account_id ?? ''}}" data-member-depo-account-id="{{$entry->member_depo_account_id ?? ''}}" data-member-loan-account-id="{{$entry->member_loan_account_id ?? ''}}" data-amount="{{$entry->amount ?? ''}}" data-debit-amount="{{$entry->debit_amount ?? ''}}" data-credit-amount="{{$entry->credit_amount ?? ''}}" data-from-date="{{$entry->from_date ?? ''}}" data-to-date="{{$entry->to_date ?? ''}}" data-opening-balance="{{$entry->opening_balance ?? ''}}" data-current-balance="{{$entry->current_balance ?? ''}}" data-transaction-mode="{{$entry->transaction_mode ?? ''}}" data-payment-mode="{{$entry->payment_mode ?? ''}}"  data-reference-no="{{$entry->reference_number ?? ''}}" data-is-reversed="{{$entry->is_reversed ?? ''}}" data-approved-by="{{$entry->approved_by ?? ''}}"  data-entered-by-id="{{$entry->entered_by ?? Auth::user()->id}}" data-entered-by="{{$entry->enteredBy->name ?? Auth::user()->name}}"   data-branch-id="{{$entry->branch->id ?? ''}}"  data-narration="{{$entry->narration ?? ''}}" data-m-narration="{{$entry->m_narration ?? ''}}" data-status="{{$entry->status}}" data-member-id="{{$entry->member_id}}" data-cheque-no="{{$entry->cheque_no}}" data-balance="{{$entry->balance}}" data-interest="{{$entry->interest}}" data-penal="{{$entry->penal}}" data-post-court="{{$entry->post_court}}" data-insurance="{{$entry->insurance}}" data-notice-fee="{{$entry->notice_fee}}" data-other="{{$entry->other}}" data-trans-chargs="{{$entry->trans_chargs}}" data-int-payable="{{$entry->int_payable}}" data-penal-interest="{{$entry->penal_interest}}" data-paid-interest="{{$entry->int_paid}}" data-total-amount="{{$entry->total_amount}}" data-route="{{ route('transfer-entry.update', $entry->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#transferEntryModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        {{-- <a href="#" data-id="{{$entry->id }}" data-route="{{ route('transfer-entry.destroy', $entry->id) }}" data-name="{{$entry->id}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('transferEntryModal'));
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
            let transactionType = this.getAttribute("data-transaction-type");
            let date = this.getAttribute("data-date");
            let branchId = this.getAttribute("data-branch-id");
            let createdBy = this.getAttribute("data-created-by");
            let createdById = this.getAttribute("data-created-by-id");
            let receiptId = this.getAttribute("data-receipt-id");
            let paymentId = this.getAttribute("data-payment-id");
            let ledgerId = this.getAttribute("data-ledger-id");
            let openingBalance = this.getAttribute("data-opening-balance");
            let currentBalance = this.getAttribute("data-current-balance");
            let narration = this.getAttribute("data-narration");
            let mNarration = this.getAttribute("data-m-narration");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("transferEntryModal");

            // Update modal title
            document.getElementById("transferEntryModalLabel").textContent = "Edit Transfer Entry";

            // Populate form fields
            document.getElementById("transferEntryId").value = id;
            document.getElementById("transactionType").value = transactionType;
            document.getElementById("date").value = date;
            document.getElementById("branchId").value = branchId;
            document.getElementById("createdBy").value = createdBy;
            document.getElementById("createdById").value = createdById;
            document.getElementById("receiptId").value = receiptId;
            document.getElementById("paymentId").value = paymentId;
            document.getElementById("ledgerId").value = ledgerId;
            document.getElementById("openingBalance").value = openingBalance;
            document.getElementById("currentBalance").value = currentBalance;
            document.getElementById("narration").value = narration;
            document.getElementById("m_narration").value = mNarration;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("transferEntryModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#transferEntryModal .btn-success").textContent = "Update Transfer Entry";
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
        document.querySelector("#transferEntryModal .btn-success").textContent = "Save Changes";
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
@endsection
