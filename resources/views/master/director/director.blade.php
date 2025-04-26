<div class="modal fade" id="directorModal" tabindex="-1" aria-labelledby="directorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('directors.store')}}" id="directorsForm">
                <input type="hidden" id="directorId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="directorModalLabel">Add Director</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mx-auto p-5 my-model text-white">
                        {{-- @isset($members) --}}
                        @if ($members->isNotEmpty())
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="memberId">Member</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="member_id" id="memberId"
                                    class="w-100 px-2 py-1 @error('member_id') is-invalid @enderror">
                                    <option value="" disabled {{ old('member_id') ? '' : 'selected' }}>---------- Select ----------</option>
                                    @foreach ($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- @endif --}}
                        @else
                        <select class="w-100 px-2 py-1" disabled>
                            <option>No members available. Please add members first.</option>
                        </select>
                        <small class="text-danger">⚠️ You must add members before submitting the form.</small>
                        @endif
                        {{-- @endisset --}}

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="name" name="name" class="w-100 px-2 py-1 @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" type="text" placeholder="Name" required>
                                @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        @isset($designations)
                        @if ($designations->isNotEmpty())
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="designationId">Designation</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="designation_id" id="designationId"
                                    class="w-100 px-2 py-1 @error('designation_id') is-invalid @enderror">
                                    <option value="" disabled {{ old('member_id') ? '' : 'selected' }}>---------- Select ----------</option>
                                    @foreach ($designations as $designation)
                                    <option value="{{ $designation->id }}"
                                        {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @endisset

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="email">Email</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="email" id="email"
                                    class="w-100 px-2 py-1 @error('email') is-invalid @enderror" type="email"
                                    placeholder="Email" value="{{ old('email') }}">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="mob0">Mobile No.</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="contact_nos[]" id="mob0"
                                    class="w-100 px-2 py-1 @error('contact_nos.0') is-invalid @enderror" type="number"
                                    placeholder="Mobile No." value="{{ old('contact_nos.0') }}">
                                @error('contact_nos.0') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="mob1">Mobile No.</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="contact_nos[]" id="mob1"
                                    class="w-100 px-2 py-1 @error('contact_nos.1') is-invalid @enderror" type="number"
                                    placeholder="Mobile No." value="{{ old('contact_nos.1') }}">
                                @error('contact_nos.1') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-xl-4 g-1">
                            <div class="col w-auto ps-0 ps-xl-5">
                                <label for="fromDate">From Date</label>
                            </div>
                            <div class="col mb-3 mb-xl-0 ms-0 ms-xl-3">
                                <input id="fromDate" name="from_date"
                                    class="w-100 px-2 py-1 @error('from_date') is-invalid @enderror" type="date"
                                    value="{{ old('from_date') }}" required>
                                @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col w-auto ms-0 ms-xl-5">
                                <label for="toDate">End Date</label>
                            </div>
                            <div class="col ms-0 ms-xl-3">
                                <input id="toDate" name="to_date"
                                    class="w-100 px-2 py-1 @error('to_date') is-invalid @enderror" type="date"
                                    value="{{ old('to_date') }}">
                                @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
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








