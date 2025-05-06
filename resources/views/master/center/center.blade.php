<!-- Center Modal -->
<div class="modal fade" id="centerModal" tabindex="-1" aria-labelledby="centerModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('centers.store') }}" id="centerForm" class="needs-validation"
                novalidate>
                @csrf
                <input type="hidden" id="centerId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="centerModalLabel"><i class="bi bi-building me-2"></i> Add Center
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">

                        {{-- Center Name (English) --}}
                        <div class="form-floating mb-3">
                            <input type="text" id="Name" name="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                value="{{ old('name') }}" required>
                            <label for="Name" class="form-label required">Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Center Name (Marathi) --}}
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

                        {{-- Address (English) --}}
                        <div class="form-floating mb-3">
                            <textarea id="address" name="address"
                                class="form-control @error('address') is-invalid @enderror" placeholder="Address"
                                style="height: 100px; resize: none;" required>{{ old('address') }}</textarea>
                            <label for="address">Address</label>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address (Marathi) --}}
                        <div class="form-floating mb-3">
                            <textarea id="marathiAddress" name="marathi_address"
                                class="form-control marathiField @error('marathi_address') is-invalid @enderror"
                                placeholder="पत्ता" style="height: 100px; resize: none;"
                                required>{{ old('marathi_address') }}</textarea>
                            <label for="marathiAddress">पत्ता</label>
                            @error('marathi_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg text-danger small d-none">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                        </div>                        {{-- Division Dropdown --}}
                        @isset($divisions)
                        <div class="form-floating mb-3">
                            @if ($divisions->isNotEmpty())
                            <select id="division_id" name="division_id"
                                class="form-select @error('division_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Division</option>
                                @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}
                                </option>
                                @endforeach
                            </select>
                            <label for="division_id" class="form-label required">Taluka/Division</label>
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
                                class="form-select @error('subdivision_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Sub Division</option>
                                @foreach ($subdivisions as $subdivision)
                                <option value="{{ $subdivision->id }}"
                                    {{ old('subdivision_id') == $subdivision->id ? 'selected' : '' }}>
                                    {{ $subdivision->name }}</option>
                                @endforeach
                            </select>
                            <label for="subdivision_id" class="form-label required">Sub Division</label>
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

                        {{-- Description (English) --}}
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

                        {{-- Description (Marathi) --}}
                        <div class="form-floating mb-3">
                            <textarea id="marathiDescription" name="marathi_description"
                                class="form-control marathiField @error('marathi_description') is-invalid @enderror"
                                placeholder="वर्णन"
                                style="height: 100px; resize: none;">{{ old('marathi_description') }}</textarea>
                            <label for="marathiDescription">वर्णन</label>
                            @error('marathi_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg text-danger small d-none">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
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