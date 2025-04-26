<div class="modal fade" id="loanInstallmentModal" tabindex="-1" aria-labelledby="loanInstallmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('loan-installments.store')}}" id="loanInstallmentModalForm">
                <input type="hidden" id="loanInstallmentId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loanInstallmentModalLabel">Loan Installment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-3">
                                @isset($loanAccounts) 
                                <div class="col-2 d-none d-xl-block">
                                    <label for="depositAccountId">Deposit Account</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                        @if ($loanAccounts->isNotEmpty())
                                        <select id="loanId" name="loan_id" class="w-100 px-2 py-1 @error('loan_id') is-invalid @enderror" required>
                                            <option value="" {{old('loan_id')? '' : 'selected'}}>----- Select Loan Account -----</option>
                                            @foreach ($loanAccount as $account)
                                                <option value="{{ $account->id }}"  
                                                {{ old('loan_id') == $account->id ? 'selected' : '' }}
                                                >
                                                {{ $account->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('loan_id')
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
                            <div class="row mb-2">
                                <div class="col-2 d-none d-xl-block">
                                    <label for="installmentType">Installment Type</label>
                                </div>
                                <div class="col-4 pe-0 pe-xl-5">
                                    <input name="installment_type" id="installmentType" class="w-100 px-2 py-1 @error('installment_type') is-invalid @enderror" value="{{ old('installment_type') }}" type="number" placeholder="Installment Type" required>
                                    @error('installment_type')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-2 d-none d-xl-block">
                                    <label for="matureDate">Mature Date</label>
                                </div>
                                <div class="col-4 pe-0 pe-xl-5">
                                    <input name="mature_date" id="matureDate" class="w-100 px-2 py-1 @error('mature_date') is-invalid @enderror" value="{{ old('mature_date') }}" type="date" placeholder="Mature Date">
                                    @error('mature_date')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-2 d-none d-xl-block">
                                    <label for="firstInstallmentDate">First Installment Date</label>
                                </div>
                                <div class="col-4 pe-0 pe-xl-5">
                                    <input name="first_installment_date" id="firstInstallmentDate" class="w-100 px-2 py-1 @error('first_installment_date') is-invalid @enderror" value="{{ old('first_installment_date') }}" type="date" placeholder="First Installment Date">
                                    @error('first_installment_date')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="col-2 d-none d-xl-block">
                                    <label for="totalInstallments">Total Installments</label>
                                </div>
                                <div class="col-4 pe-0 pe-xl-5">
                                    <input name="total_installments" id="totalInstallments" class="w-100 px-2 py-1 @error('total_installments') is-invalid @enderror" value="{{ old('total_installments') }}" type="number" placeholder="Total Installments" required>
                                    @error('total_installments')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-2 d-none d-xl-block">
                                    <label for="installmentAmount">Installment Amount</label>
                                </div>
                                <div class="col-4 pe-0 pe-xl-5">
                                    <input name="installment_amount" id="installmentAmount" class="w-100 px-2 py-1 @error('installment_amount') is-invalid @enderror" value="{{ old('installment_amount') }}" type="number" placeholder="Installment Amount" required>
                                    @error('installment_amount')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-2 d-none d-xl-block">
                                    <label for="installmentWithInterest">Installment With Interest</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                <input name="installment_with_interest" id="interestEarned" class="w-100 px-2 py-1 @error('installment_with_interest') is-invalid @enderror" value="{{ old('installment_with_interest') }}" type="text" placeholder="Installment With Interest" required>
                                    @error('installment_with_interest')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-2 d-none d-xl-block">
                                    <label for="totalInstallmentsPaid">total Installments Paid</label>
                                </div>
                                <div class="col-4 pe-0 pe-xl-5">
                                    <input name="total_installments_paid" id="totalInstallmentsPaid" class="w-100 px-2 py-1 @error('total_installments_paid') is-invalid @enderror" value="{{ old('total_installments_paid') }}" type="number"
                                        placeholder="Total Balance" required>
                                        @error('total_installments_paid')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                           
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="createdBy">Created By</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input  id="createdBy" class="w-100 px-2 py-1" value="{{$user->name}}" type="text" readonly required>
                                <input name="created_by"  class="w-100 px-2 py-1" value="{{$user->id}}" type="text" hidden required>
                                @error('created_by')
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

