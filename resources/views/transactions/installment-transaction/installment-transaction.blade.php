<div class="modal fade" id="installmentTransactionModal" tabindex="-1" aria-labelledby="installmentTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('installment-transactions.store')}}" id="installmentTransactionModalForm">
                <input type="hidden" id="installmentTransactionId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="installmentTransactionModalLabel">Installment Transaction</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-3">
                            @isset($memberDepoAccounts) 
                            <div class="col-2 d-none d-xl-block">
                                <label for="depositAccountId">Deposit Account</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                    @if ($memberDepoAccounts->isNotEmpty())
                                    <select id="depositAccountId" name="deposit_account_id" class="w-100 px-2 py-1 @error('deposit_account_id') is-invalid @enderror">
                                        <option value="">------ Select Deposit Account ------</option>
                                        @foreach ($memberDepoAccounts as $account)
                                            <option value="{{ $account->id }}"  
                                            {{ old('deposit_account_id') == $account->id ? 'selected' : '' }}
                                            >
                                            {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('deposit_account_id')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                     @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No deposit accounts available. Please add deposit accounts first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add deposit accounts before submitting the form.</small>
                                @endif
                                </div>
                            @endisset
                        </div>
                        <div class="row mb-2">
                             <div class="col-2 d-none d-xl-block">
                                <label for="installmentNo">Installment transaction No.</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="installment_no" id="installmentNo" class="w-100 px-2 py-1 @error('installment_no') is-invalid @enderror" value="{{ old('installment_no') }}" type="number" placeholder="Transaction No.">
                                @error('installment_no')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-2 d-none d-xl-block">
                                <label for="amountPaid">Amount Paid</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="amount_paid" id="amountPaid" class="w-100 px-2 py-1 @error('amount_paid') is-invalid @enderror" value="{{ old('amount_paid') }}" type="number" placeholder="Amount Paid">
                                @error('amount_paid')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 d-none d-xl-block">
                                <label for="paymentDate">Payment Date</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="payment_date" id="paymentDate" class="w-100 px-2 py-1 @error('payment_date') is-invalid @enderror" value="{{ old('payment_date') }}" type="date" placeholder="Payment Date">
                                @error('payment_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="interestEarned">Interest Earned</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                               <input name="interest_earned" id="interestEarned" class="w-100 px-2 py-1 @error('interest_earned') is-invalid @enderror" value="{{ old('interest_earned') }}" type="text" placeholder="Interest Earned">
                                @error('interest_earned')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 d-none d-xl-block">
                                <label for="totalBalance">Total Balance</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="total_balance" id="totalBalance" class="w-100 px-2 py-1 @error('total_balance') is-invalid @enderror" value="{{ old('total_balance') }}" type="number"
                                    placeholder="Total Balance">
                                    @error('total_balance')
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