<div class="modal fade" id="directorModal" tabindex="-1" aria-labelledby="directorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="directorModalLabel">Add Director</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-3 row-cols-2 row-cols-xl-4 g-3">
                            <div class="col w-auto ps-2 ps-xl-5 d-none d-xl-block">
                                <label for="id">ID</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <input id="id" class="w-100 px-2 py-1" type="text" placeholder="ID" disabled>
                            </div>
                            <div class="col w-auto d-none d-xl-block ms-5">
                                <label for="memId">Member ID</label>
                            </div>
                            <div class="col ms-0 ms-xl-5">
                                <input id="memId" class="w-100 px-2 py-1" type="text" placeholder="Member ID">
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
                                <label for="newId">ID</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="newId" class="w-100 px-2 py-1" type="text" placeholder="ID">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="designation">Designation</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="designation" class="w-100 px-2 py-1" type="text" placeholder="Designation">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="mob">Mobile No.</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="mob" class="w-100 px-2 py-1" type="text" placeholder="Mobile No.">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="mob2">Mobile No.</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="mob2" class="w-100 px-2 py-1" type="text" placeholder="Mobile No.">
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-xl-4 g-1">
                            <div class="col w-auto ps-0 ps-xl-5">
                                <label for="fromDate">From Date</label>
                            </div>
                            <div class="col mb-3 mb-xl-0 ms-0 ms-xl-3">
                                <input id="fromDate" class="w-100 px-2 py-1" type="date">
                            </div>
                            <div class="col w-auto ms-0 ms-xl-5">
                                <label for="endDate">End Date</label>
                            </div>
                            <div class="col ms-0 ms-xl-3">
                                <input id="endDate" class="w-100 px-2 py-1" type="date">
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