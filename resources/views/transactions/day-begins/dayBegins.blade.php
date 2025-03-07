<div class="modal fade" id="dayBeginsModal" tabindex="-1" aria-labelledby="dayBeginsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="dayBeginsModalLabel">Add Day Begins</h1>
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
                                <label for="user">User</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="user" class="w-100 px-2 py-1" type="text" placeholder="User">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="status">Status</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select name="status" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Status ------</option>
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
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