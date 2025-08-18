<div class="modal fade" id="voucherEntryModal" tabindex="-1" aria-labelledby="voucherEntryModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('voucher-entry.store') }}" id="voucherEntryModalForm"
                class="needs-validation" novalidate>
                <input type="hidden" id="voucherEntryId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" ><i class="bi bi-receipt-fill me-2"></i>
                        <span id="voucherEntryModalLabel">Add Voucher Entry</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                                       
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="row mb-3">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="transaction_type" id="transactionType"
                                        class="form-select @error('transaction_type') is-invalid @enderror" required>
                                        <option value="" disabled {{old('transaction_type') ? '' : 'selected'}}>Select Transaction Type</option>
                                        @foreach(['Receipt', 'Payment'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('transaction_type') == $type ? 'selected' : '' }}>{{ $type }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="transactionType" class="form-label">Transaction Type <span class="text-danger">*</span></label>
                                    @error('transaction_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="date" id="date" type="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date', \Carbon\Carbon::today()->format('Y-m-d')) }}" placeholder="Date">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="receipt_id" id="receiptId" type="text"
                                        class="form-control @error('receipt_id') is-invalid @enderror"
                                        value="{{ old('receipt_id') }}" placeholder="Receipt No.">
                                    <label for="receiptId">Receipt No. </label>
                                    @error('receipt_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="payment_id" id="paymentId" type="text"
                                        class="form-control @error('payment_id') is-invalid @enderror"
                                        value="{{ old('payment_id') }}" placeholder="Payment No.">
                                    <label for="paymentId">Payment No.</label>
                                    @error('payment_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @isset($ledgers)
                            <div class="col-md-3 mb-3">
                                @if ($ledgers->isNotEmpty())
                                <div class="form-floating">
                                    <select id="ledgerId" name="ledger_id" required
                                        class="form-select @error('ledger_id') is-invalid @enderror">
                                        <option value="" disabled {{old('ledger_id') ? '' : 'selected'}}>Select Ledger</option>
                                        @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"
                                            {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}>
                                            {{ $ledger->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="ledgerId">Ledger <span class="text-danger">*</span></label>
                                    @error('ledger_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No general ledgers available.</strong><br>
                                    Please add general ledgers first.
                                </div>
                                @endif
                            </div>
                            @endisset

                            @isset($members)
                            <div class="col-md-3 mb-3 d-none" id="selectMember">
                                @if ($members->isNotEmpty())
                                <div class="form-floating">
                                    <select id="memberId" name="member_id"
                                        class="form-select @error('member_id') is-invalid @enderror"
                                        aria-label="Member">
                                        <option value="" {{ old('member_id') ? '' : 'selected' }}>--- Select Member ---</option>
                                        @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} [ID: {{ $member->id }}]
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="memberId" class="form-label">Member</label>
                                    @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No members available.</strong><br>
                                    Please add members first.
                                </div>
                                @endif
                            </div>
                            @endisset

                            @isset($depoAccounts)
                            <div class="col-md-3 mb-3 accountField d-none" >
                                @if ($depoAccounts->isNotEmpty())
                                <div class="form-floating">
                                    <select id="memberDepoAccountId" name="member_depo_account_id"
                                        class="form-select @error('member_depo_account_id') is-invalid @enderror">
                                        <option value=""  {{old('member_depo_account_id') ? '' : 'selected'}}>Select</option>
                                        @foreach ($depoAccounts as $depoAccount)
                                        <option value="{{ $depoAccount->id }}"
                                            {{ old('member_depo_account_id') == $depoAccount->id ? 'selected' : '' }}>
                                            {{ $depoAccount->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="memberDepoAccountId">Member Deposit Acc.</label>
                                    @error('member_depo_account_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No deposit accounts available.</strong><br>
                                    Please add deposit accounts first.
                                </div>
                                @endif
                            </div>
                            @endisset

                            @isset($loanAccounts)
                            <div class="col-md-3 accountField d-none">
                                @if ($loanAccounts->isNotEmpty())
                                <div class="form-floating">
                                    <select id="memberLoanAccountId" name="member_loan_account_id"
                                        class="form-select @error('member_loan_account_id') is-invalid @enderror">
                                        <option  {{old('member_loan_account_id') ? '' : 'selected'}}>Select</option>
                                        @foreach ($loanAccounts as $loanAccount)
                                        <option value="{{ $loanAccount->id }}"
                                            {{ old('member_loan_account_id') == $loanAccount->id ? 'selected' : '' }}>
                                            {{ $loanAccount->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="memberLoanAccountId">Member Loan Account</label>
                                    @error('member_loan_account_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning ">
                                    <strong>⚠️ No loan accounts available.</strong><br>
                                    Please add loan accounts first.
                                </div>
                                @endif
                            </div>
                            @endisset

                            @isset($accounts)
                            <div class="col-md-3 mb-3 accountField d-none">
                                @if ($accounts->isNotEmpty())
                                <div class="form-floating">
                                    <select id="accountId" name="account_id"
                                        class="form-select @error('account_id') is-invalid @enderror">
                                        <option value="" {{old('account_id') ? '' : 'selected'}}>Select</option>
                                        @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="accountId">General Account</label>
                                    @error('account_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No general accounts available.</strong><br>
                                    Please add general accounts first.
                                </div>
                                @endif
                            </div>
                            @endisset
                        </div>
                        
                        <div id="loadingSpinner" class="text-center my-3 d-none">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>

                        <fieldset class=" row commonFields d-none border p-3 mb-3 rounded position-relative">
                        <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Cash In Hand</legend>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="opening_balance" id="openingBalance" type="number" step="0.01"
                                        class="form-control @error('opening_balance') is-invalid @enderror"
                                        value="{{ old('opening_balance') }}" placeholder="Opening Balance" required>
                                    <label for="openingBalance">Opening Balance</label>
                                    @error('opening_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="current_balance" id="currentBalance" type="number" step="0.01"
                                        class="form-control @error('current_balance') is-invalid @enderror"
                                        value="{{ old('current_balance') }}" placeholder="Current Balance" required>
                                    <label for="currentBalance">Current Balance</label>
                                    @error('current_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        </fieldset>

                        <fieldset id="depositAccountFieldGroup" class="border row p-3 mb-3 rounded position-relative d-none account-details">
                        <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Deposit</legend>
                        </fieldset>

                        <fieldset id="loanAccountFieldGroup" class="border row p-3 mb-3 rounded position-relative d-none account-details">
                        <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Loan</legend>
                        </fieldset>

                        <fieldset id="generalAccountFieldGroup" class="border row d-none  p-3 mb-3 rounded position-relative account-details">
                        <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">General</legend>
                        </fieldset>

                        <fieldset id="bankAccountFieldGroup" class="border row d-none  p-3 mb-3 rounded position-relative account-details">
                        <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Bank</legend>
                        </fieldset>

                        <fieldset id="fundsAccountFieldGroup" class="border row d-none  p-3 mb-3 rounded position-relative account-details">
                        <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Funds</legend>
                        </fieldset>

                        <fieldset id="shareAccountFieldGroup" class="border row d-none  p-3 mb-3 rounded position-relative account-details">
                        <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Share</legend>
                        </fieldset>

                        {{-- <div class="row"> --}}
                            {{-- <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="voucher_num" id="voucherNum" type="text"
                                        class="form-control @error('voucher_num') is-invalid @enderror"
                                        placeholder="Voucher No." value="{{ old('voucher_num') }}">
                                    <label for="voucherNum">Voucher No.</label>
                                    @error('voucher_num')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
{{-- 
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="token_number" id="tokenNumber" type="text"
                                        class="form-control @error('token_number') is-invalid @enderror"
                                        placeholder="Token No." value="{{ old('token_number') }}">
                                    <label for="tokenNumber">Token No.</label>
                                    @error('token_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="serial_no" id="serialNo" type="text"
                                        class="form-control @error('serial_no') is-invalid @enderror"
                                        placeholder="Serial No." value="{{ old('serial_no') }}">
                                    <label for="serialNo">Serial No.</label>
                                    @error('serial_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            
                            {{-- <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="debit_amount" id="debitAmount" type="number" step="0.01"
                                        class="form-control @error('debit_amount') is-invalid @enderror"
                                        value="{{ old('debit_amount') }}" placeholder="Debit Amount">
                                    <label for="debitAmount">Debit Amount</label>
                                    @error('debit_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="credit_amount" id="creditAmount" type="number" step="0.01"
                                        class="form-control @error('credit_amount') is-invalid @enderror"
                                        value="{{ old('credit_amount') }}" placeholder="Credit Amount">
                                    <label for="creditAmount">Credit Amount</label>
                                    @error('credit_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}


                        {{-- <div class="row mb-3">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                        <option value="" disabled {{old('status') ? '' : 'selected'}}>Select Status</option>
                                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>
                                            Approved
                                        </option>
                                        <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                    </select>
                                    <label for="status">Status</label>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-3 ">
                                <div class="form-floating">
                                    <select id="transactionMode" name="transaction_mode"
                                        class="form-select @error('transaction_mode') is-invalid @enderror">
                                        <option value="" disabled {{old('transaction_mode') ? '' : 'selected'}}>Select Transaction Mode</option>
                                        <option value="Cash" {{ old('transaction_mode') == 'Cash' ? 'selected' : '' }}>
                                            Cash
                                        </option>
                                        <option value="Bank" {{ old('transaction_mode') == 'Bank' ? 'selected' : '' }}>
                                            Bank
                                        </option>
                                        <option value="Online"
                                            {{ old('transaction_mode') == 'Online' ? 'selected' : '' }}>
                                            Online
                                        </option>
                                        <option value="Cheque"
                                            {{ old('transaction_mode') == 'Cheque' ? 'selected' : '' }}>
                                            Cheque
                                        </option>
                                    </select>
                                    <label for="transactionMode">Transaction Mode</label>
                                    @error('transaction_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        {{-- </div> --}}

                            {{-- <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select id="paymentMode" name="payment_mode"
                                        class="form-select @error('payment_mode') is-invalid @enderror">
                                        <option value="" disabled {{old('payment_mode') ? '' : 'selected'}}>Select Payment Mode</option>
                                        <option value="NEFT" {{ old('payment_mode') == 'NEFT' ? 'selected' : '' }}>NEFT
                                        </option>
                                        <option value="IMPS" {{ old('payment_mode') == 'IMPS' ? 'selected' : '' }}>IMPS
                                        </option>
                                        <option value="UPI" {{ old('payment_mode') == 'UPI' ? 'selected' : '' }}>UPI
                                        </option>
                                        <option value="RTGS" {{ old('payment_mode') == 'RTGS' ? 'selected' : '' }}>RTGS
                                        </option>
                                        <option value="Cheque" {{ old('payment_mode') == 'Cheque' ? 'selected' : '' }}>
                                            Cheque
                                        </option>
                                        <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="Bank Transfer"
                                            {{ old('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>Bank
                                            Transfer
                                        </option>
                                    </select>
                                    <label for="paymentMode">Payment Mode</label>
                                    @error('payment_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="reference_number" id="referenceNo" type="text"
                                        class="form-control @error('reference_number') is-invalid @enderror"
                                        value="{{ old('reference_number') }}" placeholder="Reference Number">
                                    <label for="referenceNo">Reference Number</label>
                                    @error('reference_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        {{-- </div> --}}

                            {{-- <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select id="isReversed" name="is_reversed"
                                        class="form-select @error('is_reversed') is-invalid @enderror">
                                        <option value="0" {{ old('is_reversed') == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('is_reversed') == '1' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    <label for="isReversed">Reserved</label>
                                    @error('is_reversed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="row">
                            @isset($users)
                            <div class="col-md-3">
                                @if ($users->isNotEmpty())
                                <div class="form-floating">
                                    <select id="approvedBy" name="approved_by"
                                        class="form-select @error('approved_by') is-invalid @enderror">
                                        <option value="" disabled {{old('approved_by') ? '' : 'selected'}}>Select Approved By</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('approved_by') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="approvedBy">Approved By</label>
                                    @error('approved_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No users available.</strong><br>
                                    Please add users first.
                                </div>
                                @endif
                            </div>
                            @endisset

                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                     <input id="enteredBy" name="" class="form-control" value="{{Auth::user()->name}}" readonly required>
                                     <label for="enteredBy">Entered By</label>
                                     <input id="enteredById" hidden name="entered_by" value="{{Auth::user()->id}}" class="form-control"  required>
                                    @error('entered_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if(Auth::user()->role === 'Admin')
                            @isset($branches)
                            <div class="col-md-3">
                                @if ($branches->isNotEmpty())
                                <div class="form-floating">
                                    <select id="branchId" name="branch_id"
                                        class="form-select @error('branch_id') is-invalid @enderror">
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="branchId">Branch <span class="text-danger">*</span></label>
                                    @error('branch_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No branches available.</strong><br>
                                    Please add branches first.
                                </div>
                                @endif
                            </div>
                            @endisset
                            @endif

                            {{-- <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="from_date" id="fromDate" type="date"
                                        class="form-control @error('from_date') is-invalid @enderror"
                                        value="{{ old('from_date') }}" placeholder="From Date" required>
                                    <label for="fromDate">From Date</label>
                                    @error('from_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="to_date" id="toDate" type="date"
                                        class="form-control @error('to_date') is-invalid @enderror"
                                        value="{{ old('to_date') }}" placeholder="To Date">
                                    <label for="toDate">To Date</label>
                                    @error('to_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                    </div>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating mb-3">
                            <textarea name="narration" id="narration"
                                class="form-control @error('narration') is-invalid @enderror"
                                placeholder="Narration">{{ old('narration') }}</textarea>
                            <label for="narration">Narration</label>
                            @error('narration')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating mb-3">
                            <textarea name="m_narration" id="mNarration"
                                class="form-control @error('m_narration') is-invalid @enderror"
                                placeholder="M-Narration">{{ old('m_narration') }}</textarea>
                            <label for="mNarration">M-Narration</label>
                            @error('m_narration')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                </div>

                <div class="modal-footer bg-white rounded-bottom-4 border-top">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i>Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    