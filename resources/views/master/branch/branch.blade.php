<div class="modal fade" id="branchModal" tabindex="-1" aria-labelledby="branchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('branches.store')}}" id="branchForm">
                <input type="hidden" id="branchId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="branchModalLabel">Add Branch</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="branchCode">Branch Code</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="branch_code" id="branchCode" class="w-100 px-2 py-1 @error('branch_code') is-invalid @enderror" value="{{ old('branch_code') }}" type="text" placeholder="Branch Code">
                                @error('branch_code')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="branchName">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="name" id="branchName" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Name">
                                @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="location">Location</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="location" id="location" class="w-100 px-2 py-1 @error('location') is-invalid @enderror" value="{{ old('location') }}" type="text" placeholder="Location">
                                @error('location')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                         {{-- @isset($employees) 
                         <div class="row mb-3">
                             <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="manager">Manager</label>
                                </div>
                            @if ($employees->isNotEmpty())
                            <div class="col pe-0 pe-xl-5">
                                <select name="manager_id" id="manager"  class="w-100 px-2 py-1 @error('manager_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"  
                                        {{ old('manager_id') == $employee->id ? 'selected' : '' }}
                                        >
                                        {{ $employee->member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('manager_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @else
                             <div class="col pe-0 pe-xl-5">
                                <select class="w-100 px-2 py-1" disabled>
                                    <option>No managers available. Please add managers first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add managers before submitting the form.</small>
                            </div>
                            @endif
                        </div>
                        @endisset --}}
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

<script src="{{asset('/assets/js/marathi-validate-fields.js')}}"></script>
