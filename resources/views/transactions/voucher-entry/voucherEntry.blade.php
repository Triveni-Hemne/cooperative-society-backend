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
                        @isset($depoAccounts) 
                        @if ($depoAccounts->isNotEmpty())
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="memberDepoAccountId">Member Deposit Acc.</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="memberDepoAccountId" name="member_depo_account_id" class="w-100 px-2 py-1 @error('member_depo_account_id') is-invalid @enderror">
                                    <option value="">------ Select Depo Account ------</option>
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
                            </div>
                            @endif
                        @endisset
                        @isset($loanAccounts) 
                        @if ($loanAccounts->isNotEmpty())
                            <div class="col-2 d-none d-xl-block">
                                <label for="memberLoanAccountId">Member Loan Account</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="memberLoanAccountId" name="member_loan_account_id" class="w-100 px-2 py-1 @error('member_loan_account_id') is-invalid @enderror">
                                    <option value="">------ Select Account ------</option>
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
                            </div>
                            @endif
                        @endisset
                        </div>

                        <div class="row mb-2">
                        @isset($ledgers) 
                        @if ($ledgers->isNotEmpty())
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="ledgerId">Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="ledgerId" name="ledger_id" class="w-100 px-2 py-1 @error('ledger_id') is-invalid @enderror">
                                    <option value="">------ Select Ledger ------</option>
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
                            </div>
                            @endif
                        @endisset
                        @isset($accounts) 
                        @if ($accounts->isNotEmpty())
                            <div class="col-2 d-none d-xl-block">
                                <label for="accountId">General Account</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="accountId" name="account_id" class="w-100 px-2 py-1 @error('account_id') is-invalid @enderror">
                                    <option value="">------ Select Account ------</option>
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
                            </div>
                            @endif
                        @endisset
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="transactionType">Transaction Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="transactionType" name="transaction_type" class="w-100 px-2 py-1 @error('transaction_type') is-invalid @enderror">
                                    <option value="">---- Select Transaction Type ----</option>
                                    <option value="Receipt" {{ old('transaction_type') == 'Receipt' ? 'selected' : '' }}>Receipt</option>
                                    <option value="Payment" {{ old('transaction_type') == 'Payment' ? 'selected' : '' }}>Payment</option>
                                    <option value="Journal" {{ old('transaction_type') == 'Journal' ? 'selected' : '' }}>Journal</option>
                                    <option value="Deposit" {{ old('transaction_type') == 'Deposit' ? 'selected' : '' }}>Deposit</option>
                                    <option value="Withdrawal" {{ old('transaction_type') == 'Withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                                    <option value="Loan Payment" {{ old('transaction_type') == 'Loan Payment' ? 'selected' : '' }}>Loan Payment</option>
                                    <option value="Fund Transfer" {{ old('transaction_type') == 'Fund Transfer' ? 'selected' : '' }}>Fund Transfer</option>
                                </select>
                                @error('transaction_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
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
                                <input name="date" id="date" class="w-100 px-2 py-1 @error('date') is-invalid @enderror" value="{{ old('date') }}" type="date" placeholder="Date">
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
                                    <option value="" disabled>---- Select Status ----</option>
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
                                    placeholder="Opening Balance">
                                    @error('opening_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="currentBalance">Current Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="current_balance" id="currentBalance" class="w-100 px-2 py-1 @error('current_balance') is-invalid @enderror" value="{{ old('current_balance') }}" type="number"
                                    placeholder="Current Balance">
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