<div class="modal fade" id="standingInstructionModal" tabindex="-1" aria-labelledby="standingInstructionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('standing-instructions.store')}}" id="standingInstructionForm">
                <input type="hidden" id="standingInstructionId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="standingInstructionModalLabel">Add Standing Instruction</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            @isset($ledgers) 
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="creditLedgerId">Credit Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                @if ($ledgers->isNotEmpty())
                                <select id="creditLedgerId" name="credit_ledger_id" class="w-100 px-2 py-1 @error('credit_ledger_id') is-invalid @enderror">
                                    <option value="">------ Select Credit Ledger ------</option>
                                    @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"  
                                        {{ old('credit_ledger_id') == $ledger->id ? 'selected' : '' }}
                                        >
                                        {{ $ledger->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('credit_ledger_id')
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
                            <label for="creditAccountId">Credit Account</label>
                        </div>
                        <div class="col-4 pe-0 pe-xl-5">
                                @if ($accounts->isNotEmpty())
                                <select id="creditAccountId" name="credit_account_id" class="w-100 px-2 py-1  @error('credit_account_id') is-invalid @enderror">
                                    <option value="">------ Select Credit Account ------</option>
                                     @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"  
                                        {{ old('credit_account_id') == $account->id ? 'selected' : '' }}
                                        >
                                        {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('credit_account_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No accounts available. Please add accounts first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add accounts before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="creditTransfer">Credit Transfer</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="credit_transfer" id="creditTransfer" class="w-100 px-2 py-1 @error('credit_transfer') is-invalid @enderror" value="{{ old('credit_transfer') }}" type="text"
                                    placeholder="Credit Transfer">
                                    @error('credit_transfer')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @isset($ledgers) 
                            <div class="col-2 d-none d-xl-block">
                                <label for="debitLedgerId">Debit Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                @if ($ledgers->isNotEmpty())
                                <select id="debitLedgerId" name="debit_ledger_id" class="w-100 px-2 py-1 @error('debit_ledger_id') is-invalid @enderror">
                                    <option value="">------ Select Debit Ledger ------</option>
                                    @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"  
                                        {{ old('debit_ledger_id') == $ledger->id ? 'selected' : '' }}
                                        >
                                        {{ $ledger->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('debit_ledger_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No debit ledgers available. Please add debit ledgers first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add debit ledgers before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>

                        <div class="row mb-2">
                            @isset($accounts) 
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="debitAccountId">Debit Account</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                @if ($accounts->isNotEmpty())
                                <select id="debitAccountId" name="debit_account_id" class="w-100 px-2 py-1 @error('debit_account_id') is-invalid @enderror">
                                    <option value="">------ Select Debit Account ------</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"  
                                        {{ old('debit_account_id') == $account->id ? 'selected' : '' }}
                                        >
                                        {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('debit_account_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                 @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No debit accounts available. Please add debit accounts first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add debit accounts before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                            <div class="col-2 d-none d-xl-block">
                                <label for="debitTransfer">Debit Transfer</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="debit_transfer" id="debitTransfer" class="w-100 px-2 py-1  @error('debit_transfer') is-invalid @enderror" value="{{ old('debit_transfer') }}" type="number"
                                    placeholder="Debit Transfer">
                                    @error('debit_transfer')
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
                                <label for="frequency">Frequency</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="frequency" name="frequency" class="w-100 px-2 py-1 @error('frequency') is-invalid @enderror" required>
                                    <option value="">------ Select Frequency ------</option>
                                    <option value="Daily" {{ old('frequency') == 'Daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="Weekly" {{ old('frequency') == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="Monthly" {{ old('frequency') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Other" {{ old('frequency') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('frequency')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="noOfTimes">No. of Times</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="no_of_times" id="noOfTimes" class="w-100 px-2 py-1 @error('no_of_times') is-invalid @enderror" value="{{ old('no_of_times') }}" type="number" placeholder="No. of Times" required>
                                @error('no_of_times')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="balInstallment">Balance Installment</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="bal_installment" id="balInstallment" class="w-100 px-2 py-1 @error('bal_installment') is-invalid @enderror" value="{{ old('bal_installment') }}" type="number"
                                    placeholder="Balance Installment" required>
                                    @error('bal_installment')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="executionDate">Execution Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="execution_date" id="executionDate" class="w-100 px-2 py-1 @error('execution_date') is-invalid @enderror" value="{{ old('execution_date') }}" type="date"
                                    placeholder="Execution Date" required>
                                    @error('execution_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="amount">Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="amount" id="amount" class="w-100 px-2 py-1 @error('amount') is-invalid @enderror" value="{{ old('amount') }}" type="number" placeholder="Amount" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="createdBy">Created By</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="createdBy" class="w-100 px-2 py-1 @error('created_by') is-invalid @enderror" value="{{$user->name}}" type="text" readonly required>
                                <input name="created_by" id="createdBy" class="w-100 px-2 py-1 @error('created_by') is-invalid @enderror" value="{{$user->id}}" hidden type="text" readonly required>
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