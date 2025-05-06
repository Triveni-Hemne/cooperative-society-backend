<div class="modal fade" id="subcasteModal" tabindex="-1" aria-labelledby="subcasteModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('subcastes.store') }}" id="subcasteForm" class="needs-validation"
                novalidate>
                <input type="hidden" id="subcasteId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="subcasteModalLabel"><i class="bi bi-person-plus-fill me-2"></i>
                        Add SubCaste</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">

                        {{-- Name --}}
                        <div class="form-floating mb-3">
                            <input name="name" id="Name" class="form-control @error('name') is-invalid @enderror"
                                type="text" value="{{ old('name') }}" placeholder="Name" required>
                            <label for="Name" class="form-label required">Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Marathi Name --}}
                        <div class="form-floating mb-3">
                            <input name="naav" id="marathiName"
                                class="form-control @error('naav') is-invalid @enderror marathiField" type="text"
                                value="{{ old('naav') }}" placeholder="नाव" required>
                            <label for="marathiName">नाव</label>
                            @error('naav')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                        </div>

                        {{-- Description --}}
                        <div class="form-floating mb-3">
                            <textarea name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror" rows="3"
                                placeholder="Description" style="resize:none"
                                required>{{ old('description') }}</textarea>
                            <label for="description">Description</label>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Marathi Description --}}
                        <div class="form-floating mb-3">
                            <textarea name="marathi_description" id="marathiDescription"
                                class="form-control @error('marathi_description') is-invalid @enderror marathiField"
                                rows="3" placeholder="वर्णन" style="resize:none"
                                required>{{ old('marathi_description') }}</textarea>
                            <label for="marathiDescription">वर्णन</label>
                            @error('marathi_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
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