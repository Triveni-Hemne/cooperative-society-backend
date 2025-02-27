<div class="modal fade" id="generalLedgerModal" tabindex="-1" aria-labelledby="generalLedgerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="generalLedgerModalLabel">Add General Ledger</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <!-- <div class="row mb-3 row-cols-2 row-cols-xl-4 g-3">
                            <div class="col w-auto ps-2 ps-xl-5 d-none d-xl-block">
                                <label for="ledger">Ledger</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <input id="ledger" class="w-100 px-2 py-1" type="text" placeholder="Ledger">
                            </div>
                            <div class="col w-auto d-none d-xl-block ms-5">
                                <label for="name">Name</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <input id="name" class="w-100 px-2 py-1" type="text" placeholder="Name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                            </div>
                            <div class="col pe-0 pe-xl-5">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="marathiName">नाव</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="marathiName" class="w-100 px-2 py-1" type="text" placeholder="नाव">
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-2">
                                <label for="ledger">Ledger</label>
                            </div>
                            <div class="col-4">
                                <input id="ledger" class="px-2 py-1" type="text" placeholder="Ledger">
                            </div>
                            <div class="col-2">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-4">
                                <input id="name" class="w-100 px-2 py-1" type="text" placeholder="Name">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="balance">Balance</label>
                            </div>
                            <div class="col-2">
                                <input id="balance" class="w-100 px-2 py-1" type="text" placeholder="Balance">
                            </div>
                            <div class="col-2">
                                <select name="balance" id="balance" class="w-100 px-2 py-1">
                                    <option value="credit">Credit</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="marathiName">नाव</label>
                            </div>
                            <div class="col-4">
                                <input id="marathiName" class="w-100 px-2 py-1" type="text" placeholder="नाव">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="openBalance">Open Balance</label>
                            </div>
                            <div class="col-2">
                                <input id="openBalance" class="w-100 px-2 py-1" type="text" placeholder="Open Balance">
                            </div>
                            <div class="col-2">
                                <select name="balance" id="balance" class="w-100 px-2 py-1">
                                    <option value="credit">Credit</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="scheduleId">Schedule Id</label>
                            </div>
                            <div class="col-2">
                                <input id="scheduleId" class="w-100 px-2 py-1" type="number" placeholder="Schedule Id">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="minBalance">Min. Balance</label>
                            </div>
                            <div class="col-2">
                                <input id="minBalance" class="w-100 px-2 py-1" type="text" placeholder="Min. Balance">
                            </div>
                            <div class="col-2">
                                <select name="balance" id="balance" class="w-100 px-2 py-1">
                                    <option value="credit">Credit</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="interestRate">Interest Rate</label>
                            </div>
                            <div class="col-2">
                                <input id="interestRate" class="w-100 px-2 py-1" type="number"
                                    placeholder="Interest Rate">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="penalRate">Penal Rate</label>
                            </div>
                            <div class="col-2">
                                <input id="penalRate" class="w-100 px-2 py-1" type="number" placeholder="Penal Rate">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label for="addInterest">Add Interest To Balance</label>
                            </div>
                            <div class="col-2">
                                <select name="addInterest" id="addInterest" class="w-100 px-2 py-1">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="openDate">Open Date</label>
                            </div>
                            <div class="col-2">
                                <input id="openDate" class="w-100 px-2 py-1" type="date" placeholder="Open Date">
                            </div>
                            <div class="col">
                                <label for="openDate">GL Type</label>
                            </div>
                            <div class="col-2">
                                <select name="glType" id="glType" class="w-100 px-2 py-1">
                                    <option value="Society">Society</option>
                                    <option value="city">City</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label for="addLedger">Add Ledger to Demand List</label>
                            </div>
                            <div class="col-2">
                                <select name="addLedger" id="addLedger" class="w-100 px-2 py-1">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="itemOf">Item Of</label>
                            </div>
                            <div class="col-2">
                                <select name="itemOf" id="itemOf" class="w-100 px-2 py-1">
                                    <option value="assets">Assets</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="cdRatio">CD Ratio</label>
                            </div>
                            <div class="col-2">
                                <select name="cdRatio" id="cdRatio" class="w-100 px-2 py-1">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label for="minAmount">Min Amount</label>
                            </div>
                            <div class="col-2">
                                <input id="minAmount" class="w-100 px-2 py-1" type="number" placeholder="Min Amount">
                            </div>
                            <div class="col">
                                <label for="group">Group</label>
                            </div>
                            <div class="col-2">
                                <select name="group" id="group" class="w-100 px-2 py-1">
                                    <option value="deposit">Deposit</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="type">Type</label>
                            </div>
                            <div class="col-3">
                                <select name="type" id="type" class="w-100 px-2 py-1">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label for="subsidiary">Subsidiary</label>
                            </div>
                            <div class="col-2">
                                <select name="subsidiary" id="subsidiary" class="w-100 px-2 py-1">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="demand">Demand</label>
                            </div>
                            <div class="col-2">
                                <select name="demand" id="demand" class="w-100 px-2 py-1">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="interestType">Interest Type</label>
                            </div>
                            <div class="col-3">
                                <select name="interestType" id="interestType" class="w-100 px-2 py-1">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="generateAgentWise">Want To Generate AgentWise A/C no. </label>
                            </div>
                            <div class="col-2">
                                <select name="generateAgentWise" id="generateAgentWise" class="w-100 px-2 py-1">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="sendSMS">Send SMS</label>
                            </div>
                            <div class="col-2">
                                <select name="sendSMS" id="sendSMS" class="w-100 px-2 py-1">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="paid">Interest GLID (Paid/Receivable)</label>
                            </div>
                            <div class="col-2">
                                <select name="paid" id="paid" class="w-100 px-2 py-1">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="payable">Interest GLID (Payable/Receivable)</label>
                            </div>
                            <div class="col-2">
                                <select name="payable" id="payable" class="w-100 px-2 py-1">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="penalInterest">Penal Interest GLID (Paid/Received)</label>
                            </div>
                            <div class="col-2">
                                <select name="penalInterest" id="penalInterest" class="w-100 px-2 py-1">
                                    <option value=""></option>
                                </select>
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