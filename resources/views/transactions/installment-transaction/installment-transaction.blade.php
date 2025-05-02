<div class="modal fade" id="installmentTransactionModal" tabindex="-1"
    aria-labelledby="installmentTransactionModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{route('installment-transactions.store')}}"
                id="installmentTransactionModalForm">
                <input type="hidden" id="installmentTransactionId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="installmentTransactionModalLabel">
                        <i class="bi bi-credit-card me-2"></i> Installment Transaction
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        {{-- Created By --}}
                        {{-- <div class="form-floating mb-3">
                            <input name="created_by" id="createdBy"
                                class="form-control @error('created_by') is-invalid @enderror" value="{{ $user->name }}"
                        type="text" disabled placeholder="Created By">
                        <label for="createdBy">Created By</label>
                        @error('created_by')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- Deposit Account --}}
                    @isset($memberDepoAccounts)
                    <div class="form-floating mb-3">
                        @if ($memberDepoAccounts->isNotEmpty())
                        <select id="depositAccountId" name="deposit_account_id"
                            class="form-select @error('deposit_account_id') is-invalid @enderror" required>
                            <option value="">------ Select Deposit Account ------</option>
                            @foreach ($memberDepoAccounts as $account)
                            <option value="{{ $account->id }}"
                                {{ old('deposit_account_id') == $account->id ? 'selected' : '' }}>
                                {{ $account->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="depositAccountId" class="form-label required">Deposit Account</label>
                        @error('deposit_account_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @else
                        <div class="alert alert-warning">
                            <strong>⚠️ No Deposit Account available.</strong><br>
                            Please add deposit account first.
                        </div>
                        @endif
                    </div>
                    @endisset

                    {{-- Installment Number --}}
                    <div class="form-floating mb-3">
                        <input name="installment_no" id="installmentNo" type="number"
                            class="form-control @error('installment_no') is-invalid @enderror"
                            placeholder="Transaction No." value="{{ old('installment_no') }}" required>
                        <label for="installmentNo" class="form-label required">Installment Transaction No.</label>
                        @error('installment_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Amount Paid --}}
                    <div class="form-floating mb-3">
                        <input name="amount_paid" id="amountPaid" type="number"
                            class="form-control @error('amount_paid') is-invalid @enderror" placeholder="Amount Paid"
                            value="{{ old('amount_paid') }}" required>
                        <label for="amountPaid" class="form-label required">Amount Paid</label>
                        @error('amount_paid')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payment Date --}}
                    <div class="form-floating mb-3">
                        <input name="payment_date" id="paymentDate" type="date"
                            class="form-control @error('payment_date') is-invalid @enderror" placeholder="Payment Date"
                            value="{{ old('payment_date') }}" required>
                        <label for="paymentDate" class="form-label required">Payment Date</label>
                        @error('payment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Interest Earned --}}
                    <div class="form-floating mb-3">
                        <input name="interest_earned" id="interestEarned" type="text"
                            class="form-control @error('interest_earned') is-invalid @enderror"
                            placeholder="Interest Earned" value="{{ old('interest_earned') }}" required>
                        <label for="interestEarned" class="form-label required">Interest Earned</label>
                        @error('interest_earned')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Total Balance --}}
                    <div class="form-floating mb-3">
                        <input name="total_balance" id="totalBalance" type="number"
                            class="form-control @error('total_balance') is-invalid @enderror"
                            placeholder="Total Balance" value="{{ old('total_balance') }}" required>
                        <label for="totalBalance" class="form-label required">Total Balance</label>
                        @error('total_balance')
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