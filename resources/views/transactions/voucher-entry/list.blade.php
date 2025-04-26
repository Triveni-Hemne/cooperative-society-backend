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
        <div class="col-5">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col"> 
         @if(Auth::user()->role === 'Admin')  
            @include('layouts.branchFilterInput', [
                'action' => route('voucher-entry.index')
            ])
        @endif
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#voucherEntryModal',
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
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Voucher Number</th>
                    <th scope="col">Token Number</th>
                    <th scope="col">Serial No.</th>
                    <th scope="col">Date</th>
                    <th scope="col">Receipt No.</th>
                    <th scope="col">Payment No.</th>
                    <th scope="col">Ledger</th>
                    <th scope="col">Account</th>
                    <th scope="col">Depo Account</th>
                    <th scope="col">Loan Account</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Debit Amount</th>
                    <th scope="col">Credit Amount</th>
                    <th scope="col">Opening Balance</th>
                    <th scope="col">Current Balance</th>
                    <th scope="col">Transaction Mode</th>
                    <th scope="col">Reference No.</th>
                    <th scope="col">Is Reversed</th>
                    <th scope="col">Approved By</th>
                    <th scope="col">Approved At</th>
                    <th scope="col">Entered By</th>
                    <th scope="col">Branch</th>
                    <th scope="col">From Date</th>
                    <th scope="col">To Date</th>
                    <th scope="col">Naration</th>
                    <th scope="col">M_Naration</th>
                    <th scope="col">Status</th>
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
                    <td>{{$entry->voucher_num ?? ''}}</td>
                    <td>{{$entry->token_number ?? ''}}</td>
                    <td>{{$entry->serial_no ?? ''}}</td>
                    <td>{{$entry->date}}</td>
                    <td>{{$entry->receipt_id }}</td>
                    <td>{{$entry->payment_id }}</td>
                    <td>{{$entry->ledger->name }}</td>
                    <td>{{$entry->account->name ?? ''}}</td>
                    <td>{{$entry->memberDepositAccount->name ?? '' }}</td>
                    <td>{{$entry->memberLoanAccount->name ?? ''   }}</td>
                    <td>{{$entry->amount ?? '' }}</td>
                    <td>{{$entry->debit_amount ?? '' }}</td>
                    <td>{{$entry->credit_amount ?? '' }}</td>
                    <td>{{$entry->opening_balance ?? '' }}</td>
                    <td>{{$entry->current_balance ?? '' }}</td>
                    <td>{{$entry->transaction_mode ?? '' }}</td>
                    <td>{{$entry->payment_mode ?? '' }}</td>
                    <td>{{$entry->reference_no ?? '' }}</td>
                    <td>{{$entry->is_reversed ?? '' }}</td>
                    <td>{{$entry->approved_by ?? '' }}</td>
                    <td>{{$entry->entered_by ?? '' }}</td>
                    <td>{{$entry->branch->name ?? '' }}</td>
                    <td>{{$entry->from_date ?? '' }}</td>
                    <td>{{$entry->to_date  ?? ''}}</td>
                    <td>{{$entry->narration  ?? ''}}</td>
                    <td>{{$entry->m_narration ?? '' }}</td>
                    <td>{{$entry->status  }}</td>
                    <td>
                        <a href="#" data-id="{{$entry->id }}" data-transaction-type="{{$entry->transaction_type}}" data-voucher-num="{{$entry->voucher_num ?? ''}}" data-token-number="{{$entry->token_number ?? ''}}" data-serial-no="{{$entry->serial_no ?? ''}}" data-date="{{$entry->date ?? ''}}" data-receipt-id="{{$entry->receipt_id ?? ''}}" data-payment-id="{{$entry->payment_id ?? ''}}" data-ledger-id="{{$entry->ledger_id ?? ''}}" data-account-id="{{$entry->account_id ?? ''}}" data-member-depo-account-id="{{$entry->member_depo_account_id ?? ''}}" data-member-loan-account-id="{{$entry->member_loan_account_id ?? ''}}" data-from-date="{{$entry->from_date ?? ''}}" data-to-date="{{$entry->to_date ?? ''}}" data-opening-balance="{{$entry->opening_balance ?? ''}}" data-current-balance="{{$entry->current_balance ?? ''}}"  data-narration="{{$entry->narration ?? ''}}" data-m-narration="{{$entry->m_narration ?? ''}}" data-status="{{$entry->status}}" data-route="{{ route('voucher-entry.update', $entry->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#voucherEntryModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$entry->id }}" data-route="{{ route('voucher-entry.destroy', $entry->id) }}" data-name="{{$entry->id}}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('voucherEntryModal'));
            modal.show();
        });
    </script>
@endif
{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let transactionType = this.getAttribute("data-transaction-type");
            let voucherNum = this.getAttribute("data-voucher-num");
            let tokenNumber = this.getAttribute("data-token-number");
            let serialNo = this.getAttribute("data-serial-no");
            let date = this.getAttribute("data-date");
            let receiptId = this.getAttribute("data-receipt-id");
            let paymentId = this.getAttribute("data-payment-id");
            let ledgerId = this.getAttribute("data-ledger-id");
            let accountId = this.getAttribute("data-account-id");
            let memberDepoAccountId = this.getAttribute("data-member-depo-account-id");
            let memberLoanAccountId = this.getAttribute("data-member-loan-account-id");
            let fromDate = this.getAttribute("data-from-date");
            let toDate = this.getAttribute("data-to-date");
            let openingBalance = this.getAttribute("data-opening-balance");
            let currentBalance = this.getAttribute("data-current-balance");
            let narration = this.getAttribute("data-narration");
            let mNarration = this.getAttribute("data-m-narration");
            let status = this.getAttribute("data-status");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("voucherEntryModal");

            // Update modal title
            document.getElementById("voucherEntryModalLabel").textContent = "Edit Voucher Entry";

            // Populate form fields
            document.getElementById("voucherEntryId").value = id;
            document.getElementById("transactionType").value = transactionType;
            document.getElementById("voucherNum").value = voucherNum;
            document.getElementById("tokenNumber").value = tokenNumber;
            document.getElementById("serialNo").value = serialNo;
            document.getElementById("date").value = date;
            document.getElementById("receiptId").value = receiptId;
            document.getElementById("paymentId").value = paymentId;
            document.getElementById("ledgerId").value = ledgerId;
            document.getElementById("accountId").value = accountId;
            document.getElementById("memberDepoAccountId").value = memberDepoAccountId;
            document.getElementById("memberLoanAccountId").value = memberLoanAccountId;
            document.getElementById("fromDate").value = fromDate;
            document.getElementById("toDate").value = toDate;
            document.getElementById("openingBalance").value = openingBalance;
            document.getElementById("currentBalance").value = currentBalance;
            document.getElementById("narration").value = narration;
            document.getElementById("mNarration").value = mNarration;
            document.getElementById("status").value = status;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("voucherEntryModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#voucherEntryModal .btn-primary").textContent = "Update Voucher Entry";

            // Set the selected division
            let userSelect = document.getElementById("userId");
            
            if (userSelect) {
                userSelect.value = userId; // Pre-select the correct division
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
        document.querySelector("#voucherEntryModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
@endsection