<div class="modal fade" id="memberModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="memberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" enctype="multipart/form-data" action="{{ route('members.store') }}" id="memberForm">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif
                <input type="hidden" id="memberId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-info text-white rounded-top-4 border-0">
                    <h1 class="modal-title fs-5 fw-bold" id="memberModalLabel">
                        <i class="bi bi-person-plus me-2"></i> Add Member
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="bg-white rounded shadow-sm p-4">
                        @isset($departments)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="department_id" id="departmentId"
                                        class="form-select @error('department_id') is-invalid @enderror"
                                        aria-label="Department">
                                        <option value="" selected>--- Select Department ---</option>
                                        @if ($departments->isNotEmpty())
                                        @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                        @endforeach
                                        @else
                                        <option disabled>No departments available. Please add departments
                                            first.
                                        </option>
                                        @endif
                                    </select>
                                    <label for="departmentId" class="form-label">Department</label>
                                    @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($departments->isEmpty())
                                    <small class="text-danger">⚠️ You must add departments before submitting the
                                        form.</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="created_by" id="createdBy" class="form-control"
                                        value="{{ $user->name }}" type="text" placeholder="Created By" disabled>
                                    <label for="createdBy" class="form-label">Created By</label>
                                </div>
                            </div>
                        </div>
                        @endisset

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" type="text" placeholder="Name" required>
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input id="marathiName" name="naav"
                                        class="form-control @error('naav') is-invalid @enderror marathiField"
                                        value="{{ old('naav') }}" type="text" placeholder="नाव">
                                    <label for="marathiName" class="form-label">नाव</label>
                                    @error('naav')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <p class="errorMsg text-danger" style="display:none;">फक्त मराठी अक्षरे स्वीकारली
                                        जातील.</p>
                                </div>
                            </div>
                        </div>

                        <div class="info-tabs border rounded mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info" id="personal-tab"
                                        data-bs-toggle="tab" data-bs-target="#personal-tab-pane" type="button"
                                        role="tab" aria-controls="personal-tab-pane" aria-selected="true">Personal
                                        Details
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="nominee-tab" data-bs-toggle="tab"
                                        data-bs-target="#nominee-tab-pane" type="button" role="tab"
                                        aria-controls="nominee-tab-pane" aria-selected="false">Nominee Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="bank-tab" data-bs-toggle="tab"
                                        data-bs-target="#bank-tab-pane" type="button" role="tab"
                                        aria-controls="bank-tab-pane" aria-selected="false">Bank Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="department-tab" data-bs-toggle="tab"
                                        data-bs-target="#department-tab-pane" type="button" role="tab"
                                        aria-controls="department-tab-pane" aria-selected="false">Department
                                        Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="share-tab" data-bs-toggle="tab"
                                        data-bs-target="#share-tab-pane" type="button" role="tab"
                                        aria-controls="share-tab-pane" aria-selected="false">Share Detail
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active p-3" id="personal-tab-pane" role="tabpanel"
                                    aria-labelledby="personal-tab" tabindex="0">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <textarea name="address" id="address"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    placeholder="Address"
                                                    style="height: 100px">{{ old('address') }}</textarea>
                                                <label for="address" class="form-label">Address</label>
                                                @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <textarea name="marathi_address" id="marathiAddress"
                                                    class="form-control @error('marathi_address') is-invalid @enderror marathiField"
                                                    placeholder="पत्ता"
                                                    style="height: 100px; resize:none">{{ old('marathi_address') }}</textarea>
                                                <label for="marathiAddress" class="form-label">पत्ता</label>
                                                @error('marathi_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <p class="errorMsg text-danger" style="display:none;">फक्त मराठी अक्षरे
                                                    स्वीकारली जातील.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="city" id="city"
                                                    class="form-control @error('city') is-invalid @enderror"
                                                    value="{{ old('city') }}" type="text" placeholder="City">
                                                <label for="city" class="form-label">City</label>
                                                @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="mobile_no" id="mobileNo"
                                                    class="form-control @error('mobile_no') is-invalid @enderror"
                                                    value="{{ old('mobile_no') }}" type="text" placeholder="Mobile No."
                                                    pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number">
                                                <label for="mobileNo" class="form-label">Mobile No.</label>
                                                @error('mobile_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="phone_no" id="phoneNo"
                                                    class="form-control @error('phone_no') is-invalid @enderror"
                                                    value="{{ old('phone_no') }}" type="tel" placeholder="Phone no">
                                                <label for="phoneNo" class="form-label">Phone No.</label>
                                                @error('phone_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select name="gender" id="gender"
                                                    class="form-select @error('gender') is-invalid @enderror">
                                                    <option value="Male"
                                                        {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                                        Male
                                                    </option>
                                                    <option value="Female"
                                                        {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                    <option value="Other"
                                                        {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                <label for="gender" class="form-label">Gender</label>
                                                @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="dob" id="dob"
                                                    class="form-control @error('dob') is-invalid @enderror"
                                                    value="{{ old('dob') }}" type="date" placeholder="DOB">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                @error('dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="age" id="age"
                                                    class="form-control @error('age') is-invalid @enderror"
                                                    value="{{ old('age') }}" type="number" placeholder="Age">
                                                <label for="age" class="form-label">Age</label>
                                                @error('age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="date_of_joining" id="dateOfJoining"
                                                    class="form-control @error('date_of_joining') is-invalid @enderror"
                                                    type="date" placeholder="Date of Joining"
                                                    value="{{ old('date_of_joining') }}">
                                                <label for="dateOfJoining" class="form-label">Date of Joining</label>
                                                @error('date_of_joining')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="m_reg_no" id="MRegNo"
                                                    class="form-control @error('m_reg_no') is-invalid @enderror"
                                                    value="{{ old('m_reg_no') }}" type="number"
                                                    placeholder="M. Reg. No.">
                                                <label for="MRegNo" class="form-label">M. Reg. No.</label>
                                                @error('m_reg_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select name="caste" id="caste"
                                                    class="form-select @error('caste') is-invalid @enderror">
                                                    <option value="" selected>--- Select Caste ---</option>
                                                    <option value="mahar"
                                                        {{ old('caste') == 'mahar' ? 'selected' : '' }}>
                                                        Mahar
                                                    </option>
                                                    <option value="kunbi"
                                                        {{ old('caste') == 'kunbi' ? 'selected' : '' }}>
                                                        Kunbi
                                                    </option>
                                                    <option value="kalar"
                                                        {{ old('caste') == 'kalar' ? 'selected' : '' }}>
                                                        Kalar
                                                    </option>
                                                    <option value="other"
                                                        {{ old('caste') == 'other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                <label for="caste" class="form-label">Caste</label>
                                                @error('caste')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select name="religion" id="religion"
                                                    class="form-select @error('religion') is-invalid @enderror">
                                                    <option value="" selected>--- Select Religion ---</option>
                                                    <option value="hindu"
                                                        {{ old('religion') == 'hindu' ? 'selected' : '' }}>
                                                        Hindu
                                                    </option>
                                                    <option value="muslim"
                                                        {{ old('religion') == 'muslim' ? 'selected' : '' }}>
                                                        Muslim
                                                    </option>
                                                    <option value="sikh"
                                                        {{ old('religion') == 'sikh' ? 'selected' : '' }}>
                                                        Sikh
                                                    </option>
                                                    <option value="other"
                                                        {{ old('religion') == 'other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                <label for="religion" class="form-label">Religion</label>
                                                @error('religion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select name="category" id="category"
                                                    class="form-select @error('category') is-invalid @enderror">
                                                    <option value="" selected>--- Select Category ---</option>
                                                    <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>
                                                        SC
                                                    </option>
                                                    <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>
                                                        ST
                                                    </option>
                                                    <option value="OBC"
                                                        {{ old('category') == 'OBC' ? 'selected' : '' }}>
                                                        OBC
                                                    </option>
                                                    <option value="General"
                                                        {{ old('category') == 'General' ? 'selected' : '' }}>
                                                        General
                                                    </option>
                                                    <option value="NT" {{ old('category') == 'NT' ? 'selected' : '' }}>
                                                        NT
                                                    </option>
                                                    <option value="Other"
                                                        {{ old('category') == 'Other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                <label for="category" class="form-label">Category</label>
                                                @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @isset($subcates)
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select name="subcaste_id" id="subcasteId"
                                                    class="form-select @error('subcaste_id') is-invalid @enderror">
                                                    <option value="" selected>--- Select Sub Caste ---</option>
                                                    @if ($subcates->isNotEmpty())
                                                    @foreach ($subcates as $subcate)
                                                    <option value="{{ $subcate->id }}"
                                                        {{ old('subcaste_id') == $subcate->id ? 'selected' : '' }}>
                                                        {{ $subcate->name }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option disabled>No sub-castes available. Please add
                                                        sub-castes first.
                                                    </option>
                                                    @endif
                                                </select>
                                                <label for="subcasteId" class="form-label">Sub Caste</label>
                                                @error('subcaste_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($subcates->isEmpty())
                                                <small class="text-danger">⚠️ You must add sub-castes before
                                                    submitting the form.</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endisset
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="pan_no" id="panNo"
                                                    class="form-control @error('pan_no') is-invalid @enderror"
                                                    value="{{ old('pan_no') }}" type="text" placeholder="Pan No.">
                                                <label for="panNo" class="form-label">Pan No.</label>
                                                @error('pan_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="adhar_no" id="adharNo"
                                                    class="form-control @error('adhar_no') is-invalid @enderror"
                                                    value="{{ old('adhar_no') }}" type="number"
                                                    placeholder="Aadhar No.">
                                                <label for="adharNo" class="form-label">Aadhar No.</label>
                                                @error('adhar_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-3" id="nominee-tab-pane" role="tabpanel"
                                    aria-labelledby="nominee-tab" tabindex="0">
                                    @isset($members)
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="nominee_id" id="nomineeId"
                                                    class="form-select @error('nominee_id') is-invalid @enderror"
                                                    aria-label="Nominee Member">
                                                    <option value="" selected>--- Select Member ---</option>
                                                    @if ($members->isNotEmpty())
                                                    @foreach ($members as $member)
                                                    <option value="{{ $member->id }}"
                                                        {{ old('nominee_id') == $member->id ? 'selected' : '' }}>
                                                        {{ $member->name }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option disabled>No members available.</option>
                                                    @endif
                                                </select>
                                                <label for="nomineeId" class="form-label">Member (Nominee)</label>
                                                @error('nominee_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($members->isEmpty())
                                                <small class="text-danger">⚠️ You must add members before
                                                    submitting the form.</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endisset
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="nominee_name" id="nomineeName"
                                                    class="form-control @error('nominee_name') is-invalid @enderror"
                                                    value="{{ old('nominee_name') }}" type="text"
                                                    placeholder="Nominee Name">
                                                <label for="nomineeName" class="form-label">Name</label>
                                                @error('nominee_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="nominee_naav" id="marathiNomineeName"
                                                    class="form-control @error('nominee_naav') is-invalid @enderror marathiField"
                                                    value="{{ old('nominee_naav') }}" type="text" placeholder="नाव">
                                                <label for="marathiNomineeName" class="form-label">नाव</label>
                                                @error('nominee_naav')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <p class="errorMsg text-danger" style="display:none;">फक्त मराठी अक्षरे
                                                    स्वीकारली जातील.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <textarea name="nominee_address" id="nomineeAddress"
                                                    class="form-control @error('nominee_address') is-invalid @enderror"
                                                    placeholder="Nominee Address"
                                                    style="height: 100px; resize:none">{{ old('nominee_address') }}</textarea>
                                                <label for="nomineeAddress" class="form-label">Address</label>
                                                @error('nominee_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <textarea name="nominee_marathi_address" id="nomineeMarathiAddress"
                                                    class="form-control @error('nominee_marathi_address') is-invalid @enderror marathiField"
                                                    placeholder="पत्ता"
                                                    style="height: 100px; resize:none">{{ old('nominee_marathi_address') }}</textarea>
                                                <label for="nomineeMarathiAddress" class="form-label">पत्ता</label>
                                                @error('nominee_marathi_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <p class="errorMsg text-danger" style="display:none;">फक्त मराठी अक्षरे
                                                    स्वीकारली जातील.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="nominee_age" id="nomineeAge"
                                                    class="form-control @error('nominee_age') is-invalid @enderror"
                                                    value="{{ old('nominee_age') }}" type="number"
                                                    placeholder="Nominee Age">
                                                <label for="nomineeAge" class="form-label">Age</label>
                                                @error('nominee_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select name="nominee_gender" id="nomineeGender"
                                                    class="form-select @error('nominee_gender') is-invalid @enderror">
                                                    <option value="" selected>--- Select Gender ---</option>
                                                    <option value="Male"
                                                        {{ old('nominee_gender') == 'Male' ? 'selected' : '' }}>
                                                        Male
                                                    </option>
                                                    <option value="Female"
                                                        {{ old('nominee_gender') == 'Female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                    <option value="Other"
                                                        {{ old('nominee_gender') == 'Other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                <label for="nomineeGender" class="form-label">Gender</label>
                                                @error('nominee_gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select name="relation" id="nomineeRelation"
                                                    class="form-select @error('relation') is-invalid @enderror">
                                                    <option value="" selected>--- Select Relation ---</option>
                                                    <option value="husband"
                                                        {{ old('relation') == 'husband' ? 'selected' : '' }}>
                                                        Husband
                                                    </option>
                                                    <option value="wife"
                                                        {{ old('relation') == 'wife' ? 'selected' : '' }}>
                                                        Wife
                                                    </option>
                                                    <option value="daughter"
                                                        {{ old('relation') == 'daughter' ? 'selected' : '' }}>
                                                        Daughter
                                                    </option>
                                                    <option value="son"
                                                        {{ old('relation') == 'son' ? 'selected' : '' }}>
                                                        Son
                                                    </option>
                                                    <option value="sister"
                                                        {{ old('relation') == 'sister' ? 'selected' : '' }}>
                                                        Sister
                                                    </option>
                                                    <option value="brother"
                                                        {{ old('relation') == 'brother' ? 'selected' : '' }}>
                                                        Brother
                                                    </option>
                                                    <option value="other"
                                                        {{ old('relation') == 'other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                <label for="nomineeRelation" class="form-label">Relation</label>
                                                @error('relation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="nominee_adhar_no" id="nomineeAdharNo"
                                                    class="form-control @error('nominee_adhar_no') is-invalid @enderror"
                                                    value="{{ old('nominee_adhar_no') }}" type="number"
                                                    placeholder="Nominee Aadhar No.">
                                                <label for="nomineeAdharNo" class="form-label">Aadhar No.</label>
                                                @error('nominee_adhar_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nomineeImage" class="form-label">Nominee Photo</label>
                                            <input name="nominee_image" id="nomineeImage"
                                                class="form-control @error('nominee_image') is-invalid @enderror"
                                                value="{{ old('nominee_image') }}" type="file" accept="image/*"
                                                placeholder="Nominee Photo">
                                            @error('nominee_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-3" id="bank-tab-pane" role="tabpanel"
                                    aria-labelledby="bank-tab" tabindex="0">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="bank_name" id="bankName"
                                                    class="form-control @error('bank_name') is-invalid @enderror"
                                                    value="{{ old('bank_name') }}" type="text" placeholder="Bank Name">
                                                <label for="bankName" class="form-label">Bank Name</label>
                                                @error('bank_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="branch_name" id="branchName"
                                                    class="form-control @error('branch_name') is-invalid @enderror"
                                                    value="{{ old('branch_name') }}" type="text"
                                                    placeholder="Branch Name">
                                                <label for="branchName" class="form-label">Branch Name</label>
                                                @error('branch_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="bank_account_no" id="bankAccountNo"
                                                    class="form-control @error('bank_account_no') is-invalid @enderror"
                                                    value="{{ old('bank_account_no') }}" type="text"
                                                    placeholder="Account No.">
                                                <label for="bankAccountNo" class="form-label">Account No.</label>
                                                @error('bank_account_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="ifsc_code" id="ifscCode"
                                                    class="form-control @error('ifsc_code') is-invalid @enderror"
                                                    value="{{ old('ifsc_code') }}" type="text" placeholder="IFSC Code">
                                                <label for="ifscCode" class="form-label">IFSC Code</label>
                                                @error('ifsc_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="proof_1_type" id="proof1Type"
                                                    class="form-select @error('proof_1_type') is-invalid @enderror">
                                                    <option value="" selected>--- Select Proof 1 Type ---</option>
                                                    <option value="aadhar"
                                                        {{ old('proof_1_type') == 'aadhar' ? 'selected' : '' }}>
                                                        Aadhar Card
                                                    </option>
                                                    <option value="pan"
                                                        {{ old('proof_1_type') == 'pan' ? 'selected' : '' }}>
                                                        PAN Card
                                                    </option>
                                                    <option value="vote"
                                                        {{ old('proof_1_type') == 'vote' ? 'selected' : '' }}>
                                                        Voting Card
                                                    </option>
                                                    <option value="other"
                                                        {{ old('proof_1_type') == 'other' ? 'selected' : '' }}>
                                                        Other
                                                        </< /select>
                                                        <label for="proof1Type" class="form-label">Proof 1 Type</label>
                                                        @error('proof_1_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="proof_1_no" id="proof1No"
                                                    class="form-control @error('proof_1_no') is-invalid @enderror"
                                                    value="{{ old('proof_1_no') }}" type="text"
                                                    placeholder="Proof 1 No.">
                                                <label for="proof1No" class="form-label">Proof 1 No.</label>
                                                @error('proof_1_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="proof1Image" class="form-label">Proof 1 Copy</label>
                                            <input name="proof_1_image" id="proof1Image"
                                                class="form-control @error('proof_1_image') is-invalid @enderror"
                                                value="{{ old('proof_1_image') }}" type="file" accept="image/*,.pdf"
                                                placeholder="Proof 1 Copy">
                                            @error('proof_1_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="proof_2_type" id="proof2Type"
                                                    class="form-select @error('proof_2_type') is-invalid @enderror">
                                                    <option value="" selected>--- Select Proof 2 Type ---</option>
                                                    <option value="aadhar"
                                                        {{ old('proof_2_type') == 'aadhar' ? 'selected' : '' }}>
                                                        Aadhar Card
                                                    </option>
                                                    <option value="pan"
                                                        {{ old('proof_2_type') == 'pan' ? 'selected' : '' }}>
                                                        PAN Card
                                                    </option>
                                                    <option value="vote"
                                                        {{ old('proof_2_type') == 'vote' ? 'selected' : '' }}>
                                                        Voting Card
                                                    </option>
                                                    <option value="other"
                                                        {{ old('proof_2_type') == 'other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                <label for="proof2Type" class="form-label">Proof 2 Type</label>
                                                @error('proof_2_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="proof_2_no" id="proof2No"
                                                    class="form-control @error('proof_2_no') is-invalid @enderror"
                                                    value="{{ old('proof_2_no') }}" type="text"
                                                    placeholder="Proof 2 No.">
                                                <label for="proof2No" class="form-label">Proof 2 No.</label>
                                                @error('proof_2_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="proof2Image" class="form-label">Proof 2 Copy</label>
                                            <input name="proof_2_image" id="proof2Image"
                                                class="form-control @error('proof_2_image') is-invalid @enderror"
                                                value="{{ old('proof_2_image') }}" type="file" accept="image/*,.pdf"
                                                placeholder="Proof 2 Copy">
                                            @error('proof_2_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-3" id="department-tab-pane" role="tabpanel"
                                    aria-labelledby="department-tab" tabindex="0">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="emp_code" id="empCode"
                                                    class="form-control @error('emp_code') is-invalid @enderror"
                                                    value="{{ old('emp_code') }}" type="text" placeholder="Emp Code">
                                                <label for="empCode" class="form-label">Emp Code</label>
                                                @error('emp_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @isset($designations)
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="designation_id" id="designationId"
                                                    class="form-select @error('designation_id') is-invalid @enderror">
                                                    <option value="" selected>--- Select Designation ---</option>
                                                    @if ($designations->isNotEmpty())
                                                    @foreach ($designations as $designation)
                                                    <option value="{{ $designation->id }}"
                                                        {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                        {{ $designation->name }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option disabled>No designations available. Please add
                                                        designations first.
                                                    </option>
                                                    @endif
                                                </select>
                                                <label for="designationId" class="form-label">Designation</label>
                                                @error('designation_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($designations->isEmpty())
                                                <small class="text-danger">⚠️ You must add designations before
                                                    submitting the form.</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endisset
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="salary" id="salary"
                                                    class="form-control @error('salary') is-invalid @enderror"
                                                    value="{{ old('salary') }}" type="number" placeholder="Salary">
                                                <label for="salary" class="form-label">Salary</label>
                                                @error('salary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="other_allowance" id="otherAllowance"
                                                    class="form-control @error('other_allowance') is-invalid @enderror"
                                                    value="{{ old('other_allowance') }}" type="text"
                                                    placeholder="Other Allowance">
                                                <label for="otherAllowance" class="form-label">Other Allowance</label>
                                                @error('other_allowance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        @isset($divisions)
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                {{-- <select name="division_id" id="divisionId"
                                                    class="form-select @error('division_id') is-invalid @enderror">
                                                    <option value="" selected>--- Select Division ---</option>
                                                    @if (<span class="math-inline">divisions\-\>isNotEmpty\(\)\)
                                                        @foreach \(</span>divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                {{ $division->name }}
                                                </option>
                                                @endforeach
                                                @else
                                                <option disabled>No divisions available. Please add
                                                    divisions first.
                                                </option>
                                                @endif
                                                </select> --}}
                                                <label for="divisionId" class="form-label">Division</label>
                                                @error('division_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($divisions->isEmpty())
                                                <small class="text-danger">⚠️ You must add divisions before
                                                    submitting the form.</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endisset
                                        @isset($subdivisions)
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="subdivision_id" id="subdivisionId"
                                                    class="form-select @error('subdivision_id') is-invalid @enderror">
                                                    <option value="" selected>--- Select Sub Division ---</option>
                                                    @if ($subdivisions->isNotEmpty())
                                                    @foreach ($subdivisions as $subdivision)
                                                    <option value="{{ $subdivision->id }}"
                                                        {{ old('subdivision_id') == $subdivision->id ? 'selected' : '' }}>
                                                        {{ $subdivision->name }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option disabled>No subdivisions available. Please add
                                                        subdivisions first.
                                                    </option>
                                                    @endif
                                                </select>
                                                <label for="subdivisionId" class="form-label">Sub Division</label>
                                                @error('subdivision_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($subdivisions->isEmpty())
                                                <small class="text-danger">⚠️ You must add subdivisions before
                                                    submitting the form.</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endisset
                                    </div>
                                    <div class="row mb-3">
                                        @isset($centers)
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="center_id" id="centerId"
                                                    class="form-select @error('center_id') is-invalid @enderror">
                                                    <option value="" selected>--- Select Center ---</option>
                                                    @if ($centers->isNotEmpty())
                                                    @foreach ($centers as $center)
                                                    <option value="{{ $center->id }}"
                                                        {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                                        {{ $center->name }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option disabled>No centers available. Please add centers
                                                        first.
                                                    </option>
                                                    @endif
                                                </select>
                                                <label for="centerId" class="form-label">Center</label>
                                                @error('center_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($centers->isEmpty())
                                                <small class="text-danger">⚠️ You must add centers before
                                                    submitting the form.</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endisset
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="joining_date" id="joiningDate"
                                                    class="form-control @error('joining_date') is-invalid @enderror"
                                                    value="{{ old('joining_date') }}" type="date"
                                                    placeholder="Date of Joining">
                                                <label for="joiningDate" class="form-label">Date of Joining</label>
                                                @error('joining_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="transfer_date" id="transferDate"
                                                    class="form-control @error('transfer_date') is-invalid @enderror"
                                                    value="{{ old('transfer_date') }}" type="date"
                                                    placeholder="Transfer Date">
                                                <label for="transferDate" class="form-label">Transfer Date</label>
                                                @error('transfer_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="retirement_date" id="retirementDate"
                                                    class="form-control @error('retirement_date') is-invalid @enderror"
                                                    value="{{ old('retirement_date') }}" type="date"
                                                    placeholder="Retirement Date">
                                                <label for="retirementDate" class="form-label">Retirement Date</label>
                                                @error('retirement_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="gpf_no" id="gpfNo"
                                                    class="form-control @error('gpf_no') is-invalid @enderror"
                                                    value="{{ old('gpf_no') }}" type="text" placeholder="GPF No.">
                                                <label for="gpfNo" class="form-label">GPF No.</label>
                                                @error('gpf_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="hra" id="hra"
                                                    class="form-control @error('hra') is-invalid @enderror"
                                                    value="{{ old('hra') }}" type="number" placeholder="HRA">
                                                <label for="hra" class="form-label">HRA</label>
                                                @error('hra')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="da" id="da"
                                                    class="form-control @error('da') is-invalid @enderror"
                                                    value="{{ old('da') }}" type="number" placeholder="DA">
                                                <label for="da" class="form-label">DA</label>
                                                @error('da')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-3" id="share-tab-pane" role="tabpanel"
                                    aria-labelledby="share-tab" tabindex="0">
                                    <div class="row mb-3">
                                        @isset($directors)
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="director_id" id="directorId"
                                                    class="form-select @error('director_id') is-invalid @enderror">
                                                    <option value="" selected>--- Select Director ---</option>
                                                    @if ($directors->isNotEmpty())
                                                    @foreach ($directors as $director)
                                                    <option value="{{ $director->id }}"
                                                        {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                                        {{ $director->name }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option disabled>No directors available. Please add
                                                        directors first.
                                                    </option>
                                                    @endif
                                                </select>
                                                <label for="directorId" class="form-label">Director</label>
                                                @error('director_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($directors->isEmpty())
                                                <small class="text-danger">⚠️ You must add directors before
                                                    submitting the form.</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endisset
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="page_no" id="pageNo"
                                                    class="form-control @error('page_no') is-invalid @enderror"
                                                    value="{{ old('page_no') }}" type="number" placeholder="Page No.">
                                                <label for="pageNo" class="form-label">Page No.</label>
                                                @error('page_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="division_no" id="divisionNo"
                                                    class="form-control @error('division_no') is-invalid @enderror"
                                                    value="{{ old('division_no') }}" type="text"
                                                    placeholder="Division No.">
                                                <label for="divisionNo" class="form-label">Division No.</label>
                                                @error('division_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="share_amount" id="shareAmount"
                                                    class="form-control @error('share_amount') is-invalid @enderror"
                                                    value="{{ old('share_amount') }}" type="number"
                                                    placeholder="Share Amount">
                                                <label for="shareAmount" class="form-label">Share Amount</label>
                                                @error('share_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="share_certificate_no" id="shareCertificateNo"
                                                    class="form-control @error('share_certificate_no') is-invalid @enderror"
                                                    value="{{ old('share_certificate_no') }}" type="text"
                                                    placeholder="Share Certificate No.">
                                                <label for="shareCertificateNo" class="form-label">Share Certificate
                                                    No.</label>
                                                @error('share_certificate_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="voucher_no" id="voucherNo"
                                                    class="form-control @error('voucher_no') is-invalid @enderror"
                                                    value="{{ old('voucher_no') }}" type="text"
                                                    placeholder="Voucher No.">
                                                <label for="voucherNo" class="form-label">Voucher No.</label>
                                                @error('voucher_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="admission_fees" id="admissionFees"
                                                    class="form-control @error('admission_fees') is-invalid @enderror"
                                                    value="{{ old('admission_fees') }}" type="number"
                                                    placeholder="Admission Fees">
                                                <label for="admissionFees" class="form-label">Admission Fees</label>
                                                @error('admission_fees')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="share_date" id="shareDate"
                                                    class="form-control @error('share_date') is-invalid @enderror"
                                                    value="{{ old('share_date') }}" type="date"
                                                    placeholder="Share Date">
                                                <label for="shareDate" class="form-label">Share Date</label>
                                                @error('share_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const memberModal = document.getElementById('memberModal');
    if (memberModal) {
        memberModal.addEventListener('show.bs.modal', event => {
            const relatedTarget = event.relatedTarget;
            const id = relatedTarget.getAttribute('data-bs-id');
            const departmentId = relatedTarget.getAttribute('data-bs-department_id');
            const name = relatedTarget.getAttribute('data-bs-name');
            const naav = relatedTarget.getAttribute('data-bs-naav');
            const address = relatedTarget.getAttribute('data-bs-address');
            const marathiAddress = relatedTarget.getAttribute('data-bs-marathi_address');
            const city = relatedTarget.getAttribute('data-bs-city');
            const mobileNo = relatedTarget.getAttribute('data-bs-mobile_no');
            const phoneNo = relatedTarget.getAttribute('data-bs-phone_no');
            const gender = relatedTarget.getAttribute('data-bs-gender');
            const dob = relatedTarget.getAttribute('data-bs-dob');
            const age = relatedTarget.getAttribute('data-bs-age');
            const dateOfJoining = relatedTarget.getAttribute('data-bs-date_of_joining');
            const mRegNo = relatedTarget.getAttribute('data-bs-m_reg_no');
            const caste = relatedTarget.getAttribute('data-bs-caste');
            const religion = relatedTarget.getAttribute('data-bs-religion');
            const category = relatedTarget.getAttribute('data-bs-category');
            const subcasteId = relatedTarget.getAttribute('data-bs-subcaste_id');
            const panNo = relatedTarget.getAttribute('data-bs-pan_no');
            const adharNo = relatedTarget.getAttribute('data-bs-adhar_no');
            const nomineeId = relatedTarget.getAttribute('data-bs-nominee_id');
            const nomineeName = relatedTarget.getAttribute('data-bs-nominee_name');
            const nomineeNaav = relatedTarget.getAttribute('data-bs-nominee_naav');
            const nomineeAddress = relatedTarget.getAttribute('data-bs-nominee_address');
            const nomineeMarathiAddress = relatedTarget.getAttribute('data-bs-nominee_marathi_address');
            const nomineeAge = relatedTarget.getAttribute('data-bs-nominee_age');
            const nomineeGender = relatedTarget.getAttribute('data-bs-nominee_gender');
            const relation = relatedTarget.getAttribute('data-bs-relation');
            const nomineeAdharNo = relatedTarget.getAttribute('data-bs-nominee_adhar_no');
            const bankName = relatedTarget.getAttribute('data-bs-bank_name');
            const branchName = relatedTarget.getAttribute('data-bs-branch_name');
            const bankAccountNo = relatedTarget.getAttribute('data-bs-bank_account_no');
            const ifscCode = relatedTarget.getAttribute('data-bs-ifsc_code');
            const proof1Type = relatedTarget.getAttribute('data-bs-proof_1_type');
            const proof1No = relatedTarget.getAttribute('data-bs-proof_1_no');
            const proof2Type = relatedTarget.getAttribute('data-bs-proof_2_type');
            const proof2No = relatedTarget.getAttribute('data-bs-proof_2_no');
            const empCode = relatedTarget.getAttribute('data-bs-emp_code');
            const designationId = relatedTarget.getAttribute('data-bs-designation_id');
            const salary = relatedTarget.getAttribute('data-bs-salary');
            const otherAllowance = relatedTarget.getAttribute('data-bs-other_allowance');
            const divisionId = relatedTarget.getAttribute('data-bs-division_id');
            const subdivisionId = relatedTarget.getAttribute('data-bs-subdivision_id');
            const centerId = relatedTarget.getAttribute('data-bs-center_id');
            const joiningDate = relatedTarget.getAttribute('data-bs-joining_date');
            const transferDate = relatedTarget.getAttribute('data-bs-transfer_date');
            const retirementDate = relatedTarget.getAttribute('data-bs-retirement_date');
            const gpfNo = relatedTarget.getAttribute('data-bs-gpf_no');
            const hra = relatedTarget.getAttribute('data-bs-hra');
            const da = relatedTarget.getAttribute('data-bs-da');
            const directorId = relatedTarget.getAttribute('data-bs-director_id');
            const pageNo = relatedTarget.getAttribute('data-bs-page_no');
            const divisionNoShare = relatedTarget.getAttribute('data-bs-division_no');
            const shareAmount = relatedTarget.getAttribute('data-bs-share_amount');
            const shareCertificateNo = relatedTarget.getAttribute('data-bs-share_certificate_no');
            const voucherNo = relatedTarget.getAttribute('data-bs-voucher_no');
            const admissionFees = relatedTarget.getAttribute('data-bs-admission_fees');
            const shareDate = relatedTarget.getAttribute('data-bs-share_date');

            const modalTitle = memberModal.querySelector('#memberModalLabel');
            const memberIdInput = memberModal.querySelector('#memberId');
            const formMethod = memberModal.querySelector('#formMethod');
            const departmentIdInput = memberModal.querySelector('#departmentId');
            const nameInput = memberModal.querySelector('#name');
            const naavInput = memberModal.querySelector('#marathiName');
            const addressInput = memberModal.querySelector('#address');
            const marathiAddressInput = memberModal.querySelector('#marathiAddress');
            const cityInput = memberModal.querySelector('#city');
            const mobileNoInput = memberModal.querySelector('#mobileNo');
            const phoneNoInput = memberModal.querySelector('#phoneNo');
            const genderInput = memberModal.querySelector('#gender');
            const dobInput = memberModal.querySelector('#dob');
            const ageInput = memberModal.querySelector('#age');
            const dateOfJoiningInput = memberModal.querySelector('#dateOfJoining');
            const mRegNoInput = memberModal.querySelector('#MRegNo');
            const casteInput = memberModal.querySelector('#caste');
            const religionInput = memberModal.querySelector('#religion');
            const categoryInput = memberModal.querySelector('#category');
            const subcasteIdInput = memberModal.querySelector('#subcasteId');
            const panNoInput = memberModal.querySelector('#panNo');
            const adharNoInput = memberModal.querySelector('#adharNo');
            const nomineeIdInput = memberModal.querySelector('#nomineeId');
            const nomineeNameInput = memberModal.querySelector('#nomineeName');
            const nomineeNaavInput = memberModal.querySelector('#marathiNomineeName');
            const nomineeAddressInput = memberModal.querySelector('#nomineeAddress');
            const nomineeMarathiAddressInput = memberModal.querySelector('#nomineeMarathiAddress');
            const nomineeAgeInput = memberModal.querySelector('#nomineeAge');
            const nomineeGenderInput = memberModal.querySelector('#nomineeGender');
            const relationInput = memberModal.querySelector('#nomineeRelation');
            const nomineeAdharNoInput = memberModal.querySelector('#nomineeAdharNo');
            const bankNameInput = memberModal.querySelector('#bankName');
            const branchNameInput = memberModal.querySelector('#branchName');
            const bankAccountNoInput = memberModal.querySelector('#bankAccountNo');
            const ifscCodeInput = memberModal.querySelector('#ifscCode');
            const proof1TypeInput = memberModal.querySelector('#proof1Type');
            const proof1NoInput = memberModal.querySelector('#proof1No');
            const proof2TypeInput = memberModal.querySelector('#proof2Type');
            const proof2NoInput = memberModal.querySelector('#proof2No');
            const empCodeInput = memberModal.querySelector('#empCode');
            const designationIdInput = memberModal.querySelector('#designationId');
            const salaryInput = memberModal.querySelector('#salary');
            const otherAllowanceInput = memberModal.querySelector('#otherAllowance');
            const divisionIdInput = memberModal.querySelector('#divisionId');
            const subdivisionIdInput = memberModal.querySelector('#subdivisionId');
            const centerIdInput = memberModal.querySelector('#centerId');
            const joiningDateInputDept = memberModal.querySelector('#joiningDate');
            const transferDateInput = memberModal.querySelector('#transferDate');
            const retirementDateInput = memberModal.querySelector('#retirementDate');
            const gpfNoInput = memberModal.querySelector('#gpfNo');
            const hraInput = memberModal.querySelector('#hra');
            const daInput = memberModal.querySelector('#da');
            const directorIdInput = memberModal.querySelector('#directorId');
            const pageNoInputShare = memberModal.querySelector('#pageNo');
            const divisionNoInputShare = memberModal.querySelector('#divisionNo');
            const shareAmountInput = memberModal.querySelector('#shareAmount');
            const shareCertificateNoInput = memberModal.querySelector('#shareCertificateNo');
            const voucherNoInput = memberModal.querySelector('#voucherNo');
            const admissionFeesInput = memberModal.querySelector('#admissionFees');
            const shareDateInput = memberModal.querySelector('#shareDate');

            if (id) {
                modalTitle.textContent = 'Edit Member';
                memberIdInput.value = id;
                formMethod.value = 'PUT';
                if (departmentId) departmentIdInput.value = departmentId;
                nameInput.value = name || '';
                naavInput.value = naav || '';
                addressInput.value = address || '';
                marathiAddressInput.value = marathiAddress || '';
                cityInput.value = city || '';
                mobileNoInput.value = mobileNo || '';
                phoneNoInput.value = phoneNo || '';
                if (gender) genderInput.value = gender;
                dobInput.value = dob || '';
                ageInput.value = age || '';
                dateOfJoiningInput.value = dateOfJoining || '';
                mRegNoInput.value = mRegNo || '';
                if (caste) casteInput.value = caste;
                if (religion) religionInput.value = religion;
                if (category) categoryInput.value = category;
                if (subcasteId) subcasteIdInput.value = subcasteId;
                panNoInput.value = panNo || '';
                adharNoInput.value = adharNo || '';
                if (nomineeId) nomineeIdInput.value = nomineeId;
                nomineeNameInput.value = nomineeName || '';
                nomineeNaavInput.value = nomineeNaav || '';
                nomineeAddressInput.value = nomineeAddress || '';
                nomineeMarathiAddressInput.value = nomineeMarathiAddress || '';
                nomineeAgeInput.value = nomineeAge || '';
                if (nomineeGender) nomineeGenderInput.value = nomineeGender;
                if (relation) relationInput.value = relation;
                nomineeAdharNoInput.value = nomineeAdharNo || '';
                bankNameInput.value = bankName || '';
                branchNameInput.value = branchName || '';
                bankAccountNoInput.value = bankAccountNo || '';
                ifscCodeInput.value = ifscCode || '';
                if (proof1Type) proof1TypeInput.value = proof1Type;
                proof1NoInput.value = proof1No || '';
                if (proof2Type) proof2TypeInput.value = proof2Type;
                proof2NoInput.value = proof2No || '';
                empCodeInput.value = empCode || '';
                if (designationId) designationIdInput.value = designationId;
                salaryInput.value = salary || '';
                otherAllowanceInput.value = otherAllowance || '';
                if (divisionId) divisionIdInput.value = divisionId;
                if (subdivisionId) subdivisionIdInput.value = subdivisionId;
                if (centerId) centerIdInput.value = centerId;
                joiningDateInputDept.value = joiningDate || '';
                transferDateInput.value = transferDate || '';
                retirementDateInput.value = retirementDate || '';
                gpfNoInput.value = gpfNo || '';
                hraInput.value = hraInput.value = hra || '';
                daInput.value = da || '';
                if (directorId) directorIdInput.value = directorId;
                pageNoInputShare.value = pageNo || '';
                divisionNoInputShare.value = divisionNoShare || '';
                shareAmountInput.value = shareAmount || '';
                shareCertificateNoInput.value = shareCertificateNo || '';
                voucherNoInput.value = voucherNo || '';
                admissionFeesInput.value = admissionFees || '';
                shareDateInput.value = shareDate || '';

                const personalTab = document.getElementById('personal-tab');
                if (personalTab && personalTab.classList.contains('active')) {
                    // Keep personal tab active
                } else {
                    const firstTabEl = document.querySelector('#myTab button[data-bs-toggle="tab"]');
                    if (firstTabEl) {
                        bootstrap.Tab.getInstance(firstTabEl).show();
                    }
                }

            } else {
                modalTitle.textContent = 'Add Member';
                memberIdInput.value = '';
                formMethod.value = 'POST';
                document.getElementById('memberForm').reset();
                const firstTabEl = document.querySelector('#myTab button[data-bs-toggle="tab"]');
                if (firstTabEl) {
                    bootstrap.Tab.getInstance(firstTabEl).show();
                }
            }
        });
    }

    const marathiFields = document.querySelectorAll('.marathiField');
    marathiFields.forEach(field => {
        field.addEventListener('input', function() {
            const marathiRegex = /^[\u0900-\u097F\s]+$/;
            const errorMsg = this.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('errorMsg')) {
                if (!marathiRegex.test(this.value)) {
                    errorMsg.style.display = 'block';
                    this.value = this.value.replace(/[^\u0900-\u097F\s]/g, '');
                } else {
                    errorMsg.style.display = 'none';
                }
            }
        });
    });
});
</script>