<div class="modal fade" id="dayEndsModal" tabindex="-1" aria-labelledby="dayEndsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="dayEndsModalLabel">Add Day Ends</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="date">Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="date" class="w-100 px-2 py-1" type="date" placeholder="Date">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="openingCash">Opening Cash</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="openingCash" class="w-100 px-2 py-1" type="number"
                                    placeholder="Opening Cash">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="totalCreditRS">Total Credit RS</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="totalCreditRS" class="w-100 px-2 py-1" type="text"
                                    placeholder="Total Credit RS">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="totalCreditChallan">Total Credit Challan</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="totalCreditChallan" class="w-100 px-2 py-1" type="number"
                                    placeholder="Total Credit Challan">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="totalDebitRS">Total Debit RS</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="totalDebitRS" class="w-100 px-2 py-1" type="text"
                                    placeholder="Total Debit RS">
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="totalDebitChallan">Total Debit Challan</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="totalDebitChallan" class="w-100 px-2 py-1" type="number"
                                    placeholder="Total Debit Challan">
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