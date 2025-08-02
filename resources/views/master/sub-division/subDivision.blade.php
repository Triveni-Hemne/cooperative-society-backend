<div class="modal fade" id="subDivisionModal" tabindex="-1" aria-labelledby="subDivisionModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('sub-divisions.store') }}" id="subDivisionForm"
                class="needs-validation" novalidate>
                <input type="hidden" id="subDivisionId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf

                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" ><i class="bi bi-building-add me-2"></i>
                        <span id="subDivisionModalLabel">Add Sub-Division</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="row g-3 mb-3">
                        {{-- Name --}}
                        <div class="col-md-6">
                        <div class="form-floating ">
                            <input id="Name" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                value="{{ old('name') }}" required>
                            <label for="Name" class="form-label required">Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        {{-- Marathi Name --}}
                        <div class="col-md-6">
                        <div class="form-floating ">
                            <input id="marathiName" name="naav" type="text"
                                class="form-control marathiField @error('naav') is-invalid @enderror" placeholder="नाव"
                                value="{{ old('naav') }}" required>
                            <label for="marathiName">नाव</label>
                            @error('naav')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg text-danger small d-none">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                        </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6">
                        <div class="form-floating ">
                            <textarea id="address" name="address"
                                class="form-control @error('address') is-invalid @enderror" placeholder="Address"
                                style="height: 100px;" required>{{ old('address') }}</textarea>
                            <label for="address">Address</label>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                        {{-- Marathi Address --}}
                        <div class="col-md-6">
                        <div class="form-floating ">
                            <textarea id="marathiAddress" name="marathi_address"
                                class="form-control marathiField @error('marathi_address') is-invalid @enderror"
                                placeholder="पत्ता" style="height: 100px;"
                                required>{{ old('marathi_address') }}</textarea>
                            <label for="marathiAddress">पत्ता</label>
                            @error('marathi_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg text-danger small d-none">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                        </div>
                        </div>
                        </div>

                        {{-- Division Dropdown --}}
                        @isset($divisions)
                        @if ($divisions->isNotEmpty())
                        <div class="row g-3 mb-3">
                        <div class="col">
                        <div class="form-floating">
                            <select id="division_id" name="division_id" required
                                class="form-select @error('division_id') is-invalid @enderror">
                                <option value="" disabled selected>Select Division </option>
                                @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}
                                </option>
                                @endforeach
                            </select>
                            <label for="division_id" class="form-label required">Division <span class="text-danger"> *</span></label>
                            @error('division_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                    </div>
                        @else
                        <div class="alert alert-warning">
                            <strong>⚠️ No divisions available.</strong><br>
                            Please add divisions first.
                        </div>
                        @endif
                        @endisset

                        {{-- Description --}}
                        <div class="row g-3">
                        <div class="col-md-6">
                        <div class="form-floating ">
                            <textarea id="description" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Description" style="height: 100px;">{{ old('description') }}</textarea>
                            <label for="description">Description</label>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                        {{-- Marathi Description --}}
                        <div class="col-md-6">
                        <div class="form-floating ">
                            <textarea id="marathiDescription" name="marathi_description"
                                class="form-control marathiField @error('marathi_description') is-invalid @enderror"
                                placeholder="वर्णन" style="height: 100px;">{{ old('marathi_description') }}</textarea>
                            <label for="marathiDescription">वर्णन</label>
                            @error('marathi_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg text-danger small d-none">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
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

<script src="{{ asset('/assets/js/marathi-validate-fields.js') }}"></script>