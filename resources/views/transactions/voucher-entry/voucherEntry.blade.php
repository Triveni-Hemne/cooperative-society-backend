<div class="modal fade" id="voucherEntryModal" tabindex="-1" aria-labelledby="voucherEntryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('voucher-entry.store')}}" id="voucherEntryModalForm">
                <input type="hidden" id="voucherEntryId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="voucherEntryModalLabel">Add Voucher Entry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            <div class="col-2">
                                 <label for="transaction_type" class="form-label">Transaction Type</label>
                            </div>
                             <div class="col">
                                 <select name="transaction_type" id="transaction_type" class="w-100 px-2 py-1 @error('transaction_type') is-invalid @enderror" required>
                                    <option value="" {{old('transaction_type') ? '' : 'selected'}}>--Select Transaction Type--</option>
                                    @foreach(['Receipt', 'Payment', 'Journal', 'Deposit', 'Withdrawal', 'Loan Payment', 'Fund Transfer'] as $type)
                                        <option value="{{ $type }}" {{ old('transaction_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                  @error('transaction_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        @isset($depoAccounts) 
                        <div class="col-2 ps-5 d-none d-xl-block">
                            <label for="memberDepoAccountId">Member Deposit Acc.</label>
                        </div>
                        <div class="col pe-0 pe-xl-5">
                                @if ($depoAccounts->isNotEmpty())
                                <select id="memberDepoAccountId" name="member_depo_account_id" class="w-100 px-2 py-1 @error('member_depo_account_id') is-invalid @enderror">
                                    <option value="" {{old('member_depo_account_id') ? '' : 'selected'}}>------ Select Depo Account ------</option>
                                    @foreach ($depoAccounts as $depoAccount)
                                        <option value="{{ $depoAccount->id }}"  
                                        {{ old('member_depo_account_id') == $depoAccount->id ? 'selected' : '' }}
                                        >
                                        {{ $depoAccount->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_depo_account_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No deposit accounts available. Please add deposit accounts first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add deposit accounts before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        <div class="row mb-2">
                        @isset($loanAccounts) 
                        <div class="col-2 d-none d-xl-block">
                            <label for="memberLoanAccountId">Member Loan Account</label>
                        </div>
                        <div class="col-4 pe-0 pe-xl-5">
                                @if ($loanAccounts->isNotEmpty())
                                <select id="memberLoanAccountId" name="member_loan_account_id" class="w-100 px-2 py-1 @error('member_loan_account_id') is-invalid @enderror">
                                    <option value="" {{old('member_loan_account_id') ? '' : 'selected'}}>------ Select Account ------</option>
                                    @foreach ($loanAccounts as $loanAccount)
                                        <option value="{{ $loanAccount->id }}"  
                                        {{ old('member_loan_account_id') == $loanAccount->id ? 'selected' : '' }}
                                        >
                                        {{ $loanAccount->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_loan_account_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No loan accounts available. Please add loan accounts first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add loan accounts before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>
                        </div>

                        <div class="row mb-2">
                        @isset($ledgers) 
                        <div class="col-2 ps-5 d-none d-xl-block">
                            <label for="ledgerId">Ledger</label>
                        </div>
                        <div class="col pe-0 pe-xl-5">
                                @if ($ledgers->isNotEmpty())
                                <select id="ledgerId" name="ledger_id" class="w-100 px-2 py-1 @error('ledger_id') is-invalid @enderror" required>
                                    <option value="" {{old('ledger_id') ? '' : 'selected'}}>------ Select Ledger ------</option>
                                    @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"  
                                        {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}
                                        >
                                        {{ $ledger->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ledger_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No general ledgers available. Please add general ledgers first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add general ledgers before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        @isset($accounts) 
                        <div class="col-2 d-none d-xl-block">
                            <label for="accountId">General Account</label>
                        </div>
                        <div class="col-4 pe-0 pe-xl-5">
                                @if ($accounts->isNotEmpty())
                                <select id="accountId" name="account_id" class="w-100 px-2 py-1 @error('account_id') is-invalid @enderror">
                                    <option value="" {{old('account_id') ? '' : 'selected'}}>------ Select Account ------</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"  
                                        {{ old('account_id') == $account->id ? 'selected' : '' }}
                                        >
                                        {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('account_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                 @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No general accounts available. Please add general accounts first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add general accounts before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 d-none d-xl-block">
                                <label for="voucherNum">Voucher No.</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="voucher_num" id="voucherNum" class="w-100 px-2 py-1 @error('voucher_num') is-invalid @enderror" value="{{ old('voucher_num') }}" type="text" placeholder="Voucher No.">
                                 @error('voucher_num')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="tokenNumber">Token No.</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="token_number" id="tokenNumber" class="w-100 px-2 py-1 @error('token_number') is-invalid @enderror" value="{{ old('token_number') }}" type="text" placeholder="Token No.">
                                @error('token_number')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="serialNo">Serial No.</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="serial_no" id="serialNo" class="w-100 px-2 py-1 @error('serial_no') is-invalid @enderror" value="{{ old('serial_no') }}" type="text" placeholder="Serial No.">
                                @error('serial_no')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="date">Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="date" id="date" class="w-100 px-2 py-1 @error('date') is-invalid @enderror" value="{{ old('date') }}" type="date" placeholder="Date" required>
                                @error('date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="col-2 d-none d-xl-block">
                                <label for="receiptId">Receipt</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="receipt_id" id="receiptId" class="w-100 px-2 py-1 @error('receipt_id') is-invalid @enderror" value="{{ old('receipt_id') }}" type="text" placeholder="Receipt No.">
                                @error('receipt_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="amount">Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="amount" id="amount" class="w-100 px-2 py-1 @error('amount') is-invalid @enderror" value="{{ old('amount') }}" type="number" placeholder="Amount" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="col-2 d-none d-xl-block">
                                <label for="debitAmount">Debit Amount</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="debit_amount" id="debitAmount" class="w-100 px-2 py-1 @error('debit_amount') is-invalid @enderror" value="{{ old('debit_amount') }}" type="number" placeholder="Debit Amount">
                                @error('debit_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                         <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="creditAmount">Credit Amount</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="credit_amount" id="creditAmount" class="w-100 px-2 py-1 @error('credit_amount') is-invalid @enderror" value="{{ old('credit_amount') }}" type="number" placeholder="Credit Amount">
                                @error('credit_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="paymentId">Payment</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                               <input name="payment_id" id="paymentId" class="w-100 px-2 py-1 @error('payment_id') is-invalid @enderror" value="{{ old('payment_id') }}" type="text" placeholder="Payment No.">
                                @error('payment_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="status">Status</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="status" name="status" class="w-100 px-2 py-1 @error('status') is-invalid @enderror">
                                    <option value="" disabled {{old('status') ? '' : 'selected'}}>---- Select Status ----</option>
                                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 d-none d-xl-block">
                                <label for="transactionMode">Transaction Mode</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="transactionMode" name="transaction_mode" class="w-100 px-2 py-1 @error('transaction_mode') is-invalid @enderror">
                                    <option value="" disabled {{old('transaction_mode') ? '' : 'selected'}}>---- Select Transaction Mode ----</option>
                                    <option value="Cash" {{ old('transaction_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Bank" {{ old('transaction_mode') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                    <option value="Online" {{ old('transaction_mode') == 'Online' ? 'selected' : '' }}>Online</option>
                                    <option value="Cheque" {{ old('transaction_mode') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                                @error('transaction_mode')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                             <div class="col-2 d-none d-xl-block">
                                <label for="paymentMode">Payment Mode</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="paymentMode" name="payment_mode" class="w-100 px-2 py-1 @error('payment_mode') is-invalid @enderror">
                                    <option value="" disabled {{old('payment_mode') ? '' : 'selected'}}>---- Select Payment Mode ----</option>
                                    <option value="NEFT" {{ old('payment_mode') == 'NEFT' ? 'selected' : '' }}>NEFT</option>
                                    <option value="IMPS" {{ old('payment_mode') == 'IMPS' ? 'selected' : '' }}>IMPS</option>
                                    <option value="UPI" {{ old('payment_mode') == 'UPI' ? 'selected' : '' }}>UPI</option>
                                    <option value="RTGS" {{ old('payment_mode') == 'RTGS' ? 'selected' : '' }}>RTGS</option>
                                    <option value="Cheque" {{ old('payment_mode') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Bank Transfer" {{ old('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('payment_mode')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="referenceNumber">Reference Number</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="reference_number" id="referenceNumber" class="w-100 px-2 py-1 @error('reference_number') is-invalid @enderror" value="{{ old('reference_number') }}" type="date" placeholder="Reference Number">
                                @error('reference_number')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="isReversed">Reserved</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="isReversed" name="is_reversed" class="w-100 px-2 py-1 @error('is_reversed') is-invalid @enderror">
                                    <option value="0" {{ old('is_reversed') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_reversed') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('is_reversed')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                        @isset($users) 
                        <div class="col-2 d-none d-xl-block">
                            <label for="approvedBy">Approved By</label>
                        </div>
                        <div class="col pe-0 pe-xl-5">
                                @if ($users->isNotEmpty())
                                <select id="approvedBy" name="approved_by" class="w-100 px-2 py-1 @error('approved_by') is-invalid @enderror">
                                    <option value="" {{old('approved_by') ? '' : 'selected'}}>-----Select Approved By-----</option>
                                   @foreach ($users as $usr)
                                        <option value="{{ $usr->id }}"  
                                        {{ old('approved_by') == $usr->id ? 'selected' : '' }}
                                        >
                                        {{ $usr->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('approved_by')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                               @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No users available. Please add users first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add users before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        
                        <div class="col-2 d-none d-xl-block">
                            <label for="enteredBy">Entered By</label>
                        </div>
                        <div class="col pe-0 pe-xl-5">
                                <input id="enteredBy" name="" class="w-100 px-2 py-1" value="{{$user->name}}"  required>
                                <input id="enteredBy" hidden name="entered_by" value="{{$user->id}}" class="w-100 px-2 py-1"  required>
                                @error('entered_by')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                        @isset($branches) 
                        <div class="col-2 d-none d-xl-block">
                            <label for="branchId">Branch</label>
                        </div>
                        <div class="col pe-0 pe-xl-5">
                                @if ($branches->isNotEmpty())
                                <select id="branchId" name="branch_id" class="w-100 px-2 py-1 @error('branch_id') is-invalid @enderror" required>
                                    <option value="" {{old('branch_id') ? '' : 'selected'}}>-----Select Branch-----</option>
                                   @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"  
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                        >
                                        {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                 @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No branches available. Please add branches first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add branches before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="fromDate">From Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="from_date" id="fromDate" class="w-100 px-2 py-1 @error('from_date') is-invalid @enderror" value="{{ old('from_date') }}" type="date" placeholder="From Date">
                                @error('from_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="toDate">To Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="to_date" id="toDate" class="w-100 px-2 py-1 @error('to_date') is-invalid @enderror" value="{{ old('to_date') }}" type="date" placeholder="To Date">
                                @error('to_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="openingBalance">Opening Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="opening_balance" id="openingBalance" class="w-100 px-2 py-1 @error('opening_balance') is-invalid @enderror" value="{{ old('opening_balance') }}" type="number"
                                    placeholder="Opening Balance" required>
                                    @error('opening_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="currentBalance">Current Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="current_balance" id="currentBalance" class="w-100 px-2 py-1 @error('current_balance') is-invalid @enderror" value="{{ old('current_balance') }}" type="number"
                                    placeholder="Current Balance" required>
                                    @error('current_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="narration">Narration</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="narration" id="narration" class="w-100 px-2 py-1 @error('narration') is-invalid @enderror" value="{{ old('narration') }}" type="text" placeholder="Narration">
                                @error('narration')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="mNarration">M-Narration</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="m_narration" id="mNarration" class="w-100 px-2 py-1 @error('m_narration') is-invalid @enderror" value="{{ old('m_narration') }}" type="text" placeholder="M-Narration">
                                @error('m_narration')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>