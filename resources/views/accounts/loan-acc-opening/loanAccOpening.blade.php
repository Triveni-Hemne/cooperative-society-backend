<div class="modal fade" id="loanAccOpeningModal" tabindex="-1" aria-labelledby="loanAccOpeningModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loanAccOpeningModalLabel">Add Loan Account Opening</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="ledger">Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="ledger" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Ledger ------</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="photoCopy">Photo Copy</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="photoCopy" class="w-100 px-2 py-1" type="file" accept="image/*"
                                    placeholder="Photo Copy">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="memeber">Member</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="member" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Member ------</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="signCopy">Signature Copy</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="signCopy" class="w-100 px-2 py-1" type="file" accept="image/*,.pdf"
                                    placeholder="Signature Copy">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="acc">Account</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="acc" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Account ------</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="accNo">Account No.</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="accNo" class="w-100 px-2 py-1" type="text" placeholder="Account No.">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="name" class="w-100 px-2 py-1" type="text" placeholder="Name">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="loanType">Loan Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="loanType" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Loan Type ------</option>
                                    <option value="gold">Gold Loan</option>
                                    <option value="deposit">Deposit Loan</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="interestRate">Interest Rate</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="interestRate" class="w-100 px-2 py-1" type="number"
                                    placeholder="Interest Rate">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="actDate">Act Start Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="actDate" class="w-100 px-2 py-1" type="date" placeholder="Act Start Date">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="emiAmt">EMI Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="emiAmt" class="w-100 px-2 py-1" type="number" placeholder="EMI Amount">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="openBalance">Open Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="openBalance" class="w-100 px-2 py-1" type="number"
                                    placeholder="Open Balance">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="balance">Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="balance" class="w-100 px-2 py-1" type="number" placeholder="Balance">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="purpose">Purpose</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="purpose" class="w-100 px-2 py-1" type="text" placeholder="Purpose">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="principleAmt">Principle Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="principleAmt" class="w-100 px-2 py-1" type="number"
                                    placeholder="Principle Amount">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="startDate">Start Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="startDate" class="w-100 px-2 py-1" type="date" placeholder="Start Date">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="endDate">End Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="endDate" class="w-100 px-2 py-1" type="date" placeholder="End Date">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="tenure">Tenure</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="tenure" class="w-100 px-2 py-1" type="date" placeholder="Tenure">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="priority">Priority</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="priority" class="w-100 px-2 py-1" type="text" placeholder="Priority">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="loanAmt">Loan Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="loanAmt" class="w-100 px-2 py-1" type="number" placeholder="Loan Amount">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="collateralType">Collateral Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="collateralType" class="w-100 px-2 py-1" type="text"
                                    placeholder="Collateral Type">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="collateralValue">Collateral Value</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="collateralValue" class="w-100 px-2 py-1" type="number"
                                    placeholder="Collateral Value">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="status">Status</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="status" class="w-100 px-2 py-1" type="text" placeholder="Status">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col ps-5">
                                <input type="checkbox" name="lossAsset" id="lossAsset">
                                <label for="lossAsset">Is Loss Asset</label>
                            </div>
                            <div class="col">
                                <input type="checkbox" name="caseFlag" id="caseFlag">
                                <label for="caseFlag">Case Flag</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input type="checkbox" name="addDemand" id="addDemand">
                                <label for="addDemand">Add to Demand</label>
                            </div>
                            <div class="col-2 d-none d-xl-block text-end">
                                <label for="pageNo">Page No.</label>
                            </div>
                            <div class="col-3 pe-0 pe-xl-5">
                                <input id="pageNo" class="w-100 px-2 py-1" type="number" placeholder="Page No.">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="interest">Interest</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="interest" class="w-100 px-2 py-1" type="number" placeholder="Interest">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="openInterest">Open Interest</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="openInterest" class="w-100 px-2 py-1" type="number"
                                    placeholder="Open Interest">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="insurance">Insurance</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="insurance" class="w-100 px-2 py-1" type="text" placeholder="Insurance">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="insuranceDate">Insurance Date</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="insuranceDate" class="w-100 px-2 py-1" type="date"
                                    placeholder="Insurance Date">
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-2  ps-5 d-none d-xl-block">
                                <label for="postage">Postage</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="postage" class="w-100 px-2 py-1" type="text" placeholder="Postage">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="noticeFee">Notice Fee</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="noticeFee" class="w-100 px-2 py-1" type="text" placeholder="Notice Fee">
                            </div>
                        </div>


                        <!-- Tabs -->
                        <div class="info-tabs border rounded mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info" id="nominee-tab"
                                        data-bs-toggle="tab" data-bs-target="#nominee-tab-pane" type="button" role="tab"
                                        aria-controls="nominee-tab-pane" aria-selected="true">Nominee Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="goldLoan-tab" data-bs-toggle="tab"
                                        data-bs-target="#goldLoan-tab-pane" type="button" role="tab"
                                        aria-controls="goldLoan-tab-pane" aria-selected="false">Gold Loan
                                        Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="guarantors-tab" data-bs-toggle="tab"
                                        data-bs-target="#guarantors-tab-pane" type="button" role="tab"
                                        aria-controls="guarantors-tab-pane" aria-selected="false">Guarantors
                                        Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="installments-tab" data-bs-toggle="tab"
                                        data-bs-target="#installments-tab-pane" type="button" role="tab"
                                        aria-controls="installments-tab-pane" aria-selected="false">Installments
                                        Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="resolution-tab" data-bs-toggle="tab"
                                        data-bs-target="#resolution-tab-pane" type="button" role="tab"
                                        aria-controls="resolution-tab-pane" aria-selected="false">Resolution
                                        Detail</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!-- Nominee Details -->
                                <div class="tab-pane fade show active p-3" id="nominee-tab-pane" role="tabpanel"
                                    aria-labelledby="nominee-tab" tabindex="0">

                                    <div class="row px-5">
                                        <div class="col">
                                            <h6 class="text-center">Nominee 1</h6>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee1Name">Name</label>
                                                </div>
                                                <div class="col">
                                                    <input id="nominee1Name" class="w-100 px-2 py-1" type="text"
                                                        placeholder="Nominee Name">
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="marathiNominee1Name">नाव</label>
                                                </div>
                                                <div class="col">
                                                    <input id="marathiNominee1Name" class="w-100 px-2 py-1" type="text"
                                                        placeholder="नाव">
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee1Age">Age</label>
                                                </div>
                                                <div class="col">
                                                    <input id="nominee1Age" class="w-100 px-2 py-1" type="number"
                                                        placeholder="Age">
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee1Gender">Gender</label>
                                                </div>
                                                <div class="col">
                                                    <select name="nominee1Gender" class="w-100 px-2 py-1">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee1Relation">Relation</label>
                                                </div>
                                                <div class="col">
                                                    <select name="nominee1Relation" class="w-100 px-2 py-1">
                                                        <option value="husband">Husband</option>
                                                        <option value="wife">Wife</option>
                                                        <option value="father">Father</option>
                                                        <option value="mother">Mother</option>
                                                        <option value="brother">Brother</option>
                                                        <option value="sister">Sister</option>
                                                        <option value="son">Son</option>
                                                        <option value="daughter">Daughter</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>

                                                <div class="row">
                                                    <div class="col-2 d-none d-xl-block">
                                                        <label for="nominee1Photo">Photo</label>
                                                    </div>
                                                    <div class="col">
                                                        <input id="nominee1Photo" class="w-100 px-2 py-1" type="file"
                                                            accept="image/*" placeholder="Nominee Photo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col">
                                            <h6 class="text-center">Nominee 2</h6>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee2Name">Name</label>
                                                </div>
                                                <div class="col">
                                                    <input id="nominee2Name" class="w-100 px-2 py-1" type="text"
                                                        placeholder="Nominee Name">
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="marathiNominee2Name">नाव</label>
                                                </div>
                                                <div class="col">
                                                    <input id="marathiNominee2Name" class="w-100 px-2 py-1" type="text"
                                                        placeholder="नाव">
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee2Age">Age</label>
                                                </div>
                                                <div class="col">
                                                    <input id="nominee2Age" class="w-100 px-2 py-1" type="number"
                                                        placeholder="Age">
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee2Gender">Gender</label>
                                                </div>
                                                <div class="col">
                                                    <select name="nominee2Gender" class="w-100 px-2 py-1">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee2Relation">Relation</label>
                                                </div>
                                                <div class="col">
                                                    <select name="nominee2Relation" class="w-100 px-2 py-1">
                                                        <option value="husband">Husband</option>
                                                        <option value="wife">Wife</option>
                                                        <option value="father">Father</option>
                                                        <option value="mother">Mother</option>
                                                        <option value="brother">Brother</option>
                                                        <option value="sister">Sister</option>
                                                        <option value="son">Son</option>
                                                        <option value="daughter">Daughter</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>

                                                <div class="row">
                                                    <div class="col-2 d-none d-xl-block">
                                                        <label for="nominee2Photo">Photo</label>
                                                    </div>
                                                    <div class="col">
                                                        <input id="nominee2Photo" class="w-100 px-2 py-1" type="file"
                                                            accept="image/*" placeholder="Nominee Photo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gold Loan Tab -->
                                <div class="tab-pane fade p-3" id="goldLoan-tab-pane" role="tabpanel"
                                    aria-labelledby="goldLoan-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="goldWeight">Gold Weight</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="goldWeight" class="w-100 px-2 py-1" type="number"
                                                placeholder="Gold Weight">
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="goldPurity">Gold Purity</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="goldPurity" class="w-100 px-2 py-1" type="text"
                                                placeholder="Gold Purity">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="marketVal">Market Value</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="marketVal" class="w-100 px-2 py-1" type="text"
                                                placeholder="Market Value">
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="pledgeDate">Pledge Date</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="pledgeDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Pledge Date">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="releaseState">Release State</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="releaseState" class="w-100 px-2 py-1" type="text"
                                                placeholder="Release State">
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="releaseDate">Release Date</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="releaseDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Release Date">
                                        </div>
                                    </div>
                                </div>

                                <!-- Guarantors Tab -->
                                <div class="tab-pane fade p-3" id="guarantors-tab-pane" role="tabpanel"
                                    aria-labelledby="guarantors-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="guarantorMem">Member</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="guarantorMem" class="w-100 px-2 py-1" type="number"
                                                placeholder="Member">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="guarantorType">Guarantor Type</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="guarantorType" class="w-100 px-2 py-1" type="number"
                                                placeholder="Guarantor Type">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="guarantorStatus">Status</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="guarantorStatus" class="w-100 px-2 py-1" type="text"
                                                placeholder="Status">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="addedOn">Added On</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="addedOn" class="w-100 px-2 py-1" type="text"
                                                placeholder="Added On">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="guarantorReleaseDate">Release Date</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="guarantorReleaseDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Release Date">
                                        </div>
                                    </div>
                                </div>

                                <!-- Installments Tab -->
                                <div class="tab-pane fade p-3 px-5" id="installments-tab-pane" role="tabpanel"
                                    aria-labelledby="installments-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="installmentType">Installment Type</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select name="installmentType" class="w-100 px-2 py-1">
                                                <option value="select">------ Select Installment Type ------</option>
                                            </select>
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="matureDate">Mature Date</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="matureDate" class="w-100 px-2 py-1" type="text"
                                                placeholder="Mature Date">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="firstInstallmentDate">First Installment Date</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="firstInstallmentDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="First Installment Date">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="totalInstalllment">Total Installments</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="totalInstalllment" class="w-100 px-2 py-1" type="number"
                                                placeholder="Total Installments">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="installmentWithInterest">Installment with Interest</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="installmentWithInterest" class="w-100 px-2 py-1" type="text"
                                                placeholder="Installment with Interest">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="totalInstalllmentPaid">Total Installments Paid</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="totalInstalllmentPaid" class="w-100 px-2 py-1" type="number"
                                                placeholder="Total Installments Paid">
                                        </div>
                                    </div>
                                </div>

                                <!-- Resolution Tab -->
                                <div class="tab-pane fade p-3 px-5" id="resolution-tab-pane" role="tabpanel"
                                    aria-labelledby="resolution-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 d-none d-xl-block">
                                            <label for="resolutionNo">Resolution No.</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="resolutionNo" class="w-100 px-2 py-1" type="number"
                                                placeholder="Resolution No.">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 d-none d-xl-block">
                                            <label for="resolutionDate">Resolution Date</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="resolutionDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Resolution Date">
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