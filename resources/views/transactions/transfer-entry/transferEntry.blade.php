<div class="modal fade" id="transferEntryModal" tabindex="-1" aria-labelledby="transferEntryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('transfer-entry.store')}}" id="transferEntryModalForm">
                <input type="hidden" id="transferEntryId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="transferEntryModalLabel">Add Transfer Entry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="createdBy">Created By</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="" id="createdBy" class="w-100 px-2 py-1 @error('created_by') is-invalid @enderror" value="{{$user->name}}" type="text" readonly required>
                                <input name="created_by"class="w-100 px-2 py-1 @error('created_by') is-invalid @enderror" value="{{$user->id}}" type="text" hidden required>
                                @error('created_by')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        @if(Auth::user()->role === 'Admin')
                        <div class="row mb-2">
                             @isset($branches) 
                             <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="branchId">Branch</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                @if ($branches->isNotEmpty())
                                 <select name="branch_id" id="userId"  class="w-100 px-2 py-1 @error('branch_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>---------- Select ----------</option>
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
                        @endif
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
                        </div>
                        <div class="row mb-2">
                           <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="transactionType">Transaction Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="transactionType" name="transaction_type" class="w-100 px-2 py-1 @error('transaction_type') is-invalid @enderror" required>
                                    <option value="">---- Select Transaction Type ----</option>
                                    <option value="Credit" {{ old('transaction_type') == 'Credit' ? 'selected' : '' }}>Credit</option>
                                    <option value="Debit" {{ old('transaction_type') == 'Debit' ? 'selected' : '' }}>Debit</option>
                                    <option value="Journal" {{ old('transaction_type') == 'Journal' ? 'selected' : '' }}>Journal</option>
                                </select>
                                @error('transaction_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @isset($ledgers) 
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="ledgerId">Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                    @if ($ledgers->isNotEmpty())
                                    <select id="ledgerId" name="ledger_id" class="w-100 px-2 py-1 @error('ledger_id') is-invalid @enderror" required>
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
                                     @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No general ledgers available. Please add general ledgers first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add general ledgers before submitting the form.</small>
                                @endif
                                </div>
                            @endisset
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 d-none d-xl-block">
                                <label for="receiptId">Receipt</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input required name="receipt_id" id="receiptId" class="w-100 px-2 py-1 @error('receipt_id') is-invalid @enderror" value="{{ old('receipt_id') }}" type="text" placeholder="Receipt No.">
                                @error('receipt_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="paymentId">Payment</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                               <input required name="payment_id" id="paymentId" class="w-100 px-2 py-1 @error('payment_id') is-invalid @enderror" value="{{ old('payment_id') }}" type="text" placeholder="Payment No.">
                                @error('payment_id')
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