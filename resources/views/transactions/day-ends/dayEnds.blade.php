<div class="modal fade" id="dayEndsModal" tabindex="-1" aria-labelledby="dayEndsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('day-end.store')}}" id="dayEndsModalForm">
                <input type="hidden" id="dayEndsId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">   
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="dayEndsModalLabel">Add Day Ends</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                          <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="createdBy">Created By</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="created_by" id="createdBy" class="w-100 px-2 py-1 @error('created_by') is-invalid @enderror" value="{{$user->name}}" type="text" disabled placeholder="Crated By">
                                @error('created_by')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="date">Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="date" id="date" class="w-100 px-2 py-1 @error('date') is-invalid @enderror" value="{{ old('date') }}" type="date" placeholder="Date">
                                @error('date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="openingCash">Opening Cash</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="opening_cash" id="openingCash" class="w-100 px-2 py-1 @error('opening_cash') is-invalid @enderror" value="{{ old('opening_cash') }}" type="number"
                                    placeholder="Opening Cash">
                                    @error('opening_cash')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="totalCreditRs">Total Credit RS</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="total_credit_rs" id="totalCreditRs" class="w-100 px-2 py-1 @error('total_credit_rs') is-invalid @enderror" value="{{ old('total_credit_rs') }}" type="text"
                                    placeholder="Total Credit RS">
                                    @error('total_credit_rs')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="totalCreditChalans">Total Credit Challan</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="total_credit_chalans" id="totalCreditChalans" class="w-100 px-2 py-1 @error('total_credit_chalans') is-invalid @enderror" value="{{ old('total_credit_chalans') }}" type="number"
                                    placeholder="Total Credit Challan">
                                    @error('total_credit_chalans')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="totalDebitRs">Total Debit RS</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="total_debit_rs" id="totalDebitRs" class="w-100 px-2 py-1 @error('total_debit_rs') is-invalid @enderror" value="{{ old('total_debit_rs') }}" type="text"
                                    placeholder="Total Debit RS">
                                    @error('total_debit_rs')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="totalDebitChallans">Total Debit Challan</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="total_debit_challans" id="totalDebitChallans" class="w-100 px-2 py-1 @error('total_debit_challans') is-invalid @enderror" value="{{ old('total_debit_challans') }}" type="number"
                                    placeholder="Total Debit Challan">
                                    @error('total_debit_challans')
                                    <div class="invalid-feedback">{{$message}}</div>
                                 @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>