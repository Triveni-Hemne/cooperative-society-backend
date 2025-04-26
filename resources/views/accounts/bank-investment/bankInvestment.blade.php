<div class="modal fade" id="bankInvestmentModal" tabindex="-1" aria-labelledby="bankInvestmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form  method="POST" enctype="multipart/form-data" action="{{route('bank-investments.store')}}" id="bankInvestmentForm">
                 @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <input type="hidden" id="bankInvestmentId" name="id">
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="bankInvestmentModalLabel">Add Bank Investment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="mx-auto p-5 my-model text-white">
                            <div class="row mb-2">
                                @isset($ledgers)
                                <div class="col-2 ps-5 d-none d-xl-block">
                                    <label for="ledgerId">Ledger</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    @if ($ledgers->isNotEmpty())
                                    <select id="ledgerId" name="ledger_id" class="w-100 px-2 py-1 @error('ledger_id') is-invalid @enderror" required>
                                        <option value="select" {{ old('ledger_id') ? '' : 'selected' }}>------ Select Ledger ------</option>
                                        @foreach ($ledgers as $ledger)
                                            <option value="{{ $ledger->id }}"  
                                            {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}>
                                            {{ $ledger->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ledger_id')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No general ledgers available. Please add general ledgers first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add general ledgers before submitting the form.</small>
                                @endif
                                </div>
                                @endisset
                                @isset($accounts)
                                <div class="col-2 ps-5 d-none d-xl-block">
                                    <label for="accountId">Account</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    @if ($accounts->isNotEmpty())
                                    <select id="accountId" name="account_id" class="w-100 px-2 py-1 @error('account_id') is-invalid @enderror">
                                        <option value=""  {{ old('account_id') ? '' : 'selected' }}>---Select General Account---</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}"  
                                            {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('account_id')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    @else
                                    <select class="w-100 px-2 py-1" disabled>
                                        <option>No general accounts available. Please add general accounts first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add general accounts before submitting the form.</small>
                                    @endif
                                </div>
                                @endisset
                            </div>

                            <div class="row mb-2">
                                @isset($depoAccounts)
                                <div class="col-2 ps-5 d-none d-xl-block">
                                    <label for="depoAccountId">Depo Account</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    @if ($depoAccounts->isNotEmpty())
                                    <select id="depoAccountId" name="depo_account_id" class="w-100 px-2 py-1 @error('depo_account_id') is-invalid @enderror">
                                        <option value="" {{ old('depo_account_id') ? '' : 'selected' }}>---Select Deposite Account---</option>
                                        @foreach ($depoAccounts as $account)
                                            <option value="{{ $account->id }}"  
                                            {{ old('depo_account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('depo_account_id')
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
                                <div class="col-2 ps-5 d-none d-xl-block">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    <input name="name" id="name" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-2 ps-5 d-none d-xl-block">
                                    <label for="investmentType">Investment Type</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    <select id="investmentType" name="investment_type" class="w-100 px-2 py-1 @error('investment_type') is-invalid @enderror" required>
                                        <option value="select"  {{ old('investment_type') ? '' : 'selected' }}>------ Select Investment Type ------</option>
                                        <option value="RD" {{ old('investment_type') == 'RD' ? 'selected' : '' }}>RD</option>
                                        <option value="FD" {{ old('investment_type') == 'FD' ? 'selected' : '' }}>FD</option>
                                        <option value="Other" {{ old('investment_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('investment_type')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-2 d-none d-xl-block">
                                    <label for="interestRate">Interest Rate</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    <input name="interest_rate" id="interestRate" class="w-100 px-2 py-1 @error('interest_rate') is-invalid @enderror" value="{{ old('interest_rate') }}" type="number"
                                        placeholder="Interest Rate" required>
                                        @error('interest_rate')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-2 ps-5 d-none d-xl-block">
                                    <label for="openingDate">Opening Date</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    <input name="opening_date" id="openingDate" class="w-100 px-2 py-1 @error('opening_date') is-invalid @enderror" value="{{ old('opening_date') }}" type="date" placeholder="Opening Date" required>
                                    @error('opening_date')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-2 d-none d-xl-block">
                                    <label for="openingBalance">Opening Balance</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                    <input name="opening_balance" id="openingBalance" class="w-100 px-2 py-1 @error('opening_balance') is-invalid @enderror" value="{{ old('opening_balance') }}" type="number"
                                        placeholder="Opening Balance" required>
                                        @error('opening_balance')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 ps-5 d-none d-xl-block">
                                    <label for="currentBalance">Current Balance</label>
                                </div>
                                <div class="col-4 pe-0 pe-xl-5">
                                    <input name="current_balance" id="currentBalance" class="w-100 px-2 py-1 @error('current_balance') is-invalid @enderror" value="{{ old('current_balance') }}" type="number"
                                        placeholder="Current Balance" required>
                                        @error('current_balance')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Tabs -->
                            <div class="info-tabs border rounded mb-3">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item col" role="presentation">
                                        <button class="nav-link w-100 active text-info" id="rd-tab" data-bs-toggle="tab"
                                            data-bs-target="#rd-tab-pane" type="button" role="tab"
                                            aria-controls="rd-tab-pane" aria-selected="false">RD Detail</button>
                                    </li>
                                    <li class="nav-item col" role="presentation">
                                        <button class="nav-link w-100 text-info" id="fd-tab" data-bs-toggle="tab"
                                            data-bs-target="#fd-tab-pane" type="button" role="tab"
                                            aria-controls="fd-tab-pane" aria-selected="false">FD Detail</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <!-- RD Details -->
                                    <div class="tab-pane fade show active p-3 px-5" id="rd-tab-pane" role="tabpanel"
                                        aria-labelledby="rd-tab" tabindex="0">
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdMaturityDate">Maturity Date</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="rd_maturity_date" id="rdMaturityDate" class="w-100 px-2 py-1 @error('rd_maturity_date') is-invalid @enderror" value="{{ old('rd_maturity_date') }}" type="date"
                                                    placeholder="Maturity Date" required>
                                                    @error('rd_maturity_date')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdDepositTermDays">Deposit Term Days</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input name="rd_deposit_term_days" id="rdDepositTermDays" class="w-100 px-2 py-1 @error('rd_deposit_term_days') is-invalid @enderror" value="{{ old('rd_deposit_term_days') }}" type="number"
                                                    placeholder="Deposit Term Days">
                                                    @error('rd_deposit_term_days')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdMonths">Months</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="rd_months" id="rdMonths" class="w-100 px-2 py-1 @error('rd_months') is-invalid @enderror" value="{{ old('rd_months') }}" type="number"
                                                    placeholder="Months">
                                                    @error('rd_months')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdYears">Years</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input name="rd_years" id="rdYears" class="w-100 px-2 py-1 @error('rd_years') is-invalid @enderror" value="{{ old('rd_years') }}" type="number"
                                                    placeholder="Years">
                                                    @error('rd_years')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdMonthlyDeposit">Monthly Amount</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="rd_monthly_deposit" id="rdMonthlyDeposit" class="w-100 px-2 py-1 @error('rd_monthly_deposit') is-invalid @enderror" value="{{ old('rd_monthly_deposit') }}" type="number"
                                                    placeholder="Monthly Amount">
                                                    @error('rd_monthly_deposit')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdTermMonths">RD Term Months</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input name="rd_term_months" id="rdTermMonths" class="w-100 px-2 py-1 @error('rd_term_months') is-invalid @enderror" value="{{ old('rd_term_months') }}" type="number"
                                                    placeholder="RD Term Months">
                                                    @error('rd_term_months')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdMaturityAmount">Maturity Amount</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="rd_maturity_amount" id="rdMaturityAmount" class="w-100 px-2 py-1 @error('rd_maturity_amount') is-invalid @enderror" value="{{ old('rd_maturity_amount') }}" type="number"
                                                    placeholder="Maturity Amount" required>
                                                    @error('rd_maturity_amount')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdInterestReceivable">Interest Receivable</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input name="rd_interest_receivable" id="rdInterestReceivable" class="w-100 px-2 py-1 @error('rd_interest_receivable') is-invalid @enderror" value="{{ old('rd_interest_receivable') }}" type="number"
                                                    placeholder="Interest Receivable" required>
                                                    @error('rd_interest_receivable')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="rdInterestFrequency">Interest Frequency</label>
                                            </div>
                                            <div class="col-4 pe-0 pe-xl-4">
                                                <input name="rd_interest_frequency" id="rdInterestFrequency" class="w-100 px-2 py-1 @error('rd_interest_frequency') is-invalid @enderror" value="{{ old('rd_interest_frequency') }}" type="number"
                                                    placeholder="Interest Frequency">
                                                    @error('rd_interest_frequency')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FD Tab -->
                                    <div class="tab-pane fade p-3 px-5" id="fd-tab-pane" role="tabpanel"
                                        aria-labelledby="fd-tab" tabindex="0">
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdMaturityDate">Maturity Date</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="fd_maturity_date" id="fdMaturityDate" class="w-100 px-2 py-1 @error('fd_maturity_date') is-invalid @enderror" value="{{ old('fd_maturity_date') }}" type="date"
                                                    placeholder="Maturity Date" required>
                                                    @error('fd_maturity_date')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdDepositTermDays">Deposit Term Days</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input name="fd_deposit_term_days" id="fdDepositTermDays" class="w-100 px-2 py-1 @error('fd_deposit_term_days') is-invalid @enderror" value="{{ old('fd_deposit_term_days') }}" type="number"
                                                    placeholder="Deposit Term Days">
                                                    @error('fd_deposit_term_days')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdMonths">Months</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="fd_months" id="fdMonths" class="w-100 px-2 py-1 @error('fd_months') is-invalid @enderror" value="{{ old('fd_months') }}" type="number"
                                                    placeholder="Months">
                                                    @error('fd_months')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdYears">Years</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input id="fdYears" class="w-100 px-2 py-1 @error('fd_years') is-invalid @enderror" value="{{ old('fd_years') }}" type="number"
                                                    placeholder="Years">
                                                    @error('fd_years')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdAmount">FD Amount</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="fd_amount" id="fdAmount" class="w-100 px-2 py-1 @error('fd_amount') is-invalid @enderror" value="{{ old('fd_amount') }}" type="number"
                                                    placeholder="RD Amount">
                                                    @error('fd_amount')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdMonthlyDeposit">Monthly Amount</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input name="fd_monthly_deposit" id="fdMonthlyDeposit" class="w-100 px-2 py-1 @error('fd_monthly_deposit') is-invalid @enderror" value="{{ old('fd_monthly_deposit') }}" type="number"
                                                    placeholder="Monthly Amount">
                                                    @error('fd_monthly_deposit')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdMaturityAmount">Maturity Amount</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="fd_maturity_amount" id="fdMaturityAmount" class="w-100 px-2 py-1 @error('fd_maturity_amount') is-invalid @enderror" value="{{ old('fd_maturity_amount') }}" type="number"
                                                    placeholder="Maturity Amount" required>
                                                    @error('fd_maturity_amount')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdInterest">Interest</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input name="interest" id="fdInterest" class="w-100 px-2 py-1 @error('interest') is-invalid @enderror" value="{{ old('interest') }}" type="number"
                                                    placeholder="Interest" required>
                                                    @error('interest')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdInterestReceivable">Interest Receivable</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <input name="fd_interest_receivable" id="fdInterestReceivable" class="w-100 px-2 py-1 @error('fd_interest_receivable') is-invalid @enderror" value="{{ old('fd_interest_receivable') }}" type="number"
                                                    placeholder="Interest Receivable" required>
                                                    @error('fd_interest_receivable')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-2 d-none d-xl-block">
                                                <label for="fdInterestFrequency">Interest Frequency</label>
                                            </div>
                                            <div class="col pe-0">
                                                <input name="fd_interest_frequency" id="fdInterestFrequency" class="w-100 px-2 py-1 @error('fd_interest_frequency') is-invalid @enderror" value="{{ old('fd_interest_frequency') }}" type="number"
                                                    placeholder="Interest Frequency">
                                                    @error('fd_interest_frequency')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
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
</div>