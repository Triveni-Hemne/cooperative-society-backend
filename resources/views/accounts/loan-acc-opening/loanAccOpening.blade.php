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
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4 border-0">
                    <h1 class="modal-title fs-5 fw-bold">
                        <i class="bi bi-cash-coin me-2"></i> <span id="loanAccOpeningModalLabel">Add Loan Account</span>
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light p-4 py-0">
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="row g-3">
                            @isset($ledgers)
                            <div class="col-md-12 mb-3">
                                @if ($ledgers->isNotEmpty())
                                <div class="form-floating">
                                    <select id="ledgerId" name="ledger_id"
                                        class="form-select @error('ledger_id') is-invalid @enderror"
                                        aria-label="Ledger" required>
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
                                    <strong>⚠️ No ledgers available.</strong><br>
                                    Please add ledgers first.
                                </div>
                                @endif
                            </div>
                            @endisset
                        </div>
                        <fieldset class="border p-3 mb-3 rounded position-relative mb-3">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Member Information</legend>
                        <div class="row g-3">
                             @isset($members)
                            <div class="col-md-4">
                                @if ($members->isNotEmpty())
                                <div class="form-floating">
                                    <select id="memberId" name="member_id"
                                        class="form-select @error('member_id') is-invalid @enderror"
                                        aria-label="Member">
                                        <option value="" selected>--- Select Member ---</option>
                                        @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}[ID: {{$member->id}}]
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="memberId" class="form-label">Member <span
                                            class="text-danger">*</span></label>
                                    @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No departments available.</strong><br>
                                    Please add departments first.
                                </div>
                                @endif
                            </div>
                            @endisset
                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
                        </fieldset>
                        <fieldset class="border p-3 mb-3 rounded position-relative">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Account Information</legend>
                        <div class="row g-3">
                            {{-- @isset($accounts)
                            <div class="col-md-6 mb-3">
                                @if ($accounts->isNotEmpty())
                                <div class="form-floating">
                                    <select id="accountId" name="account_id"
                                        class="form-select @error('account_id') is-invalid @enderror"
                                        aria-label="Account">
                                        <option value="" {{ old('account_id') ? '' : 'selected' }}>--- Select Account ---</option>
                                        @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="accountId" class="form-label">Account</label>
                                    @error('account_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No departments available.</strong><br>
                                    Please add departments first.
                                </div>
                                @endif
                            </div>
                            @endisset --}}

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="acc_no" id="accNo"
                                        class="form-control @error('acc_no') is-invalid @enderror"
                                        value="{{ old('acc_no') }}" type="text" placeholder="Account No." required>
                                    <label for="accNo" class="form-label">Account No. <span
                                            class="text-danger">*</span></label>
                                    @error('acc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <input name="name" id="Name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" type="text" placeholder="Name" required>
                                <label for="Name" class="form-label">Name</label>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        </fieldset>
                        <fieldset class="border p-3 mb-3 rounded position-relative">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Loan Details</legend>    
                        {{-- <div class="row ">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select name="loan_type" id="loanType"
                                        class="form-select @error('loan_type') is-invalid @enderror" required>
                                        <option value="" {{ old('loan_type') ? '' : 'selected' }}>------ Select Loan Type ------</option>
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
                        </div> --}}

                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input id="acStartDate" name="ac_start_date"
                                        class="form-control @error('ac_start_date') is-invalid @enderror"
                                        value="{{ old('ac_start_date') }}" type="date" placeholder="Acc Start Date" required>
                                    <label for="acStartDate" class="form-label">Acc Start Date <span
                                            class="text-danger">*</span></label>
                                    @error('ac_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="interest_rate" id="interestRate"
                                        class="form-control @error('interest_rate') is-invalid @enderror"
                                        value="{{ old('interest_rate') }}" type="number" step="0.01" placeholder="Interest Rate" required>
                                    <label for="interestRate" class="form-label">Interest Rate <span
                                            class="text-danger">*</span></label>
                                    @error('interest_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="emi_amount" id="emiAmount"
                                        class="form-control @error('emi_amount') is-invalid @enderror"
                                        value="{{ old('emi_amount') }}" step="0.01" type="number" placeholder="EMI Amount" required>
                                    <label for="emiAmount" class="form-label">EMI Amount <span
                                            class="text-danger">*</span></label>
                                    @error('emi_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="open_balance" id="openBalance"
                                        class="form-control @error('open_balance') is-invalid @enderror"
                                        value="{{ old('open_balance') }}" step="0.01" type="number" placeholder="Open Balance ">
                                    <label for="openBalance" class="form-label">Open Balance <span
                                            class="text-danger">*</span></label>
                                    @error('open_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="balance" id="balance"
                                        class="form-control @error('balance') is-invalid @enderror"
                                        value="{{ old('balance') }}" step="0.01" type="number" placeholder="Balance" required>
                                    <label for="balance" class="form-label">Balance <span
                                            class="text-danger">*</span></label>
                                    @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="loan_amount" id="loanAmount"
                                        class="form-control @error('loan_amount') is-invalid @enderror"
                                        value="{{ old('loan_amount') }}" step="0.01" type="number" placeholder="Loan Amount" required>
                                    <label for="loanAmount" class="form-label">Loan Amount <span
                                            class="text-danger">*</span></label>
                                    @error('loan_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                             {{-- <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="priority" id="priority"
                                        class="form-control @error('priority') is-invalid @enderror"
                                        value="{{ old('priority') }}" type="number" placeholder="Priority" required>
                                    <label for="priority" class="form-label">Priority</label>
                                    @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                               <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="tenure" id="tenure"
                                        class="form-control @error('tenure') is-invalid @enderror"
                                        value="{{ old('tenure') }}" step="0.01" type="number" placeholder="Tenure" required>
                                    <label for="tenure" class="form-label">Tenure <span
                                            class="text-danger">*</span></label>
                                    @error('tenure')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="start_date" id="startDate"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}" type="date" placeholder="Start Date" required>
                                    <label for="startDate" class="form-label">Start Date <span
                                            class="text-danger">*</span></label>
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="end_date" id="endDate"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}" type="date" placeholder="End Date" required>
                                    <label for="endDate" class="form-label">End Date <span
                                            class="text-danger">*</span></label>
                                    @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            </fieldset>

                            <fieldset class="border p-3 mb-3 rounded position-relative">
                                <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Loan Account
                                    Loan Purpose</legend>
                            <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="purpose" name="purpose" class="form-select" required>
                                        <option value="" {{ old('purpose') ? '' : 'selected' }}>------ Select Loan Purpose ------</option>
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
                                    <label for="purpose" class="form-label">Purpose <span
                                            class="text-danger">*</span></label>
                                </div>
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="principal_amount" id="principalAmount"
                                        class="form-control @error('principal_amount') is-invalid @enderror"
                                        value="{{ old('principal_amount') }}" step="0.01" type="number"
                                        placeholder="Principal Amount" required>
                                    <label for="principalAmount" class="form-label">Principal Amount</label>
                                    @error('principal_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                            </fieldset>                         

                            {{-- <fieldset class="border p-3 mb-3 rounded position-relative">
                                <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Collateral Information</legend>
                        <div class="row ">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select id="collateralType" name="collateral_type"
                                        class="form-select @error('collateral_type') is-invalid @enderror" required>
                                        <option value="" {{ old('collateral_type') ? '' : 'selected' }}>------ Select Collateral Type ------</option>
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
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="collateral_value" id="collateralValue"
                                        class="form-control @error('collateral_value') is-invalid @enderror"
                                        value="{{ old('collateral_value') }}" step="0.01" type="number"
                                        placeholder="Collateral Value">
                                    <label for="collateralValue" class="form-label">Collateral Value</label>
                                    @error('collateral_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                            </fieldset> --}}
                        <fieldset class="border p-3 mb-3 rounded position-relative">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Loan Account
                                Classification</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="page_no" id="pageNo"
                                        class="form-control @error('page_no') is-invalid @enderror"
                                        value="{{ old('page_no') }}" type="text" placeholder="Page No.">
                                    <label for="pageNo" class="form-label">Page No. </label>
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
                        </fieldset>
                        <fieldset class="border p-3 mb-3 rounded position-relative">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Interest Detail</legend>
                        <div class="row g-3">
                            <div class="col-md-3" >
                                <div class="form-floating">
                                    <input name="interest" id="interest"
                                        class="form-control @error('interest') is-invalid @enderror"
                                        value="{{ old('interest') }}" step="0.01" type="number" placeholder="Interest">
                                    <label for="interest" class="form-label">Interest <span
                                            class="text-danger">*</span></label>
                                    @error('interest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3" >
                                <div class="form-floating">
                                    <input name="penal_interest" id="penalInterest"
                                        class="form-control @error('penal_interest') is-invalid @enderror"
                                        value="{{ old('penal_interest') }}" step="0.01" type="number" placeholder="Penal Interest">
                                    <label for="penalInterest" class="form-label">Penal Interest</label>
                                    @error('penal_interest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-4 mb-3" >
                                <div class="form-floating">
                                    <input name="open_interest" id="openInterest"
                                        class="form-control @error('open_interest') is-invalid @enderror"
                                        value="{{ old('open_interest') }}" step="0.01" type="number" placeholder="Open Interest">
                                    <label for="openInterest" class="form-label">Open Interest</label>
                                    @error('open_interest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                        </fieldset>
                        {{-- <fieldset class="border p-3 mb-3 rounded position-relative">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Insurance Information</legend>
                        <div class="row "> --}}
                            {{-- <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="insurance" id="insurance"
                                        class="form-control @error('insurance') is-invalid @enderror"
                                        value="{{ old('insurance') }}" step="0.01" type="number" placeholder="Insurance">
                                    <label for="insurance" class="form-label">Insurance</label>
                                    @error('insurance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="insurance_date" id="insuranceDate"
                                        class="form-control @error('insurance_date') is-invalid @enderror"
                                        value="{{ old('insurance_date') }}" step="0.01" type="date" placeholder="Insurance Date">
                                    <label for="insuranceDate" class="form-label">Insurance Date</label>
                                    @error('insurance_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        {{-- </div>
                        </fieldset> --}}
                        {{-- <fieldset class="border p-3 mb-3 rounded position-relative">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Other Charges</legend>
                        <div class="row "> --}}
                            {{-- <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="postage" id="postage"
                                        class="form-control @error('postage') is-invalid @enderror"
                                        value="{{ old('postage') }}" step="0.01" type="number" placeholder="Postage">
                                    <label for="postage" class="form-label">Postage</label>
                                    @error('postage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input name="notice_fee" id="noticeFee"
                                        class="form-control @error('notice_fee') is-invalid @enderror"
                                        value="{{ old('notice_fee') }}" step="0.01" type="number" placeholder="Notice Fee">
                                    <label for="noticeFee" class="form-label">Notice Fee</label>
                                    @error('notice_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        {{-- </div>
                        </fieldset> --}}


                        <!-- Tabs -->
                        <div class="bg-secondary warning-tabs border rounded mb-3 p-2">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info fw-bold" id="nominee-tab"
                                        data-bs-toggle="tab" data-bs-target="#nominee-tab-pane" type="button" role="tab"
                                        aria-controls="nominee-tab-pane" aria-selected="true">Nominee
                                        Detail
                                    </button>
                                </li>
                                {{-- <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info fw-bold" id="goldLoan-tab"
                                        data-bs-toggle="tab" data-bs-target="#goldLoan-tab-pane" type="button"
                                        role="tab" aria-controls="goldLoan-tab-pane" aria-selected="false">Gold Loan
                                        Detail
                                    </button>
                                </li> --}}
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info fw-bold" id="guarantors-tab"
                                        data-bs-toggle="tab" data-bs-target="#guarantors-tab-pane" type="button"
                                        role="tab" aria-controls="guarantors-tab-pane" aria-selected="false">Guarantors
                                        Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info fw-bold" id="installments-tab"
                                        data-bs-toggle="tab" data-bs-target="#installments-tab-pane" type="button"
                                        role="tab" aria-controls="installments-tab-pane"
                                        aria-selected="false">Installments Detail
                                    </button>
                                </li>
                                {{-- <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info fw-bold" id="resolution-tab"
                                        data-bs-toggle="tab" data-bs-target="#resolution-tab-pane" type="button"
                                        role="tab" aria-controls="resolution-tab-pane" aria-selected="false">Resolution
                                        Detail
                                    </button>
                                </li> --}}
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active p-3" id="nominee-tab-pane" role="tabpanel"
                                    aria-labelledby="nominee-tab" tabindex="0">

                                    <div class="row g-3">
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-center mb-3">Nominee 1</h6>
                                            <div class="row g-3">
                                            <div class="form-floating col-md-12">
                                                <input name="nominees[0][nominee_name]" id="nominee1Name"
                                                    class="form-control @error('nominees.0.nominee_name') is-invalid @enderror"
                                                    type="text" placeholder="Nominee Name"
                                                    value="{{ old('nominees.0.nominee_name') }}" required>
                                                <label for="nominee1Name" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.0.nominee_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-12">
                                                <input name="nominees[0][nominee_naav]" id="marathiNominee1Name"
                                                    class="form-control @error('nominees.0.nominee_naav') is-invalid @enderror"
                                                    type="text" value="{{ old('nominees.0.nominee_naav') }}"
                                                    placeholder="नाव">
                                                <label for="marathiNominee1Name" class="form-label">नाव <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.0.nominee_naav')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <input name="nominees[0][nominee_age]" id="nominee1Age"
                                                    class="form-control @error('nominees.0.nominee_age') is-invalid @enderror"
                                                    type="number" placeholder="Age"
                                                    value="{{ old('nominees.0.nominee_age') }}" required>
                                                <label for="nominee1Age" class="form-label">Age <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.0.nominee_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <select id="nominee1Gender" name="nominees[0][nominee_gender]"
                                                    class="form-select @error('nominees.0.nominee_gender') is-invalid @enderror" required>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <label for="nominee1Gender" class="form-label">Gender <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.0.nominee_gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <select id="nominee1Relation" name="nominees[0][relation]"
                                                    class="form-select @error('nominees.0.relation') is-invalid @enderror" required>
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
                                                <label for="nominee1Relation" class="form-label">Relation <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.0.relation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="nominee1Photo" class="form-label text-white">Photo</label>
                                                <input name="nominees[0][nominee_image]" id="nominee1Photo"
                                                    value="{{ old('nominees.0.nominee_image') }}"
                                                    class="form-control @error('nominees.0.nominee_image') is-invalid @enderror"
                                                    type="file" accept="image/*" placeholder="Nominee Photo">
                                                @error('nominees.0.nominee_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-center mb-3">Nominee 2</h6>
                                            <div class="row g-3">
                                            <div class="form-floating col-md-12">
                                                <input name="nominees[1][nominee_name]" id="nominee2Name"
                                                    class="form-control @error('nominees.1.nominee_name') is-invalid @enderror"
                                                    value="{{ old('nominees.1.nominee_name') }}" type="text"
                                                    placeholder="Nominee Name" required>
                                                <label for="nominee2Name" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.1.nominee_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-12">
                                                <input name="nominees[1][nominee_naav]" id="marathiNominee2Name"
                                                    class="form-control @error('nominees.1.nominee_naav') is-invalid @enderror"
                                                    type="text" value="{{ old('nominees.1.nominee_naav') }}"
                                                    placeholder="नाव">
                                                <label for="marathiNominee2Name" class="form-label">नाव <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.1.nominee_naav')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <input name="nominees[1][nominee_age]" id="nominee2Age"
                                                    class="form-control @error('nominees.1.nominee_age') is-invalid @enderror"
                                                    type="number" placeholder="Age"
                                                    value="{{ old('nominees.1.nominee_age') }}" required>
                                                <label for="nominee2Age" class="form-label">Age <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.1.nominee_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <select id="nominee2Gender" name="nominees[1][nominee_gender]"
                                                    class="form-select @error('nominees.1.nominee_gender') is-invalid @enderror" required>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <label for="nominee2Gender" class="form-label">Gender <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.1.nominee_gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <select id="nominee2Relation" name="nominees[1][relation]"
                                                    class="form-select @error('nominees.1.relation') is-invalid @enderror" required>
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
                                                <label for="nominee2Relation" class="form-label">Relation <span
                                            class="text-danger">*</span></label>
                                                @error('nominees.1.relation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="nominee2Photo" class="form-label text-white">Photo</label>
                                                <input name="nominees[1][nominee_image]" id="nominee2Photo"
                                                    value="{{ old('nominees.1.nominee_image') }}"
                                                    class="form-control @error('nominees.1.nominee_image') is-invalid @enderror"
                                                    type="file" accept="image/*" placeholder="Nominee Photo" >
                                                @error('nominees.1.nominee_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade p-3" id="goldLoan-tab-pane" role="tabpanel"
                                    aria-labelledby="goldLoan-tab" tabindex="0">
                                    <div class="row ">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input id="goldWeight" name="gold_weight"
                                                    class="form-control @error('gold_weight') is-invalid @enderror"
                                                    value="{{ old('gold_weight') }}" step="0.01" type="number"
                                                    placeholder="Gold Weight">
                                                <label for="goldWeight" class="form-label">Gold Weight</label>
                                                @error('gold_weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
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
                                    <div class="row ">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input name="market_value" id="marketValue"
                                                    class="form-control @error('market_value') is-invalid @enderror"
                                                    value="{{ old('market_value') }}" step="0.01" type="number"
                                                    placeholder="Market Value">
                                                <label for="marketValue" class="form-label">Market Value</label>
                                                @error('market_value')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input name="pledged_date" id="pledgedDate"
                                                    class="form-control @error('pledged_date') is-invalid @enderror"
                                                    value="{{ old('pledged_date') }}" step="0.01" type="date"
                                                    placeholder="Pledge Date">
                                                <label for="pledgedDate" class="form-label">Pledge Date</label>
                                                @error('pledged_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-6 mb-3">
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
                                        <div class="col-md-6 mb-3">
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
                                </div> --}}
                                <div class="tab-pane fade p-3" id="guarantors-tab-pane" role="tabpanel"
                                    aria-labelledby="guarantors-tab" tabindex="0">
                                    <h6 class="text-center">Guarantor 1</h6>
                                    <div class="row g-3 mb-3">
                                        @isset($members)
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select id="grMemberId1" name="garantors[0][gr_member_id]"
                                                    class="form-select @error('garantors.0.gr_member_id') is-invalid @enderror" required>
                                                    <option value="" disabled {{old('garantors.0.gr_member_id') ? '' : 'selected'}}>------ Select Member ------</option>
                                                    @foreach ($members as $member)
                                                    <option value="{{ $member->id }}"
                                                        {{ old('garantors.0.gr_member_id') == $member->id ? 'selected' : '' }}>
                                                        {{ $member->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <label for="grMemberId1" class="form-label">Member</label>
                                                @error('garantors.0.gr_member_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @endisset
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select id="guarantorType1" name="garantors[0][guarantor_type]"
                                                    class="form-select @error('garantors.0.guarantor_type') is-invalid @enderror" required>
                                                    <option value="Primary"
                                                        {{ old('garantors.0.guarantor_type') == 'Primary' ? 'selected' : '' }}>
                                                        Primary
                                                    </option>
                                                    <option value="Secondary"
                                                        {{ old('garantors.0.guarantor_type') == 'Secondary' ? 'selected' : '' }}>
                                                        Secondary
                                                    </option>
                                                    <option value="Tertiary"
                                                        {{ old('garantors.0.guarantor_type') == 'Tertiary' ? 'selected' : '' }}>
                                                        Tertiary
                                                    </option>
                                                </select>
                                                <label for="guarantorType1" class="form-label">Guarantor Type</label>
                                                @error('garantors.0.guarantor_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input name="garantors[0][added_on]" id="addedOn1"
                                                    class="form-control @error('garantors.0.added_on') is-invalid @enderror"
                                                    value="{{ old('garantors.0.added_on') }}" type="date" placeholder="Added On" required>
                                                <label for="addedOn1" class="form-label">Added On</label>
                                                @error('garantors.0.added_on')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input name="garantors[0][released_on]" id="releasedOn1"
                                                    class="form-control @error('garantors.0.released_on') is-invalid @enderror"
                                                    value="{{ old('garantors.0.released_on') }}" type="date"
                                                    placeholder="Release Date">
                                                <label for="releasedOn1" class="form-label">Release Date</label>
                                                @error('garantors.0.released_on')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="text-center">Guarantor 2</h6>
                                    <div class="row g-3">
                                        @isset($members)
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select id="grMemberId2" name="garantors[1][gr_member_id]"
                                                    class="form-select @error('garantors.1.gr_member_id') is-invalid @enderror" required>
                                                    <option value="" disabled {{old('garantors.1.gr_member_id') ? '' : 'selected'}}>------ Select Member ------</option>
                                                    @foreach ($members as $member)
                                                    <option value="{{ $member->id }}"
                                                        {{ old('garantors.1.gr_member_id') == $member->id ? 'selected' : '' }}>
                                                        {{ $member->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <label for="grMemberId2" class="form-label">Member</label>
                                                @error('garantors.1.gr_member_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @endisset
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select id="guarantorType2" name="garantors[1][guarantor_type]"
                                                    class="form-select @error('garantors.1.guarantor_type') is-invalid @enderror" required>
                                                    <option value="Primary"
                                                        {{ old('garantors.1.guarantor_type') == 'Primary' ? 'selected' : '' }}>
                                                        Primary
                                                    </option>
                                                    <option value="Secondary"
                                                        {{ old('garantors.1.guarantor_type') == 'Secondary' ? 'selected' : '' }}>
                                                        Secondary
                                                    </option>
                                                    <option value="Tertiary"
                                                        {{ old('garantors.1.guarantor_type') == 'Tertiary' ? 'selected' : '' }}>
                                                        Tertiary
                                                    </option>
                                                </select>
                                                <label for="guarantorType2" class="form-label">Guarantor Type</label>
                                                @error('garantors.1.guarantor_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input name="garantors[1][added_on]" id="addedOn2"
                                                    class="form-control @error('garantors.1.added_on') is-invalid @enderror"
                                                    value="{{ old('garantors.1.added_on') }}" type="date" placeholder="Added On" required>
                                                <label for="addedOn2" class="form-label">Added On</label>
                                                @error('garantors.1.added_on')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input name="garantors[1][released_on]" id="releasedOn2"
                                                    class="form-control @error('garantors.1.released_on') is-invalid @enderror"
                                                    value="{{ old('garantors.1.released_on') }}" type="date"
                                                    placeholder="Release Date">
                                                <label for="releasedOn2" class="form-label">Release Date</label>
                                                @error('garantors.1.released_on')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade p-3" id="installments-tab-pane" role="tabpanel"
                                    aria-labelledby="installments-tab" tabindex="0">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select id="installmentType" name="installment_type"
                                                    class="form-select @error('installment_type') is-invalid @enderror" >
                                                    <option value="" {{ old('installment_type') ? '' : 'selected' }}>------ Select Type ------</option>
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
                                                <label for="installmentType" class="form-label">Installment Type <span
                                            class="text-danger">*</span></label>
                                                @error('installment_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input name="total_installments" id="totalInstallments"
                                                    class="form-control @error('total_installments') is-invalid @enderror"
                                                    value="{{ old('total_installments') }}" type="number"
                                                    placeholder="Total Installments" >
                                                <label for="totalInstallments" class="form-label">Total
                                                    Installments</label>
                                                @error('total_installments')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input id="installmentAmount" name="installment_amount"
                                                    class="form-control @error('installment_amount') is-invalid @enderror"
                                                    value="{{ old('installment_amount') }}" step="0.01" type="number"
                                                    placeholder="Installment Amount" >
                                                <label for="installmentAmount" class="form-label">Installment
                                                    Amount</label>
                                                @error('installment_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input name="installment_with_interest" id="installmentWithInterest"
                                                    class="form-control @error('installment_with_interest') is-invalid @enderror"
                                                    value="{{ old('installment_with_interest') }}" step="0.01" type="number"
                                                    placeholder="Installment with Interest" >
                                                <label for="installmentWithInterest" class="form-label">Installment with
                                                    Interest</label>
                                                @error('installment_with_interest')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input id="installmentsPaid" name="total_installments_paid"
                                                    class="form-control @error('total_installments_paid') is-invalid @enderror"
                                                    value="{{ old('total_installments_paid') }}" type="number"
                                                    placeholder="Total Installments Paid" >
                                                <label for="installmentsPaid" class="form-label">Total Installments
                                                    Paid</label>
                                                @error('total_installments_paid')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade p-3" id="resolution-tab-pane" role="tabpanel"
                                    aria-labelledby="resolution-tab" tabindex="0">
                                    <div class="row ">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input name="resolution_no" id="resolutionNo"
                                                    class="form-control @error('resolution_no') is-invalid @enderror"
                                                    value="{{ old('resolution_no') }}" type="number"
                                                    placeholder="Resolution No." required>
                                                <label for="resolutionNo" class="form-label">Resolution No.</label>
                                                @error('resolution_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input name="resolution_date" id="resolutionDate"
                                                    class="form-control @error('resolution_date') is-invalid @enderror"
                                                    value="{{ old('resolution_date') }}" type="date" required>
                                                <label for="resolutionDate" class="form-label">Resolution Date</label>
                                                @error('resolution_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
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
