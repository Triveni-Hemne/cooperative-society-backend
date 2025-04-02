<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="{{route('members.store')}}" id="memberForm">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                <input type="hidden" id="memberId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="memberModalLabel">Add Member</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="mx-auto p-5 my-model text-white">
                         @isset($departments)
                         @if ($departments->isNotEmpty())
                        <div class="row mb-3 row-cols-xl-4 g-3">
                            <div class="col w-auto ps-2 ps-xl-5 d-none d-xl-block">
                                <label for="departmentId">Department</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <select name="department_id" id="departmentId"  class="w-100 px-2 py-1 @error('department_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"  
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}
                                        >
                                        {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                 @error('department_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                         @endif
                        @endisset

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="name" id="name" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Name" required>
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
                                <input id="marathiName" name="naav" class="w-100 px-2 py-1 @error('naav') is-invalid @enderror marathiField" value="{{ old('naav') }}" type="text" placeholder="नाव">
                                 @error('naav')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                            </div>
                        </div>

                        <div class="info-tabs border rounded mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info" id="personal-tab"
                                        data-bs-toggle="tab" data-bs-target="#personal-tab-pane" type="button"
                                        role="tab" aria-controls="personal-tab-pane" aria-selected="true">Personal
                                        Details</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="nominee-tab" data-bs-toggle="tab"
                                        data-bs-target="#nominee-tab-pane" type="button" role="tab"
                                        aria-controls="nominee-tab-pane" aria-selected="false">Nominee Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="bank-tab" data-bs-toggle="tab"
                                        data-bs-target="#bank-tab-pane" type="button" role="tab"
                                        aria-controls="bank-tab-pane" aria-selected="false">Bank Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="department-tab" data-bs-toggle="tab"
                                        data-bs-target="#department-tab-pane" type="button" role="tab"
                                        aria-controls="department-tab-pane" aria-selected="false">Department
                                        Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="share-tab" data-bs-toggle="tab"
                                        data-bs-target="#share-tab-pane" type="button" role="tab"
                                        aria-controls="share-tab-pane" aria-selected="false">Share Detail</button>
                                </li>                            
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!-- Personal Details -->
                                <div class="tab-pane fade show active py-3" id="personal-tab-pane" role="tabpanel"
                                    aria-labelledby="personal-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="address">Address</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <textarea name="address" id="address" placeholder="Address" class="w-100 px-2 py-1 @error('address') is-invalid @enderror" rows="1">{{ old('address') }}</textarea>
                                                 @error('address')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="marathiAddress">पत्ता</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <textarea name="marathi_address" id="marathiAddress" placeholder="पत्ता" class="w-100 px-2 py-1 @error('marathi_address') is-invalid @enderror marathiField"
                                                rows="1" style="resize:none">{{ old('marathi_address') }}</textarea>
                                                @error('marathi_address')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-1 ps-5 d-none d-xl-block">
                                            <label for="city">City</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <input name="city" id="city" class="w-100 px-2 py-1 @error('city') is-invalid @enderror" value="{{ old('city') }}" type="text" placeholder="City">
                                            @error('city')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="mobileNo" class="w-100">Mobile No.</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <input name="mobile_no" id="mobileNo" class="w-100 px-2 py-1 @error('mobile_no') is-invalid @enderror" 
                                            value="{{ old('mobile_no') }}" type="text" placeholder="Mobile No." 
                                            pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number">
                                                @error('mobile_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="phoneNo" class="w-100">Phone No.</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <input name="phone_no" id="phoneNo" class="w-100 px-2 py-1 @error('phone_no') is-invalid @enderror" value="{{ old('phone_no') }}" type="tel"
                                                placeholder="Phone no">
                                                @error('phone_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="gender">Gender</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select name="gender" id="gender" class="w-100 px-2 py-1 @error('gender') is-invalid @enderror">
                                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>

                                            @error('gender')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                         <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="dob">Date of Birth</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input name="dob" id="dob" class="w-100 px-2 py-1 @error('dob') is-invalid @enderror" value="{{ old('dob') }}" type="date" placeholder="DOB">
                                            @error('dob')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="age">Age</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input name="age" id="age" class="w-100 px-2 py-1 @error('age') is-invalid @enderror" value="{{ old('age') }}" type="number" placeholder="Age">
                                             @error('age')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="dateOfJoining">Date of Joining</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input name="date_of_joining" id="dateOfJoining" class="w-100 px-2 py-1 @error('date_of_joining') is-invalid @enderror" type="date"
                                                placeholder="Date of Joining" value="{{ old('date_of_joining') }}">
                                                @error('date_of_joining')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="MRegNo" class="w-100">M. Reg. No.</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input name="m_reg_no" id="MRegNo" class="w-100 px-2 py-1 @error('m_reg_no') is-invalid @enderror" value="{{ old('m_reg_no') }}" type="number"
                                                placeholder="M. Reg. No.">
                                                 @error('m_reg_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                         <div class="col-1 d-none d-xl-block">
                                            <label for="caste">Caste</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select name="caste" id="caste" class="w-100 px-2 py-1 @error('caste') is-invalid @enderror" value="{{ old('caste') }}">
                                                <option value="mahar">Mahar</option>
                                                <option value="kunbi">Kunbi</option>
                                                <option value="kalar">Kalar</option>
                                                <option value="other">Other</option>
                                            </select>
                                             @error('caste')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-1 ps-5 d-none d-xl-block">
                                            <label for="religion">Religion</label>
                                        </div>
                                        <div class="col-3 ps-5 pe-0 pe-xl-5">
                                            <select name="religion" id="religion" class="w-100 px-2 py-1 @error('religion') is-invalid @enderror" value="{{ old('religion') }}">
                                                <option value="hindu">Hindu</option>
                                                <option value="muslim">Muslim</option>
                                                <option value="sikh">Sikh</option>
                                                <option value="other">Other</option>
                                            </select>
                                             @error('religion')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="category">Category</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select name="category" id="category" class="w-100 px-2 py-1 @error('category') is-invalid @enderror" >
                                                <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>SC</option>
                                                <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>ST</option>
                                                <option value="OBC" {{ old('category') == 'OBC' ? 'selected' : '' }}>OBC</option>
                                                <option {{ old('category') == 'General' ? 'selected' : '' }}value="General">General</option>
                                                <option {{ old('category') == 'NT' ? 'selected' : '' }} value="NT">NT</option>
                                                <option {{ old('category') == 'Other' ? 'selected' : '' }} value="other">Other</option>
                                            </select>
                                             @error('category')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                         <div class="col-1 d-none d-xl-block">
                                            <label for="subcasteId">Sub Caste</label>
                                        </div>
                                         @isset($subcates)
                                         @if ($subcates->isNotEmpty())
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select name="subcaste_id" id="subcasteId" class="w-100 px-2 py-1 @error('subcaste_id') is-invalid @enderror" value="{{ old('subcaste_id') }}">
                                                @foreach ($subcates as $subcate)
                                                    <option value="{{ $subcate->id }}"  
                                                    {{ old('subcaste_id') == $subcate->id ? 'selected' : '' }}>
                                                    {{ $subcate->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                             @error('subcaste_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                         @endif
                                        @endisset
                                       
                                    </div>

                                    <div class="row">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="panNo" class="w-100">Pan No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="pan_no" id="panNo" class="w-100 px-2 py-1 @error('pan_no') is-invalid @enderror" value="{{ old('pan_no') }}" type="text" placeholder="Pan No.">
                                             @error('pan_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="adharNo">Aadhar No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="adhar_no" id="adharNo" class="w-100 px-2 py-1 @error('adhar_no') is-invalid @enderror" value="{{ old('adhar_no') }}" type="number"
                                                placeholder="Aadhar No.">
                                                 @error('adhar_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Nominee Details -->
                                <div class="tab-pane fade p-3" id="nominee-tab-pane" role="tabpanel"
                                    aria-labelledby="nominee-tab" tabindex="0">
                                     @isset($members)
                                    @if ($members->isNotEmpty())
                                    <div class="row mb-3">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="nomineeId">Member</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <select name="nominee_id" id="nomineeId"  class="w-100 px-2 py-1 @error('nominee_id') is-invalid @enderror">
                                                <option value="" disabled selected>---------- Select ----------</option>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id }}"  
                                                    {{ old('nominee_id') == $member->id ? 'selected' : '' }}
                                                    >
                                                    {{ $member->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('nominee_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    @endif
                                    @endisset
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="nomineeName">Name</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="nominee_name" id="nomineeName" class="w-100 px-2 py-1 @error('nominee_name') is-invalid @enderror" 
                                            value="{{ old('nominee_name') }}" type="text" placeholder="Name">
                                                 @error('nominee_name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="marathiNomineeName">नाव</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="nominee_naav" id="marathiNomineeName" class="w-100 px-2 py-1 @error('nominee_naav') is-invalid @enderror marathiField" value="{{ old('nominee_naav') }}" type="text"
                                                placeholder="नाव">
                                                 @error('nominee_naav')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="nomineeAddress">Address</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <textarea name="nominee_address" id="nomineeAddress" placeholder="Nominee Address"
                                                class="w-100 px-2 py-1 @error('nominee_address') is-invalid @enderror" rows="1" style="resize:none">{{ old('nominee_address') }}</textarea>
                                                 @error('nominee_address')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="nomineeMarathiAddress">पत्ता</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <textarea name="nominee_marathi_address" id="nomineeMarathiAddress" placeholder="पत्ता"
                                        class="w-100 px-2 py-1 @error('nominee_marathi_address') is-invalid @enderror marathiField" rows="1" style="resize:none">{{ old('nominee_marathi_address') }}</textarea>
                                                 @error('nominee_marathi_address')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            <p class="errorMsg" style="color:red; display:none;">फक्त मराठी अक्षरे स्वीकारली जातील.</p>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="nomineeAge">Age</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input name="nominee_age" id="nomineeAge" class="w-100 px-2 py-1 @error('nominee_age') is-invalid @enderror" value="{{ old('nominee_age') }}" type="number"
                                                placeholder="Nominee Age">
                                                 @error('nominee_age')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>

                                        <div class="col-1 d-none d-xl-block">
                                            <label for="nomineeGender">Gender</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select name="nominee_gender" id="nomineeGender" class="w-100 px-2 py-1 @error('nominee_gender') is-invalid @enderror" value="{{ old('nominee_gender') }}">
                                                <option value="Male" {{ old('nominee_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('nominee_gender') == 'Female' ? 'selected' : '' }}>Female</option><option value="Other" {{ old('nominee_gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                             @error('nominee_gender')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="col-1 d-none d-xl-block">
                                            <label for="nomineeRelation">Relation</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select name="relation" id="nomineeRelation" class="w-100 px-2 py-1 @error('relation') is-invalid @enderror" value="{{ old('relation') }}">
                                                <option value="">------ Select Relation with Nominee ------</option>
                                                <option value="husband" {{ old('relation') == 'husband' ? 'selected' : '' }}>Husband</option>
                                                <option value="wife" {{ old('relation') == 'wife' ? 'selected' : '' }}>Wife</option>
                                                <option value="daughter" {{ old('relation') == 'daughter' ? 'selected' : '' }}>Daughter</option>
                                                <option value="son" {{ old('relation') == 'son' ? 'selected' : '' }}>Son</option>
                                                <option value="sister" {{ old('relation') == 'sister' ? 'selected' : '' }}>Sister</option>
                                                <option value="brother" {{ old('relation') == 'brother' ? 'selected' : '' }}>Brother</option>
                                                <option value="other" {{ old('relation') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                             @error('relation')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="/">Aadhar No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="nominee_adhar_no" id="nomineeAdharNo" class="w-100 px-2 py-1 @error('nominee_adhar_no') is-invalid @enderror" value="{{ old('nominee_adhar_no') }}" type="number"
                                                placeholder="Nominee Aadhar No.">
                                                 @error('nominee_adhar_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="nomineeImage">Nominee Photo</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="nominee_image" id="nomineeImage" class="w-100 px-2 py-1 @error('nominee_image') is-invalid @enderror" value="{{ old('nominee_image') }}" type="file" accept="image/*"
                                                placeholder="Nominee Photo">
                                                 @error('nominee_image')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Tab -->
                                <div class="tab-pane fade py-3" id="bank-tab-pane" role="tabpanel"
                                    aria-labelledby="bank-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="bankName">Bank Name</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="bank_name" id="bankName" class="w-100 px-2 py-1 @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}" type="text"
                                                placeholder="Bank Name">
                                                 @error('bank_name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="branchName">Branch Name</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="branch_name" id="branchName" class="w-100 px-2 py-1 @error('branch_name') is-invalid @enderror" value="{{ old('branch_name') }}" type="text"
                                                placeholder="Branch Name">
                                                 @error('branch_name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="bankAccountNo">Account No.</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="bank_account_no" id="bankAccountNo" class="w-100 px-2 py-1 @error('bank_account_no') is-invalid @enderror" value="{{ old('bank_account_no') }}" type="text"
                                                placeholder="Account No.">
                                                 @error('bank_account_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="ifscCode">IFSC Code</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="ifsc_code" id="ifscCode" class="w-100 px-2 py-1 @error('ifsc_code') is-invalid @enderror" value="{{ old('ifsc_code') }}" type="text"
                                                placeholder="IFSC Code">
                                                 @error('ifsc_code')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="proof1Type">Proof 1 Type</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select name="proof_1_type" id="proof1Type" class="w-100 px-2 py-1 @error('proof_1_type') is-invalid @enderror" >
                                                <option value="aadhar" {{ old('proof_1_type') == 'aadhar' ? 'selected' : '' }}>Aadhar Card</option>
                                                <option value="pan" {{ old('proof_1_type') == 'pan' ? 'selected' : '' }}>PAN Card</option>
                                                <option value="vote" {{ old('proof_1_type') == 'vote' ? 'selected' : '' }}>Voting Card</option>
                                                <option value="other" {{ old('proof_1_type') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                             @error('proof_1_type')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="proof1No">Proof 1 No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="proof_1_no" id="proof1No" class="w-100 px-2 py-1 @error('proof_1_no') is-invalid @enderror" value="{{ old('proof_1_no') }}" type="text"
                                                placeholder="Proof 1 No.">
                                                 @error('proof_1_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="proof1Image">Proof 1 Copy</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="proof_1_image" id="proof1Image" class="w-100 px-2 py-1 @error('proof_1_image') is-invalid @enderror" value="{{ old('proof_1_image') }}" type="file"
                                                accept="image/*,.pdf" placeholder="Proof 1 Copy">
                                                 @error('proof_1_image')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="proof2Type">Proof 2 Type</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select name="proof_2_type" id="proof2Type" class="w-100 px-2 py-1 @error('proof_2_type') is-invalid @enderror" value="{{ old('proof_2_type') }}">
                                                <option value="aadhar">Aadhar Card</option>
                                                <option value="pan">PAN Card</option>
                                                <option value="voting">Voting Card</option>
                                                <option value="other">Other</option>
                                            </select>
                                             @error('proof_2_type')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="proof2No">Proof 2 No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="proof_2_no" id="proof2No" class="w-100 px-2 py-1 @error('proof_2_no') is-invalid @enderror" value="{{ old('proof_2_no') }}" type="text"
                                                placeholder="Proof 2 No.">
                                                 @error('proof_2_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="proof2Image">Proof 2 Copy</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="proof_2_image" id="proof2Image" class="w-100 px-2 py-1 @error('proof_2_image') is-invalid @enderror" value="{{ old('proof_2_image') }}" type="file"
                                                accept="image/*,.pdf" placeholder="Proof 2 Copy">
                                                 @error('proof_2_image')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Department Tab -->
                                <div class="tab-pane fade py-3" id="department-tab-pane" role="tabpanel"
                                    aria-labelledby="department-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="empCode">Emp Code</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="emp_code" id="empCode" class="w-100 px-2 py-1 @error('emp_code') is-invalid @enderror" value="{{ old('emp_code') }}" type="text"
                                                placeholder="Emp Code">
                                                 @error('emp_code')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        @isset($designations)
                                        @if ($designations->isNotEmpty())
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="designationId">Designation</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                             <select name="designation_id" id="designationId" class="w-100 px-2 py-1 @error('designation_id') is-invalid @enderror">
                                                    <option value="" disabled selected>---------- Select ----------</option>
                                                    @foreach ($designations as $designation)
                                                        <option value="{{ $designation->id }}"  
                                                        {{ old('designation_id') == $designation->id ? 'selected' : '' }}
                                                        >
                                                        {{ $designation->name}}
                                                        </option>
                                                    @endforeach
                                            </select>
                                                 @error('designation_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        @endif
                                        @endisset
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="salary">Salary</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="salary" id="salary" class="w-100 px-2 py-1 @error('salary') is-invalid @enderror" value="{{ old('salary') }}" type="number"
                                                placeholder="Salary">
                                                 @error('salary')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="otherAllowance">Other Allowance</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="other_allowance" id="otherAllowance" class="w-100 px-2 py-1 @error('other_allowance') is-invalid @enderror" value="{{ old('other_allowance') }}" type="text"
                                                placeholder="Other Allowance">
                                                 @error('other_allowance')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                         @isset($divisions)
                                        @if ($divisions->isNotEmpty())
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="divisionId">Division</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select name="division_id" id="divisionId" class="w-100 px-2 py-1 @error('division_id') is-invalid @enderror">
                                                    <option value="" disabled selected>---------- Select ----------</option>
                                                    @foreach ($divisions as $division)
                                                        <option value="{{ $division->id }}"  
                                                        {{ old('division_id') == $division->id ? 'selected' : '' }}
                                                        >
                                                        {{ $division->name}}
                                                        </option>
                                                    @endforeach
                                            </select>
                                             @error('division_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        @endif
                                        @endisset
                                        @isset($subdivisions)
                                        @if ($subdivisions->isNotEmpty())
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="subdivisionId">Sub Division</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select name="subdivision_id" id="subdivisionId" class="w-100 px-2 py-1 @error('subdivision_id') is-invalid @enderror">
                                                    <option value="" disabled selected>---------- Select ----------</option>
                                                    @foreach ($subdivisions as $subdivision)
                                                        <option value="{{ $subdivision->id }}"  
                                                        {{ old('subdivision_id') == $subdivision->id ? 'selected' : '' }}
                                                        >
                                                        {{ $subdivision->name}}
                                                        </option>
                                                    @endforeach
                                            </select>
                                             @error('subdivision_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        @endif
                                        @endisset
                                    </div>
                                    <div class="row mb-1">
                                        @isset($centers)
                                        @if ($centers->isNotEmpty())
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="centerId">Center</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select name="center_id" id="centerId" class="w-100 px-2 py-1 @error('center_id') is-invalid @enderror">
                                                    <option value="" disabled selected>---------- Select ----------</option>
                                                    @foreach ($centers as $center)
                                                        <option value="{{ $center->id }}"  
                                                        {{ old('center_id') == $center->id ? 'selected' : '' }}
                                                        >
                                                        {{ $center->name}}
                                                        </option>
                                                    @endforeach
                                            </select>
                                             @error('center_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        @endif
                                        @endisset
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="joiningDate">Date of Joining</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input name="joining_date" id="joiningDate" class="w-100 px-2 py-1 @error('joining_date') is-invalid @enderror" value="{{ old('joining_date') }}" type="date"
                                                placeholder="Date of Joining">
                                                 @error('joining_date')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="transferDate">Transfer Date</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input name="transfer_date" id="transferDate" class="w-100 px-2 py-1 @error('transfer_date') is-invalid @enderror" value="{{ old('transfer_date') }}" type="date"
                                                placeholder="Transfer Date">
                                                 @error('transfer_date')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="retirementDate">Retirement Date</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input name="retirement_date" id="retirementDate" class="w-100 px-2 py-1 @error('retirement_date') is-invalid @enderror" value="{{ old('retirement_date') }}" type="date"
                                                placeholder="Retirement Date">
                                                 @error('retirement_date')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-1 ps-5 d-none d-xl-block">
                                            <label for="gpfNo">GPF No.</label>
                                        </div>
                                        <div class="col ps-5 pe-0 pe-xl-5">
                                            <input name="gpf_no" id="gpfNo" class="w-100 px-2 py-1 @error('gpf_no') is-invalid @enderror" value="{{ old('gpf_no') }}" type="text"
                                                placeholder="GPF No.">
                                                @error('gpf_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="hra">HRA</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="hra" id="hra" class="w-100 px-2 py-1 @error('hra') is-invalid @enderror" value="{{ old('hra') }}" type="number" placeholder="HRA">
                                             @error('hra')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                             @enderror
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="da">DA</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="da" id="da" class="w-100 px-2 py-1 @error('da') is-invalid @enderror" value="{{ old('da') }}" type="number" placeholder="DA">
                                             @error('da')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Share Tab -->
                                <div class="tab-pane fade py-3 px-5" id="share-tab-pane" role="tabpanel"
                                    aria-labelledby="share-tab" tabindex="0">
                                    <div class="row mb-1">
                                        @isset($directors)
                                        @if ($directors->isNotEmpty())
                                            <div class="col-2 ps-5 d-none d-xl-block">
                                                <label for="directorId">Director</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <select name="director_id" id="directorId"  class="w-100 px-2 py-1 @error('director_id') is-invalid @enderror">
                                                    <option value="" disabled selected>---------- Select ----------</option>
                                                    @foreach ($directors as $director)
                                                        <option value="{{ $director->id }}"  
                                                        {{ old('director_id') == $director->id ? 'selected' : '' }}
                                                        >
                                                        {{ $director->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                  @error('director_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        @endif
                                        @endisset
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="pageNo">Page No.</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input name="page_no" id="pageNo" class="w-100 px-2 py-1 @error('page_no') is-invalid @enderror" value="{{ old('page_no') }}" type="number"
                                                placeholder="Page No.">
                                                 @error('page_no')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="dividendAmount">Divident Amount</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input name="dividend_amount" id="dividendAmount" class="w-100 px-2 py-1 @error('dividend_amount') is-invalid @enderror" value="{{ old('dividend_amount') }}" type="number"
                                                placeholder="Divident Amount">
                                                 @error('dividend_amount')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="shareAmount">Share Amount</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input name="share_amount" id="shareAmount" class="w-100 px-2 py-1 @error('share_amount') is-invalid @enderror" value="{{ old('share_amount') }}" type="number"
                                                placeholder="Share Amount">
                                                 @error('share_amount')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                          
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="numberOfShares">Number of Shares</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input name="number_of_shares" id="numberOfShares" class="w-100 px-2 py-1 @error('number_of_shares') is-invalid @enderror" value="{{ old('number_of_shares') }}" type="number"
                                                placeholder="Number of Share">
                                                 @error('number_of_shares')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="currentBalance">Current Balance</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input name="current_balance" id="currentBalance" class="w-100 px-2 py-1 @error('current_balance') is-invalid @enderror" value="{{ old('current_balance') }}" type="number"
                                                placeholder="Current Balance">
                                                 @error('current_balance')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>

                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="monthlyDeposit">Monthly Deposit</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input name="monthly_deposit" id="monthlyDeposit" class="w-100 px-2 py-1 @error('monthly_deposit') is-invalid @enderror" value="{{ old('monthly_deposit') }}" type="number"
                                                placeholder="Monthly Deposit">
                                                 @error('monthly_deposit')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="welfareFund">Welfare Amount</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input name="welfare_fund" id="welfareFund" class="w-100 px-2 py-1 @error('welfare_fund') is-invalid @enderror" value="{{ old('welfare_fund') }}" type="number"
                                                placeholder="Welfare Amount">
                                                 @error('welfare_fund')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                       
                                    </div>
                                    <div class="row mb-1">
                                         <div class="col-2 d-none d-xl-block">
                                            <label for="monthlyBalance">Monthly Balance</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input name="monthly_balance" id="monthlyBalance" class="w-100 px-2 py-1 @error('monthly_balance') is-invalid @enderror" value="{{ old('monthly_balance') }}" type="number"
                                                placeholder="Monthly Balance">
                                                @error('monthly_balance')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="demand">Demand</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-4">
                                            <select name="demand" id="demand" class="w-100 px-2 py-1 @error('demand') is-invalid @enderror">
                                                <option value="yes" {{ old('demand') == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ old('demand') == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                             @error('demand')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
             
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="type">Account Type</label>
                                        </div>
                                        <div class="col-4 pe-0">
                                            <select name="type" id="type" class="w-100 px-2 py-1 @error('type') is-invalid @enderror">
                                                <option value="Share" {{ old('type') == 'Share' ? 'selected' : '' }}>Share</option>
                                                <option value="Dividend" {{ old('type') == 'Dividend' ? 'selected' : '' }}>Dividend</option>
                                                <option value="Deposit" {{ old('type') == 'Deposit' ? 'selected' : '' }}>Deposit</option>
                                            </select>
                                             @error('type')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                             @enderror
                                        </div>
                                    </div>
                                </div>
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