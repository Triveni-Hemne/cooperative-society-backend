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
                                <input name="created_by" id="createdBy" class="w-100 px-2 py-1 @error('created_by') is-invalid @enderror" value="{{$user->name}}" type="text" disabled placeholder="Crated By" required>
                                @error('created_by')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                         <div class="row mb-2">
                             @isset($users) 
                             <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="userId">User</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                @if ($users->isNotEmpty())
                                 <select name="user_id" id="userId"  class="w-100 px-2 py-1 @error('user_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"  
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}
                                        >
                                        {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                  @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No users available. Please add users first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add users before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>

                        @if(Auth::user()->role === 'Admin')
                        <div class="row mb-2">
                             @isset($branches) 
                             <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="branchId">Branch</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                @if ($branches->isNotEmpty())
                                 <select name="branch_id" id="userId"  class="w-100 px-2 py-1 @error('branch_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"  
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                        >
                                        {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                  @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No branches available. Please add branches first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add branches before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>
                        @endif
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
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="ClosingCashBalance">Closing Cash Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="closing_cash_balance" id="ClosingCashBalance" class="w-100 px-2 py-1 @error('closing_cash_balance') is-invalid @enderror" value="{{ old('closing_cash_balance') }}" type="number" placeholder="Closing Cash Balance">
                                @error('closing_cash_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="TotalReceipts">Total Receipts</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="total_receipts" id="ClosingCashBalance" class="w-100 px-2 py-1 @error('total_receipts') is-invalid @enderror" value="{{ old('total_receipts') }}" type="number" placeholder="Total Receipts">
                                @error('total_receipts')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="TotalPayments">Total Payments</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="total_payments" id="TotalPayments" class="w-100 px-2 py-1 @error('total_payments') is-invalid @enderror" value="{{ old('total_payments') }}" type="number" placeholder="Total Payments">
                                @error('total_payments')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for=">SystemClosingBalance">System Closing Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="system_closing_balance" id="SystemClosingBalance" class="w-100 px-2 py-1 @error('system_closing_balance') is-invalid @enderror" value="{{ old('system_closing_balance') }}" type="number" placeholder="System Closing Balance">
                                @error('system_closing_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for=">DifferenceAmount">Difference Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="difference_amount" id="DifferenceAmount" class="w-100 px-2 py-1 @error('difference_amount') is-invalid @enderror" value="{{ old('difference_amount') }}" type="number" placeholder="Difference Amount">
                                @error('difference_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for=">IsDayClosed">Is Day Closed</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="is_day_closed" id="IsDayClosed" class="w-100 px-2 py-1 @error('is_day_closed') is-invalid @enderror" value="{{ old('is_day_closed') }}" type="text" placeholder="Is Day Closed">
                                @error('is_day_closed')
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

                        <div class="row mb-3">
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
                            <div class="row mb-3">
                                <div class="col-2 ps-5 d-none d-xl-block">
                                    <label for="remarks">Remarks</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    <textarea name="remarks" id="remarks" class="w-100 px-2 py-1  @error('remarks') is-invalid @enderror" type="text">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
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