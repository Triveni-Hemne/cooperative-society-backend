<div class="modal fade" id="subDivisionModal" tabindex="-1" aria-labelledby="subDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('sub-divisions.store')}}" id="subDivisionForm">
                    <input type="hidden" id="subDivisionId" name="id">
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif 
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="subDivisionModalLabel">Add Sub-Division</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-3 row-cols-xl-4 g-3">
                            <div class="col w-auto ps-2 ps-xl-5 d-none d-xl-block">
                                {{-- <label for="id">ID</label> --}}
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                {{-- <input id="id" name="id" class="w-100 px-2 py-1" type="text" placeholder="ID" disabled> --}}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="name" name="name" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Name">
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

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="address">Address</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea id="address" name="address" placeholder="Address" class="w-100 px-2 py-1 @error('address') is-invalid @enderror" rows="3"
                                    style="resize:none">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="marathiAddress">पत्ता</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea id="marathiAddress" name="marathi_address" placeholder="पत्ता" class="w-100 px-2 py-1 marathiField @error('marathi_address') is-invalid @enderror" rows="3"
                                    style="resize:none">{{ old('marathi_address') }}</textarea>
                                    @error('marathi_address')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                            </div>
                        </div>
                        @isset($divisions)
                          @if ($divisions->isNotEmpty())
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="taluka">Taluka/Division</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="division_id" name="division_id" class="w-100 px-2 py-1 @error('division_id') is-invalid @enderror">
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
                        @endif
                        @endisset
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="description">Description</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea name="description" id="description" placeholder="Description" class="w-100 px-2 py-1 @error('description') is-invalid @enderror" rows="3"
                                    style="resize:none">{{old('description')}}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="marathiDescription">वर्णन</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea name="marathi_description" id="marathiDescription" placeholder="वर्णन" class="w-100 px-2 py-1 @error('marathi_description') is-invalid @enderror marathiField"  rows="3"
                                    style="resize:none"> {{ old('marathi_description') }} </textarea>
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
