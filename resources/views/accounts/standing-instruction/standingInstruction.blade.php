<div class="modal fade" id="standingInstructionModal" tabindex="-1" aria-labelledby="standingInstructionModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('standing-instructions.store') }}" id="standingInstructionForm"
                class="needs-validation" novalidate>
                <input type="hidden" id="standingInstructionId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="standingInstructionModalLabel"><i
                            class="bi bi-file-earmark-check me-2"></i>Add Standing Instruction</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    @if (Session::has('error'))
                    <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                    @endif
                    <div class="p-4 bg-white rounded shadow-sm">
                        {{-- Credit Ledger --}}
                        {{-- @isset($ledgers) --}}
                        @if ($ledgers->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select id="creditLedgerId" name="credit_ledger_id"
                                class="form-select @error('credit_ledger_id') is-invalid @enderror" required>
                                <option value="">Select Credit Ledger</option>
                                @foreach ($ledgers as $ledger)
                                <option value="{{ $ledger->id }}"
                                    {{ old('credit_ledger_id') == $ledger->id ? 'selected' : '' }}>{{ $ledger->name }}
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
                            <strong>⚠️ No general ledgers available.</strong><br>Please add general ledgers first.
                        </div>
                        @endisset

                        {{-- Credit Account --}}
                        {{-- @isset($accounts) --}}
                        @if ($accounts->isNotEmpty())
                        <div class="form-floating mb-3">
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
                        @endisset

                        {{-- Credit Transfer --}}
                        <div class="form-floating mb-3">
                            <input name="credit_transfer" id="creditTransfer" type="text"
                                class="form-control @error('credit_transfer') is-invalid @enderror"
                                placeholder="Credit Transfer" value="{{ old('credit_transfer') }}" required>
                            <label for="creditTransfer" class="form-label required">Credit Transfer</label>
                            @error('credit_transfer')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Debit Ledger --}}
                        {{-- @isset($ledgers) --}}
                        @if ($ledgers->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select id="debitLedgerId" name="debit_ledger_id"
                                class="form-select @error('debit_ledger_id') is-invalid @enderror" required>
                                <option value="">Select Debit Ledger</option>
                                @foreach ($ledgers as $ledger)
                                <option value="{{ $ledger->id }}"
                                    {{ old('debit_ledger_id') == $ledger->id ? 'selected' : '' }}>{{ $ledger->name }}
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
                        @endisset

                        {{-- Debit Account --}}
                        {{-- @isset($accounts) --}}
                        @if ($accounts->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select id="debitAccountId" name="debit_account_id"
                                class="form-select @error('debit_account_id') is-invalid @enderror" required>
                                <option value="">Select Debit Account</option>
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}"
                                    {{ old('debit_account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}
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
                        @endisset

                        {{-- Debit Transfer --}}
                        <div class="form-floating mb-3">
                            <input name="debit_transfer" id="debitTransfer" type="number"
                                class="form-control @error('debit_transfer') is-invalid @enderror"
                                placeholder="Debit Transfer" value="{{ old('debit_transfer') }}" required>
                            <label for="debitTransfer" class="form-label required">Debit Transfer</label>
                            @error('debit_transfer')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Date and Frequency --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="date" id="date" type="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date') }}" required>
                                    <label for="date" class="form-label required">Date</label>
                                    @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="frequency" name="frequency"
                                        class="form-select @error('frequency') is-invalid @enderror" required>
                                        <option value="">Select Frequency</option>
                                        <option value="Daily" {{ old('frequency') == 'Daily' ? 'selected' : '' }}>Daily
                                        </option>
                                        <option value="Weekly" {{ old('frequency') == 'Weekly' ? 'selected' : '' }}>
                                            Weekly</option>
                                        <option value="Monthly" {{ old('frequency') == 'Monthly' ? 'selected' : '' }}>
                                            Monthly</option>
                                        <option value="Other" {{ old('frequency') == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    <label for="frequency" class="form-label required">Frequency</label>
                                    @error('frequency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- No. of Times --}}
                        <div class="form-floating mb-3">
                            <input name="no_of_times" id="noOfTimes" type="number"
                                class="form-control @error('no_of_times') is-invalid @enderror"
                                placeholder="No. of Times" value="{{ old('no_of_times') }}" required>
                            <label for="noOfTimes" class="form-label required">No. of Times</label>
                            @error('no_of_times')
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