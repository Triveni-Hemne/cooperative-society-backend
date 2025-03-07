<div class="modal fade" id="generalAccModal" tabindex="-1" aria-labelledby="generalAccModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="generalAccModalLabel">Add General Account</h1>
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
                                <label for="memeber">Member</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="member" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Member ------</option>
                                </select>
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
                                <label for="startDate">Start Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="startDate" class="w-100 px-2 py-1" type="date" placeholder="Start Date">
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
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="agent" class="w-100 px-2 py-1" type="text" placeholder="Agent">
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
                            <div class="col pe-0 pe-xl-5">
                                <select name="installmentType" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Installment Type ------</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quaterly">Quaterky</option>
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
                                <label for="totalInstallmentPaid">Total Installment Paid</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="totalInstallmentPaid" class="w-100 px-2 py-1" type="number"
                                    placeholder="Total Installment Paid">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="closingDate">Closing Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="closingDate" class="w-100 px-2 py-1" type="date" placeholder="Closing Date">
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