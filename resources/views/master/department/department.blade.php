<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('departments.store')}}" id="departmentForm">
                 @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                <input type="hidden" id="departmentId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="departmentModalLabel">Add Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="mx-auto p-5 my-model text-white">
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

                         @isset($employees)
                         <div class="row mb-3">
                             <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="headId">Head of Department</label>
                                </div>
                                @if ($employees->isNotEmpty())
                            <div class="col pe-0 pe-xl-5">
                                <select name="head_id" id="headId"  class="w-100 px-2 py-1 @error('head_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"  
                                        {{ old('head_id') == $employee->id ? 'selected' : '' }}
                                        >
                                        {{ $employee->member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                  @error('head_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @else
                            <div class="col pe-0 pe-xl-5">
                                <select class="w-100 px-2 py-1" disabled>
                                    <option>No head of department available. Please add members as head of department first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add head of department before submitting the form.</small>
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

<script src="{{asset('/assets/js/marathi-validate-fields.js')}}"></script>
