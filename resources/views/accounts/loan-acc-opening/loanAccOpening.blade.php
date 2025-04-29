<div class="modal fade" id="loanAccOpeningModal" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="loanAccOpeningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" enctype="multipart/form-data" action="{{ route('member-loan-accounts.store') }}"
                id="memberLoanAccForm">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif
                <input type="hidden" id="loanAccId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-info text-white rounded-top-4 border-0">
                    <h1 class="modal-title fs-5 fw-bold" id="loanAccOpeningModalLabel">
                        <i class="bi bi-cash-coin me-2"></i> Add Loan Account
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="row mb-3">
                            @isset($ledgers)
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="ledgerId" name="ledger_id"
                                        class="form-select @error('ledger_id') is-invalid @enderror"
                                        aria-label="Ledger">
                                        <option value="" selected>--- Select Ledger ---</option>
                                        @if ($ledgers->isNotEmpty())
                                        @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"
                                            {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}>
                                            {{ $ledger->name }}
                                        </option>
                                        @endforeach
                                        @else
                                        <option disabled>No general ledgers available. Please add them first.
                                        </option>
                                        @endif
                                    </select>
                                    <label for="ledgerId" class="form-label">Ledger <span
                                            class="text-danger">*</span></label>
                                    @error('ledger_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($ledgers->isEmpty())
                                    <small class="text-danger">⚠️ You must add general ledgers before submitting
                                        the form.</small>
                                    @endif
                                </div>
                            </div>
                            @endisset
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="photo" id="photoCopy"
                                        class="form-control @error('photo') is-invalid @enderror"
                                        value="{{ old('photo') }}" type="file" accept="image/*"
                                        placeholder="Photo Copy">
                                    <label for="photoCopy" class="form-label">Photo Copy</label>
                                    @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            @isset($members)
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="memberId" name="member_id"
                                        class="form-select @error('member_id') is-invalid @enderror"
                                        aria-label="Member">
                                        <option value="" selected>--- Select Member ---</option>
                                        @if ($members->isNotEmpty())
                                        @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}
                                        </option>
                                        @endforeach
                                        @else
                                        <option disabled>No members available. Please add members first.</option>
                                        @endif
                                    </select>
                                    <label for="memberId" class="form-label">Member <span
                                            class="text-danger">*</span></label>
                                    @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($members->isEmpty())
                                    <small class="text-danger">⚠️ You must add members before submitting the
                                        form.</small>
                                    @endif
                                </div>
                            </div>
                            @endisset
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="signature" id="signCopy"
                                        class="form-control @error('signature') is-invalid @enderror"
                                        value="{{ old('signature') }}" type="file" accept="image/*"
                                        placeholder="Signature Copy">
                                    <label for="signCopy" class="form-label">Signature Copy</label>
                                    @error('signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            @isset($accounts)
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="accountId" name="account_id"
                                        class="form-select @error('account_id') is-invalid @enderror"
                                        aria-label="Account">
                                        <option value="" selected>--- Select Account ---</option>
                                        @if ($accounts->isNotEmpty())
                                        @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                        </option>
                                        @endforeach
                                        @else
                                        <option disabled>No general accounts available. Please add general
                                            accounts first.
                                        </option>
                                        @endif
                                    </select>
                                    <label for="accountId" class="form-label">Account</label>
                                    @error('account_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($accounts->isEmpty())
                                    <small class="text-danger">⚠️ You must add general accounts before submitting
                                        the form.</small>
                                    @endif
                                </div>
                            </div>
                            @endisset
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="acc_no" id="accNo"
                                        class="form-control @error('acc_no') is-invalid @enderror"
                                        value="{{ old('acc_no') }}" type="text" placeholder="Account No.">
                                    <label for="accNo" class="form-label">Account No.</label>
                                    @error('acc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" type="text" placeholder="Name">
                                    <label for="name" class="form-label">Name</label>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="loan_type" id="loanType"
                                        class="form-select @error('loan_type') is-invalid @enderror">
                                        <option value="" selected>------ Select Loan Type ------</option>
                                        <option value="Personal Loan"
                                            {{ old('loan_type') == 'Personal Loan' ? 'selected' : '' }}>Personal Loan
                                        </option>
                                        <option value="Home Loan"
                                            {{ old('loan_type') == 'Home Loan' ? 'selected' : '' }}>
                                            Home Loan
                                        </option>
                                        <option value="Auto Loan"
                                            {{ old('loan_type') == 'Auto Loan' ? 'selected' : '' }}>
                                            Auto Loan
                                        </option>
                                        <option value="Business Loan"
                                            {{ old('loan_type') == 'Business Loan' ? 'selected' : '' }}>Business Loan
                                        </option>
                                        <option value="Gold Loan"
                                            {{ old('loan_type') == 'Gold Loan' ? 'selected' : '' }}>
                                            Gold Loan
                                        </option>
                                    </select>
                                    <label for="loanType" class="form-label">Loan Type</label>
                                    @error('loan_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input id="acStartDate" name="ac_start_date"
                                        class="form-control @error('ac_start_date') is-invalid @enderror"
                                        value="{{ old('ac_start_date') }}" type="date" placeholder="Acc Start Date">
                                    <label for="acStartDate" class="form-label">Acc Start Date</label>
                                    @error('ac_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
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

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="emi_amount" id="emiAmount"
                                        class="form-control @error('emi_amount') is-invalid @enderror"
                                        value="{{ old('emi_amount') }}" type="number" placeholder="EMI Amount">
                                    <label for="emiAmount" class="form-label">EMI Amount</label>
                                    @error('emi_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="open_balance" id="openBalance"
                                        class="form-control @error('open_balance') is-invalid @enderror"
                                        value="{{ old('open_balance') }}" type="number" placeholder="Open Balance ">
                                    <label for="openBalance" class="form-label">Open Balance</label>
                                    @error('open_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="balance" id="balance"
                                        class="form-control @error('balance') is-invalid @enderror"
                                        value="{{ old('balance') }}" type="number" placeholder="Balance">
                                    <label for="balance" class="form-label">Balance</label>
                                    @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="purpose" name="purpose" class="form-select">
                                        <option value="" selected>------ Select Loan Purpose ------</option>
                                        <option value="Agriculture"
                                            {{ old('purpose') == 'Agriculture' ? 'selected' : '' }}>Agriculture
                                        </option>
                                        <option value="Construction"
                                            {{ old('purpose') == 'Construction' ? 'selected' : '' }}>Construction
                                        </option>
                                        <option value="Cottage" {{ old('purpose') == 'Cottage' ? 'selected' : '' }}>
                                            Cottage
                                        </option>
                                        <option value="SSI Unit" {{ old('purpose') == 'SSI Unit' ? 'selected' : '' }}>
                                            SSI Unit
                                        </option>
                                        <option value="Dairy" {{ old('purpose') == 'Dairy' ? 'selected' : '' }}>Dairy
                                        </option>
                                    </select>
                                    <label for="purpose" class="form-label">Purpose</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="principal_amount" id="principalAmount"
                                        class="form-control @error('principal_amount') is-invalid @enderror"
                                        value="{{ old('principal_amount') }}" type="number"
                                        placeholder="Principal Amount">
                                    <label for="principalAmount" class="form-label">Principal Amount</label>
                                    @error('principal_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="start_date" id="startDate"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}" type="date" placeholder="Start Date">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="end_date" id="endDate"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}" type="date" placeholder="End Date">
                                    <label for="endDate" class="form-label">End Date</label>
                                    @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="tenure" id="tenure"
                                        class="form-control @error('tenure') is-invalid @enderror"
                                        value="{{ old('tenure') }}" type="number" placeholder="Tenure">
                                    <label for="tenure" class="form-label">Tenure</label>
                                    @error('tenure')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="priority" id="priority"
                                        class="form-control @error('priority') is-invalid @enderror"
                                        value="{{ old('priority') }}" type="number" placeholder="Priority">
                                    <label for="priority" class="form-label">Priority</label>
                                    @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="loan_amount" id="loanAmount"
                                        class="form-control @error('loan_amount') is-invalid @enderror"
                                        value="{{ old('loan_amount') }}" type="number" placeholder="Loan Amount">
                                    <label for="loanAmount" class="form-label">Loan Amount</label>
                                    @error('loan_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="collateralType" name="collateral_type"
                                        class="form-select @error('collateral_type') is-invalid @enderror">
                                        <option value="" selected>------ Select Collateral Type ------</option>
                                        <option value="Gold" {{ old('collateral_type') == 'Gold' ? 'selected' : '' }}>
                                            Gold
                                        </option>
                                        <option value="Property"
                                            {{ old('collateral_type') == 'Property' ? 'selected' : '' }}>Property
                                        </option>
                                        <option value="Vehicle"
                                            {{ old('collateral_type') == 'Vehicle' ? 'selected' : '' }}>Vehicle
                                        </option>
                                        <option value="None" {{ old('collateral_type') == 'None' ? 'selected' : '' }}>
                                            None
                                        </option>
                                    </select>
                                    <label for="collateralType" class="form-label">Collateral Type</label>
                                    @error('collateral_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="collateral_value" id="collateralValue"
                                        class="form-control @error('collateral_value') is-invalid @enderror"
                                        value="{{ old('collateral_value') }}" type="number"
                                        placeholder="Collateral Value">
                                    <label for="collateralValue" class="form-label">Collateral Value</label>
                                    @error('collateral_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="page_no" id="pageNo"
                                        class="form-control @error('page_no') is-invalid @enderror"
                                        value="{{ old('page_no') }}" type="text" placeholder="Page No.">
                                    <label for="pageNo" class="form-label">Page No.</label>
                                    @error('page_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input name="is_loss_asset"
                                        class="form-check-input @error('is_loss_asset') is-invalid @enderror"
                                        type="checkbox" role="switch" id="isLossAsset" value="1"
                                        {{ old('is_loss_asset') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isLossAsset">Is Loss Asset</label>
                                    @error('is_loss_asset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-switch ms-3">
                                    <input name="case_flag"
                                        class="form-check-input @error('case_flag') is-invalid @enderror"
                                        type="checkbox" role="switch" id="caseFlag" value="1"
                                        {{ old('case_flag') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="caseFlag">Case Flag</label>
                                    @error('case_flag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-switch ms-3">
                                    <input name="add_to_demand"
                                        class="form-check-input @error('add_to_demand') is-invalid @enderror"
                                        type="checkbox" role="switch" id="addToDemand" value="1"
                                        {{ old('add_to_demand') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="addToDemand">Add to Demand</label>
                                    @error('add_to_demand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input name="interest" id="interest"
                                        class="form-control @error('interest') is-invalid @enderror"
                                        value="{{ old('interest') }}" type="number" placeholder="Interest">
                                    <label for="interest" class="form-label">Interest</label>
                                    @error('interest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input name="penal_interest" id="penalInterest"
                                        class="form-control @error('penal_interest') is-invalid @enderror"
                                        value="{{ old('penal_interest') }}" type="number" placeholder="Penal Interest">
                                    <label for="penalInterest" class="form-label">Penal Interest</label>
                                    @error('penal_interest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input name="open_interest" id="openInterest"
                                        class="form-control @error('open_interest') is-invalid @enderror"
                                        value="{{ old('open_interest') }}" type="number" placeholder="Open Interest">
                                    <label for="openInterest" class="form-label">Open Interest</label>
                                    @error('open_interest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="insurance" id="insurance"
                                        class="form-control @error('insurance') is-invalid @enderror"
                                        value="{{ old('insurance') }}" type="number" placeholder="Insurance">
                                    <label for="insurance" class="form-label">Insurance</label>
                                    @error('insurance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="insurance_date" id="insuranceDate"
                                        class="form-control @error('insurance_date') is-invalid @enderror"
                                        value="{{ old('insurance_date') }}" type="date" placeholder="Insurance Date">
                                    <label for="insuranceDate" class="form-label">Insurance Date</label>
                                    @error('insurance_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="postage" id="postage"
                                        class="form-control @error('postage') is-invalid @enderror"
                                        value="{{ old('postage') }}" type="number" placeholder="Postage">
                                    <label for="postage" class="form-label">Postage</label>
                                    @error('postage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="notice_fee" id="noticeFee"
                                        class="form-control @error('notice_fee') is-invalid @enderror"
                                        value="{{ old('notice_fee') }}" type="number" placeholder="Notice Fee">
                                    <label for="noticeFee" class="form-label">Notice Fee</label>
                                    @error('notice_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="info-tabs border rounded mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info" id="nominee-tab"
                                        data-bs-toggle="tab" data-bs-target="#nominee-tab-pane" type="button" role="tab"
                                        aria-controls="nominee-tab-pane" aria-selected="true">Nominee
                                        Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="goldLoan-tab" data-bs-toggle="tab"
                                        data-bs-target="#goldLoan-tab-pane" type="button" role="tab"
                                        aria-controls="goldLoan-tab-pane" aria-selected="false">Gold Loan
                                        Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="guarantors-tab" data-bs-toggle="tab"
                                        data-bs-target="#guarantors-tab-pane" type="button" role="tab"
                                        aria-controls="guarantors-tab-pane" aria-selected="false">Guarantors
                                        Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="installments-tab" data-bs-toggle="tab"
                                        data-bs-target="#installments-tab-pane" type="button" role="tab"
                                        aria-controls="installments-tab-pane" aria-selected="false">Installments Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="resolution-tab" data-bs-toggle="tab"
                                        data-bs-target="#resolution-tab-pane" type="button" role="tab"
                                        aria-controls="resolution-tab-pane" aria-selected="false">Resolution Detail
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active p-3" id="nominee-tab-pane" role="tabpanel"
                                    aria-labelledby="nominee-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-center mb-3">Nominee 1</h6>
                                            <div class="form-floating mb-3">
                                                <input name="nominees[0][nominee_name]" id="nominee1Name"
                                                    class="form-control @error('nominees.0.nominee_name') is-invalid @enderror"
                                                    type="text" placeholder="Nominee Name"
                                                    value="{{ old('nominees.0.nominee_name') }}">
                                                <label for="nominee1Name" class="form-label">Name</label>
                                                @error('nominees.0.nominee_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input name="nominees[0][nominee_naav]" id="marathiNominee1Name"
                                                    class="form-control @error('nominees.0.nominee_naav') is-invalid @enderror"
                                                    type="text" value="{{ old('nominees.0.nominee_naav') }}"
                                                    placeholder="नाव">
                                                <label for="marathiNominee1Name" class="form-label">नाव</label>
                                                @error('nominees.0.nominee_naav')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input name="nominees[0][nominee_age]" id="nominee1Age"
                                                    class="form-control @error('nominees.0.nominee_age') is-invalid @enderror"
                                                    type="number" placeholder="Age"
                                                    value="{{ old('nominees.0.nominee_age') }}">
                                                <label for="nominee1Age" class="form-label">Age</label>
                                                @error('nominees.0.nominee_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select id="nominee1Gender" name="nominees[0][nominee_gender]"
                                                    class="form-select @error('nominees.0.nominee_gender') is-invalid @enderror">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <label for="nominee1Gender" class="form-label">Gender</label>
                                                @error('nominees.0.nominee_gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select id="nominee1Relation" name="nominees[0][relation]"
                                                    class="form-select @error('nominees.0.relation') is-invalid @enderror">
                                                    <option value="husband">Husband</option>
                                                    <option value="wife">Wife</option>
                                                    <option value="father">Father</option>
                                                    <option value="mother">Mother</option>
                                                    <option value="brother">Brother</option>
                                                    <option value="sister">Sister</option>
                                                    <option value="son">Son</option>
                                                    <option value="daughter">Daughter</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <label for="nominee1Relation" class="form-label">Relation</label>
                                                @error('nominees.0.relation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="nominee1Photo" class="form-label">Photo</label>
                                                <input name="nominees[0][nominee_image]" id="nominee1Photo"
                                                    value="{{ old('nominees.0.nominee_image') }}"
                                                    class="form-control @error('nominees.0.nominee_image') is-invalid @enderror"
                                                    type="file" accept="image/*" placeholder="Nominee Photo">
                                                @error('nominees.0.nominee_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-center mb-3">Nominee 2</h6>
                                            <div class="form-floating mb-3">
                                                <input name="nominees[1][nominee_name]" id="nominee2Name"
                                                    class="form-control @error('nominees.1.nominee_name') is-invalid @enderror"
                                                    value="{{ old('nominees.1.nominee_name') }}" type="text"
                                                    placeholder="Nominee Name">
                                                <label for="nominee2Name" class="form-label">Name</label>
                                                @error('nominees.1.nominee_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input name="nominees[1][nominee_naav]" id="marathiNominee2Name"
                                                    class="form-control @error('nominees.1.nominee_naav') is-invalid @enderror"
                                                    type="text" value="{{ old('nominees.1.nominee_naav') }}"
                                                    placeholder="नाव">
                                                <label for="marathiNominee2Name" class="form-label">नाव</label>
                                                @error('nominees.1.nominee_naav')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input name="nominees[1][nominee_age]" id="nominee2Age"
                                                    class="form-control @error('nominees.1.nominee_age') is-invalid @enderror"
                                                    type="number" placeholder="Age"
                                                    value="{{ old('nominees.1.nominee_age') }}">
                                                <label for="nominee2Age" class="form-label">Age</label>
                                                @error('nominees.1.nominee_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select id="nominee2Gender" name="nominees[1][nominee_gender]"
                                                    class="form-select @error('nominees.1.nominee_gender') is-invalid @enderror">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <label for="nominee2Gender" class="form-label">Gender</label>
                                                @error('nominees.1.nominee_gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select id="nominee2Relation" name="nominees[1][relation]"
                                                    class="form-select @error('nominees.1.relation') is-invalid @enderror">
                                                    <option value="husband">Husband</option>
                                                    <option value="wife">Wife</option>
                                                    <option value="father">Father</option>
                                                    <option value="mother">Mother</option>
                                                    <option value="brother">Brother</option>
                                                    <option value="sister">Sister</option>
                                                    <option value="son">Son</option>
                                                    <option value="daughter">Daughter</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <label for="nominee2Relation" class="form-label">Relation</label>
                                                @error('nominees.1.relation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="nominee2Photo" class="form-label">Photo</label>
                                                <input name="nominees[1][nominee_image]" id="nominee2Photo"
                                                    value="{{ old('nominees.1.nominee_image') }}"
                                                    class="form-control @error('nominees.1.nominee_image') is-invalid @enderror"
                                                    type="file" accept="image/*" placeholder="Nominee Photo">
                                                @error('nominees.1.nominee_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-3" id="goldLoan-tab-pane" role="tabpanel"
                                    aria-labelledby="goldLoan-tab" tabindex="0">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input id="goldWeight" name="gold_weight"
                                                    class="form-control @error('gold_weight') is-invalid @enderror"
                                                    value="{{ old('gold_weight') }}" type="number"
                                                    placeholder="Gold Weight">
                                                <label for="goldWeight" class="form-label">Gold Weight</label>
                                                @error('gold_weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select id="goldPurity" name="gold_purity"
                                                    class="form-select @error('gold_purity') is-invalid @enderror">
                                                    <option value="" selected>--- Select Purity ---</option>
                                                    <option value="18K"
                                                        {{ old('gold_purity') == '18K' ? 'selected' : '' }}>18K
                                                    </option>
                                                    <option value="22K"
                                                        {{ old('gold_purity') == '22K' ? 'selected' : '' }}>22K
                                                    </option>
                                                    <option value="24K"
                                                        {{ old('gold_purity') == '24K' ? 'selected' : '' }}>24K
                                                    </option>
                                                </select>
                                                <label for="goldPurity" class="form-label">Gold Purity</label>
                                                @error('gold_purity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="market_value" id="marketValue"
                                                    class="form-control @error('market_value') is-invalid @enderror"
                                                    value="{{ old('market_value') }}" type="number"
                                                    placeholder="Market Value">
                                                <label for="marketValue" class="form-label">Market Value</label>
                                                @error('market_value')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="pledged_date" id="pledgedDate"
                                                    class="form-control @error('pledged_date') is-invalid @enderror"
                                                    value="{{ old('pledged_date') }}" type="date"
                                                    placeholder="Pledge Date">
                                                <label for="pledgedDate" class="form-label">Pledge Date</label>
                                                @error('pledged_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select id="releaseStatus" name="release_status"
                                                    class="form-select @error('release_status') is-invalid @enderror">
                                                    <option value="" selected>--- Select Status ---</option>
                                                    <option value="Pledged"
                                                        {{ old('release_status') == 'Pledged' ? 'selected' : '' }}>
                                                        Pledged
                                                    </option>
                                                    <option value="Released"
                                                        {{ old('release_status') == 'Released' ? 'selected' : '' }}>
                                                        Released
                                                    </option>
                                                </select>
                                                <label for="releaseStatus" class="form-label">Release Status</label>
                                                @error('release_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="release_date" id="releaseDate"
                                                    class="form-control @error('release_date') is-invalid @enderror"
                                                    value="{{ old('release_date') }}" type="date"
                                                    placeholder="Release Date">
                                                <label for="releaseDate" class="form-label">Release Date</label>
                                                @error('release_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-3" id="guarantors-tab-pane" role="tabpanel"
                                    aria-labelledby="guarantors-tab" tabindex="0">
                                    <div class="row mb-3">
                                        @isset($members)
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select id="grMemberId" name="gr_member_id"
                                                    class="form-select @error('gr_member_id') is-invalid @enderror">
                                                    <option value="" selected>------ Select Member ------</option>
                                                    @foreach ($members as $member)
                                                    <option value="{{ $member->id }}"
                                                        {{ old('gr_member_id') == $member->id ? 'selected' : '' }}>
                                                        {{ $member->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <label for="grMemberId" class="form-label">Member</label>
                                                @error('gr_member_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @endisset
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select id="guarantorType" name="guarantor_type"
                                                    class="form-select @error('guarantor_type') is-invalid @enderror">
                                                    <option value="" selected>--- Select Type ---</option>
                                                    <option value="Primary"
                                                        {{ old('guarantor_type') == 'Primary' ? 'selected' : '' }}>
                                                        Primary
                                                    </option>
                                                    <option value="Secondary"
                                                        {{ old('guarantor_type') == 'Secondary' ? 'selected' : '' }}>
                                                        Secondary
                                                    </option>
                                                    <option value="Tertiary"
                                                        {{ old('guarantor_type') == 'Tertiary' ? 'selected' : '' }}>
                                                        Tertiary
                                                    </option>
                                                </select>
                                                <label for="guarantorType" class="form-label">Guarantor Type</label>
                                                @error('guarantor_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="added_on" id="addedOn"
                                                    class="form-control @error('added_on') is-invalid @enderror"
                                                    value="{{ old('added_on') }}" type="date" placeholder="Added On">
                                                <label for="addedOn" class="form-label">Added On</label>
                                                @error('added_on')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="released_on" id="releasedOn"
                                                    class="form-control @error('released_on') is-invalid @enderror"
                                                    value="{{ old('released_on') }}" type="date"
                                                    placeholder="Release Date">
                                                <label for="releasedOn" class="form-label">Release Date</label>
                                                @error('released_on')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-3" id="installments-tab-pane" role="tabpanel"
                                    aria-labelledby="installments-tab" tabindex="0">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select id="installmentType" name="installment_type"
                                                    class="form-select @error('installment_type') is-invalid @enderror">
                                                    <option value="" selected>------ Select Type ------</option>
                                                    <option value="Monthly"
                                                        {{ old('installment_type') == 'Monthly' ? 'selected' : '' }}>
                                                        Monthly
                                                    </option>
                                                    <option value="Quarterly"
                                                        {{ old('installment_type') == 'Quarterly' ? 'selected' : '' }}>
                                                        Quarterly
                                                    </option>
                                                    <option value="Yearly"
                                                        {{ old('installment_type') == 'Yearly' ? 'selected' : '' }}>
                                                        Yearly
                                                    </option>
                                                </select>
                                                <label for="installmentType" class="form-label">Installment Type</label>
                                                @error('installment_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input id="matureDate" name="mature_date"
                                                    class="form-control @error('mature_date') is-invalid @enderror"
                                                    value="{{ old('mature_date') }}" type="date"
                                                    placeholder="Mature Date">
                                                <label for="matureDate" class="form-label">Mature Date</label>
                                                @error('mature_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input id="firstInstallmentDate" name="first_installment_date"
                                                    class="form-control @error('first_installment_date') is-invalid @enderror"
                                                    value="{{ old('first_installment_date') }}" type="date"
                                                    placeholder="First Installment Date">
                                                <label for="firstInstallmentDate" class="form-label">First Installment
                                                    Date</label>
                                                @error('first_installment_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="total_installments" id="totalInstallments"
                                                    class="form-control @error('total_installments') is-invalid @enderror"
                                                    value="{{ old('total_installments') }}" type="number"
                                                    placeholder="Total Installments">
                                                <label for="totalInstallments" class="form-label">Total
                                                    Installments</label>
                                                @error('total_installments')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-3" id="resolution-tab-pane" role="tabpanel"
                                    aria-labelledby="resolution-tab" tabindex="0">
                                    <div class="mb-3">
                                        <label for="resolutionDetails" class="form-label">Resolution Details</label>
                                        <textarea class="form-control" id="resolutionDetails" name="resolution_details"
                                            rows="3">{{ old('resolution_details') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="resolutionDate" class="form-label">Resolution Date</label>
                                        <input type="date" class="form-control" id="resolutionDate"
                                            name="resolution_date" value="{{ old('resolution_date') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="boardMeetingNo" class="form-label">Board Meeting No.</label>
                                        <input type="text" class="form-control" id="boardMeetingNo"
                                            name="board_meeting_no" value="{{ old('board_meeting_no') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="boardMeetingDate" class="form-label">Board Meeting Date</label>
                                        <input type="date" class="form-control" id="boardMeetingDate"
                                            name="board_meeting_date" value="{{ old('board_meeting_date') }}">
                                    </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loanAccOpeningModal = document.getElementById('loanAccOpeningModal');
    if (loanAccOpeningModal) {
        loanAccOpeningModal.addEventListener('show.bs.modal', event => {
            const relatedTarget = event.relatedTarget;
            const id = relatedTarget.getAttribute('data-bs-id');
            const ledgerId = relatedTarget.getAttribute('data-bs-ledger_id');
            const memberId = relatedTarget.getAttribute('data-bs-member_id');
            const accountId = relatedTarget.getAttribute('data-bs-account_id');
            const accNo = relatedTarget.getAttribute('data-bs-acc_no');
            const name = relatedTarget.getAttribute('data-bs-name');
            const loanType = relatedTarget.getAttribute('data-bs-loan_type');
            const interestRate = relatedTarget.getAttribute('data-bs-interest_rate');
            const acStartDate = relatedTarget.getAttribute('data-bs-ac_start_date');
            const emiAmount = relatedTarget.getAttribute('data-bs-emi_amount');
            const openBalance = relatedTarget.getAttribute('data-bs-open_balance');
            const balance = relatedTarget.getAttribute('data-bs-balance');
            const purpose = relatedTarget.getAttribute('data-bs-purpose');
            const principalAmount = relatedTarget.getAttribute('data-bs-principal_amount');
            const startDate = relatedTarget.getAttribute('data-bs-start_date');
            const endDate = relatedTarget.getAttribute('data-bs-end_date');
            const tenure = relatedTarget.getAttribute('data-bs-tenure');
            const priority = relatedTarget.getAttribute('data-bs-priority');
            const loanAmount = relatedTarget.getAttribute('data-bs-loan_amount');
            const collateralType = relatedTarget.getAttribute('data-bs-collateral_type');
            const collateralValue = relatedTarget.getAttribute('data-bs-collateral_value');
            const pageNo = relatedTarget.getAttribute('data-bs-page_no');
            const isLossAsset = relatedTarget.getAttribute('data-bs-is_loss_asset');
            const caseFlag = relatedTarget.getAttribute('data-bs-case_flag');
            const addToDemand = relatedTarget.getAttribute('data-bs-add_to_demand');
            const interest = relatedTarget.getAttribute('data-bs-interest');
            const penalInterest = relatedTarget.getAttribute('data-bs-penal_interest');
            const openInterest = relatedTarget.getAttribute('data-bs-open_interest');
            const insurance = relatedTarget.getAttribute('data-bs-insurance');
            const insuranceDate = relatedTarget.getAttribute('data-bs-insurance_date');
            const postage = relatedTarget.getAttribute('data-bs-postage');
            const noticeFee = relatedTarget.getAttribute('data-bs-notice_fee');
            const goldWeight = relatedTarget.getAttribute('data-bs-gold_weight');
            const goldPurity = relatedTarget.getAttribute('data-bs-gold_purity');
            const marketValue = relatedTarget.getAttribute('data-bs-market_value');
            const pledgedDate = relatedTarget.getAttribute('data-bs-pledged_date');
            const releaseStatus = relatedTarget.getAttribute('data-bs-release_status');
            const releaseDate = relatedTarget.getAttribute('data-bs-release_date');
            const grMemberId = relatedTarget.getAttribute('data-bs-gr_member_id');
            const guarantorType = relatedTarget.getAttribute('data-bs-guarantor_type');
            const addedOn = relatedTarget.getAttribute('data-bs-added_on');
            const releasedOn = relatedTarget.getAttribute('data-bs-released_on');
            const installmentType = relatedTarget.getAttribute('data-bs-installment_type');
            const matureDate = relatedTarget.getAttribute('data-bs-mature_date');
            const firstInstallmentDate = relatedTarget.getAttribute('data-bs-first_installment_date');
            const totalInstallments = relatedTarget.getAttribute('data-bs-total_installments');
            const resolutionDetails = relatedTarget.getAttribute('data-bs-resolution_details');
            const resolutionDate = relatedTarget.getAttribute('data-bs-resolution_date');
            const boardMeetingNo = relatedTarget.getAttribute('data-bs-board_meeting_no');
            const boardMeetingDate = relatedTarget.getAttribute('data-bs-board_meeting_date');
            const nominee1Name = relatedTarget.getAttribute('data-bs-nominee1_name');
            const nominee1Naav = relatedTarget.getAttribute('data-bs-nominee1_naav');
            const nominee1Age = relatedTarget.getAttribute('data-bs-nominee1_age');
            const nominee1Gender = relatedTarget.getAttribute('data-bs-nominee1_gender');
            const nominee1Relation = relatedTarget.getAttribute('data-bs-nominee1_relation');
            const nominee2Name = relatedTarget.getAttribute('data-bs-nominee2_name');
            const nominee2Naav = relatedTarget.getAttribute('data-bs-nominee2_naav');
            const nominee2Age = relatedTarget.getAttribute('data-bs-nominee2_age');
            const nominee2Gender = relatedTarget.getAttribute('data-bs-nominee2_gender');
            const nominee2Relation = relatedTarget.getAttribute('data-bs-nominee2_relation');

            const modalTitle = loanAccOpeningModal.querySelector('#loanAccOpeningModalLabel');
            const loanAccIdInput = loanAccOpeningModal.querySelector('#loanAccId');
            const formMethod = loanAccOpeningModal.querySelector('#formMethod');
            const ledgerIdInput = loanAccOpeningModal.querySelector('#ledgerId');
            const memberIdInput = loanAccOpeningModal.querySelector('#memberId');
            const accountIdInput = loanAccOpeningModal.querySelector('#accountId');
            const accNoInput = loanAccOpeningModal.querySelector('#accNo');
            const nameInput = loanAccOpeningModal.querySelector('#name');
            const loanTypeInput = loanAccOpeningModal.querySelector('#loanType');
            const interestRateInput = loanAccOpeningModal.querySelector('#interestRate');
            const acStartDateInput = loanAccOpeningModal.querySelector('#acStartDate');
            const emiAmountInput = loanAccOpeningModal.querySelector('#emiAmount');
            const openBalanceInput = loanAccOpeningModal.querySelector('#openBalance');
            const balanceInput = loanAccOpeningModal.querySelector('#balance');
            const purposeInput = loanAccOpeningModal.querySelector('#purpose');
            const principalAmountInput = loanAccOpeningModal.querySelector('#principalAmount');
            const startDateInput = loanAccOpeningModal.querySelector('#startDate');
            const endDateInput = loanAccOpeningModal.querySelector('#endDate');
            const tenureInput = loanAccOpeningModal.querySelector('#tenure');
            const priorityInput = loanAccOpeningModal.querySelector('#priority');
            const loanAmountInput = loanAccOpeningModal.querySelector('#loanAmount');
            const collateralTypeInput = loanAccOpeningModal.querySelector('#collateralType');
            const collateralValueInput = loanAccOpeningModal.querySelector('#collateralValue');
            const pageNoInput = loanAccOpeningModal.querySelector('#pageNo');
            const isLossAssetInput = loanAccOpeningModal.querySelector('#isLossAsset');
            const caseFlagInput = loanAccOpeningModal.querySelector('#caseFlag');
            const addToDemandInput = loanAccOpeningModal.querySelector('#addToDemand');
            const interestInput = loanAccOpeningModal.querySelector('#interest');
            const penalInterestInput = loanAccOpeningModal.querySelector('#penalInterest');
            const openInterestInput = loanAccOpeningModal.querySelector('#openInterest');
            const insuranceInput = loanAccOpeningModal.querySelector('#insurance');
            const insuranceDateInput = loanAccOpeningModal.querySelector('#insuranceDate');
            const postageInput = loanAccOpeningModal.querySelector('#postage');
            const noticeFeeInput = loanAccOpeningModal.querySelector('#noticeFee');
            const goldWeightInput = loanAccOpeningModal.querySelector('#goldWeight');
            const goldPurityInput = loanAccOpeningModal.querySelector('#goldPurity');
            const marketValueInput = loanAccOpeningModal.querySelector('#marketValue');
            const pledgedDateInput = loanAccOpeningModal.querySelector('#pledgedDate');
            const releaseStatusInput = loanAccOpeningModal.querySelector('#releaseStatus');
            const releaseDateInput = loanAccOpeningModal.querySelector('#releaseDate');
            const grMemberIdInput = loanAccOpeningModal.querySelector('#grMemberId');
            const guarantorTypeInput = loanAccOpeningModal.querySelector('#guarantorType');
            const addedOnInput = loanAccOpeningModal.querySelector('#addedOn');
            const releasedOnInput = loanAccOpeningModal.querySelector('#releasedOn');
            const installmentTypeInput = loanAccOpeningModal.querySelector('#installmentType');
            const matureDateInput = loanAccOpeningModal.querySelector('#matureDate');
            const firstInstallmentDateInput = loanAccOpeningModal.querySelector(
                '#firstInstallmentDate');
            const totalInstallmentsInput = loanAccOpeningModal.querySelector('#totalInstallments');
            const resolutionDetailsInput = loanAccOpeningModal.querySelector('#resolutionDetails');
            const resolutionDateInput = loanAccOpeningModal.querySelector('#resolutionDate');
            const boardMeetingNoInput = loanAccOpeningModal.querySelector('#boardMeetingNo');
            const boardMeetingDateInput = loanAccOpeningModal.querySelector('#boardMeetingDate');
            const nominee1NameInput = loanAccOpeningModal.querySelector('#nominee1Name');
            const nominee1NaavInput = loanAccOpeningModal.querySelector('#marathiNominee1Name');
            const nominee1AgeInput = loanAccOpeningModal.querySelector('#nominee1Age');
            const nominee1GenderInput = loanAccOpeningModal.querySelector('#nominee1Gender');
            const nominee1RelationInput = loanAccOpeningModal.querySelector('#nominee1Relation');
            const nominee2NameInput = loanAccOpeningModal.querySelector('#nominee2Name');
            const nominee2NaavInput = loanAccOpeningModal.querySelector('#marathiNominee2Name');
            const nominee2AgeInput = loanAccOpeningModal.querySelector('#nominee2Age');
            const nominee2GenderInput = loanAccOpeningModal.querySelector('#nominee2Gender');
            const nominee2RelationInput = loanAccOpeningModal.querySelector('#nominee2Relation');

            if (id) {
                modalTitle.textContent = 'Edit Loan Account';
                loanAccIdInput.value = id;
                formMethod.value = 'PUT';
                if (ledgerId) ledgerIdInput.value = ledgerId;
                if (memberId) memberIdInput.value = memberId;
                if (accountId) accountIdInput.value = accountId;
                accNoInput.value = accNo || '';
                nameInput.value = name || '';
                if (loanType) loanTypeInput.value = loanType;
                interestRateInput.value = interestRate || '';
                acStartDateInput.value = acStartDate || '';
                emiAmountInput.value = emiAmount || '';
                openBalanceInput.value = openBalance || '';
                balanceInput.value = balance || '';
                if (purpose) purposeInput.value = purpose;
                principalAmountInput.value = principalAmount || '';
                startDateInput.value = startDate || '';
                endDateInput.value = endDate || '';
                tenureInput.value = tenure || '';
                priorityInput.value = priority || '';
                loanAmountInput.value = loanAmount || '';
                if (collateralType) collateralTypeInput.value = collateralType;
                collateralValueInput.value = collateralValue || '';
                pageNoInput.value = pageNo || '';
                isLossAssetInput.checked = isLossAsset == 1;
                caseFlagInput.checked = caseFlag == 1;
                addToDemandInput.checked = addToDemand == 1;
                interestInput.value = interest || '';
                penalInterestInput.value = penalInterest || '';
                openInterestInput.value = openInterest || '';
                insuranceInput.value = insurance || '';
                insuranceDateInput.value = insuranceDate || '';
                postageInput.value = postage || '';
                noticeFeeInput.value = noticeFee || '';
                goldWeightInput.value = goldWeight || '';
                if (goldPurity) goldPurityInput.value = goldPurity;
                marketValueInput.value = marketValue || '';
                pledgedDateInput.value = pledgedDate || '';
                if (releaseStatus) releaseStatusInput.value = releaseStatus;
                releaseDateInput.value = releaseDate || '';
                if (grMemberId) grMemberIdInput.value = grMemberId;
                if (guarantorType) guarantorTypeInput.value = guarantorType;
                addedOnInput.value = addedOn || '';
                releasedOnInput.value = releasedOn || '';
                if (installmentType) installmentTypeInput.value = installmentType;
                matureDateInput.value = matureDate || '';
                firstInstallmentDateInput.value = firstInstallmentDate || '';
                totalInstallmentsInput.value = totalInstallments || '';
                resolutionDetailsInput.value = resolutionDetails || '';
                resolutionDateInput.value = resolutionDate || '';
                boardMeetingNoInput.value = boardMeetingNo || '';
                boardMeetingDateInput.value = boardMeetingDate || '';
                nominee1NameInput.value = nominee1Name || '';
                nominee1NaavInput.value = nominee1Naav || '';
                nominee1AgeInput.value = nominee1Age || '';
                if (nominee1Gender) nominee1GenderInput.value = nominee1Gender;
                if (nominee1Relation) nominee1RelationInput.value = nominee1Relation;
                nominee2NameInput.value = nominee2Name || '';
                nominee2NaavInput.value = nominee2Naav || '';
                nominee2AgeInput.value = nominee2Age || '';
                if (nominee2Gender) nominee2GenderInput.value = nominee2Gender;
                if (nominee2Relation) nominee2RelationInput.value = nominee2Relation;
            } else {
                modalTitle.textContent = 'Add Loan Account';
                loanAccIdInput.value = '';
                formMethod.value = 'POST';
                document.getElementById('memberLoanAccForm').reset();
                // Reset tab to Nominee Detail on add new
                const nomineeTab = document.getElementById('nominee-tab');
                if (nomineeTab) {
                    bootstrap.Tab.getOrCreateInstance(nomineeTab).show();
                }
            }
        });
    }
});
</script>


{{--
    <div class="row mb-1">
<div class="col-2 d-none d-xl-block">
<label for="installmentsPaid">Total Installments Paid</label>
</div>
<div class="col-4">
<input id="installmentsPaid" name="total_installments_paid" class="w-100 px-2 py-1 @error('total_installments_paid') is-invalid @enderror" value="{{ old('total_installments_paid') }}"
type="number" placeholder="Total Installments Paid">
@error('total_installments_paid')
<div class="invalid-feedback">{{$message}}</div>
@enderror
</div>
</div>
</div>

<!-- Resolution Tab -->
<div class="tab-pane fade p-3 px-5" id="resolution-tab-pane" role="tabpanel" aria-labelledby="resolution-tab"
    tabindex="0">
    <div class="row mb-1">
        <div class="col-3 d-none d-xl-block">
            <label for="resolutionNo">Resolution No.</label>
        </div>
        <div class="col-4">
            <input id="resolutionNo" name="resolution_no"
                class="w-100 px-2 py-1 @error('resolution_no') is-invalid @enderror" value="{{ old('resolution_no') }}"
                type="text" placeholder="Resolution No.">
            @error('resolution_no')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3 d-none d-xl-block">
            <label for="resolutionDate">Resolution Date</label>
        </div>
        <div class="col-4">
            <input name="resolution_date" id="resolutionDate"
                class="w-100 px-2 py-1 @error('resolution_date') is-invalid @enderror"
                value="{{ old('resolution_date') }}" type="date" placeholder="Resolution Date">
            @error('resolution_date')
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
--}}