<div class="modal fade" id="branchLedgerModal" tabindex="-1" aria-labelledby="branchLedgerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
             <form method="POST" action="{{route('branch-ledger.store')}}" id="branchLedgerModalForm">
                <input type="hidden" id="branchLedgerId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="branchLedgerModalLabel">Add Branch Ledger</h1>
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
                                <label for="branchCode">Branch Code</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="branch_code" id="branchCode" class="w-100 px-2 py-1 @error('branch_code') is-invalid @enderror" value="{{ old('branch_code') }}" type="text" placeholder="Branch Code">
                                @error('branch_code')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                
                           @isset($ledgers) 
                        @if ($ledgers->isNotEmpty())
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="glId">Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="glId" name="gl_id" class="w-100 px-2 py-1 @error('gl_id') is-invalid @enderror">
                                    <option value="">------ Select Ledger ------</option>
                                    @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"  
                                        {{ old('gl_id') == $ledger->id ? 'selected' : '' }}
                                        >
                                        {{ $ledger->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gl_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @endif
                        @endisset
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="openDate">Open Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="open_date" id="openDate" class="w-100 px-2 py-1 @error('open_date') is-invalid @enderror" value="{{ old('open_date') }}" type="date" placeholder="Open Date">
                                @error('open_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="openBalance">Open Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="open_balance" id="openBalance" class="w-100 px-2 py-1 @error('open_balance') is-invalid @enderror" value="{{ old('open_balance') }}" type="number"
                                    placeholder="Open Balance">
                                    @error('open_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="balance">Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="balance" id="balance" class="w-100 px-2 py-1 @error('balance') is-invalid @enderror" value="{{ old('balance') }}" type="number" placeholder="Balance">
                                @error('balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="balanceType">Balance Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="balanceType" name="balance_type" class="w-100 px-2 py-1 @error('balance_type') is-invalid @enderror">
                                    <option value="">------ Select Balance Type ------</option>
                                    <option value="Credit" {{ old('balance_type') == 'Credit' ? 'selected' : '' }}>Credit</option>
                                    <option value="Debit" {{ old('balance_type') == 'Debit' ? 'selected' : '' }}>Debit</option>
                                </select>
                                  @error('balance_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="itemType">Item Type</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="itemType" name="item_type" class="w-100 px-2 py-1 @error('item_type') is-invalid @enderror">
                                    <option value="">------ Select Item Type ------</option>
                                    <option value="Asset" {{ old('item_type') == 'Asset' ? 'selected' : '' }}>Asset</option>
                                    <option value="Liability" {{ old('item_type') == 'Liability' ? 'selected' : '' }}>Liability</option>
                                    <option value="Income" {{ old('item_type') == 'Income' ? 'selected' : '' }}>Income</option>
                                    <option value="Expense" {{ old('item_type') == 'Expense' ? 'selected' : '' }}>Expense</option>
                                </select>
                                @error('item_type')
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