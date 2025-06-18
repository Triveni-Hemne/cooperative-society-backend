<div class="modal fade" id="dayEndsModal" tabindex="-1" aria-labelledby="dayEndsModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('day-end.store') }}" id="dayEndsModalForm" class="needs-validation"
                novalidate>
                <input type="hidden" id="dayEndsId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" ><i class="bi bi-calendar-check me-2"></i> <span id="dayEndsModalLabel">Add
                        Day Ends</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="row g-3 mb-3">
                             @isset($users) 
                            <div class="form-floating">
                                @if ($users->isNotEmpty())
                                 <select name="user_id" id="userId"  class="form-select @error('user_id') is-invalid @enderror" required>
                                    {{-- <option value="" disabled {{old('user_id') ? '' : 'selected'}}>---------- Select ----------</option> --}}
                                    {{-- @foreach ($users as $u) --}}
                                        {{-- <option value="{{ $u->id }}"  
                                        {{ old('user_id') == $u->id ? 'selected' : '' }}
                                        >
                                        {{ $u->name }}
                                        </option> --}}
                                        <option value="{{ Auth::user()->id }}"  
                                            {{ old('user_id') == Auth::user()->id ? 'selected' : '' }}
                                            >
                                            {{ Auth::user()->name }}
                                            </option>
                                    {{-- @endforeach --}}
                                </select>
                                <label for="userId" class="ms-2">User</label>
                                @error('user_id')
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
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                {{-- Created By --}}
                                <div class="form-floating">
                                    <input  id="createdBy" class="form-control" value="{{$user->name}}" type="text" @readonly(true) required>
                                    <input name="created_by" id="createdById" class="" value="{{$user->id}}" type="text" hidden required>
                                    <label for="createdBy">Created By</label>
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
                                        <option value="{{ $branch->id }}"
                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}</option>
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
                        </div>
                    </div>
                    @endisset
                    @endif

                    <div class="row g-3 mb-3">
                        {{-- Date --}}
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                                    value="{{ old('date') }}" type="date" required>
                                <label for="date" class="form-label required">Date</label>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Closing Cash Balance --}}
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input name="closing_cash_balance" id="ClosingCashBalance"
                                    class="form-control @error('closing_cash_balance') is-invalid @enderror"
                                    value="{{ old('closing_cash_balance') }}" type="number" step="0.01" required
                            placeholder="Closing Cash Balance">
                            <label for="ClosingCashBalance" class="form-label required">Closing Cash Balance</label>
                            @error('closing_cash_balance')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    {{-- Total Receipt --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="total_receipts" id="totalReceipts"
                                class="form-control @error('total_receipts') is-invalid @enderror"
                                value="{{ old('total_receipts') }}" type="number" required
                                 placeholder="Total
                        Receipts">
                        <label for="TotalReceipts" class="form-label required">Total Receipts</label>
                        @error('total_receipts')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Total Payment --}}
                <div class="col-md-6">
                    <div class="form-floating">
                            <input name="total_payments" id="totalPayments"
                                class="form-control @error('total_payments') is-invalid @enderror"
                                value="{{ old('total_payments') }}" type="number" required placeholder="Total
                    Payments" required>
                    <label for="TotalPayments" class="form-label required">Total Payments</label>
                    @error('total_payments')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        </div>
    </div>

    {{-- <div class="row g-3 mb-3"> --}}
        {{-- System Closing Balance --}}
        {{-- <div class="col-md-6">
            <div class="form-floating">
                            <input name="system_closing_balance" id="systemClosingBalance"
                                class="form-control @error('system_closing_balance') is-invalid @enderror"
                                value="{{ old('system_closing_balance') }}" type="number" step="0.01" 
            placeholder="System Closing Balance">
            <label for="SystemClosingBalance" class="form-label ">System Closing
                Balances</label>
            @error('system_closing_balance')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div> --}}

    {{-- Difference Amount --}}
    {{-- <div class="col-md-6">
        <div class="form-floating">
                            <input name="difference_amount" id="differenceAmount"
                                class="form-control @error('difference_amount') is-invalid @enderror"
                                value="{{ old('difference_amount') }}" type="number" step="0.01" 
        placeholder="Difference Amounts">
        <label for="DifferenceAmount" class="form-label">Difference Amounts</label>
        @error('difference_amount')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div> --}}
{{-- </div> --}}

<div class="row g-3 mb-3">
    {{-- Is Day Closed --}}
    <div class="col-md-6">
        <div class="form-floating">
            <select name="is_day_closed" id="isDayClosed" class="form-select @error('is_day_closed') is-invalid @enderror" required>
                <option value="1" {{ old('is_day_closed') == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('is_day_closed') == '0' ? 'selected' : '' }}>No</option>
            </select>
        <label for="IsDayClosed" class="form-label required">Is Day Closed</label>
        @error('is_day_closed')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- Opening Cash --}}
{{-- <div class="col-md-6">
    <div class="form-floating">
        <input name="opening_cash" id="openingCash" class="form-control @error('opening_cash') is-invalid @enderror"
            value="{{ old('opening_cash') }}" type="number" required placeholder="Opening Cash">
        <label for="openingCash" class="form-label required">Opening Cash</label>
        @error('opening_cash')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div> --}}
</div>

<div class="row g-3 mb-3">
    {{-- Total Credit RS --}}
    <div class="col-md-6">
        <div class="form-floating">
            <input name="total_credit_rs" id="totalCreditRs"
                class="form-control @error('total_credit_rs') is-invalid @enderror" value="{{ old('total_credit_rs') }}"
                type="number" step="0.01" required placeholder="Total Credit RS" required>
            <label for="totalCreditRs" class="form-label required">Total Credit RS</label>
            @error('total_credit_rs')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Total Credit Challans --}}
    <div class="col-md-6">
        <div class="form-floating">
            <input name="total_credit_chalans" id="totalCreditChalans"
                class="form-control @error('total_credit_chalans') is-invalid @enderror"
                value="{{ old('total_credit_chalans') }}" type="number" step="0.01" placeholder="Total Credit Challan">
            <label for="totalCreditChalans" class="form-label">Total Credit Challan</label>
            @error('total_credit_chalans')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    {{-- Total Debit RS --}}
    <div class="col-md-6">
        <div class="form-floating">
            <input name="total_debit_rs" id="totalDebitRs"
                class="form-control @error('total_debit_rs') is-invalid @enderror" value="{{ old('total_debit_rs') }}"
                type="number" step="0.01" required placeholder="Total Debit RS">
            <label for="totalDebitRs" class="form-label required">Total Debit RS</label>
            @error('total_debit_rs')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Total Debit Challans --}}
    <div class="col-md-6">
        <div class="form-floating">
            <input name="total_debit_challans" id="totalDebitChallans"
                class="form-control @error('total_debit_challans') is-invalid @enderror"
                value="{{ old('total_debit_challans') }}" type="number" placeholder="Total Debit Challan">
            <label for="totalDebitChallans" class="form-label">Total Debit Challan</label>
            @error('total_debit_challans')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Remark -->
<div class="form-floating mb-3">
    <textarea class="form-control @error('remarks') is-invalid @enderror" placeholder="Remarks" id="remarks"
        name="remarks" style="height: 100px" required>{{ old('remarks') }}</textarea>
<label for="remarks">Remarks</label>
@error('remarks')
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