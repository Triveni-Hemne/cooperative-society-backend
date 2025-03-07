<div class="modal fade" id="branchLedgerModal" tabindex="-1" aria-labelledby="branchLedgerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="branchLedgerModalLabel">Add Branch Ledger</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="branch">Branch</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="branch" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Branch ------</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="ledger">Ledger</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="ledger" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Ledger ------</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="openDate">Open Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="openDate" class="w-100 px-2 py-1" type="date" placeholder="Open Date">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="openBalance">Open Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="openBalance" class="w-100 px-2 py-1" type="number"
                                    placeholder="Open Balance">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="balance">Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="balance" class="w-100 px-2 py-1" type="number" placeholder="Balance">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="balanceType">Balance Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="balanceType" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Balance Type ------</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="itemType">Item Type</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="itemType" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Item Type ------</option>
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