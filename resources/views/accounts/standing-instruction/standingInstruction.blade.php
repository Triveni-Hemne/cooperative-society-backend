<div class="modal fade" id="standingInstructionModal" tabindex="-1" aria-labelledby="standingInstructionModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('standing-instructions.store') }}" id="standingInstructionForm"
                class="needs-validation" novalidate>
                <input type="hidden" id="standingInstructionId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                @if (Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i
                            class="bi bi-file-earmark-check me-2"></i><span id="standingInstructionModalLabel">Add Standing Instruction</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="row g-3 mb-3">
                            <!-- Created By -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                   <input id="createdBy" class=" form-control @error('created_by') is-invalid @enderror" value="{{$user->name}}" type="text" readonly required>
                                <input name="created_by" id="createdBy" class="py-1 @error('created_by') is-invalid @enderror" value="{{$user->id}}" hidden type="text" readonly required>
                        <label for="createdBy" class="form-label">Created By</label>
                        @error('created_by')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

        @if(Auth::user()->role === 'Admin')
                @isset($branches)
                <div class="col-md-6">
                    @if ($branches->isNotEmpty())
                    <div class="form-floating">
                        <select name="branch_id" id="branchId"
                            class="form-select @error('branch_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Select Branch</option>
                            @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}</option>
                            @endforeach
                        </select>
                        <label for="branchId" class="form-label">Branch</label>
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
                </div>
                @endisset
        </div>
        @endif

        {{-- Credit Ledger --}}
        <div class="row mb-3">
            @isset($ledgers)
            <div class="col-md-6">
                @if ($ledgers->isNotEmpty())
                <div class="form-floating">
                    <select id="creditLedgerId" name="credit_ledger_id"
                        class="form-select @error('credit_ledger_id') is-invalid @enderror" required>
                        <option value="">Select Credit Ledger</option>
                        @foreach ($ledgers as $ledger)
                        <option value="{{ $ledger->id }}"
                            {{ old('credit_ledger_id') == $ledger->id ? 'selected' : '' }}>
                            {{ $ledger->name }}
                        </option>
                        @endforeach
                    </select>
                    <label for="creditLedgerId" class="form-label required">Credit Ledger</label>
                    @error('credit_ledger_id')
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

            {{-- Credit Account --}}
            @isset($accounts)
            <div class="col-md-6">
                @if ($accounts->isNotEmpty())
                <div class="form-floating">
                    <select id="creditAccountId" name="credit_account_id"
                        class="form-select @error('credit_account_id') is-invalid @enderror" required>
                        <option value="">Select Credit Account</option>
                        @foreach ($accounts as $account)
                        <option value="{{ $account->id }}"
                            {{ old('credit_account_id') == $account->id ? 'selected' : '' }}>
                            {{ $account->name }}</option>
                        @endforeach
                    </select>
                    <label for="creditAccountId" class="form-label required">Credit Account</label>
                    @error('credit_account_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @else
                <div class="alert alert-warning">
                    <strong>⚠️ No accounts available.</strong><br>Please add accounts first.
                </div>
                @endif
            </div>
            @endisset
        </div>

        <div class="row mb-3">
            {{-- Credit Transfer --}}
            <div class="col-md-6">
                <div class="form-floating">
                    <input name="credit_transfer" id="creditTransfer" type="text"
                        class="form-control @error('credit_transfer') is-invalid @enderror"
                        placeholder="Credit Transfer" value="{{ old('credit_transfer') }}" required>
                    <label for="creditTransfer" class="form-label required">Credit Transfer</label>
                    @error('credit_transfer')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Debit Ledger --}}
            @isset($ledgers)
            <div class="col-md-6">
                @if ($ledgers->isNotEmpty())
                <div class="form-floating">
                    <select id="debitLedgerId" name="debit_ledger_id"
                        class="form-select @error('debit_ledger_id') is-invalid @enderror">
                        <option value="">Select Debit Ledger</option>
                        @foreach ($ledgers as $ledger)
                        <option value="{{ $ledger->id }}" {{ old('debit_ledger_id') == $ledger->id ? 'selected' : '' }}>
                            {{ $ledger->name }}
                        </option>
                        @endforeach
                    </select>
                    <label for="debitLedgerId" class="form-label required">Debit Ledger</label>
                    @error('debit_ledger_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @else
                <div class="alert alert-warning">
                    <strong>⚠️ No debit ledgers available.</strong><br>Please add debit ledgers first.
                </div>
                @endif
            </div>
            @endisset
        </div>

        <div class="row mb-3">
            {{-- Debit Account --}}
            @isset($accounts)
            <div class="col-md-6">
                @if ($accounts->isNotEmpty())
                <div class="form-floating mb-3">
                    <select id="debitAccountId" name="debit_account_id"
                        class="form-select @error('debit_account_id') is-invalid @enderror">
                        <option value="">Select Debit Account</option>
                        @foreach ($accounts as $account)
                        <option value="{{ $account->id }}"
                            {{ old('debit_account_id') == $account->id ? 'selected' : '' }}>
                            {{ $account->name }}
                        </option>
                        @endforeach
                    </select>
                    <label for="debitAccountId" class="form-label required">Debit Account</label>
                    @error('debit_account_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @else
                <div class="alert alert-warning">
                    <strong>⚠️ No accounts available.</strong><br>Please add accounts first.
                </div>
                @endif
            </div>
            @endisset

            <div class="col-md-6">
                {{-- Debit Transfer --}}
                <div class="form-floating mb-3">
                    <input name="debit_transfer" id="debitTransfer" type="number"
                        class="form-control @error('debit_transfer') is-invalid @enderror" placeholder="Debit Transfer"
                        value="{{ old('debit_transfer') }}">
                    <label for="debitTransfer" class="form-label required">Debit Transfer</label>
                    @error('debit_transfer')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Date and Frequency --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input name="date" id="date" type="date" class="form-control @error('date') is-invalid @enderror"
                        value="{{ old('date') }}" required>
                    <label for="date" class="form-label required">Date</label>
                    @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select id="frequency" name="frequency" class="form-select @error('frequency') is-invalid @enderror"
                        required>
                        <option value="">Select Frequency</option>
                        <option value="Daily" {{ old('frequency') == 'Daily' ? 'selected' : '' }}>
                            Daily
                        </option>
                        <option value="Weekly" {{ old('frequency') == 'Weekly' ? 'selected' : '' }}>
                            Weekly</option>
                        <option value="Monthly" {{ old('frequency') == 'Monthly' ? 'selected' : '' }}>
                            Monthly</option>
                        <option value="Other" {{ old('frequency') == 'Other' ? 'selected' : '' }}>
                            Other
                        </option>
                    </select>
                    <label for="frequency" class="form-label required">Frequency</label>
                    @error('frequency')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            {{-- No. of Times --}}
            <div class="col-md-6">
                <div class="form-floating">
                    <input name="no_of_times" id="noOfTimes" type="number"
                        class="form-control @error('no_of_times') is-invalid @enderror" placeholder="No. of Times"
                        value="{{ old('no_of_times') }}" required>
                    <label for="noOfTimes" class="form-label required">No. of Times</label>
                    @error('no_of_times')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input name="bal_installment" id="balInstallment" type="number"
                        class="form-control @error('bal_installment') is-invalid @enderror"
                        placeholder="Balance Installment" value="{{ old('bal_installment') }}" required>
                    <label for="balInstallment" class="form-label required">Balance Installment</label>
                    @error('bal_installment')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            {{-- Execution Date --}}
            <div class="col-md-6">
                <div class="form-floating">
                    <input name="execution_date" id="executionDate" type="number"
                        class="form-control @error('execution_date') is-invalid @enderror" placeholder="Execution Date"
                        value="{{ old('execution_date') }}" required>
                    <label for="executionDate" class="form-label required">Execution Date</label>
                    @error('execution_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input name="amount" id="amount" type="number"
                        class="form-control @error('amount') is-invalid @enderror" placeholder="Amount"
                        value="{{ old('amount') }}" required>
                    <label for="amount" class="form-label required">Amount</label>
                    @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
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