<div class="modal fade" id="designationModal" tabindex="-1" aria-labelledby="designationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('designations.store')}}" id="designationForm">
                <input type="hidden" id="designationId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="designationModalLabel">Add Designation</h1>
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
                                <label for="marathiName">नाव</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="naav" id="marathiName" class="w-100 px-2 py-1 @error('naav') is-invalid @enderror marathiField" value="{{ old('naav') }}" type="text" placeholder="नाव">
                                @error('naav')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                            </div>
                        </div>

                       @isset($divisions) 
                       <div class="row mb-3">
                           <div class="col-2 ps-5 d-none d-xl-block">
                               <label for="division_id">Taluka/Division</label>
                            </div>
                        @if ($divisions->isNotEmpty())
                            <div class="col pe-0 pe-xl-5">
                                <select name="division_id" id="division_id"  class="w-100 px-2 py-1 @error('division_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"  
                                        {{ old('division_id') == $division->id ? 'selected' : '' }}
                                        >
                                        {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                           @else
                            <div class="col pe-0 pe-xl-5">
                                <select class="w-100 px-2 py-1" disabled>
                                    <option>No divisions available. Please add divisions first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add divisions before submitting the form.</small>
                            </div>
                            @endif
                        </div>
                       @endisset
                        @isset($subdivisions) 
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="subdivision_id">Sub Division</label>
                            </div>
                            @if ($subdivisions->isNotEmpty())
                            <div class="col pe-0 pe-xl-5">
                                <select name="subdivision_id" id="subdivision_id" class="w-100 px-2 py-1 @error('subdivision_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($subdivisions as $subdivision)
                                        <option value="{{ $subdivision->id }}" 
                                        {{ old('subdivision_id') == $subdivision->id ? 'selected' : '' }}
                                        >
                                        {{ $subdivision->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                             @else
                             <div class="col pe-0 pe-xl-5">
                                <select class="w-100 px-2 py-1" disabled>
                                    <option>No sub-divisions available. Please add sub-divisions first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add sub-divisions before submitting the form.</small>
                            </div>
                            @endif
                        </div>
                        @endisset
                        @isset($centers) 
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="center_id">Center</label>
                            </div>
                         @if ($centers->isNotEmpty())
                            <div class="col pe-0 pe-xl-5">
                                <select name="center_id" id="center_id" class="w-100 px-2 py-1 @error('center_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}" 
                                        {{ old('center_id') == $center->id ? 'selected' : '' }}
                                        >
                                        {{ $center->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                             <div class="col pe-0 pe-xl-5">
                                <select class="w-100 px-2 py-1" disabled>
                                    <option>No centers available. Please add centers first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add centers before submitting the form.</small>
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
