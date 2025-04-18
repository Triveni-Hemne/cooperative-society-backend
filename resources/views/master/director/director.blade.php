<div class="modal fade" id="directorModal" tabindex="-1" aria-labelledby="directorModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('directors.store') }}" id="directorsForm" class="needs-validation"
                novalidate>
                <input type="hidden" id="directorId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf

                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="directorModalLabel"><i class="bi bi-person-plus-fill me-2"></i>
                        Add Director</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        {{-- Member Dropdown --}}
                        @if ($members->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select name="member_id" id="memberId"
                                class="form-select @error('member_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Member</option>
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

                        {{-- Name --}}
                        <div class="form-floating mb-3">
                            <input id="name" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                value="{{ old('name') }}" required>
                            <label for="name" class="form-label required">Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Designation --}}
                        @isset($designations)
                        @if ($designations->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select name="designation_id" id="designationId"
                                class="form-select @error('designation_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Designation</option>
                                @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}"
                                    {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                    {{ $designation->name }}</option>
                                @endforeach
                            </select>
                            <label for="designationId" class="form-label required">Designation</label>
                            @error('designation_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
                        @endisset

                        {{-- Email (Optional) --}}
                        <div class="form-floating mb-3">
                            <input name="email" id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                value="{{ old('email') }}">
                            <label for="email">Email</label>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mobile Numbers --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="contact_nos[]" id="mob0" type="number"
                                        class="form-control @error('contact_nos.0') is-invalid @enderror"
                                        placeholder="Mobile No." value="{{ old('contact_nos.0') }}" required>
                                    <label for="mob0" class="form-label required">Mobile No. 1</label>
                                    @error('contact_nos.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="contact_nos[]" id="mob1" type="number"
                                        class="form-control @error('contact_nos.1') is-invalid @enderror"
                                        placeholder="Mobile No." value="{{ old('contact_nos.1') }}" required>
                                    <label for="mob1">Mobile No. 2</label>
                                    @error('contact_nos.1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Dates --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input id="fromDate" name="from_date" type="date"
                                        class="form-control @error('from_date') is-invalid @enderror"
                                        value="{{ old('from_date') }}" required>
                                    <label for="fromDate" class="form-label required">From Date</label>
                                    @error('from_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input id="toDate" name="to_date" type="date"
                                        class="form-control @error('to_date') is-invalid @enderror"
                                        value="{{ old('to_date') }}">
                                    <label for="toDate">End Date</label>
                                    @error('to_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

<style>
label.required::after {
    content: " *";
    color: red;
    font-weight: bold;
}
</style>