<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('users.store')}}" id="userModalForm">
                <input type="hidden" id="userId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userModalLabel">Add User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                        @isset($employees) 
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="employee">Employee  (optional)</label>
                            </div>
                            @if ($employees->isNotEmpty())
                            <div class="col pe-0 pe-xl-5">
                                <select name="employee_id" id="employee"  class="w-100 px-2 py-1 @error('employee_id') is-invalid @enderror">
                                    <option value="" selected>---------- Select ----------</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"  
                                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                        >
                                        {{ $employee->member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @else
                             <div class="col pe-0 pe-xl-5">
                                <select class="w-100 px-2 py-1" disabled>
                                    <option>No branches available. Please add branches first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add branches before submitting the form.</small>
                            </div>
                            @endif
                        </div>
                        @endisset
                    <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="name" id="userName" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="email">Email</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="email" id="userEmail" class="w-100 px-2 py-1 @error('email') is-invalid @enderror" value="{{ old('email') }}" type="email" placeholder="Email">
                                @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="password">Password</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="password" id="password" class="w-100 px-2 py-1 @error('password') is-invalid @enderror" value="{{ old('password') }}" type="password" placeholder="Password">
                                @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                     <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="role">Role</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="role" id="role"  class="w-100 px-2 py-1 @error('role') is-invalid @enderror" required>
                                        <option value="User" selected >
                                        User
                                        </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                   
                        @isset($branches) 
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="branch">Branch</label>
                            </div>
                            @if ($branches->isNotEmpty())
                            <div class="col pe-0 pe-xl-5">
                                <select name="branch_id" id="branch"  class="w-100 px-2 py-1 @error('branch_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"  
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                        >
                                        {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @else
                             <div class="col pe-0 pe-xl-5">
                                <select class="w-100 px-2 py-1" disabled>
                                    <option>No branches available. Please add branches first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add branches before submitting the form.</small>
                            </div>
                            @endif
                        </div>
                        @endisset
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

