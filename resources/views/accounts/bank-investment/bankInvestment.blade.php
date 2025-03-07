<div class="modal fade" id="bankInvestmentModal" tabindex="-1" aria-labelledby="bankInvestmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bankInvestmentModalLabel">Add Bank Investment</h1>
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
                                <label for="acc">Account</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="acc" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Account ------</option>
                                </select>
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
                                <label for="investmentType">Investment Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="investmentType" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Investment Type ------</option>
                                    <option value="rd">RD Loan</option>
                                    <option value="fd">FD Loan</option>
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
                                <label for="openingDate">Opening Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="openingDate" class="w-100 px-2 py-1" type="date" placeholder="Opening Date">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="openingBalance">Opening Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="openingBalance" class="w-100 px-2 py-1" type="number"
                                    placeholder="Opening Balance">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="currentBalance">Current Balance</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="currentBalance" class="w-100 px-2 py-1" type="number"
                                    placeholder="Current Balance">
                            </div>
                        </div>


                        <!-- Tabs -->
                        <div class="info-tabs border rounded mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info" id="rd-tab" data-bs-toggle="tab"
                                        data-bs-target="#rd-tab-pane" type="button" role="tab"
                                        aria-controls="rd-tab-pane" aria-selected="false">RD Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="fd-tab" data-bs-toggle="tab"
                                        data-bs-target="#fd-tab-pane" type="button" role="tab"
                                        aria-controls="fd-tab-pane" aria-selected="false">FD Detail</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!-- RD Details -->
                                <div class="tab-pane fade show active p-3 px-5" id="rd-tab-pane" role="tabpanel"
                                    aria-labelledby="rd-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdMaturityDate">Maturity Date</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="rdMaturityDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Maturity Date">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdDepositTermDays">Deposit Term Days</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="rdDepositTermDate" class="w-100 px-2 py-1" type="number"
                                                placeholder="Deposit Term Days">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdMonths">Months</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="rdMonths" class="w-100 px-2 py-1" type="number"
                                                placeholder="Months">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdYear">Years</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="rdYear" class="w-100 px-2 py-1" type="number"
                                                placeholder="Years">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdMonthlyAmt">Monthly Amount</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="rdMonthlyAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="Monthly Amount">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdTermMonths">RD Term Months</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="rdTermMonths" class="w-100 px-2 py-1" type="number"
                                                placeholder="RD Term Months">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdMaturityAmt">Maturity Amount</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="rdMaturityAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="Maturity Amount">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdInterestReceivable">Interest Receivable</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="rdInterestReceivable" class="w-100 px-2 py-1" type="number"
                                                placeholder="Interest Receivable">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="rdInterestFrequency">Interest Frequency</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-4">
                                            <input id="rdInterestFrequency" class="w-100 px-2 py-1" type="number"
                                                placeholder="Interest Frequency">
                                        </div>
                                    </div>
                                </div>

                                <!-- FD Tab -->
                                <div class="tab-pane fade p-3 px-5" id="fd-tab-pane" role="tabpanel"
                                    aria-labelledby="fd-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdMaturityDate">Maturity Date</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="fdMaturityDate" class="w-100 px-2 py-1" type="date"
                                                placeholder="Maturity Date">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdDepositTermDays">Deposit Term Days</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="fdDepositTermDate" class="w-100 px-2 py-1" type="number"
                                                placeholder="Deposit Term Days">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdMonths">Months</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="fdMonths" class="w-100 px-2 py-1" type="number"
                                                placeholder="Months">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdYear">Years</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="fdYear" class="w-100 px-2 py-1" type="number"
                                                placeholder="Years">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdAmt">RD Amount</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="fdAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="RD Amount">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdMonthlyAmt">Monthly Amount</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="fdMonthlyAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="Monthly Amount">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdMaturityAmt">Maturity Amount</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="fdMaturityAmt" class="w-100 px-2 py-1" type="number"
                                                placeholder="Maturity Amount">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdInterest">Interest</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="fdInterest" class="w-100 px-2 py-1" type="number"
                                                placeholder="Interest">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdInterestReceivable">Interest Receivable</label>
                                        </div>
                                        <div class="col pe-0 pe-xl-5">
                                            <input id="fdInterestReceivable" class="w-100 px-2 py-1" type="number"
                                                placeholder="Interest Receivable">
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="fdInterestFrequency">Interest Frequency</label>
                                        </div>
                                        <div class="col pe-0">
                                            <input id="fdInterestFrequency" class="w-100 px-2 py-1" type="number"
                                                placeholder="Interest Frequency">
                                        </div>
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