<div class="modal fade" id="subDivisionModal" tabindex="-1" aria-labelledby="subDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="subDivisionModalLabel">Add Sub-Division</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-3 row-cols-xl-4 g-3">
                            <div class="col w-auto ps-2 ps-xl-5 d-none d-xl-block">
                                <label for="id">Sr. No.</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <input id="id" class="w-100 px-2 py-1" type="text" placeholder="Sr. No." disabled>
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

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="address">Address</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea id="address" placeholder="Address" class="w-100 px-2 py-1" rows="3"
                                    style="resize:none"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="marathiAddress">पत्ता</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <textarea id="marathiAddress" placeholder="पत्ता" class="w-100 px-2 py-1" rows="3"
                                    style="resize:none"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="taluka">Taluka/Division</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <!-- <input id="mob" class="w-100 px-2 py-1" type="text" placeholder="Mobile No."> -->
                                <select id="taluka" class="w-100 px-2 py-1">
                                    <option value="select">---------- Select ----------</option>
                                    <option value="taluka1">M.R.V. DISTRIBUTION CO. LTD. BHANDARA</option>
                                    <option value="taluka1">M.R.V. DISTRIBUTION CO. LTD. BHANDARA</option>
                                    <option value="taluka1">M.R.V. DISTRIBUTION CO. LTD. BHANDARA</option>
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