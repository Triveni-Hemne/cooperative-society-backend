@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Member</h3>
    <div class="row">
        <!-- Search Bar -->
        <div class="col-8 col-lg-5 mb-3">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col-8 col-lg-5">
           @include('layouts.branchFilterInput', [
                    'action' => route('members.index')
                ])
        </div>

        <div class="col col-md-2">
           @include('layouts.add-button', [
                'target' => '#memberModal',
                'text' => 'Add New'
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
                    <th scope="col">Date Of Join</th>
                    <th scope="col">Religion</th>
                    <th scope="col">Category</th>
                    <th scope="col">Caste</th>
                    <th scope="col">Subcaste</th>
                    <th scope="col">M. Reg. No.</th>
                    <th scope="col">Pan No.</th>
                    <th scope="col">Adhar</th>
                    <th scope="col">Department</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Address</th>
                    <th scope="col">पत्ता</th>
                    <th scope="col">City</th>
                    <th scope="col">Mobile No.</th>
                    <th scope="col">Employee Code</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Other Allowance</th>
                    <th scope="col">Division</th>
                    <th scope="col">Sub Division</th>
                    <th scope="col">Center</th>
                    <th scope="col">Joining Date</th>
                    <th scope="col">Retirement Date</th>
                    <th scope="col">GPF No.</th>
                    <th scope="col">HRA</th>
                    <th scope="col">DA</th>
                    <th scope="col">Bank Name</th>
                    <th scope="col">Branch Name</th>
                    <th scope="col">Bank Acc. No.</th>
                    <th scope="col">IFSC Code</th>
                    <th scope="col">Proof1 No (Type) </th>
                    <th scope="col">Proof1 Image</th>
                    <th scope="col">Proof2 No (Type) </th>
                    <th scope="col">Proof2 Image</th>
                    <th scope="col">Director</th>
                    <th scope="col">Share Amount</th>
                    <th scope="col">Number of Shares</th>
                    <th scope="col">Welfare Fund</th>
                    <th scope="col">Page No. </th>
                    <th scope="col">Current Balance</th>
                    <th scope="col">Monthly Balance</th>
                    <th scope="col">Dividend Amount</th>
                    <th scope="col">Monthly Deposit</th>
                    <th scope="col">Demand</th>
                    <th scope="col">Type</th>
                    <th scope="col">Nominee Name</th>
                    <th scope="col">Nominee Naav</th>
                    <th scope="col">Nominee Age</th>
                    <th scope="col">Nominee Gender</th>
                    <th scope="col">Nominee Relation</th>
                    <th scope="col">Nominee Image</th>
                    <th scope="col">Nominee Address</th>
                    <th scope="col">Nominee Address in Marathi</th>
                    <th scope="col">Nominee Adhar No. </th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($members->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($members as $member)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <th scope="row">{{$member->id}}</th>
                    <th scope="row">{{$member->name ?? ''}}</th>
                    <th scope="row">{{$member->naav ?? ''}}</th>
                    <th scope="row">{{$member->dob ?? ''}}</th>
                    <th scope="row">{{$member->gender ?? ''}}</th>
                    <th scope="row">{{$member->age ?? ''}}</th>
                    <th scope="row">{{$member->date_of_joining ?? ''}}</th>
                    <th scope="row">{{$member->religion ?? ''}}</th>
                    <th scope="row">{{$member->category ?? ''}}</th>
                    <th scope="row">{{$member->caste ?? ''}}</th>
                    <th scope="row">{{$member->subcaste->name ?? ''}}</th>
                    <th scope="row">{{$member->m_reg_no  ?? ''}}</th>
                    <th scope="row">{{$member->pan_no ?? ''}} </th>
                    <th scope="row">{{$member->adhar_no ?? ''}} </th>
                    <th scope="row">{{optional($member->department)->name  ?? ''}}</th>
                    <th scope="row">{{optional($member->branch)->name  ?? ''}}</th>
                    <th scope="row">{{$member->user->name ?? ''}}</th>
                    <th scope="row">{{$member->contact->address ?? ''}}</th>
                    <th scope="row">{{$member->contact->marathi_address ?? ''}}</th>
                    <th scope="row">{{$member->contact->city ?? ''}}</th>
                    <th scope="row">{{$member->contact->mobile_no ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->emp_code  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->designation->name  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->salary  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->other_allowance  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->division->name  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->subdivision->name  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->center->name  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->joining_date  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->transfer_date  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->retirement_date  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->gpf_no  ?? ''}}</th>
                    <th scope="row">{{optional($member->employee)->da  ?? ''}}</th>
                    <th scope="row">{{optional($member->bankdtl)->bank_name  ?? ''}}</th>
                    <th scope="row">{{optional($member->bankdtl)->branch_name  ?? ''}}</th>
                    <th scope="row">{{optional($member->bankdtl)->bank_account_no  ?? ''}}</th>
                    <th scope="row">{{optional($member->bankdtl)->ifsc_code  ?? ''}}</th>
                    <th scope="row">{{optional($member->bankdtl)->proof_1_no  ?? ''}} {{optional($member->bankdtl)->proof_1_type  ?? ''}}</th>
                    <th scope="row">{{optional($member->bankdtl)->proof_1_image  ?? ''}}</th>
                    <th scope="row">{{optional($member->bankdtl)->proof_2_no  ?? ''}} {{optional($member->bankdtl)->proof_2_type  ?? ''}}</th>
                    <th scope="row">{{optional($member->bankdtl)->proof_2_image  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->director->name  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->share_amount  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->number_of_shares  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->welfare_fund  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->page_no  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->current_balance  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->monthly_balance  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->dividend_amount  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->monthly_deposit  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->demand  ?? ''}}</th>
                    <th scope="row">{{optional($member->financialdtl)->type  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->nominee_name  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->nominee_naav  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->nominee_age  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->nominee_gender  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->relation  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->nominee_image  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->nominee_address  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->nominee_marathi_address  ?? ''}}</th>
                    <th scope="row">{{optional($member->nominee)->nominee_adhar_no  ?? ''}}</th>
                    <td>
                       <a href="#" 
                            data-id="{{$member->id}}" data-nominee-id="{{optional($member->nominee)->member_id }}" 
                            data-name="{{$member->name ?? '' }}" 
                            data-naav="{{$member->naav ?? '' }}" 
                            data-created-by="{{$member->user->id ?? '' }}" 
                            data-branch-id="{{$member->branch->id ?? '' }}" 
                            data-route="{{ route('members.update', $member->id) }}" 
                            data-subcaste-id="{{$member->subcaste->id ?? ''}}" 
                            data-subcaste-name="{{$member->subcaste->name ?? ''}}" 
                            data-department-id="{{$member->department->id ?? ''}}" 
                            data-department-name="{{$member->department->name ?? ''}}" 
                            data-dob="{{$member->dob ?? '' }}" 
                            data-gender="{{$member->gender ?? '' }}" 
                            data-age="{{$member->age ?? '' }}" 
                            data-date-of-joining="{{$member->date_of_joining ?? '' }}" 
                            data-religion="{{$member->religion ?? '' }}" 
                            data-category="{{$member->category ?? '' }}" 
                            data-caste="{{$member->caste ?? '' }}" 
                            data-m-reg-no="{{$member->m_reg_no ?? '' }}" 
                            data-pan-no="{{$member->pan_no ?? '' }}" 
                            data-adhar-no="{{$member->adhar_no ?? '' }}" 
                            data-emp-code="{{$member->employee->emp_code ?? '' }}" 
                            data-designation-id="{{$member->employee->designation->id ?? '' }}" 
                            data-designation-name="{{$member->employee->designation->name ?? '' }}" 
                            data-salary="{{$member->employee->salary ?? '' }}" 
                            data-other-allowance="{{$member->employee->other_allowance ?? '' }}" 
                            data-division-id="{{$member->employee->division_id ?? '' }}" 
                            data-division-name="{{$member->employee->division->name ?? '' }}" 
                            data-subdivision-id="{{$member->employee->subdivision_id ?? '' }}" 
                            data-subdivision-name="{{$member->employee->subdivision->name ?? '' }}" 
                            data-center-id="{{$member->employee->center_id ?? '' }}" 
                            data-center-name="{{$member->employee->center->name ?? '' }}" 
                            data-joining-date="{{$member->employee->joining_date ?? '' }}" 
                            data-transfer-date="{{$member->employee->transfer_date ?? '' }}" 
                            data-retirement-date="{{$member->employee->retirement_date ?? '' }}" 
                            data-gpf-no="{{$member->employee->gpf_no ?? '' }}" 
                            data-hra="{{$member->employee->hra ?? '' }}" 
                            data-da="{{$member->employee->da ?? '' }}" 
                            data-address="{{ $member->contact->address ?? '' }}" 
                            data-marathiAddress="{{$member->contact->marathi_address ?? ''}}" 
                            data-city="{{$member->contact->city ?? '' }}" 
                            data-mobile-no="{{$member->contact->mobile_no ?? '' }}" 
                            data-phone-no="{{$member->contact->phone_no ?? '' }}" 
                            data-nominee-name="{{$member->nominee->nominee_name ?? '' }}" 
                            data-nominee-naav="{{$member->nominee->nominee_naav ?? '' }}" 
                            data-nominee-age="{{$member->nominee->nominee_age ?? '' }}" 
                            data-nominee-gender="{{$member->nominee->nominee_gender ?? '' }}" 
                            data-relation="{{$member->nominee->relation ?? '' }}" 
                            data-nominee-image="{{$member->nominee->nominee_image ?? '' }}" 
                            data-nominee-address="{{$member->nominee->nominee_address ?? '' }}" 
                            data-nominee-marathi-address="{{$member->nominee->nominee_marathi_address ?? '' }}" 
                            data-nominee-adhar-no="{{$member->nominee->nominee_adhar_no ?? '' }}" 
                            data-bank-name="{{$member->bankdtl->bank_name ?? '' }}" 
                            data-branch-name="{{$member->bankdtl->branch_name ?? '' }}" 
                            data-bank-account-no="{{$member->bankdtl->bank_account_no ?? '' }}" 
                            data-ifsc-code="{{$member->bankdtl->ifsc_code ?? '' }}" 
                            data-proof-1-no="{{$member->bankdtl->proof_1_no ?? '' }}" 
                            data-proof-1-type="{{$member->bankdtl->proof_1_type ?? '' }}" 
                            data-proof-2-image="{{$member->bankdtl->proof_2_image ?? '' }}" 
                            data-proof-2-no="{{$member->bankdtl->proof_2_no ?? '' }}" 
                            data-proof-2-type="{{$member->bankdtl->proof_2_type ?? '' }}" 
                            data-director-id="{{$member->financialdtl->director_id ?? '' }}" 
                            data-share-amount="{{$member->financialdtl->share_amount ?? '' }}" 
                            data-number-of-shares="{{$member->financialdtl->number_of_shares ?? '' }}" 
                            data-welfare-fund="{{$member->financialdtl->welfare_fund ?? '' }}" data-page-no="{{$member->financialdtl->page_no ?? '' }}" data-current-balance="{{$member->financialdtl->current_balance ?? '' }}" data-monthly-balance="{{$member->financialdtl->monthly_balance ?? '' }}" data-dividend-amount="{{$member->financialdtl->dividend_amount ?? '' }}" data-monthly-deposit="{{$member->financialdtl->monthly_deposit ?? '' }}" data-demand="{{$member->financialdtl->demand ?? '' }}" data-type="{{$member->financialdtl->type ?? '' }}"
                            class="text-decoration-none me-4 edit-member-btn" 
                            data-bs-toggle="modal"
                            data-bs-target="#memberModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$member->id}}" data-route="{{ route('members.destroy', $member->id) }}" data-name="{{ $member->name }}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a>
                    </td>
                </tr>
                @php $i++ @endphp
                 @endforeach
                 @else
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No members added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>   
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
         @include('layouts.pagination', ['paginationVariable' => 'members'])
    </div>
</div>

<!-- Form Model -->
@include('accounts.member.member')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('memberModal'));
            modal.show();
        });
    </script>
