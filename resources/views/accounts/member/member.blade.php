<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="memberModalLabel">Add Member</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-3 row-cols-xl-4 g-3">
                            <div class="col w-auto ps-2 ps-xl-5 d-none d-xl-block">
                                <label for="memId">Member id</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <input id="memId" class="w-100 px-2 py-1" type="text" placeholder="Member Id" disabled>
                            </div>
                        </div>

                        <div class="row mb-3 row-cols-xl-4 g-3">
                            <div class="col w-auto ps-2 ps-xl-5 d-none d-xl-block">
                                <label for="empId">Emp Acc. Id</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <input id="empId" class="w-100 px-2 py-1" type="text" placeholder="Emp Acc. Id"
                                    disabled>
                            </div>
                            <div class="col w-auto ps-2 ps-xl-5 d-none d-xl-block">
                                <label for="dptId">Department Id</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <input id="dptId" class="w-100 px-2 py-1" type="text" placeholder="Department Id"
                                    disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="name" class="w-100 px-2 py-1" type="text" placeholder="Name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="marathiName">नाव</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="marathiName" class="w-100 px-2 py-1" type="text" placeholder="नाव">
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
                                </li>                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!-- Personal Details -->
                                <div class="tab-pane fade show active py-3" id="personal-tab-pane" role="tabpanel"
                                    aria-labelledby="personal-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="address">Address</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <textarea id="address" placeholder="Address" class="w-100 px-2 py-1"
                                                rows="1" style="resize:none"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="marathiAddress">पत्ता</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <textarea id="marathiAddress" placeholder="पत्ता" class="w-100 px-2 py-1"
                                                rows="1" style="resize:none"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-1 ps-5 d-none d-xl-block">
                                            <label for="city">City</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <input id="city" class="w-100 px-2 py-1" type="text" placeholder="City">
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="mobNo" class="w-100">Mobile No.</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <input id="mobNo" class="w-100 px-2 py-1" type="text"
                                                placeholder="Mobile No.">
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="mobNo" class="w-100">Phone No.</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <input id="mobNo" class="w-100 px-2 py-1" type="text"
                                                placeholder="Mobile No.">
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="gender">Gender</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select id="gender" class="w-100 px-2 py-1">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="dob">Date of Birth</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input id="dob" class="w-100 px-2 py-1" type="date" placeholder="DOB">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="jainDate">Date of Joining</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input id="jainDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Date of Joining">
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="regNo" class="w-100">M. Reg. No.</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input id="regNo" class="w-100 px-2 py-1" type="number"
                                                placeholder="M. Reg. No.">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="age">Age</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input id="age" class="w-100 px-2 py-1" type="number" placeholder="Age">
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-1 ps-5 d-none d-xl-block">
                                            <label for="religion">Religion</label>
                                        </div>
                                        <div class="col-3 ps-5 pe-0 pe-xl-5">
                                            <select id="religion" class="w-100 px-2 py-1">
                                                <option value="hindu">Hindu</option>
                                                <option value="muslim">Muslim</option>
                                                <option value="sikh">Sikh</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="category">Category</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select id="category" class="w-100 px-2 py-1">
                                                <option value="SC/ST">SC/ST</option>
                                                <option value="OBC">OBC</option>
                                                <option value="Open">Open</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="caste">Caste</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select id="caste" class="w-100 px-2 py-1">
                                                <option value="mahar">Mahar</option>
                                                <option value="kunbi">Kunbi</option>
                                                <option value="kalar">Kalar</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="pan" class="w-100">Pan No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="pan" class="w-100 px-2 py-1" type="text" placeholder="Pan No.">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="aadhar">Aadhar No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="aadhar" class="w-100 px-2 py-1" type="number"
                                                placeholder="Aadhar No.">
                                        </div>
                                    </div>
                                </div>

                                <!-- Nominee Details -->
                                <div class="tab-pane fade p-3" id="nominee-tab-pane" role="tabpanel"
                                    aria-labelledby="nominee-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="nomineeName">Name</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="nomineeName" class="w-100 px-2 py-1" type="text"
                                                placeholder="Nominee Name">
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="marathiNomineeName">नाव</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="marathiNomineeName" class="w-100 px-2 py-1" type="text"
                                                placeholder="नाव">
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="nomineeAddress">Address</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <textarea id="nomineeAddress" placeholder="Nominee Address"
                                                class="w-100 px-2 py-1" rows="1" style="resize:none"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="marathiNomineeAddress">पत्ता</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <textarea id="marathiNomineeAddress" placeholder="पत्ता"
                                                class="w-100 px-2 py-1" rows="1" style="resize:none"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="nomineeAge">Age</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input id="nomineeAge" class="w-100 px-2 py-1" type="number"
                                                placeholder="Nominee Age">
                                        </div>

                                        <div class="col-1 d-none d-xl-block">
                                            <label for="nomineeGender">Gender</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select id="nomineeGender" class="w-100 px-2 py-1">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>

                                        <div class="col-1 d-none d-xl-block">
                                            <label for="relation">Relation</label>
                                        </div>
                                        <div class="col-3 pe-0 pe-xl-5">
                                            <select id="relation" class="w-100 px-2 py-1">
                                                <option value="">------ Select Relation with Nominee ------</option>
                                                <option value="husband">Husband</option>
                                                <option value="wife">Wife</option>
                                                <option value="daughter">Daughter</option>
                                                <option value="son">Son</option>
                                                <option value="Sister">Sister</option>
                                                <option value="brother">Brother</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="aadhar">Aadhar No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="aadhar" class="w-100 px-2 py-1" type="number"
                                                placeholder="Nominee Aadhar No.">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="aadhar">Nominee Photo</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="aadhar" class="w-100 px-2 py-1" type="file" accept="image/*"
                                                placeholder="Nominee Photo">
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
                                            <input id="bankName" class="w-100 px-2 py-1" type="text"
                                                placeholder="Bank Name">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="branchName">Branch Name</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="branchName" class="w-100 px-2 py-1" type="text"
                                                placeholder="Branch Name">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="accNo">Account No.</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="accNo" class="w-100 px-2 py-1" type="text"
                                                placeholder="Account No.">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="ifscCode">IFSC Code</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="ifscCode" class="w-100 px-2 py-1" type="text"
                                                placeholder="IFSC Code">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="proof1Type">Proof 1 Type</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select id="proof1Type" class="w-100 px-2 py-1">
                                                <option value="aadhar">Aadhar Card</option>
                                                <option value="pan">PAN Card</option>
                                                <option value="voting">Voting Card</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="proof1No">Proof 1 No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="proof1No" class="w-100 px-2 py-1" type="text"
                                                placeholder="Proof 1 No.">
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="proof1Copy">Proof 1 Copy</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="proof1Copy" class="w-100 px-2 py-1" type="file"
                                                accept="image/*,.pdf" placeholder="Proof 1 Copy">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="proof2Type">Proof 2 Type</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select id="proof2Type" class="w-100 px-2 py-1">
                                                <option value="aadhar">Aadhar Card</option>
                                                <option value="pan">PAN Card</option>
                                                <option value="voting">Voting Card</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="proof2No">Proof 2 No.</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="proof2No" class="w-100 px-2 py-1" type="text"
                                                placeholder="Proof 2 No.">
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="proof2Copy">Proof 2 Copy</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="proof2Copy" class="w-100 px-2 py-1" type="file"
                                                accept="image/*,.pdf" placeholder="Proof 2 Copy">
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
                                            <input id="empCode" class="w-100 px-2 py-1" type="text"
                                                placeholder="Emp Code">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="designation">Designation</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="designation" class="w-100 px-2 py-1" type="text"
                                                placeholder="Designation">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="salary">Salary</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="salary" class="w-100 px-2 py-1" type="number"
                                                placeholder="Salary">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="allowance">Other Allowance</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="allowance" class="w-100 px-2 py-1" type="text"
                                                placeholder="Other Allowance">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="division">Division</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select id="division" class="w-100 px-2 py-1">
                                                <option value="divA">Division A</option>
                                                <option value="divB">Division B</option>
                                                <option value="divC">Division C</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="subDivision">Sub-Division</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select id="subDivision" class="w-100 px-2 py-1">
                                                <option value="subDivA">Sub-Division A</option>
                                                <option value="subDivB">Sub-Division C</option>
                                                <option value="subDivC">Sub-Division C</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="center">Center</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select id="center" class="w-100 px-2 py-1">
                                                <option value="centerA">Center A</option>
                                                <option value="centerB">Center B</option>
                                                <option value="centerC">Center C</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="jainDate">Date of Joining</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input id="jainDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Date of Joining">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="transferDate">Transfer Date</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input id="transferDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Transfer Date">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="ratirementDate">Retirement Date</label>
                                        </div>
                                        <div class="col-2 pe-0 pe-xl-5">
                                            <input id="ratirementDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Retirement Date">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-1 ps-5 d-none d-xl-block">
                                            <label for="gpfNo">GPF No.</label>
                                        </div>
                                        <div class="col ps-5 pe-0 pe-xl-5">
                                            <input id="gpfNo" class="w-100 px-2 py-1" type="number"
                                                placeholder="GPF No.">
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="hra">HRA</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="hra" class="w-100 px-2 py-1" type="number" placeholder="HRA">
                                        </div>
                                        <div class="col-1 d-none d-xl-block">
                                            <label for="da">DA</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="da" class="w-100 px-2 py-1" type="number" placeholder="DA">
                                        </div>
                                    </div>
                                </div>

                                <!-- Share Tab -->
                                <div class="tab-pane fade py-3 px-5" id="share-tab-pane" role="tabpanel"
                                    aria-labelledby="share-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="director">Director</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="director" class="w-100 px-2 py-1" type="text"
                                                placeholder="Director">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="pageNo">Page No.</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="pageNo" class="w-100 px-2 py-1" type="number"
                                                placeholder="Page No.">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="dividentAmt">Divident Amount</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="dividentAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="Divident Amount">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="shareAmt">Share Amount</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="shareAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="Share Amount">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="currentBlance">Current Balance</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="currentBlance" class="w-100 px-2 py-1" type="number"
                                                placeholder="Current Balance">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="monthlyDeposit">Monthly Deposit</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="monthlyDeposit" class="w-100 px-2 py-1" type="number"
                                                placeholder="Monthly Deposit">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="welfareAmt">Welfare Amount</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="welfareAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="Welfare Amount">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="monthlyBalance">Monthly Balance</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="monthlyBalance" class="w-100 px-2 py-1" type="number"
                                                placeholder="Monthly Balance">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="demand">Demand</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-4">
                                            <select id="center" class="w-100 px-2 py-1">
                                                <option value="yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="accType">Account Type</label>
                                        </div>
                                        <div class="col-4 pe-0">
                                            <select id="center" class="w-100 px-2 py-1">
                                                <option value="general">General</option>
                                                <option value="fd">FD</option>
                                                <option value="rd">RD</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>