<div class="modal fade" id="transferEntryModal" tabindex="-1" aria-labelledby="transferEntryModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{route('transfer-entry.store')}}" id="transferEntryModalForm"
                class="needs-validation" novalidate>
                <input type="hidden" id="transferEntryId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                 @csrf
                        @if(Session::has('error'))
                        <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                        @endif
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" ><span id="transferEntryModalLabel">Add Transfer Entry</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        {{-- Created By --}}
                       <div class="form-floating mb-3">
                                <input id="createdBy" class="form-control" value="{{ $user->name }}" type="text"
                                       readonly required>
                                <label for="createdBy" class="form-label">Created By</label>
                                <input name="created_by" class="form-control" value="{{ $user->id }}" type="text"
                                       hidden required>
                                @error('created_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                       </div>

                        <div class="row g-3 mb-3">
                        @if(Auth::user()->role === 'Admin')
                             @isset($branches) 
                            <div class="col-md-6">
                                {{-- Branch --}}
                                @if ($branches->isNotEmpty())
                                <div class="form-floating">
                                    <select name="branch_id" id="branchId"
                                        class="form-select @error('branch_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"  
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                        >
                                        {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="branchId">Branch</label>
                                @error('branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @else
                            <div class="alert alert-warning">
                                <strong>⚠️ No Branch available.</strong><br>
                                Please add Branch first.
                            </div>
                            @endif
                            @endisset
                            @endif
                        </div>
                        <div class="col-md-6">
                            {{-- Date --}}
                            <div class="form-floating">
                                <input name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                                    value="{{ old('date') }}" type="date" placeholder="Date" required>
                                <label for="date" class="form-label required">Date</label>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                   

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            {{-- Transaction Type --}}
                            <div class="form-floating">
                                <select id="transactionType" name="transaction_type"
                                    class="form-select @error('transaction_type') is-invalid @enderror">
                                    <option value="">---- Select Transaction Type ----</option>
                                    <option value="Credit" {{ old('transaction_type') == 'Credit' ? 'selected' : '' }}>
                                        Credit</option>
                                    <option value="Debit" {{ old('transaction_type') == 'Debit' ? 'selected' : '' }}>
                                        Debit
                                    </option>
                                    <option value="Journal"
                                        {{ old('transaction_type') == 'Journal' ? 'selected' : '' }}>
                                        Journal</option>
                                </select>
                                <label for="transactionType" class="form-label required">Transaction Type</label>
                                @error('transaction_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Ledger --}}
                            @isset($ledgers)
                            @if ($ledgers->isNotEmpty())
                            <div class="form-floating">
                                <select id="ledgerId" name="ledger_id"
                                    class="form-select @error('ledger_id') is-invalid @enderror" required>
                                    <option value="">---- Select Ledger ----</option>
                                    @foreach ($ledgers as $ledger)
                                    <option value="{{ $ledger->id }}"
                                        {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}>{{ $ledger->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <label for="ledgerId" class="form-label required">Ledger</label>
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
                            @endisset
                        </div>
                    </div>

                    {{-- Receipt No. --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input name="receipt_id" id="receiptId"
                                    class="form-control @error('receipt_id') is-invalid @enderror"
                                    value="{{ old('receipt_id') }}" type="text" placeholder="Receipt No.">
                                <label for="receiptId">Receipt</label>
                                @error('receipt_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Payment No. --}}
                            <div class="form-floating">
                                <input name="payment_id" id="paymentId"
                                    class="form-control @error('payment_id') is-invalid @enderror"
                                    value="{{ old('payment_id') }}" type="text" placeholder="Payment No.">
                                <label for="paymentId">Payment</label>
                                @error('payment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Opening Balance --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input name="opening_balance" id="openingBalance"
                                    class="form-control @error('opening_balance') is-invalid @enderror"
                                    value="{{ old('opening_balance') }}" type="number" placeholder="Opening Balance" required>
                                <label for="openingBalance">Opening Balance</label>
                                @error('opening_balance')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Current Balance --}}
                            <div class="form-floating">
                                <input name="current_balance" id="currentBalance"
                                    class="form-control @error('current_balance') is-invalid @enderror"
                                    value="{{ old('current_balance') }}" type="number" placeholder="Current Balance" required>
                                <label for="currentBalance">Current Balance</label>
                                @error('current_balance')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            {{-- Narration --}}
                            <div class="form-floating">
                                <input name="narration" id="narration"
                                    class="form-control @error('narration') is-invalid @enderror"
                                    value="{{ old('narration') }}" type="text" placeholder="Narration">
                                <label for="narration">Narration</label>
                                @error('narration')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- M-Narration --}}
                            <div class="form-floating">
                                <input name="m_narration" id="m_narration"
                                    class="form-control @error('m_narration') is-invalid @enderror"
                                    value="{{ old('m_narration') }}" type="text" placeholder="M-Narration">
                                <label for="m_narration">M-Narration</label>
                                @error('m_narration')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div> </div>
                
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
</div>
</div>