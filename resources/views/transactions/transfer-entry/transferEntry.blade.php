<div class="modal fade" id="transferEntryModal" tabindex="-1" aria-labelledby="transferEntryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="transferEntryModalLabel">Add Transfer Entry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="date">Date</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input id="date" class="w-100 px-2 py-1" type="date" placeholder="Date">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="transactionType">Transaction Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="transactionType" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Transaction Type ------</option>
                                    <option value="receipt">Receipt</option>
                                    <option value="payment">Payment</option>
                                    <option value="journal">Journal</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="ledger">Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="ledger" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Ledger ------</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="receipt">Receipt</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="receipt" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Receipt ------</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="payment">Payment</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="payment" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Payment ------</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="openingBalance">Opening Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="openingBalance" class="w-100 px-2 py-1" type="number"
                                    placeholder="Opening Balance">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="currentBalance">Current Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="currentBalance" class="w-100 px-2 py-1" type="number"
                                    placeholder="Current Balance">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="narration">Narration</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="narration" class="w-100 px-2 py-1" type="text" placeholder="Narration">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="mNarration">M-Narration</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="mNarration" class="w-100 px-2 py-1" type="number" placeholder="M-Narration">
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