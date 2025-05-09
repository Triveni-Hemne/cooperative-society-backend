<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('users.store') }}" id="userModalForm" class="needs-validation"
                novalidate>
                <input type="hidden" id="userId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2"></i><span id="userModalLabel">Add
                        User</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        {{-- Employee --}}
                        @isset($employees)
                        @if ($employees->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select name="employee_id" id="employee"
                                class="form-select @error('employee_id') is-invalid @enderror">
                                <option value="" disabled selected>Select Employee (Optional)</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->member->name }}
                        </option>
                        @endforeach
                        </select>
                        <label for="employee">Employee</label>
                        @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <strong>⚠️ No Employees available.</strong><br>
                        Please add Employees first.
                    </div>
                    @endif
                    @endisset

                    {{-- Name --}}
                    <div class="form-floating mb-3">
                        <input name="name" id="userName" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" type="text" placeholder="Name" required>
                        <label for="userName" class="form-label required">Name</label>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-floating mb-3">
                        <input name="email" id="userEmail" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" type="email" placeholder="Email">
                        <label for="userEmail">Email</label>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-floating mb-3">
                        <input name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                            type="password" placeholder="Password">
                        <label for="password">Password</label>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="form-floating mb-3">
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="User" selected>User</option>
                        </select>
                        <label for="role" class="form-label required">Role</label>
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Branch --}}
                    @if ($branches->isNotEmpty())
                    <div class="form-floating mb-3">
                        <select name="branch_id" id="branch"
                            class="form-select @error('branch_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Select Branch</option>
                             @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"  
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                        >
                                        {{ $branch->name }}
                                        </option>
                                    @endforeach
                        </select>
                        <label for="branch">Branch</label>
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


