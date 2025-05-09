<div class="modal fade" id="bankInvestmentModal" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="bankInvestmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" enctype="multipart/form-data" action="{{ route('bank-investments.store') }}"
                id="bankInvestmentForm">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif
                <input type="hidden" id="bankInvestmentId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4 border-0">
                    <h1 class="modal-title fs-5 fw-bold" >
                        <i class="bi bi-bank me-2"></i> <span id="bankInvestmentModalLabel">Add Bank Investment</span>
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="row">
                            @isset($ledgers)
                            <div class="col-md-4 mb-3">
                                @if ($ledgers->isNotEmpty())
                                <div class="form-floating">
                                    <select id="ledgerId" name="ledger_id"
                                        class="form-select @error('ledger_id') is-invalid @enderror"
                                        aria-label="Ledger">
                                        <option value="" {{ old('ledger_id') ? '' : 'selected' }}>--- Select Ledger ---</option>
                                        @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"
                                            {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}>
                                            {{ $ledger->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="ledgerId" class="form-label">Ledger <span
                                            class="text-danger">*</span></label>
                                    @error('ledger_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No ledger available.</strong><br>
                                    Please add ledger first.
                                </div>
                                @endif
                            </div>
                            @endisset

                            @isset($accounts)
                            <div class="col-md-4 mb-3">
                                @if ($accounts->isNotEmpty())
                                <div class="form-floating">
                                    <select id="accountId" name="account_id"
                                        class="form-select @error('account_id') is-invalid @enderror"
                                        aria-label="Account">
                                        <option value="" {{ old('account_id') ? '' : 'selected' }}>--- Select General Account ---</option>
                                        @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="accountId" class="form-label">Account <span
                                            class="text-danger">*</span></label>
                                    @error('account_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No general account available.</strong><br>
                                    Please add general account first.
                                </div>
                                @endif
                            </div>
                            @endisset

                            @isset($depoAccounts)
                            <div class="col-md-4 mb-3">
                                @if ($depoAccounts->isNotEmpty())
                                <div class="form-floating">
                                    <select id="depoAccountId" name="depo_account_id"
                                        class="form-select @error('depo_account_id') is-invalid @enderror"
                                        aria-label="Depo Account">
                                        <option value="" {{ old('depo_account_id') ? '' : 'selected' }}>--- Select Deposit Account ---</option>
                                        @foreach ($depoAccounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ old('depo_account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="depoAccountId" class="form-label">Depo Account <span
                                            class="text-danger">*</span></label>
                                    @error('depo_account_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No deposit account available.</strong><br>
                                    Please add deposit account first.
                                </div>
                                @endif
                            </div>
                            @endisset
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input name="name" id="Name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" type="text" placeholder="Name" required>
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <select id="investmentType" name="investment_type"
                                        class="form-select @error('investment_type') is-invalid @enderror"
                                        aria-label="Investment Type" required>
                                        <option value="" {{ old('investment_type') ? '' : 'selected' }}>--- Select Investment Type ---</option>
                                        <option value="RD" {{ old('investment_type') == 'RD' ? 'selected' : '' }}>RD
                                        </option>
                                        <option value="FD" {{ old('investment_type') == 'FD' ? 'selected' : '' }}>FD
                                        </option>
                                        <option value="Other" {{ old('investment_type') == 'Other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                    <label for="investmentType" class="form-label">Investment Type <span
                                            class="text-danger">*</span></label>
                                    @error('investment_type')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input name="interest_rate" id="interestRate"
                                        class="form-control @error('interest_rate') is-invalid @enderror"
                                        value="{{ old('interest_rate') }}" type="number" placeholder="Interest Rate">
                                    <label for="interestRate" class="form-label">Interest Rate</label>
                                    @error('interest_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input name="opening_date" id="openingDate"
                                        class="form-control @error('opening_date') is-invalid @enderror"
                                        value="{{ old('opening_date') }}" type="date" placeholder="Opening Date">
                                    <label for="openingDate" class="form-label">Opening Date</label>
                                    @error('opening_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input name="opening_balance" id="openingBalance"
                                        class="form-control @error('opening_balance') is-invalid @enderror"
                                        value="{{ old('opening_balance') }}" type="number"
                                        placeholder="Opening Balance">
                                    <label for="openingBalance" class="form-label">Opening Balance</label>
                                    @error('opening_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input name="current_balance" id="currentBalance"
                                        class="form-control @error('current_balance') is-invalid @enderror"
                                        value="{{ old('current_balance') }}" type="number"
                                        placeholder="Current Balance">
                                    <label for="currentBalance" class="form-label">Current Balance</label>
                                    @error('current_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Tabs -->
                        <div class="bg-secondary warning-tabs border rounded mb-3 p-2">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info fw-bold" id="rd-tab"
                                        data-bs-toggle="tab" data-bs-target="#rd-tab-pane" type="button" role="tab"
                                        aria-controls="rd-tab-pane" aria-selected="true">RD Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info fw-bold" id="fd-tab" data-bs-toggle="tab"
                                        data-bs-target="#fd-tab-pane" type="button" role="tab"
                                        aria-controls="fd-tab-pane" aria-selected="false">FD Detail
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active p-3" id="rd-tab-pane" role="tabpanel"
                                    aria-labelledby="rd-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_maturity_date" id="rdMaturityDate"
                                                    class="form-control @error('rd_maturity_date') is-invalid @enderror"
                                                    value="{{ old('rd_maturity_date') }}" type="date"
                                                    placeholder="Maturity Date">
                                                <label for="rdMaturityDate" class="form-label">Maturity Date</label>
                                                @error('rd_maturity_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_deposit_term_days" id="rdDepositTermDays"
                                                    class="form-control @error('rd_deposit_term_days') is-invalid @enderror"
                                                    value="{{ old('rd_deposit_term_days') }}" type="number"
                                                    placeholder="Deposit Term Days">
                                                <label for="rdDepositTermDays" class="form-label">Deposit Term
                                                    Days</label>
                                                @error('rd_deposit_term_days')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_months" id="rdMonths"
                                                    class="form-control @error('rd_months') is-invalid @enderror"
                                                    value="{{ old('rd_months') }}" type="number" placeholder="Months">
                                                <label for="rdMonths" class="form-label">Months</label>
                                                @error('rd_months')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_years" id="rdYears"
                                                    class="form-control @error('rd_years') is-invalid @enderror"
                                                    value="{{ old('rd_years') }}" type="number" placeholder="Years">
                                                <label for="rdYears" class="form-label">Years</label>
                                                @error('rd_years')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_monthly_deposit" id="rdMonthlyDeposit"
                                                    class="form-control @error('rd_monthly_deposit') is-invalid @enderror"
                                                    value="{{ old('rd_monthly_deposit') }}" type="number"
                                                    placeholder="Monthly Amount">
                                                <label for="rdMonthlyDeposit" class="form-label">Monthly Amount</label>
                                                @error('rd_monthly_deposit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_term_months" id="rdTermMonths"
                                                    class="form-control @error('rd_term_months') is-invalid @enderror"
                                                    value="{{ old('rd_term_months') }}" type="number"
                                                    placeholder="RD Term Months">
                                                <label for="rdTermMonths" class="form-label">RD Term Months</label>
                                                @error('rd_term_months')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_maturity_amount" id="rdMaturityAmount"
                                                    class="form-control @error('rd_maturity_amount') is-invalid @enderror"
                                                    value="{{ old('rd_maturity_amount') }}" type="number"
                                                    placeholder="Maturity Amount">
                                                <label for="rdMaturityAmount" class="form-label">Maturity Amount</label>
                                                @error('rd_maturity_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_interest_receivable" id="rdInterestReceivable"
                                                    class="form-control @error('rd_interest_receivable') is-invalid @enderror"
                                                    value="{{ old('rd_interest_receivable') }}" type="number"
                                                    placeholder="Interest Receivable">
                                                <label for="rdInterestReceivable" class="form-label">Interest
                                                    Receivable</label>
                                                @error('rd_interest_receivable')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="rd_interest_frequency" id="rdInterestFrequency"
                                                    class="form-control @error('rd_interest_frequency') is-invalid @enderror"
                                                    value="{{ old('rd_interest_frequency') }}" type="number"
                                                    placeholder="Interest Frequency">
                                                <label for="rdInterestFrequency">
                                                    Interest Frequency</label>
                                                @error('rd_interest_frequency')
                                                <div class=" invalid-feedback">{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-3" id="fd-tab-pane" role="tabpanel" aria-labelledby="fd-tab"
                                    tabindex="0">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_maturity_date" id="fdMaturityDate"
                                                    class="form-control @error('fd_maturity_date') is-invalid @enderror"
                                                    value="{{ old('fd_maturity_date') }}" type="date"
                                                    placeholder="Maturity Date">
                                                <label for="fdMaturityDate" class="form-label">Maturity Date</label>
                                                @error('fd_maturity_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_deposit_term_days" id="fdDepositTermDays"
                                                    class="form-control @error('fd_deposit_term_days') is-invalid @enderror"
                                                    value="{{ old('fd_deposit_term_days') }}" type="number"
                                                    placeholder="Deposit Term Days">
                                                <label for="fdDepositTermDays" class="form-label">Deposit Term
                                                    Days</label>
                                                @error('fd_deposit_term_days')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_months" id="fdMonths"
                                                    class="form-control @error('fd_months') is-invalid @enderror"
                                                    value="{{ old('fd_months') }}" type="number" placeholder="Months">
                                                <label for="fdMonths" class="form-label">Months</label>
                                                @error('fd_months')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_years" id="fdYears"
                                                    class="form-control @error('fd_years') is-invalid @enderror"
                                                    value="{{ old('fd_years') }}" type="number" placeholder="Years">
                                                <label for="fdYears" class="form-label">Years</label>
                                                @error('fd_years')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_amount" id="fdAmount"
                                                    class="form-control @error('fd_amount') is-invalid @enderror"
                                                    value="{{ old('fd_amount') }}" type="number"
                                                    placeholder="RD Amount">
                                                <label for="fdAmount" class="form-label">RD Amount</label>
                                                @error('fd_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_monthly_deposit" id="fdMonthlyDeposit"
                                                    class="form-control @error('fd_monthly_deposit') is-invalid @enderror"
                                                    value="{{ old('fd_monthly_deposit') }}" type="number"
                                                    placeholder="Monthly Amount">
                                                <label for="fdMonthlyDeposit" class="form-label">Monthly Amount</label>
                                                @error('fd_monthly_deposit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_maturity_amount" id="fdMaturityAmount"
                                                    class="form-control @error('fd_maturity_amount') is-invalid @enderror"
                                                    value="{{ old('fd_maturity_amount') }}" type="number"
                                                    placeholder="Maturity Amount">
                                                <label for="fdMaturityAmount" class="form-label">Maturity Amount</label>
                                                @error('fd_maturity_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="interest" id="fdInterest"
                                                    class="form-control @error('interest') is-invalid @enderror"
                                                    value="{{ old('interest') }}" type="number" placeholder="Interest">
                                                <label for="fdInterest" class="form-label">Interest</label>
                                                @error('interest')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_interest_receivable" id="fdInterestReceivable"
                                                    class="form-control @error('fd_interest_receivable') is-invalid @enderror"
                                                    value="{{ old('fd_interest_receivable') }}" type="number"
                                                    placeholder="Interest Receivable">
                                                <label for="fdInterestReceivable" class="form-label">Interest
                                                    Receivable</label>
                                                @error('fd_interest_receivable')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input name="fd_interest_frequency" id="fdInterestFrequency"
                                                    class="form-control @error('fd_interest_frequency') is-invalid @enderror"
                                                    value="{{ old('fd_interest_frequency') }}" type="number"
                                                    placeholder="Interest Frequency">
                                                <label for="fdInterestFrequency" class="form-label">Interest
                                                    Frequency</label>
                                                @error('fd_interest_frequency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white rounded-bottom-4 border-top">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close">
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

