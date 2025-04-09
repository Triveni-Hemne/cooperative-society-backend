<div class="modal fade" id="designationModal" tabindex="-1" aria-labelledby="designationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('designations.store')}}" id="designationForm">
                <input type="hidden" id="designationId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="designationModalLabel">Add Branch</h1>
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
                                <label for="name">Branch Code</label>
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
                                <label for="name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="name" id="name" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Name">
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

                         @isset($employees) 
                        @if ($employees->isNotEmpty())
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="managerId">Manager</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="manager_id" id="userId"  class="w-100 px-2 py-1 @error('manager_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"  
                                        {{ old('manager_id') == $employee->id ? 'selected' : '' }}
                                        >
                                        {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('manager_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
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

<script src="{{asset('/assets/js/marathi-validate-fields.js')}}"></script>
