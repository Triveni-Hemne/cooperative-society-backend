<div class="modal fade" id="generalLedgerModal" tabindex="-1" aria-labelledby="generalLedgerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
         <form method="POST" action="{{route('general-ledgers.store')}}" id="generalLedgerForm">
                <input type="hidden" id="generalLedgerId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="generalLedgerModalLabel">Add General Ledger</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                       
                        <div class="row ">
                             <div class="col-2">
                                <label for="ledger">Ledger No.</label>
                                 @if ($errors->any())
                                @foreach($errors as $e) 
                                Hello{{$e}}
                                @endforeach
                                @else
                                no errors
                                @endif
                            </div>
                            <div class="col-4">
                                <input name="ledger_no" id="ledgerNo" class="px-2 py-1 @error('ledger_no') is-invalid @enderror" value="{{ old('ledger_no') }}" type="text" placeholder="Ledger" required>
                                @error('ledger_no')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <label for="Name">Ledger Name</label>
                            </div>
                            <div class="col-4">
                                <input id="Name" name="name" class="px-2 py-1 @error('name') is-invalid @enderror" type="text" value="{{ old('name') }}" placeholder="Ledger Name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        @isset($generalLedgers) 
                        <div class="row mt-2">
                            @if ($generalLedgers->isNotEmpty())
                            <div class="col-2 ">
                                <label for="parentLedger">Parent Ledger</label>
                            </div>
                            <div class="col-4">
                                <select name="parent_ledger_id" id="parentLedger" class="w-100 px-2 py-1 @error('ledger_no') is-invalid @enderror">
                                    <option value="" {{ old('parent_ledger_id') ? '' : 'selected' }}>------Select Parent Ledger-------</option>
                                        @foreach ($generalLedgers as $generalLedger)
                                            <option value="{{ $generalLedger->id }}"  
                                            {{ old('parent_ledger_id') == $generalLedger->id ? 'selected' : '' }}
                                            >
                                            {{ $generalLedger->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_ledger_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                @endif
                        </div>
                        @endisset
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="balance">Balance</label>
                            </div>
                            <div class="col-2">
                                <input name="balance" id="balance" class="w-100 px-2 py-1 @error('balance') is-invalid @enderror" value="{{ old('balance') }}" type="number" placeholder="Balance" required>
                                @error('balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <select name="balance_type" id="balanceType" class="w-100 px-2 py-1 @error('balance_type') is-invalid @enderror" required>
                                    <option value="Credit">Credit</option>
                                    <option value="Debit">Debit</option>
                                </select>
                                @error('balance_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <label for="penalRate">Penal Rate</label>
                            </div>
                            <div class="col-2">
                                <input name="penal_rate" id="penalRate" class="w-100 px-2 py-1 @error('penal_rate') is-invalid @enderror" value="{{ old('penal_rate') }}" type="number" placeholder="Penal Rate">
                                @error('penal_rate')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="openBalance">Open Balance</label>
                            </div>
                            <div class="col-2">
                                <input name="open_balance" id="openBalance" class="w-100 px-2 py-1 @error('open_balance') is-invalid @enderror" value="{{ old('open_balance') }}" type="number" placeholder="Open Balance" required>
                                @error('open_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <select name="open_balance_type" id="openBalanceType" class="w-100 px-2 py-1 @error('open_balance_type') is-invalid @enderror" required>
                                    <option value="Credit">Credit</option>
                                    <option value="Debit">Debit</option>
                                </select>
                                @error('open_balance_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <label for="interestRate">Interest Rate</label>
                            </div>
                            <div class="col-2">
                                <input name="interest_rate" id="interestRate" class="w-100 px-2 py-1 @error('interest_rate') is-invalid @enderror" value="{{ old('interest_rate') }}" type="number"
                                    placeholder="Interest Rate" required>
                                    @error('interest_rate')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="minBalance">Min. Balance</label>
                            </div>
                            <div class="col-2">
                                <input name="min_balance" id="minBalance" class="w-100 px-2 py-1 @error('min_balance') is-invalid @enderror" value="{{ old('min_balance') }}" type="number" placeholder="Min. Balance" required>
                                @error('min_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <select name="min_balance_type" id="minBalanceType" class="w-100 px-2 py-1 @error('min_balance_type') is-invalid @enderror" required>
                                    <option value="Credit">Credit</option>
                                    <option value="Debit">Debit</option>
                                </select>
                                @error('min_balance_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                             <div class="col-2">
                                <label for="interestType">Interest Type</label>
                            </div>
                            <div class="col-3">
                                <select name="interest_type" id="interestType" class="w-100 px-2 py-1 @error('interest_type') is-invalid @enderror" required>
                                    <option value="Saving Deposite">Saving Deposite</option>
                                    <option value="Saving Deposite Monthly">Saving Deposite Monthly</option>
                                </select>
                                 @error('interest_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="openDate">Open Date</label>
                            </div>
                            <div class="col-2">
                                <input name="open_date" id="openDate" class="w-100 px-2 py-1 @error('open_date') is-invalid @enderror" value="{{ old('open_date') }}" type="date" placeholder="Open Date" required>
                                 @error('open_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <label for="openDate">GL Type</label>
                            </div>
                            <div class="col-2">
                                <select name="gl_type" id="glType" class="w-100 px-2 py-1 @error('gl_type') is-invalid @enderror" required>
                                    <option selected value="Society">Society</option>
                                    <option value="Store">Store</option>
                                </select>
                                 @error('gl_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="cdRatio">CD Ratio</label>
                            </div>
                            <div class="col-2">
                                <input type="number" name="cd_ratio" id="cdRatio" class="w-100 px-2 py-1 @error('cd_ratio') is-invalid @enderror">
                                 @error('cd_ratio')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="add_interest_to_balance">Add Interest to Balance</label>
                            </div>
                            <div class="col-2">
                                <select name="add_interest_to_balance" id="addInterestToBalance" class="w-100 px-2 py-1 @error('add_interest_to_balance') is-invalid @enderror">
                                    <option value="1">Yes</option>
                                    <option selected value="0">No</option>
                                </select>
                                 @error('add_interest_to_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <label for="itemOf">Item Of</label>
                            </div>
                            <div class="col-2">
                                <select name="item_of" id="itemOf" class="w-100 px-2 py-1 @error('item_of') is-invalid @enderror" required>
                                    <option value="assets">Assets</option>
                                    <option value="other">Other</option>
                                </select>
                                 @error('item_of')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="group">Group</label>
                            </div>
                            <div class="col-2">
                                <select name="group" id="group" class="w-100 px-2 py-1 @error('group') is-invalid @enderror">
                                    <option value="Deposit">Deposit</option>
                                    <option value="Loan">Loan</option>
                                    <option value="Bank">Bank</option>
                                    <option value="General">General</option>
                                    <option value="Funds">Funds</option>
                                    <option value="Share">Share</option>
                                </select>
                                 @error('group')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="subsidiary">Subsidiary</label>
                            </div>
                            <div class="col-2">
                                <select name="subsidiary" id="subsidiary" class="w-100 px-2 py-1 @error('subsidiary') is-invalid @enderror" required>
                                    <option value="1">Yes</option>
                                    <option selected value="0">No</option>
                                </select>
                                 @error('subsidiary')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <label for="sendSMS">Send SMS</label>
                            </div>
                            <div class="col-2">
                                <select name="send_sms" id="sendSMS" class="w-100 px-2 py-1 @error('send_sms') is-invalid @enderror" required>
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                                 @error('send_sms')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="type">Type</label>
                            </div>
                            <div class="col-3">
                                <select name="type" id="type" class="w-100 px-2 py-1 @error('type') is-invalid @enderror">
                                    <option value="Saving Deposits">Saving Deposits</option>
                                    <option value="Monthly Deposits">Monthly Deposits</option>
                                    <option value="Current Deposits">Recurring Deposits</option>
                                    <option value="Fixed Deposits">Fixed Deposits</option>
                                </select>
                                 @error('type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <label for="demand">Demand</label>
                            </div>
                            <div class="col-2">
                                <select name="demand" id="demand" class="w-100 px-2 py-1 @error('demand') is-invalid @enderror">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                                 @error('demand')
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