<div class="modal fade" id="dayBeginsModal" tabindex="-1" aria-labelledby="dayBeginsModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('day-begins.store') }}" id="dayBeginModalForm" class="needs-validation"
                novalidate>
                <input type="hidden" id="dayBeginId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="dayBeginsModalLabel"><i
                            class="bi bi-calendar-plus-fill me-2"></i>Add Day Begin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        {{-- Created By --}}
                        <div class="form-floating mb-3">
                            <input name="created_by" id="createdBy"
                                class="form-control @error('created_by') is-invalid @enderror" value="{{$user->name}}"
                                type="text" disabled placeholder="Created By">
                            <label for="createdBy">Created By</label>
                            @error('created_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Date --}}
                        <div class="form-floating mb-3">
                            <input name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date') }}" type="date" placeholder="Date" required>
                            <label for="date" class="form-label required">Date</label>
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- User Dropdown --}}
                        @isset($users)
                        @if ($users->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select name="user_id" id="userId"
                                class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="" disabled selected>---------- Select ----------</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                                @endforeach
                            </select>
                            <label for="userId">User</label>
                            @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <strong>⚠️ No users available.</strong><br>
                            Please add users first.
                        </div>
                        @endif
                        @endisset

                        <!-- Branch -->
                        {{-- @if(Auth::user()->role === 'Admin')
                         @if ($branches->isNotEmpty())
                                <div class="form-floating">
                                    <select name="branch_id" id="userBranch"
                                        class="form-select @error('branch_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                        <option value="{{ $member->id }}"
                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}</option>
                        @endforeach
                        </select>
                        <label for="userBranch">Branch</label>
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
                    @endif --}}

                    {{-- Opening Cash Balance --}}
                    <div class="col-md-6">
                        {{-- <div class="form-floating">
                                <input name="opening_cash_balance" id="openingCashBalance"
                                    class="form-control @error('opening_cash_balance') is-invalid @enderror"
                                    value="{{ old('opening_cash_balance') }}" type="number" required
                        placeholder="Opening Cash Balance">
                        <label for="openingCashBalance" class="form-label required">Opening Cash Balance</label>
                        @error('opening_cash_balance')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- Status Dropdown --}}
                    <div class="form-floating mb-3">
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror"
                            required>
                            <option value="">------ Select Status ------</option>
                            <option value="Open" {{ old('status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        <label for="status" class="form-label required">Status</label>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remark -->
                    {{-- <div class="form-floating mb-3">
    <textarea class="form-control @error('remarks') is-invalid @enderror" placeholder="Remarks" id="remarks"
        name="remarks" style="height: 100px" required>{{ old('remarks') }}</textarea>
                    <label for="remarks">Remarks</label>
                    @error('remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}
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