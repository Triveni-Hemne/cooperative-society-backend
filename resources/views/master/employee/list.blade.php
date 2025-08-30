@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Employee</h3>
    <div class="row">
        <!-- Search Bar -->
        <div class="col-8 col-lg-5 mb-3">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col-8 col-lg-5">
           @include('layouts.branchFilterInput', [
                    'action' => route('employees.index')
                ])
        </div>

        <div class="col col-md-2">
           @include('layouts.add-button', [
                'target' => '#employeeModal',
                'text' => 'Add New',
                'id' => 'addNewEmployee'
            ])
        </div>
    </div>
</div>  
<div class="d-flex flex-column justify-content-between" style="height: 82%">
    <!-- List of Directors -->
    <div class="border overflow-auto" style="height: 88%">
        <table id="tableFilter" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sr.No.</th>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">नाव</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Age</th>
                    <th scope="col">Religion</th>
                    <th scope="col">Category</th>
                    <th scope="col">Caste</th>
                    {{-- <th scope="col">Subcaste</th> --}}
                    {{-- <th scope="col">M. Reg. No.</th> --}}
                    <th scope="col">Pan No.</th>
                    <th scope="col">Adhar</th>
                    {{-- <th scope="col">Department</th> --}}
                    <th scope="col">Branch</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Address</th>
                    <th scope="col">पत्ता</th>
                    <th scope="col">City</th>
                    <th scope="col">Mobile No.</th>
                    {{-- <th scope="col">Employee Code</th> --}}
                    <th scope="col">Designation</th>
                    {{-- <th scope="col">Salary</th> --}}
                    {{-- <th scope="col">Other Allowance</th> --}}
                    <th scope="col">Division</th>
                    <th scope="col">Sub Division</th>
                    {{-- <th scope="col">Center</th> --}}
                    <th scope="col">Joining Date</th>
                    {{-- <th scope="col">Retirement Date</th> --}}
                    {{-- <th scope="col">GPF No.</th> --}}
                    {{-- <th scope="col">HRA</th> --}}
                    {{-- <th scope="col">DA</th> --}}
                    {{-- <th scope="col">Bank Name</th> --}}
                    {{-- <th scope="col">Branch Name</th> --}}
                    {{-- <th scope="col">Bank Acc. No.</th> --}}
                    {{-- <th scope="col">IFSC Code</th> --}}
                    {{-- <th scope="col">Proof1 No (Type) </th> --}}
                    {{-- <th scope="col">Proof1 Image</th> --}}
                    {{-- <th scope="col">Proof2 No (Type) </th> --}}
                    {{-- <th scope="col">Proof2 Image</th> --}}
                    {{-- <th scope="col">Director</th>
                    <th scope="col">Share Amount</th>
                    <th scope="col">Number of Shares</th>
                    <th scope="col">Welfare Fund</th>
                    <th scope="col">Page No. </th>
                    <th scope="col">Current Balance</th>
                    <th scope="col">Monthly Balance</th>
                    <th scope="col">Dividend Amount</th>
                    <th scope="col">Monthly Deposit</th>
                    <th scope="col">Demand</th>
                    <th scope="col">Type</th> --}}
                    {{-- <th scope="col">Nominee Name</th> --}}
                    {{-- <th scope="col">Nominee Naav</th> --}}
                    {{-- <th scope="col">Nominee Age</th> --}}
                    {{-- <th scope="col">Nominee Gender</th> --}}
                    {{-- <th scope="col">Nominee Relation</th> --}}
                    {{-- <th scope="col">Nominee Image</th> --}}
                    {{-- <th scope="col">Nominee Address</th> --}}
                    {{-- <th scope="col">Nominee Address in Marathi</th> --}}
                    {{-- <th scope="col">Nominee Adhar No. </th> --}}
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if ($employees->isNotEmpty()) --}}
                @if ($employees->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($employees as $employee)
                <tr>
                    
                    <th scope="row">{{$i}}</th>
                    <th scope="row">{{$employee->id}}</th>
                    <th scope="row">{{$employee->name ?? ''}}</th>
                    <th scope="row">{{$employee->naav ?? ''}}</th>
                    <th scope="row">{{$employee->dob ?? ''}}</th>
                    <th scope="row">{{$employee->gender ?? ''}}</th>
                    <th scope="row">{{$employee->age ?? ''}}</th>
                    {{-- <th scope="row">{{$employee->employee->date_of_joining ?? ''}}</th> --}}
                    <th scope="row">{{$employee->religion ?? ''}}</th>
                    <th scope="row">{{$employee->category->name ?? ''}}</th>
                    <th scope="row">{{$employee->caste ?? ''}}</th>
                    {{-- <th scope="row">{{$employee->subcaste->name ?? ''}}</th> --}}
                    {{-- <th scope="row">{{$employee->m_reg_no  ?? ''}}</th> --}}
                    <th scope="row">{{$employee->pan_no ?? ''}} </th>
                    <th scope="row">{{$employee->adhar_no ?? ''}} </th>
                    {{-- <th scope="row">{{optional($employee->department)->name  ?? ''}}</th> --}}
                    <th scope="row">{{optional($employee->branch)->name  ?? ''}}</th>
                    <th scope="row">{{$employee->user->name ?? ''}}</th>
                    <th scope="row">{{$employee->contact->address ?? ''}}</th>
                    <th scope="row">{{$employee->contact->marathi_address ?? ''}}</th>
                    <th scope="row">{{$employee->contact->city ?? ''}}</th>
                    <th scope="row">{{$employee->contact->mobile_no ?? ''}}</th>
                    {{-- <th scope="row">{{$employee->employee->emp_code  ?? ''}}</th> --}}
                    <th scope="row">{{optional($employee->employee)->designation->name  ?? ''}}</th>
                    {{-- <th scope="row">{{optional($employee->employee)->salary  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee->employee)->other_allowance  ?? ''}}</th> --}}
                    <th scope="row">{{optional($employee)->division->name  ?? ''}}</th>
                    <th scope="row">{{optional($employee)->subdivision->name  ?? ''}}</th>
                    {{-- <th scope="row">{{optional($employee)->center->name  ?? ''}}</th> --}}
                    <th scope="row">{{$employee->employee->joining_date  ?? ''}}</th>
                    {{-- <th scope="row">{{optional($employee->employee)->transfer_date  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee->employee)->retirement_date  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee->employee)->gpf_no  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee->employee)->da  ?? ''}}</th> --}}
            
                    {{-- <th scope="row">{{optional($employee)->bankdtl->bank_name  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->bankdtl->branch_name  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->bankdtl->bank_account_no  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->bankdtl->ifsc_code  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->bankdtl->proof_1_no  ?? ''}} {{optional($employee)->bankdtl->proof_1_type  ?? ''}}</th> --}}
                    {{-- <th scope="row">@php $imagePath = optional($employee)->bankdtl->proof_1_image ?? ''; @endphp
                        @if ($imagePath)
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Proof 1 Image" style="max-width: 50px; max-height: 50px;">
                        @else
                            No Image
                        @endif
                    </th> --}}
                    {{-- <th scope="row">{{optional($employee)->bankdtl->proof_2_no  ?? ''}} {{optional($employee)->bankdtl->proof_2_type  ?? ''}}</th> --}}
                    {{-- <th scope="row">@php $imagePath = optional($employee)->bankdtl->proof_2_image ?? ''; @endphp
                        @if ($imagePath)
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Proof 1 Image" style="max-width: 50px; max-height: 50px;">
                        @else
                            No Image
                        @endif
                    </th> --}}
                    {{-- <th scope="row">{{optional($employee->financialdtl)->director->name  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->share_amount  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->number_of_shares  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->welfare_fund  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->page_no  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->current_balance  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->monthly_balance  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->dividend_amount  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->monthly_deposit  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->demand  ?? ''}}</th>
                    <th scope="row">{{optional($employee->financialdtl)->type  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->nominee->nominee_name  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->nominee->nominee_naav  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->nominee->nominee_age  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->nominee->nominee_gender  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->nominee->relation  ?? ''}}</th> --}}
                    {{-- <th scope="row">@php $imagePath = optional($employee->nominee)->nominee_image; @endphp
                        @if ($imagePath)
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Proof 1 Image" style="max-width: 50px; max-height: 50px;">
                        @else
                            No Image
                        @endif
                    </th> --}}
                    {{-- <th scope="row">{{optional($employee)->nominee->nominee_address  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->nominee->nominee_marathi_address  ?? ''}}</th> --}}
                    {{-- <th scope="row">{{optional($employee)->nominee->nominee_adhar_no  ?? ''}}</th> --}}
                    <td>
                       <a href="#" 
                            data-id="{{$employee->id}}" data-nominee-id="{{optional($employee)->nominee->id ?? '' }}" 
                            data-name="{{$employee->name ?? '' }}" 
                            data-naav="{{$employee->naav ?? '' }}" 
                            data-created-by="{{$employee->user->name ?? Auth::user()->name }}" 
                            data-created-by-id="{{$employee->user->id ?? Auth::user()->id }}" 
                            data-branch-id="{{$employee->branch->id ?? '' }}" 
                            data-route="{{ route('employees.update', $employee->id ?? '') }}" 
                            data-subcaste-id="{{$employee->subcaste->id ?? ''}}" 
                            data-subcaste-name="{{$employee->subcaste->name ?? ''}}" 
                            data-department-id="{{$employee->department->id ?? ''}}" 
                            data-department-name="{{$employee->department->name ?? ''}}" 
                            data-dob="{{$employee->dob ?? '' }}" 
                            data-gender="{{$employee->gender ?? '' }}" 
                            data-age="{{$employee->age ?? '' }}" 
                            data-date-of-joining="{{$employee->date_of_joining ?? '' }}" 
                            data-religion="{{$employee->religion ?? '' }}" 
                            data-category="{{$employee->category->id ?? '' }}" 
                            data-caste="{{$employee->caste ?? '' }}" 
                            data-m-reg-no="{{$employee->m_reg_no ?? '' }}" 
                            data-pan-no="{{$employee->pan_no ?? '' }}" 
                            data-adhar-no="{{$employee->adhar_no ?? '' }}" 
                            data-member-branch="{{$employee->member_branch_id ?? '' }}" 
                            data-designation-id="{{$employee->employee->designation->id ?? '' }}" 
                            data-designation-name="{{$employee->employee->designation->name ?? '' }}" 
                            data-salary="{{$employee->employee->salary ?? '' }}" 
                            data-other-allowance="{{$employee->employee->other_allowance ?? '' }}" 
                            data-division-id="{{$employee->division_id ?? '' }}" 
                            data-division-name="{{$employee->division->name ?? '' }}" 
                            data-subdivision-id="{{$employee->subdivision_id ?? '' }}" 
                            data-subdivision-name="{{$employee->subdivision->name ?? '' }}" 
                            data-center-id="{{$employee->employee->center_id ?? '' }}" 
                            data-center-name="{{$employee->employee->center->name ?? '' }}" 
                            data-joining-date="{{$employee->employee->joining_date ?? '' }}" 
                            data-transfer-date="{{$employee->employee->transfer_date ?? '' }}" 
                            data-retirement-date="{{$employee->employee->retirement_date ?? '' }}" 
                            data-gpf-no="{{$employee->employee->gpf_no ?? '' }}" 
                            data-hra="{{$employee->employee->hra ?? '' }}" 
                            data-da="{{$employee->employee->da ?? '' }}" 
                            data-address="{{ $employee->contact->address ?? '' }}" 
                            data-marathiAddress="{{$employee->contact->marathi_address ?? ''}}" 
                            data-city="{{$employee->contact->city ?? '' }}" 
                            data-mobile-no="{{$employee->contact->mobile_no ?? '' }}" 
                            data-phone-no="{{$employee->contact->phone_no ?? '' }}" 
                            data-nominee-name="{{$employee->nominee->nominee_name ?? '' }}" 
                            data-nominee-naav="{{$employee->nominee->nominee_naav ?? '' }}" 
                            data-nominee-age="{{$employee->nominee->nominee_age ?? '' }}" 
                            data-nominee-gender="{{$employee->nominee->nominee_gender ?? '' }}" 
                            data-relation="{{$employee->nominee->relation ?? '' }}" 
                            data-nominee-image="{{$employee->nominee->nominee_image ?? '' }}" 
                            data-nominee-address="{{$employee->nominee->nominee_address ?? '' }}" 
                            data-nominee-marathi-address="{{$employee->nominee->nominee_marathi_address ?? '' }}" 
                            data-nominee-adhar-no="{{$employee->nominee->nominee_adhar_no ?? '' }}" 
                            data-bank-name="{{$employee->bankdtl->bank_name ?? '' }}" 
                            data-branch-name="{{$employee->bankdtl->branch_name ?? '' }}"
                            data-bank-account-no="{{$employee->bankdtl->bank_account_no ?? '' }}" 
                            data-ifsc-code="{{$employee->bankdtl->ifsc_code ?? '' }}" 
                            data-proof-1-no="{{$employee->bankdtl->proof_1_no ?? '' }}" 
                            data-proof-1-type="{{$employee->bankdtl->proof_1_type ?? '' }}" 
                            data-proof-2-image="{{$employee->bankdtl->proof_2_image ?? '' }}" 
                            data-proof-2-no="{{$employee->bankdtl->proof_2_no ?? '' }}" 
                            data-proof-2-type="{{$employee->bankdtl->proof_2_type ?? '' }}"         
                            class="text-decoration-none me-4 edit-employee-btn" 
                            data-bs-toggle="modal"
                            data-bs-target="#employeeModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        {{-- <a href="#" data-id="{{$employee->id}}" data-route="{{ route('employees.destroy', $employee->id) }}" data-name="{{ $employee->name ?? '' }}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a> --}}
                    </td>
                </tr>
                @php $i++ @endphp
                 @endforeach
                 @else
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No employees added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>   
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
         @include('layouts.pagination', ['paginationVariable' => 'employees'])
    </div>
