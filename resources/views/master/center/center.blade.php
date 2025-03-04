<div class="modal fade" id="centerModal" tabindex="-1" aria-labelledby="centerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('centers.store')}}" id="centerForm">
                <input type="hidden" id="centerId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="centerModalLabel">Add Center</h1>
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
                                <input name="naav" id="marathiName" class="w-100 px-2 py-1 @error('naav') is-invalid @enderror marathiField" type="text"  value="{{ old('naav') }}" placeholder="नाव">
                                @error('naav')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="address">Address</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea name="address" id="address" placeholder="Address" class="w-100 px-2 py-1 @error('address') is-invalid @enderror"  rows="3"
                                    style="resize:none">{{ old('address') }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="marathiAddress">पत्ता</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea name="marathi_address" id="marathiAddress" placeholder="पत्ता" class="w-100 px-2 py-1 @error('marathi_address') is-invalid @enderror marathiField"  rows="3"
                                    style="resize:none">{{ old('marathi_address') }}</textarea>
                                    @error('marathi_address')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="division_id">Taluka/Division</label>
                            </div>
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
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="subdivision_id">Sub Division</label>
                            </div>
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
                        </div>
                         <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="description">Description</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea name="description" id="description" placeholder="description" class="w-100 px-2 py-1 @error('description') is-invalid @enderror"  rows="3"
                                    style="resize:none">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                        </div>
                         <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="marathi_description">वर्णन</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea name="marathi_description" id="marathiDescription" placeholder="वर्णन" class="w-100 px-2 py-1 @error('marathi_description') is-invalid @enderror  marathiField"  rows="3"
                                    style="resize:none">{{ old('marathi_description') }}</textarea>
                                    @error('marathi_description')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                            </div>
                        </div>
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
