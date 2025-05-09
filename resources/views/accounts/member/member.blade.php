<div class="modal fade" id="memberModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="memberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('members.store') }}" id="memberForm">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif
                <input type="hidden" id="memberId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4 border-0">
                    <h1 class="modal-title fs-5 fw-bold">
                        <i class="bi bi-person-plus me-2"></i><span  id="memberModalLabel"> Add Member</span>
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light p-4">
                    <div class="bg-white rounded shadow-sm p-4">
                        @isset($departments)
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                @if ($departments->isNotEmpty())
                                <div class="form-floating">
                                    <select name="department_id" id="departmentId"
                                        class="form-select @error('department_id') is-invalid @enderror"
                                        aria-label="Department">
                                        <option value="" selected>--- Select Department ---</option>
                                        @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="departmentId" class="form-label">Department</label>
                                    @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No departments available.</strong><br>
                                    Please add departments first.
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="" id="createdBy" class="form-control"
                                        value="{{ $user->name }}" type="text" placeholder="Created By" readonly required>
                                        <input name="created_by" id="" class="w-100 px-2 py-1 @error('created_by') is-invalid @enderror" value="{{$user->id}}" hidden type="text" readonly required>
                                    <label for="createdBy" class="form-label">Created By</label>
                                </div>
                            </div>
                        </div>
                        @endisset

                       <div class="row">                           
                        @if(Auth::user()->role === 'Admin')
                        @isset($branches) 
                             @if ($branches->isNotEmpty())
                        <div class="form-floating mb-3">
                            <select name="branch_id" id="branchId"
                                class="form-select @error('branch_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Branch</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}</option>
                        @endforeach
                        </select>
                        <label for="branchId">Branch</label>
                        @error('branch_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <strong>⚠️ No Branch available.</strong><br>
                        Please add Branch first.
                    </div>
                    @endif
                    @endisset
                    @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input name="name" id="Name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" type="text" placeholder="Name" required>
                                <label for="Name" class="form-label">Name <span class="text-danger">*</span></label>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
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
                    <!-- Tabs -->
                    <div class="bg-secondary warning-tabs border rounded mb-3 p-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item col" role="presentation">
                                <button class="nav-link w-100 active text-info fw-bold" id="personal-tab"
                                    data-bs-toggle="tab" data-bs-target="#personal-tab-pane" type="button" role="tab"
                                    aria-controls="personal-tab-pane" aria-selected="true">Personal
                                    Details
                                </button>
                            </li>
                            <li class="nav-item col" role="presentation">
                                <button class="nav-link w-100 text-info fw-bold" id="nominee-tab" data-bs-toggle="tab"
                                    data-bs-target="#nominee-tab-pane" type="button" role="tab"
                                    aria-controls="nominee-tab-pane" aria-selected="false">Nominee Detail
                                </button>
                            </li>
                            <li class="nav-item col" role="presentation">
                                <button class="nav-link w-100 text-info fw-bold" id="bank-tab" data-bs-toggle="tab"
                                    data-bs-target="#bank-tab-pane" type="button" role="tab"
                                    aria-controls="bank-tab-pane" aria-selected="false">Bank Detail
                                </button>
                            </li>
                            <li class="nav-item col" role="presentation">
                                <button class="nav-link w-100 text-info fw-bold" id="department-tab"
                                    data-bs-toggle="tab" data-bs-target="#department-tab-pane" type="button" role="tab"
                                    aria-controls="department-tab-pane" aria-selected="false">Department
                                    Detail
                                </button>
                            </li>
                            <li class="nav-item col" role="presentation">
                                <button class="nav-link w-100 text-info fw-bold" id="share-tab" data-bs-toggle="tab"
                                    data-bs-target="#share-tab-pane" type="button" role="tab"
                                    aria-controls="share-tab-pane" aria-selected="false">Share Detail
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!-- Personal Details Tab -->
                            <div class="tab-pane fade show active p-3" id="personal-tab-pane" role="tabpanel"
                                aria-labelledby="personal-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <textarea name="address" id="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                placeholder="Address" required
                                                style="height: 100px">{{ old('address') }}</textarea>
                                            <label for="address" class="form-label">Address</label>
                                            @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="city" id="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                value="{{ old('city') }}" type="text" placeholder="City" required>
                                            <label for="city" class="form-label">City</label>
                                            @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="mobile_no" id="mobileNo"
                                                class="form-control @error('mobile_no') is-invalid @enderror"
                                                value="{{ old('mobile_no') }}" type="text" placeholder="Mobile No."
                                                pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number" required>
                                            <label for="mobileNo" class="form-label">Mobile No.</label>
                                            @error('mobile_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <select name="gender" id="gender"
                                                class="form-select @error('gender') is-invalid @enderror" required>
                                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                                    Male
                                                </option>
                                                <option value="Female"
                                                    {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                                    Female
                                                </option>
                                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            <label for="gender" class="form-label">Gender</label>
                                            @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <input name="dob" id="dob"
                                                class="form-control @error('dob') is-invalid @enderror"
                                                value="{{ old('dob') }}" type="date" placeholder="DOB" required>
                                            <label for="dob" class="form-label">Date of Birth</label>
                                            @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <input name="age" id="age"
                                                class="form-control @error('age') is-invalid @enderror"
                                                value="{{ old('age') }}" type="number" placeholder="Age" required>
                                            <label for="age" class="form-label">Age</label>
                                            @error('age')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
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
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating ">
                                            <input name="m_reg_no" id="MRegNo"
                                                class="form-control @error('m_reg_no') is-invalid @enderror"
                                                value="{{ old('m_reg_no') }}" type="number" placeholder="M. Reg. No.">
                                            <label for="MRegNo" class="form-label">M. Reg. No.</label>
                                            @error('m_reg_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <select name="caste" id="caste"
                                                class="form-select @error('caste') is-invalid @enderror" required>
                                                <option value="mahar" {{ old('caste') == 'mahar' ? 'selected' : '' }}>
                                                    Mahar
                                                </option>
                                                <option value="kunbi" {{ old('caste') == 'kunbi' ? 'selected' : '' }}>
                                                    Kunbi
                                                </option>
                                                <option value="kalar" {{ old('caste') == 'kalar' ? 'selected' : '' }}>
                                                    Kalar
                                                </option>
                                                <option value="other" {{ old('caste') == 'other' ? 'selected' : '' }}>
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

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <select name="religion" id="religion"
                                                class="form-select @error('religion') is-invalid @enderror">
                                                <option value="hindu"
                                                    {{ old('religion') == 'hindu' ? 'selected' : '' }}>
                                                    Hindu
                                                </option>
                                                <option value="muslim"
                                                    {{ old('religion') == 'muslim' ? 'selected' : '' }}>
                                                    Muslim
                                                </option>
                                                <option value="sikh" {{ old('religion') == 'sikh' ? 'selected' : '' }}>
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
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <select name="category" id="category"
                                                class="form-select @error('category') is-invalid @enderror" required>
                                                <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>
                                                    SC
                                                </option>
                                                <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>
                                                    ST
                                                </option>
                                                <option value="OBC" {{ old('category') == 'OBC' ? 'selected' : '' }}>
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
                                    <div class="col-md-4 mb-3">
                                        @if ($subcates->isNotEmpty())
                                        <div class="form-floating">
                                            <select name="subcaste_id" id="subcasteId"
                                                class="form-select @error('subcaste_id') is-invalid @enderror">
                                                <option value="" selected>--- Select Sub Caste ---</option>
                                                @foreach ($subcates as $subcate)
                                                <option value="{{ $subcate->id }}"
                                                    {{ old('subcaste_id') == $subcate->id ? 'selected' : '' }}>
                                                    {{ $subcate->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="subcasteId" class="form-label">Sub Caste</label>
                                            @error('subcaste_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @else
                                        <div class="alert alert-warning">
                                            <strong>⚠️ No sub-caste available.</strong><br>
                                            Please add sub-caste first.
                                        </div>
                                        @endif
                                    </div>
                                    @endisset
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="adhar_no" id="adharNo"
                                                class="form-control @error('adhar_no') is-invalid @enderror"
                                                value="{{ old('adhar_no') }}" type="number" placeholder="Aadhar No.">
                                            <label for="adharNo" class="form-label">Aadhar No.</label>
                                            @error('adhar_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nominee Details Tab -->
                            <div class="tab-pane fade p-3" id="nominee-tab-pane" role="tabpanel"
                                aria-labelledby="nominee-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="nominee_name" id="nomineeName"
                                                class="form-control @error('nominee_name') is-invalid @enderror"
                                                value="{{ old('nominee_name') }}" type="text"
                                                placeholder="Nominee Name" required>
                                            <label for="nomineeName" class="form-label">Name</label>
                                            @error('nominee_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
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

                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                    <div class="col-md-6 mb-3">
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

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <input name="nominee_age" id="nomineeAge"
                                                class="form-control @error('nominee_age') is-invalid @enderror"
                                                value="{{ old('nominee_age') }}" type="number"
                                                placeholder="Nominee Age" required>
                                            <label for="nomineeAge" class="form-label">Age</label>
                                            @error('nominee_age')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <select name="nominee_gender" id="nomineeGender"
                                                class="form-select @error('nominee_gender') is-invalid @enderror" required>
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
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <select name="relation" id="nomineeRelation"
                                                class="form-select @error('relation') is-invalid @enderror" required>
                                                <option value="" selected>--- Select Relation ---</option>
                                                <option value="husband"
                                                    {{ old('relation') == 'husband' ? 'selected' : '' }}>
                                                    Husband
                                                </option>
                                                <option value="wife" {{ old('relation') == 'wife' ? 'selected' : '' }}>
                                                    Wife
                                                </option>
                                                <option value="daughter"
                                                    {{ old('relation') == 'daughter' ? 'selected' : '' }}>
                                                    Daughter
                                                </option>
                                                <option value="son" {{ old('relation') == 'son' ? 'selected' : '' }}>
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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                    <div class="col-md-6 mb-3">
                                        <label for="nomineeImage" class="form-label text-white">Nominee Photo</label>
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

                            <div class="tab-pane fade p-3" id="bank-tab-pane" role="tabpanel" aria-labelledby="bank-tab"
                                tabindex="0">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="bank_name" id="bankName"
                                                class="form-control @error('bank_name') is-invalid @enderror"
                                                value="{{ old('bank_name') }}" type="text" placeholder="Bank Name" required>
                                            <label for="bankName" class="form-label">Bank Name</label>
                                            @error('bank_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="branch_name" id="branchName"
                                                class="form-control @error('branch_name') is-invalid @enderror"
                                                value="{{ old('branch_name') }}" type="text" placeholder="Branch Name" required>
                                            <label for="branchName" class="form-label">Branch Name</label>
                                            @error('branch_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="bank_account_no" id="bankAccountNo"
                                                class="form-control @error('bank_account_no') is-invalid @enderror"
                                                value="{{ old('bank_account_no') }}" type="text"
                                                placeholder="Account No." required>
                                            <label for="bankAccountNo" class="form-label">Account No.</label>
                                            @error('bank_account_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="ifsc_code" id="ifscCode"
                                                class="form-control @error('ifsc_code') is-invalid @enderror"
                                                value="{{ old('ifsc_code') }}" type="text" placeholder="IFSC Code" required>
                                            <label for="ifscCode" class="form-label">IFSC Code</label>
                                            @error('ifsc_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                                </option>
                                            </select>
                                            <label for="proof1Type" class="form-label">Proof 1 Type</label>
                                            @error('proof_1_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="proof_1_no" id="proof1No"
                                                class="form-control @error('proof_1_no') is-invalid @enderror"
                                                value="{{ old('proof_1_no') }}" type="text" placeholder="Proof 1 No.">
                                            <label for="proof1No" class="form-label">Proof 1 No.</label>
                                            @error('proof_1_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="proof1Image" class="form-label text-white">Proof 1 Copy</label>
                                        <input name="proof_1_image" id="proof1Image"
                                            class="form-control @error('proof_1_image') is-invalid @enderror"
                                            value="{{ old('proof_1_image') }}" type="file" accept="image/*,.pdf"
                                            placeholder="Proof 1 Copy">
                                        @error('proof_1_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="proof_2_no" id="proof2No"
                                                class="form-control @error('proof_2_no') is-invalid @enderror"
                                                value="{{ old('proof_2_no') }}" type="text" placeholder="Proof 2 No.">
                                            <label for="proof2No" class="form-label">Proof 2 No.</label>
                                            @error('proof_2_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="proof2Image" class="form-label text-white">Proof 2 Copy</label>
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

                            <!-- Department Detail Tab -->
                            <div class="tab-pane fade p-3" id="department-tab-pane" role="tabpanel"
                                aria-labelledby="department-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                    <div class="col-md-6 mb-3">
                                        @if ($designations->isNotEmpty())
                                        <div class="form-floating">
                                            <select name="designation_id" id="designationId"
                                                class="form-select @error('designation_id') is-invalid @enderror">
                                                <option value="" selected>--- Select Designation ---</option>
                                                @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}"
                                                    {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="designationId" class="form-label">Designation</label>
                                            @error('designation_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @else
                                        <div class="alert alert-warning">
                                            <strong>⚠️ No designation available.</strong><br>
                                            Please add designation first.
                                        </div>
                                        @endif
                                    </div>
                                    @endisset
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                    <div class="col-md-6 mb-3">
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
                                <div class="row">
                                    @isset($divisions)
                                    <div class="col-md-6 mb-3">
                                        @if ($divisions->isNotEmpty())
                                        <div class="form-floating">
                                            <select name="division_id" id="divisionId"
                                                class="form-select @error('division_id') is-invalid @enderror">
                                                <option value="" selected>--- Select Division ---</option>
                                                @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                    {{ $division->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="divisionId" class="form-label">Division</label>
                                            @error('division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @else
                                        <div class="alert alert-warning">
                                            <strong>⚠️ No division available.</strong><br>
                                            Please add division first.
                                        </div>
                                        @endif
                                    </div>
                                    @endisset

                                    @isset($subdivisions)
                                    <div class="col-md-6 mb-3">
                                        @if ($subdivisions->isNotEmpty())
                                        <div class="form-floating">
                                            <select name="subdivision_id" id="subdivisionId"
                                                class="form-select @error('subdivision_id') is-invalid @enderror">
                                                <option value="" selected>--- Select Sub Division ---</option>
                                                @foreach ($subdivisions as $subdivision)
                                                <option value="{{ $subdivision->id }}"
                                                    {{ old('subdivision_id') == $subdivision->id ? 'selected' : '' }}>
                                                    {{ $subdivision->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="subdivisionId" class="form-label">Sub Division</label>
                                            @error('subdivision_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @else
                                        <div class="alert alert-warning">
                                            <strong>⚠️ No sub-designation available.</strong><br>
                                            Please add sub-designation first.
                                        </div>
                                        @endif
                                    </div>
                                    @endisset
                                </div>
                                <div class="row">
                                    @isset($centers)
                                    <div class="col-md-6 mb-3">
                                        @if ($centers->isNotEmpty())
                                        <div class="form-floating">
                                            <select name="center_id" id="centerId"
                                                class="form-select @error('center_id') is-invalid @enderror">
                                                <option value="" selected>--- Select Center ---</option>
                                                @foreach ($centers as $center)
                                                <option value="{{ $center->id }}"
                                                    {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                                    {{ $center->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="centerId" class="form-label">Center</label>
                                            @error('center_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @else
                                        <div class="alert alert-warning">
                                            <strong>⚠️ No center available.</strong><br>
                                            Please add center first.
                                        </div>
                                        @endif
                                    </div>

                                    @endisset
                                    <div class="col-md-6 mb-3">
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
                                <div class="row">
                                    <div class="col-md-4 mb-3">
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
                                    <div class="col-md-4 mb-3">
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
                                    <div class="col-md-4 mb-3">
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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                    <div class="col-md-6 mb-3">
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

                            <!-- Share Tab -->
                            <div class="tab-pane fade p-3" id="share-tab-pane" role="tabpanel"
                                aria-labelledby="share-tab" tabindex="0">
                                <div class="row">
                                    @isset($directors)
                                    <div class="col-md-6 mb-3">
                                        @if ($directors->isNotEmpty())
                                        <div class="form-floating">
                                            <select name="director_id" id="directorId"
                                                class="form-select @error('director_id') is-invalid @enderror">
                                                <option value="" selected>--- Select Director ---</option>
                                                @foreach ($directors as $director)
                                                <option value="{{ $director->id }}"
                                                    {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                                    {{ $director->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="directorId" class="form-label">Director</label>
                                            @error('director_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @else
                                        <div class="alert alert-warning">
                                            <strong>⚠️ No director available.</strong><br>
                                            Please add director first.
                                        </div>
                                        @endif
                                    </div>
                                    @endisset
                                    <div class="col-md-6 mb-3">
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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="dividend_amount" id="dividendAmount"
                                                class="form-control @error('dividend_amount') is-invalid @enderror"
                                                value="{{ old('dividend_amount') }}" type="number"
                                                placeholder="Divident Amount">
                                            <label for="dividendAmount" class="form-label">Divident Amount</label>
                                            @error('dividend_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="number_of_shares" id="numberOfShares"
                                                class="form-control @error('number_of_shares') is-invalid @enderror"
                                                value="{{ old('number_of_shares') }}" type="number"
                                                placeholder="Number of Shares">
                                            <label for="numberOfShares" class="form-label">Number of Shares</label>
                                            @error('number_of_shares')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="current_balance" id="currentBalance"
                                                class="form-control @error('current_balance') is-invalid @enderror"
                                                value="{{ old('current_balance') }}" type="number"
                                                placeholder="Voucher No.">
                                            <label for="currentBalance" class="form-label">Current Balance</label>
                                            @error('current_balance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="monthly_deposit" id="monthlyDeposit"
                                                class="form-control @error('monthly_deposit') is-invalid @enderror"
                                                value="{{ old('monthly_deposit') }}" type="number"
                                                placeholder="Monthly Deposit">
                                            <label for="monthlyDeposit" class="form-label">Monthly Deposit</label>
                                            @error('monthly_deposit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="welfare_fund" id="welfareFund"
                                                class="form-control @error('welfare_fund') is-invalid @enderror"
                                                value="{{ old('welfare_fund') }}" type="number"
                                                placeholder="Welfare Amount">
                                            <label for="welfareFund" class="form-label">Welfare Amount</label>
                                            @error('welfare_fund')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input name="monthly_balance" id="monthlyBalance"
                                                class="form-control @error('monthly_balance') is-invalid @enderror"
                                                value="{{ old('monthly_balance') }}" type="number"
                                                placeholder="Monthly Balance">
                                            <label for="monthlyBalance" class="form-label">Monthly Balance</label>
                                            @error('monthly_balance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <select name="demand" id="demand"
                                                class="form-select @error('demand') is-invalid @enderror">
                                                <option value="" selected>--- Demand ---</option>
                                                <option value="yes" {{ old('demand') == 'yes' ? 'selected' : '' }}>Yes
                                                </option>
                                                <option value="no" {{ old('demand') == 'no' ? 'selected' : '' }}>No
                                                </option>
                                            </select>
                                            <label for="demand" class="form-label">Demand</label>
                                            @error('demand')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <select name="type" id="type"
                                                class="form-select @error('type') is-invalid @enderror">
                                                <option value="" selected>--- Account Type ---</option>
                                                <option value="Share" {{ old('type') == 'Share' ? 'selected' : '' }}>
                                                    Share
                                                </option>
                                                <option value="Dividend"
                                                    {{ old('type') == 'Dividend' ? 'selected' : '' }}>Dividend
                                                </option>
                                                <option value="Deposit"
                                                    {{ old('type') == 'Deposit' ? 'selected' : '' }}>Deposit
                                                </option>
                                            </select>
                                            <label for="type" class="form-label">Account Type</label>
                                            @error('type')
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