</div>

<!-- Form Model -->
@include('master.employee.employee')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('employeeModal'));
            modal.show();
        });
    </script>
@endif --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-employee-btn").forEach(button => {
        button.addEventListener("click", function () {

            let modal = document.getElementById("employeeModal");

            // Fetch all data attributes from the clicked button
            let id = this.getAttribute("data-id");
            let name = this.getAttribute("data-name");
            let naav = this.getAttribute("data-naav");
            let createdBy = this.getAttribute("data-created-by");
            let createdById = this.getAttribute("data-created-by-id");
            let branchId = this.getAttribute("data-branch-id");
            let memberBranchId = this.getAttribute("data-member-branch");
            let route = this.getAttribute("data-route");
            // let subcasteId = this.getAttribute("data-subcaste-id");
            // let subcasteName = this.getAttribute("data-subcaste-name");
            // let departmentId = this.getAttribute("data-department-id");
            // let departmentName = this.getAttribute("data-department-name");
            
            let dob = this.getAttribute("data-dob");
            let gender = this.getAttribute("data-gender");
            let age = this.getAttribute("data-age");
            let dateOfJoining = this.getAttribute("data-date-of-joining");
            // let membershipDate = this.getAttribute("data-membership-date");
            let religion = this.getAttribute("data-religion");
            let category = this.getAttribute("data-category");
            let caste = this.getAttribute("data-caste");
            
            let dataMRegNo = this.getAttribute("data-m-reg-no");
            let panNo = this.getAttribute("data-pan-no");
            let adharNo = this.getAttribute("data-adhar-no");
            // let empCode = this.getAttribute("data-emp-code");
            let designationId = this.getAttribute("data-designation-id");
            // let designationName = this.getAttribute("data-designation-name");
            // let salary = this.getAttribute("data-salary");
            // let otherAllowance = this.getAttribute("data-other-allowance");
            let divisionId = this.getAttribute("data-division-id");
            // let divisionName = this.getAttribute("data-division-name");
            let subdivisionId = this.getAttribute("data-subdivision-id");
            // let subdivisionName = this.getAttribute("data-subdivision-name");
            // let centerId = this.getAttribute("data-center-id");
            // let centerName = this.getAttribute("data-center-name");
            // let joiningDate = this.getAttribute("data-joining-date");
            // let transferDate = this.getAttribute("data-transfer-date");
            // let retirementDate = this.getAttribute("data-retirement-date");
            let gpfNo = this.getAttribute("data-gpf-no");
            // let hra = this.getAttribute("data-hra");
            // let da = this.getAttribute("data-da");          
            
            let address = this.getAttribute("data-address");
            let marathiAddress = this.getAttribute("data-marathiAddress");
            let city = this.getAttribute("data-city");
            let mobileNo = this.getAttribute("data-mobile-no");
            // let phoneNo = this.getAttribute("data-phone-no");
            
            
            let nomineeId = this.getAttribute("data-nominee-id");
            let nomineeName = this.getAttribute("data-nominee-name");
            let marathiNomineeName = this.getAttribute("data-nominee-naav");
            let nomineeAge = this.getAttribute("data-nominee-age");
            let nomineeGender = this.getAttribute("data-nominee-gender");
            let nomineeRelation = this.getAttribute("data-relation");
            let nomineeImage = this.getAttribute("data-nominee-image");
            let nomineeAddress = this.getAttribute("data-nominee-address");
            let nomineeMarathiAddress = this.getAttribute("data-nominee-marathi-address");
            let nomineeAdharNo = this.getAttribute("data-nominee-adhar-no");
            
            let bankName = this.getAttribute("data-bank-name");
            let branchName = this.getAttribute("data-branch-name");
            let bankAccountNo = this.getAttribute("data-bank-account-no");
            let ifscCode = this.getAttribute("data-ifsc-code");
            
            let proof1No = this.getAttribute("data-proof-1-no");
            let proof1Type = this.getAttribute("data-proof-1-type");
            let proof1Image = this.getAttribute("data-proof-1-image");
            let proof2No = this.getAttribute("data-proof-2-no");
            let proof2Type = this.getAttribute("data-proof-2-type");
            let proof2Image = this.getAttribute("data-proof-2-image");
            
            // let directorId = this.getAttribute("data-director-id");
            // let shareAmount = this.getAttribute("data-share-amount");
            // let numberOfShares = this.getAttribute("data-number-of-shares");
            // let welfareFund = this.getAttribute("data-welfare-fund");
            // let pageNo = this.getAttribute("data-page-no");
            // let currentBalance = this.getAttribute("data-current-balance");
            // let monthlyBalance = this.getAttribute("data-monthly-balance");
            // let dividendAmount = this.getAttribute("data-dividend-amount");
            // let monthlyDeposit = this.getAttribute("data-monthly-deposit");
            // let demand = this.getAttribute("data-demand");
            // let type = this.getAttribute("data-type");
            
            // Populate the modal form fields
            document.getElementById("employeeId").value = id;
            document.getElementById("Name").value = name;
            document.getElementById("marathiName").value = naav;
            
            document.getElementById("createdBy").value = createdBy;
            document.getElementById("createdById").value = createdById;
            document.getElementById("branchId").value = branchId;
            
            document.getElementById("memberBranchId").value = memberBranchId;
            
            // document.getElementById("subcasteId").value = subcasteId;
            // document.getElementById("subcasteName").value = subcasteName;
            // document.getElementById("departmentId").value = departmentId;
            // document.getElementById("departmentName").value = departmentName;
            
            document.getElementById("dob").value = dob;
            document.getElementById("gender").value = gender;
            document.getElementById("age").value = age;
            document.getElementById("dateOfJoining").value = dateOfJoining;
            // document.getElementById("membershipDate").value = membershipDate;
            document.getElementById("religion").value = religion;
            if(document.getElementById("category")){
                document.getElementById("category").value = category;
            }
            document.getElementById("caste").value = caste;
            // document.getElementById("MRegNo").value = dataMRegNo;
            document.getElementById("panNo").value = panNo;
            document.getElementById("adharNo").value = adharNo;


            // document.getElementById("empCode").value = empCode;
            document.getElementById("designationId").value = designationId;
            // document.getElementById("designationName").value = designationName;
            // document.getElementById("salary").value = salary;
            // document.getElementById("otherAllowance").value = otherAllowance;
            document.getElementById("divisionId").value = divisionId;
            // document.getElementById("divisionName").value = divisionName;
            document.getElementById("subDivisionId").value = subdivisionId;
            // document.getElementById("subdivisionName").value = subdivisionName;
            // console.log("centerId",centerId);
            // document.getElementById("centerId").value = centerId;
            // document.getElementById("centerName").value = centerName;
            // document.getElementById("joiningDate").value = joiningDate;
            // document.getElementById("transferDate").value = transferDate;
            // document.getElementById("retirementDate").value = retirementDate;
            document.getElementById("gpfNo").value = gpfNo;
            // document.getElementById("hra").value = hra;
            // document.getElementById("da").value = da;
            
            document.getElementById("address").value = address;
            document.getElementById("marathiAddress").value = marathiAddress;
            document.getElementById("city").value = city;
            document.getElementById("mobileNo").value = mobileNo;
            // document.getElementById("phoneNo").value = phoneNo;
            
            
            // document.getElementById("nomineeId").value = nomineeId;
            document.getElementById("nomineeName").value = nomineeName;
            document.getElementById("marathiNomineeName").value = marathiNomineeName;
            document.getElementById("nomineeAge").value = nomineeAge;
            document.getElementById("nomineeGender").value = nomineeGender;
            document.getElementById("nomineeRelation").value = nomineeRelation;
            document.getElementById("nomineeImage").value = '';
            document.getElementById("nomineeAddress").value = nomineeAddress;
            document.getElementById("nomineeMarathiAddress").value = nomineeMarathiAddress;
            document.getElementById("nomineeAdharNo").value = nomineeAdharNo;
            
            document.getElementById("bankName").value = bankName;
            document.getElementById("branchName").value = branchName;
            document.getElementById("bankAccountNo").value = bankAccountNo;
            document.getElementById("ifscCode").value = ifscCode;
            
            document.getElementById("proof1No").value = proof1No;
            document.getElementById("proof1Type").value = proof1Type;
            document.getElementById("proof1Image").value = '';
            document.getElementById("proof2No").value = proof2No;
            document.getElementById("proof2Type").value = proof2Type;
            document.getElementById("proof2Image").value = '';

            // let directorSelect = document.getElementById("directorId");
            // if (directorSelect){
            //     directorSelect.value = directorId;
            // } else {
            //     console.error("Element #directorId not found in the DOM.");
            // }
            // document.getElementById("shareAmount").value = shareAmount;
            // document.getElementById("numberOfShares").value = numberOfShares;
            // document.getElementById("welfareFund").value = welfareFund;
            // document.getElementById("pageNo").value = pageNo;
            // document.getElementById("currentBalance").value = currentBalance;
            // document.getElementById("monthlyBalance").value = monthlyBalance;
            // document.getElementById("dividendAmount").value = dividendAmount;
            // document.getElementById("monthlyDeposit").value = monthlyDeposit;
            // document.getElementById("demand").value = demand;
            // document.getElementById("type").value = type;

            // Set form action and method
            let form = document.getElementById("employeeForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT"; // Change to PUT for update

            // Update modal title and button text
            document.getElementById("employeeModalLabel").textContent = "Edit Employee";
            document.querySelector("#employeeModal .btn-success").textContent = "Update Employee";
        });
    });

    // Reset modal on close
    document.getElementById("employeeModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("employeeForm");

        // Reset form fields
        form.reset();

        // Reset form method and action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('employees.store') }}");

        // Reset modal title & button text
        document.getElementById("employeeModalLabel").textContent = "Add Employee";
        document.querySelector("#employeeModal .btn-success").textContent = "Save Changes";
    });
});
</script>
<script src="{{asset('assets\js\autofil-content-employee.js')}}"></script>
@endsection