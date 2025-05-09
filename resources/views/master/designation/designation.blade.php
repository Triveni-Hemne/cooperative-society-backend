<!-- Designation Modal -->
<div class="modal fade" id="designationModal" tabindex="-1" aria-labelledby="designationModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('designations.store') }}" id="designationForm" class="needs-validation"
                novalidate>
                @csrf
                <input type="hidden" id="designationId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" ><i class="bi bi-person-badge me-2"></i>
                        <span id="designationModalLabel">Add Designation</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">

                        {{-- Designation Name (English) --}}
                        <div class="form-floating mb-3">
                            <input type="text" id="Name" name="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                value="{{ old('name') }}" required>
                            <label for="Name" class="form-label required">Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Designation Name (Marathi) --}}
                        <div class="form-floating mb-3">
                            <input type="text" id="marathiName" name="naav"
                                class="form-control marathiField @error('naav') is-invalid @enderror" placeholder="नाव"
                                value="{{ old('naav') }}" required>
                            <label for="marathiName">नाव</label>
                            @error('naav')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg text-danger small d-none">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                        </div>
                        {{-- Division Dropdown --}}
                        @isset($divisions)
                        <div class="form-floating mb-3">
                            @if ($divisions->isNotEmpty())
                            <select id="division_id" name="division_id"
                                class="form-select @error('division_id') is-invalid @enderror">
                                <option value="" disabled selected>Select Division</option>
                                @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}
                                </option>
                                @endforeach
                            </select>
                            <label for="division_id" class="form-label">Taluka/Division</label>
                            @error('division_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="alert alert-warning">
                                <strong>⚠️ No divisions available.</strong><br>
                                Please add divisions first.
                            </div>
                            @endif
                        </div>
                        @endisset

                        {{-- Subdivision Dropdown --}}
                        @isset($subdivisions)
                        <div class="form-floating mb-3">
                            @if ($subdivisions->isNotEmpty())
                            <select id="subdivision_id" name="subdivision_id"
                                class="form-select @error('subdivision_id') is-invalid @enderror">
                                <option value="" disabled selected>Select Sub Division</option>
                                @foreach ($subdivisions as $subdivision)
                                <option value="{{ $subdivision->id }}"
                                    {{ old('subdivision_id') == $subdivision->id ? 'selected' : '' }}>
                                    {{ $subdivision->name }}</option>
                                @endforeach
                            </select>
                            <label for="subdivision_id" class="form-label">Sub Division</label>
                            @error('subdivision_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="alert alert-warning">
                                <strong>⚠️ No sub-divisions available.</strong><br>
                                Please add sub-divisions first.
                            </div>
                            @endif
                        </div>
                        @endisset

                        {{-- Center Dropdown --}}
                        @isset($centers)
                        <div class="form-floating mb-3">
                            @if ($centers->isNotEmpty())
                            <select id="center_id" name="center_id"
                                class="form-select @error('center_id') is-invalid @enderror">
                                <option value="" disabled selected>Select Center</option>
                                @foreach ($centers as $center)
                                <option value="{{ $center->id }}"
                                    {{ old('center_id') == $center->id ? 'selected' : '' }}>{{ $center->name }}</option>
                                @endforeach
                            </select>
                            <label for="center_id">Center</label>
                            @error('center_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="alert alert-warning">
                                <strong>⚠️ No centers available.</strong><br>
                                Please add centers first.
                            </div>
                            @endif
                        </div>
                        @endisset

                        <div class="form-floating mb-3">
                            <textarea id="description" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Description"
                                style="height: 100px; resize: none;">{{ old('description') }}</textarea>
                            <label for="description">Description</label>
                            @error('description')
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

<!-- Marathi Field Validation Script -->
<script src="{{ asset('/assets/js/marathi-validate-fields.js') }}"></script>