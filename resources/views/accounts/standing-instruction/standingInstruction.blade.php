<div class="modal fade" id="standingInstructionModal" tabindex="-1" aria-labelledby="standingInstructionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="standingInstructionModalLabel">Add Standing Instruction Master</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="creditLedger">Credit Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="creditLedger" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Credit Ledger ------</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="creditAcc">Credit Account</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="creditAcc" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Credit Account ------</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="creditTransfer">Credit Transfer</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="creditTransfer" class="w-100 px-2 py-1" type="text"
                                    placeholder="Credit Transfer">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="debitLedger">Debit Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="debitLedger" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Debit Ledger ------</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="debitAcc">Debit Account</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="debitAcc" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Debit Account ------</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="debitTransfer">Debit Transfer</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="debitTransfer" class="w-100 px-2 py-1" type="number"
                                    placeholder="Debit Transfer">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="date">Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="date" class="w-100 px-2 py-1" type="date" placeholder="Date">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="frequency">Frequency</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="frequency" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Frequency ------</option>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="noOfTimes">No. of Times</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="noOfTimes" class="w-100 px-2 py-1" type="number" placeholder="No. of Times">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="balanceInstallment">Balance Installment</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="balanceInstallment" class="w-100 px-2 py-1" type="number"
                                    placeholder="Balance Installment">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="executionDate">Execution Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="executionDate" class="w-100 px-2 py-1" type="date"
                                    placeholder="Execution Date">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="amount">Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="amount" class="w-100 px-2 py-1" type="number" placeholder="Amount">
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