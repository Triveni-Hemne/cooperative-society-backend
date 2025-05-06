<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{route('departments.store')}}" id="departmentForm" class="needs-validation"
                novalidate>
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{Session::get('error')}}</div>
                @endif
                <input type="hidden" id="departmentId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="departmentModalLabel"><i class="bi bi-building me-2"></i> Add
                        Department</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">

                        {{-- Name --}}
                        <div class="form-floating mb-3">
                            <input name="name" id="Name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" type="text" placeholder="Name" required>
                            <label for="Name" class="form-label required">Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        @isset($employees)
                        {{-- Head of Department --}}
                        <div class="form-floating mb-3">
                            @if ($employees->isNotEmpty())
                            <select name="head_id" id="headId"
                                class="form-select @error('head_id') is-invalid @enderror" required>
                                <option value="" disabled selected>---------- Select ----------</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('head_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                                @endforeach
                            </select>
                            <label for="headId" class="form-label required">Head of Department</label>
                            @error('head_id')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            @else
                            <div class="alert alert-warning">
                                <strong>⚠️ No head of department available.</strong><br>
                                Please add members first.
                            </div>
                            @endif
                        </div>
                        @endisset

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

<!-- <style>
label.required::after {
    content: " *";
    color: red;
    font-weight: bold;
}
</style> -->