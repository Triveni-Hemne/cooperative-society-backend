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

                        {{-- Member Dropdown --}}
                        @isset($members)
                        @if ($members->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select name="member_id" id="memberId"
                                class="form-select @error('member_id') is-invalid @enderror" required>
                                <option value="" disabled selected>---------- Select ----------</option>
                                @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                            <label for="memberId">Member</label>
                            @error('member_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <strong>⚠️ No members available.</strong><br>
                            Please add members first.
                        </div>
                        @endif
                        @endisset

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