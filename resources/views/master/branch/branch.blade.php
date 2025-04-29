<div class="modal fade" id="branchModal" tabindex="-1" aria-labelledby="branchModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('branches.store') }}" id="branchForm" class="needs-validation"
                novalidate>
                <input type="hidden" id="branchId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="branchModalLabel"><i class="bi bi-house-door me-2"></i>Add
                        Branch</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        {{-- Branch Code --}}
                        <div class="form-floating mb-3">
                            <input name="branch_code" id="branchCode"
                                class="form-control @error('branch_code') is-invalid @enderror"
                                value="{{ old('branch_code') }}" type="text" placeholder="Branch Code" required>
                            <label for="branchCode" class="form-label required">Branch Code</label>
                            @error('branch_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Branch Name --}}
                        <div class="form-floating mb-3">
                            <input name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" type="text" placeholder="Branch Name" required>
                            <label for="name" class="form-label required">Branch Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Location --}}
                        <div class="form-floating mb-3">
                            <input name="location" id="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location') }}" type="text" placeholder="Location" required>
                            <label for="location" class="form-label required">Location</label>
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Manager Dropdown --}}
                        {{-- @isset($employees)
                        @if ($employees->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select name="manager_id" id="manager"
                                class="form-select @error('manager_id') is-invalid @enderror" required>
                                <option value="" disabled selected>---------- Select Manager ----------</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                        {{ old('manager_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->member->name }}
                        </option>
                        @endforeach
                        </select>
                        <label for="manager" class="form-label required">Manager</label>
                        @error('manager_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <strong>⚠️ No managers available.</strong><br>
                        Please add managers first.
                    </div>
                    @endif
                    @endisset--}}
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