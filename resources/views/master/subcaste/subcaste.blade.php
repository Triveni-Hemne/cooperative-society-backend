<div class="modal fade" id="subcasteModal" tabindex="-1" aria-labelledby="subcasteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('subcastes.store')}}" id="subcasteForm">
                <input type="hidden" id="subcasteId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="subcasteModalLabel">Add SubCaste</h1>
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
                                <label for="Name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="name" id="Name" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Name" required>
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