@endif --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-member-btn").forEach(button => {
        button.addEventListener("click", function () {
            let modal = document.getElementById("memberModal");

            // Fetch all data attributes from the clicked button
            let id = this.getAttribute("data-id");
            let name = this.getAttribute("data-name");
            let naav = this.getAttribute("data-naav");
            let createdBy = this.getAttribute("data-created-by");
            let branchId = this.getAttribute("data-branch-id");
            let route = this.getAttribute("data-route");
            let subcasteId = this.getAttribute("data-subcaste-id");
            let subcasteName = this.getAttribute("data-subcaste-name");
            let departmentId = this.getAttribute("data-department-id");
            let departmentName = this.getAttribute("data-department-name");
            
            let dob = this.getAttribute("data-dob");
            let gender = this.getAttribute("data-gender");
            let age = this.getAttribute("data-age");
            let dateOfJoining = this.getAttribute("data-date-of-joining");
            let religion = this.getAttribute("data-religion");
            let category = this.getAttribute("data-category");
            let caste = this.getAttribute("data-caste");
            
            let dataMRegNo = this.getAttribute("data-m-reg-no");
            let panNo = this.getAttribute("data-pan-no");
            let adharNo = this.getAttribute("data-adhar-no");
            let empCode = this.getAttribute("data-emp-code");
            let designationId = this.getAttribute("data-designation-id");
            let designationName = this.getAttribute("data-designation-name");
            let salary = this.getAttribute("data-salary");
            let otherAllowance = this.getAttribute("data-other-allowance");
            let divisionId = this.getAttribute("data-division-id");
            let divisionName = this.getAttribute("data-division-name");
            let subdivisionId = this.getAttribute("data-subdivision-id");
            let subdivisionName = this.getAttribute("data-subdivision-name");
            let centerId = this.getAttribute("data-center-id");
            let centerName = this.getAttribute("data-center-name");
            let joiningDate = this.getAttribute("data-joining-date");
            let transferDate = this.getAttribute("data-transfer-date");
            let retirementDate = this.getAttribute("data-retirement-date");
            let gpfNo = this.getAttribute("data-gpf-no");
            let hra = this.getAttribute("data-hra");
            let da = this.getAttribute("data-da");          
            
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
            
            let directorId = this.getAttribute("data-director-id");
            let shareAmount = this.getAttribute("data-share-amount");
            let numberOfShares = this.getAttribute("data-number-of-shares");
            let welfareFund = this.getAttribute("data-welfare-fund");
            let pageNo = this.getAttribute("data-page-no");
            let currentBalance = this.getAttribute("data-current-balance");
            let monthlyBalance = this.getAttribute("data-monthly-balance");
            let dividendAmount = this.getAttribute("data-dividend-amount");
            let monthlyDeposit = this.getAttribute("data-monthly-deposit");
            let demand = this.getAttribute("data-demand");
            let type = this.getAttribute("data-type");
            
            // Populate the modal form fields
            document.getElementById("memberId").value = id;
            document.getElementById("Name").value = name;
            document.getElementById("marathiName").value = naav;
            
            document.getElementById("branchId").value = branchId;
            
            document.getElementById("subcasteId").value = subcasteId;
            // document.getElementById("subcasteName").value = subcasteName;
            document.getElementById("departmentId").value = departmentId;
            // document.getElementById("departmentName").value = departmentName;
            
            document.getElementById("dob").value = dob;
            document.getElementById("gender").value = gender;
            document.getElementById("age").value = age;
            document.getElementById("dateOfJoining").value = dateOfJoining;
            document.getElementById("religion").value = religion;
            document.getElementById("category").value = category;
            document.getElementById("caste").value = caste;
            document.getElementById("MRegNo").value = dataMRegNo;
            document.getElementById("panNo").value = panNo;
            document.getElementById("adharNo").value = adharNo;


            document.getElementById("empCode").value = empCode;
            document.getElementById("designationId").value = designationId;
            // document.getElementById("designationName").value = designationName;
            document.getElementById("salary").value = salary;
            document.getElementById("otherAllowance").value = otherAllowance;
            document.getElementById("divisionId").value = divisionId;
            // document.getElementById("divisionName").value = divisionName;
            document.getElementById("subdivisionId").value = subdivisionId;
            // document.getElementById("subdivisionName").value = subdivisionName;
            console.log("centerId",centerId);
            document.getElementById("centerId").value = centerId;
            // document.getElementById("centerName").value = centerName;
            document.getElementById("joiningDate").value = joiningDate;
            document.getElementById("transferDate").value = transferDate;
            document.getElementById("retirementDate").value = retirementDate;
            document.getElementById("gpfNo").value = gpfNo;
            document.getElementById("hra").value = hra;
            document.getElementById("da").value = da;
            
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

            let directorSelect = document.getElementById("directorId");
            if (directorSelect){
                directorSelect.value = directorId;
            } else {
                console.error("Element #directorId not found in the DOM.");
            }
            document.getElementById("shareAmount").value = shareAmount;
            document.getElementById("numberOfShares").value = numberOfShares;
            document.getElementById("welfareFund").value = welfareFund;
            document.getElementById("pageNo").value = pageNo;
            document.getElementById("currentBalance").value = currentBalance;
            document.getElementById("monthlyBalance").value = monthlyBalance;
            document.getElementById("dividendAmount").value = dividendAmount;
            document.getElementById("monthlyDeposit").value = monthlyDeposit;
            document.getElementById("demand").value = demand;
            document.getElementById("type").value = type;

            // Set form action and method
            let form = document.getElementById("memberForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT"; // Change to PUT for update

            // Update modal title and button text
            document.getElementById("memberModalLabel").textContent = "Edit Member";
            document.querySelector("#memberModal .btn-primary").textContent = "Update Member";
        });
    });

    // Reset modal on close
    document.getElementById("memberModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("memberForm");

        // Reset form fields
        form.reset();

        // Reset form method and action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('members.store') }}");

        // Reset modal title & button text
        document.getElementById("memberModalLabel").textContent = "Add Member";
        document.querySelector("#memberModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
<script src="{{asset('assets/js/autofill-calc-member-from.js')}}"></script>
<script src="{{asset('assets\js\autofil-content-member.js')}}"></script>
@endsection