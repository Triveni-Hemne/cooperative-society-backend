<div class="modal fade" id="depositAccOpeningModal" tabindex="-1" aria-labelledby="depositAccOpeningModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="depositAccOpeningModalLabel">Add Deposit Account Opening</h1>
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
                                <label for="interestRate">Interest Rate</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="interestRate" class="w-100 px-2 py-1" type="number"
                                    placeholder="Interest Rate">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="interestPayable">Interst Payable</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="interestPayable" class="w-100 px-2 py-1" type="number"
                                    placeholder="Interst Payable">
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
                                <label for="accClosingDate">Acc. Closing Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="accClosingDate" class="w-100 px-2 py-1" type="date"
                                    placeholder="Acc. Closing Date">
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
                                <label for="agent">Agent</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="agent" class="w-100 px-2 py-1" type="text" placeholder="Agent">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="pageNo">Page No.</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="pageNo" class="w-100 px-2 py-1" type="number" placeholder="Page No.">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="depositeType">Deposit Type</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="depositeType" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Deposit Type ------</option>
                                    <option value="savings">Savings</option>
                                    <option value="fd">Fixed Deposit</option>
                                    <option value="rd">Recurring Deposit</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="checkbox" name="closingFlag" id="closingFlag">
                                <label for="closingFlag">Closing Flag</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input type="checkbox" name="addDemand" id="addDemand">
                                <label for="addDemand">Add to Demand</label>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="installmentType">Installment Type</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="installmentType" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Installment Type ------</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="installmentAmt">Installment Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="installmentAmt" class="w-100 px-2 py-1" type="number"
                                    placeholder="Installment Amount">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="TotalInstallment">Total Installments</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="TotalInstallment" class="w-100 px-2 py-1" type="number"
                                    placeholder="Total Installments">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="totalPayableAmt">Total Payable Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="totalPayableAmt" class="w-100 px-2 py-1" type="number"
                                    placeholder="Total Payable Amount">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="TotalInstallmentPaid">Total Installments Paid</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="TotalInstallmentPaid" class="w-100 px-2 py-1" type="number"
                                    placeholder="Total Installments Paid">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="totalPayableAmt">Total Payable Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="totalPayableAmt" class="w-100 px-2 py-1" type="number"
                                    placeholder="Total Payable Amount">
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
                                    <button class="nav-link w-100 text-info" id="rd-tab" data-bs-toggle="tab"
                                        data-bs-target="#rd-tab-pane" type="button" role="tab"
                                        aria-controls="rd-tab-pane" aria-selected="false">RD Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="fd-tab" data-bs-toggle="tab"
                                        data-bs-target="#fd-tab-pane" type="button" role="tab"
                                        aria-controls="fd-tab-pane" aria-selected="false">FD Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="saving-tab" data-bs-toggle="tab"
                                        data-bs-target="#saving-tab-pane" type="button" role="tab"
                                        aria-controls="saving-tab-pane" aria-selected="false">Saving Detail</button>
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


                                    <!-- <div class="row mb-1">
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
                                    </div> -->
                                </div>

                                <!-- RD Tab -->
                                <div class="tab-pane fade p-3" id="rd-tab-pane" role="tabpanel" aria-labelledby="rd-tab"
                                    tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="openingInterest">Opening Interest</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="openingInterest" class="w-100 px-2 py-1" type="number"
                                                placeholder="Opening Interest">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="rdTermMonths">RD Term Months</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="rdTermMonths" class="w-100 px-2 py-1" type="number"
                                                placeholder="RD Term Months">
                                        </div>
                                    </div>
                                </div>

                                <!-- FD Tab -->
                                <div class="tab-pane fade p-3" id="fd-tab-pane" role="tabpanel" aria-labelledby="fd-tab"
                                    tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="maturityAmt">Maturity Amount</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="maturityAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="Maturity Amount">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="fdTermMonths">FD Term Months</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="fdTermMonths" class="w-100 px-2 py-1" type="number"
                                                placeholder="FD Term Months">
                                        </div>
                                    </div>
                                </div>

                                <!-- saving Tab -->
                                <div class="tab-pane fade p-3" id="saving-tab-pane" role="tabpanel"
                                    aria-labelledby="saving-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="balance">Balance</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="balance" class="w-100 px-2 py-1" type="text"
                                                placeholder="Balance">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="interestRate">Interest Rate</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="interestRate" class="w-100 px-2 py-1" type="text"
                                                placeholder="Interest Rate">
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