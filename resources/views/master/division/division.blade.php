<div class="modal fade" id="divisionModal" tabindex="-1" aria-labelledby="divisionModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('divisions.store') }}" id="divisionForm" class="needs-validation"
                novalidate>
                @csrf
                <input type="hidden" id="divisionId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="divisionModalLabel"><i class="bi bi-diagram-3-fill me-2"></i>
                        Add Division</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">

                        <!-- Name -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Name" value="{{ old('name') }}" required>
                            <label for="name" class="form-label required">Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Marathi Name -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control marathiField @error('naav') is-invalid @enderror"
                                id="marathiName" name="naav" placeholder="नाव" value="{{ old('naav') }}" required>
                            <label for="marathiName">नाव</label>
                            @error('naav')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="errorMsg text-danger small d-none">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                        </div>

                        <!-- Description -->
                        <div class="form-floating mb-3">
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                placeholder="Description" id="description" name="description" style="height: 100px"
                                required>{{ old('description') }}</textarea>
                            <label for="description">Description</label>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Marathi Description -->
                        <div class="form-floating mb-3">
                            <textarea
                                class="form-control marathiField @error('marathi_description') is-invalid @enderror"
                                placeholder="वर्णन" id="marathiDescription" name="marathi_description"
                                style="height: 100px" required>{{ old('marathi_description') }}</textarea>
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