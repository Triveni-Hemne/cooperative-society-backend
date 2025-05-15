<div class="modal fade" id="generalLedgerModal" tabindex="-1" aria-labelledby="generalLedgerModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('general-ledgers.store') }}" id="generalLedgerForm"
                class="needs-validation" novalidate>
                <input type="hidden" id="generalLedgerId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-book-fill me-2"></i>
                       <span id="generalLedgerModalLabel"> Add General Ledger</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="ledger_no" id="ledgerNo" type="text"
                                        class="form-control @error('ledger_no') is-invalid @enderror"
                                        value="{{ old('ledger_no') }}" placeholder="Ledger No." required>
                                    <label for="ledgerNo" class="form-label">Ledger No.</label>
                                    @error('ledger_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="Name" name="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="Ledger Name" required>
                                    <label for="Name" class="form-label required">Ledger Name</label>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @isset($generalLedgers)
                        @if ($generalLedgers->isNotEmpty())
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select name="parent_ledger_id" id="parentLedger"
                                        class="form-select @error('parent_ledger_id') is-invalid @enderror">
                                        <option value="" {{ old('parent_ledger_id') ? '' : 'selected' }}>Select Parent Ledger</option>
                                        @foreach ($generalLedgers as $generalLedger)
                                        <option value="{{ $generalLedger->id }}"
                                            {{ old('parent_ledger_id') == $generalLedger->id ? 'selected' : '' }}>
                                            {{ $generalLedger->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="parentLedger" class="form-label">Parent Ledger</label>
                                    @error('parent_ledger_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <strong>⚠️ No parent ledger available.</strong><br>
                            Please add parent ledger first.
                        </div>
                        @endif
                        @endisset

                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="balance" id="balance" type="number" step="0.01"
                                        class="form-control @error('balance') is-invalid @enderror"
                                        value="{{ old('balance') }}" placeholder="Balance" required>
                                    <label for="balance" class="form-label">Balance</label>
                                    @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="balance_type" id="balanceType" required
                                        class="form-select @error('balance_type') is-invalid @enderror">
                                        <option value="Credit" {{ old('balance_type') == 'Credit' ? 'selected' : '' }}>
                                            Credit
                                        </option>
                                        <option value="Debit" {{ old('balance_type') == 'Debit' ? 'selected' : '' }}>
                                            Debit
                                        </option>
                                    </select>
                                    <label for="balanceType" class="form-label">Balance Type</label>
                                    @error('balance_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="penal_rate" id="penalRate" type="number" step="0.01"
                                        class="form-control @error('penal_rate') is-invalid @enderror"
                                        value="{{ old('penal_rate') }}" placeholder="Penal Rate">
                                    <label for="penalRate" class="form-label">Penal Rate</label>
                                    @error('penal_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="open_balance" id="openBalance" type="number" step="0.01"
                                        class="form-control @error('open_balance') is-invalid @enderror"
                                        value="{{ old('open_balance') }}" placeholder="Open Balance" required>
                                    <label for="openBalance" class="form-label">Open Balance</label>
                                    @error('open_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="open_balance_type" id="openBalanceType" required
                                        class="form-select @error('open_balance_type') is-invalid @enderror">
                                        <option value="Credit"
                                            {{ old('open_balance_type') == 'Credit' ? 'selected' : '' }}>Credit
                                        </option>
                                        <option value="Debit"
                                            {{ old('open_balance_type') == 'Debit' ? 'selected' : '' }}>Debit
                                        </option>
                                    </select>
                                    <label for="openBalanceType" class="form-label">Open Balance Type</label>
                                    @error('open_balance_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="interest_rate" id="interestRate" type="number" step="0.01"
                                        class="form-control @error('interest_rate') is-invalid @enderror"
                                        value="{{ old('interest_rate') }}" placeholder="Interest Rate" required>
                                    <label for="interestRate" class="form-label">Interest Rate</label>
                                    @error('interest_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="interest_type" id="interestType" required
                                        class="form-select @error('interest_type') is-invalid @enderror">
                                        <option value="Saving Deposite"
                                            {{ old('interest_type') == 'Saving Deposite' ? 'selected' : '' }}>Saving
                                            Deposite
                                        </option>
                                        <option value="Saving Deposite Monthly"
                                            {{ old('interest_type') == 'Saving Deposite Monthly' ? 'selected' : '' }}>
                                            Saving Deposite Monthly
                                        </option>
                                    </select>
                                    <label for="interestType" class="form-label">Interest Type</label>
                                    @error('interest_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="min_balance" id="minBalance" type="number" step="0.01"
                                        class="form-control @error('min_balance') is-invalid @enderror"
                                        value="{{ old('min_balance') }}" placeholder="Min. Balance" required>
                                    <label for="minBalance" class="form-label">Min. Balance</label>
                                    @error('min_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="min_balance_type" id="minBalanceType" required
                                        class="form-select @error('min_balance_type') is-invalid @enderror">
                                        <option value="Credit"
                                            {{ old('min_balance_type') == 'Credit' ? 'selected' : '' }}>Credit
                                        </option>
                                        <option value="Debit"
                                            {{ old('min_balance_type') == 'Debit' ? 'selected' : '' }}>Debit
                                        </option>
                                    </select>
                                    <label for="minBalanceType" class="form-label">Min. Balance Type</label>
                                    @error('min_balance_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="add_interest_to_balance" id="addInterestToBalance"
                                        class="form-select @error('add_interest_to_balance') is-invalid @enderror">
                                        <option value="1" {{ old('add_interest_to_balance') == '1' ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                        <option value="0" {{ old('add_interest_to_balance') == '0' ? 'selected' : '' }}>
                                            No
                                        </option>
                                    </select>
                                    <label for="addInterestToBalance" class="form-label">Add Interest to
                                        Balance</label>
                                    @error('add_interest_to_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="type" id="type"
                                        class="form-select @error('type') is-invalid @enderror">
                                        <option value="Saving Deposits"
                                            {{ old('type') == 'Saving Deposits' ? 'selected' : '' }}>Saving Deposits
                                        </option>
                                        <option value="Monthly Deposits"
                                            {{ old('type') == 'Monthly Deposits' ? 'selected' : '' }}>Monthly Deposits
                                        </option>
                                        <option value="Current Deposits"
                                            {{ old('type') == 'Current Deposits' ? 'selected' : '' }}>Recurring
                                            Deposits
                                        </option>
                                        <option value="Fixed Deposits"
                                            {{ old('type') == 'Fixed Deposits' ? 'selected' : '' }}>Fixed Deposits
                                        </option>
                                    </select>
                                    <label for="type" class="form-label">Type</label>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="open_date" id="openDate" type="date"
                                        class="form-control @error('open_date') is-invalid @enderror"
                                        value="{{ old('open_date') }}" placeholder="Open Date" required>
                                    <label for="openDate" class="form-label">Open Date</label>
                                    @error('open_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="gl_type" id="glType" required
                                        class="form-select @error('gl_type') is-invalid @enderror">
                                        <option value="Society" {{ old('gl_type') == 'Society' ? 'selected' : '' }}>
                                            Society
                                        </option>
                                        <option value="Store" {{ old('gl_type') == 'Store' ? 'selected' : '' }}>Store
                                        </option>
                                    </select>
                                    <label for="glType" class="form-label">GL Type</label>
                                    @error('gl_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="number" name="cd_ratio" id="cdRatio" step="0.01"
                                        class="form-control @error('cd_ratio') is-invalid @enderror"
                                        value="{{ old('cd_ratio') }}" placeholder="CD Ratio">
                                    <label for="cdRatio" class="form-label">CD Ratio</label>
                                    @error('cd_ratio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="demand" id="demand"
                                        class="form-select @error('demand') is-invalid @enderror">
                                        <option value="1" {{ old('demand') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('demand') == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    <label for="demand" class="form-label">Demand</label>
                                    @error('demand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="item_of" id="itemOf"
                                        class="form-select @error('item_of') is-invalid @enderror" required>
                                        <option value="assets" {{ old('item_of') == 'assets' ? 'selected' : '' }}>Assets
                                        </option>
                                        <option value="other" {{ old('item_of') == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    <label for="itemOf" class="form-label">Item Of</label>
                                    @error('item_of')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="group" id="group"
                                        class="form-select @error('group') is-invalid @enderror">
                                        <option value="Deposit" {{ old('group') == 'Deposit' ? 'selected' : '' }}>
                                            Deposit
                                        </option>
                                        <option value="Loan" {{ old('group') == 'Loan' ? 'selected' : '' }}>Loan
                                        </option>
                                        <option value="Bank" {{ old('group') == 'Bank' ? 'selected' : '' }}>Bank
                                        </option>
                                        <option value="General" {{ old('group') == 'General' ? 'selected' : '' }}>
                                            General
                                        </option>
                                        <option value="Funds" {{ old('group') == 'Funds' ? 'selected' : '' }}>Funds
                                        </option>
                                        <option value="Share" {{ old('group') == 'Share' ? 'selected' : '' }}>Share
                                        </option>
                                    </select>
                                    <label for="group" class="form-label">Group</label>
                                    @error('group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="subsidiary" id="subsidiary" required
                                        class="form-select @error('subsidiary') is-invalid @enderror">
                                        <option value="1" {{ old('subsidiary') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('subsidiary') == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    <label for="subsidiary" class="form-label">Subsidiary</label>
                                    @error('subsidiary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select name="send_sms" id="sendSMS"
                                        class="form-select @error('send_sms') is-invalid @enderror" required>
                                        <option value="1" {{ old('send_sms') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('send_sms') == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    <label for="sendSMS" class="form-label">Send SMS</label>
                                    @error('send_sms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white rounded-bottom-4 border-top">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i>Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>