 <div class="modal fade" id="loanInstallmentModal" tabindex="-1" aria-labelledby="loanInstallmentModalLabel"
     aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                <h1 class="modal-title fs-5" id="loanInstallmentModalLabel">Loan Installment</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('loan-installments.store') }}" id="loanInstallmentModalForm">
                @csrf
                <input type="hidden" id="loanInstallmentId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
               
                <div class="modal-body p-4">
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    <div class="mb-3">
                        @isset($loanAccounts)
                            <div class="form-floating">
                                <select id="loanId" name="loan_id"
                                        class="form-select @error('loan_id') is-invalid @enderror" required>
                                    <option value="" {{ old('loan_id') ? '' : 'selected' }}>
                                        --- Select Loan Account ---
                                    </option>
                                    @if ($loanAccounts->isNotEmpty())
                                        @foreach ($loanAccounts as $account)
                                            <option value="{{ $account->id }}"
                                                    {{ old('loan_id') == $account->id ? 'selected' : '' }}>
                                                {{ $account->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option disabled>No loan accounts available. Please add loan accounts first.
                                        </option>
                                    @endif
                                </select>
                                <label for="loanId" class="form-label">Loan Account</label>
                                @error('loan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($loanAccounts->isEmpty())
                                    <small class="text-danger">⚠ You must add loan accounts before submitting the
                                        form.</small>
                                @endif
                            </div>
                        @endisset
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <select name="installment_type" id="installmentType"
                                        class="form-select @error('installment_type') is-invalid @enderror" required>
                                    <option value="Monthly" {{ old('installment_type') === 'Monthly' ? 'selected' : '' }}>
                                        Monthly
                                    </option>
                                    <option value="Quarterly" {{ old('installment_type') === 'Quarterly' ? 'selected' : '' }}>
                                        Quarterly
                                    </option>
                                     <option value="Yearly" {{ old('installment_type') === 'Yearly' ? 'selected' : '' }}>
                                        Yearly
                                    </option>
                                </select>
                                <label for="installmentType" class="form-label">Installment Type</label>
                                @error('installment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input name="mature_date" id="matureDate"
                                       class="form-control @error('mature_date') is-invalid @enderror"
                                       value="{{ old('mature_date') }}" type="date" placeholder="Mature Date">
                                <label for="matureDate" class="form-label">Mature Date</label>
                                @error('mature_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input name="first_installment_date" id="firstInstallmentDate"
                                       class="form-control @error('first_installment_date') is-invalid @enderror"
                                       value="{{ old('first_installment_date') }}" type="date"
                                       placeholder="First Installment Date">
                                <label for="firstInstallmentDate" class="form-label">First Installment Date</label>
                                @error('first_installment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input name="total_installments" id="totalInstallments"
                                       class="form-control @error('total_installments') is-invalid @enderror"
                                       value="{{ old('total_installments') }}" type="number" 
                                       placeholder="Total Installments" required>
                                <label for="totalInstallments" class="form-label">Total Installments</label>
                                @error('total_installments')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input name="installment_amount" id="installmentAmount"
                                       class="form-control @error('installment_amount') is-invalid @enderror"
                                       value="{{ old('installment_amount') }}" type="number" step="0.01"
                                       placeholder="Installment Amount" required>
                                <label for="installmentAmount" class="form-label">Installment Amount</label>
                                @error('installment_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input name="installment_with_interest" id="installmentWithInterest"
                                       class="form-control @error('installment_with_interest') is-invalid @enderror"
                                       value="{{ old('installment_with_interest') }}" type="text"
                                       placeholder="Installment With Interest" required>
                                <label for="installmentWithInterest" class="form-label">Installment With
                                    Interest</label>
                                @error('installment_with_interest')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input name="total_installments_paid" id="totalInstallmentsPaid"
                                       class="form-control @error('total_installments_paid') is-invalid @enderror"
                                       value="{{ old('total_installments_paid') }}" type="number"
                                       placeholder="Total Installments Paid" required>
                                <label for="totalInstallmentsPaid" class="form-label">Total Installments Paid</label>
                                @error('total_installments_paid')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input id="createdBy" class="form-control" value="{{ $user->name }}" type="text"
                                       readonly required>
                                <label for="createdBy" class="form-label">Created By</label>
                                <input name="created_by" id="createdById" class="form-control" value="{{ $user->id }}" type="text"
                                       hidden required>
                                @error('created_by')
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