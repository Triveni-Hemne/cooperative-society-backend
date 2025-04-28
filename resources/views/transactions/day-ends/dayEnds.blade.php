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
                    <h5 class="modal-title fw-bold" id="dayEndsModalLabel"><i class="bi bi-calendar-check me-2"></i> Add
                        Day Ends</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">

                        {{-- Created By --}}
                        <div class="form-floating mb-3">
                            <input name="created_by" id="createdBy"
                                class="form-control @error('created_by') is-invalid @enderror" value="{{ $user->name }}"
                                type="text" disabled placeholder="Created By">
                            <label for="createdBy">Created By</label>
                            @error('created_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Date --}}
                        <div class="form-floating mb-3">
                            <input name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date') }}" type="date" required>
                            <label for="date" class="form-label required">Date</label>
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Opening Cash --}}
                        <div class="form-floating mb-3">
                            <input name="opening_cash" id="openingCash"
                                class="form-control @error('opening_cash') is-invalid @enderror"
                                value="{{ old('opening_cash') }}" type="number" required placeholder="Opening Cash">
                            <label for="openingCash" class="form-label required">Opening Cash</label>
                            @error('opening_cash')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Credit RS --}}
                        <div class="form-floating mb-3">
                            <input name="total_credit_rs" id="totalCreditRs"
                                class="form-control @error('total_credit_rs') is-invalid @enderror"
                                value="{{ old('total_credit_rs') }}" type="number" required
                                placeholder="Total Credit RS">
                            <label for="totalCreditRs" class="form-label required">Total Credit RS</label>
                            @error('total_credit_rs')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Credit Challans --}}
                        <div class="form-floating mb-3">
                            <input name="total_credit_chalans" id="totalCreditChalans"
                                class="form-control @error('total_credit_chalans') is-invalid @enderror"
                                value="{{ old('total_credit_chalans') }}" type="number" required
                                placeholder="Total Credit Challan">
                            <label for="totalCreditChalans" class="form-label required">Total Credit Challan</label>
                            @error('total_credit_chalans')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Debit RS --}}
                        <div class="form-floating mb-3">
                            <input name="total_debit_rs" id="totalDebitRs"
                                class="form-control @error('total_debit_rs') is-invalid @enderror"
                                value="{{ old('total_debit_rs') }}" type="number" required placeholder="Total Debit RS">
                            <label for="totalDebitRs" class="form-label required">Total Debit RS</label>
                            @error('total_debit_rs')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Debit Challans --}}
                        <div class="form-floating mb-3">
                            <input name="total_debit_challans" id="totalDebitChallans"
                                class="form-control @error('total_debit_challans') is-invalid @enderror"
                                value="{{ old('total_debit_challans') }}" type="number" required
                                placeholder="Total Debit Challan">
                            <label for="totalDebitChallans" class="form-label required">Total Debit Challan</label>
                            @error('total_debit_challans')
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