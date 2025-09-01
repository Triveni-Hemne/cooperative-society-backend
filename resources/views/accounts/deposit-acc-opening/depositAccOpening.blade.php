<div class="modal fade" id="depositAccOpeningModal" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="depositAccOpeningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('member-depo-accounts.store') }}" id="depositAccModalForm"
                enctype="multipart/form-data">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif
                <input type="hidden" id="memberDepoAccountId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4 border-0">
                    <h1 class="modal-title fs-5 fw-bold">
                        <i class="bi bi-bank me-2"></i> <span id="depositAccOpeningModalLabel">Add Deposit Account</span>
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light p-4 py-0">
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="row g-3 mb-3">
                            @isset($ledgers)
                            <div class="col-md-12">
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
                                    <strong>⚠️ No ledgers available.</strong><br>
                                    Please add ledgers first.
                                </div>
                                @endif
                            </div>
                          @endisset
                        </div>

                    <fieldset class="border p-3  rounded position-relative mb-3">
                    <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Member Information</legend> 
                        <div class="row g-3">
                            @isset($members)
                            <div class="col-md-4">
                                @if ($members->isNotEmpty())
                                <div class="form-floating">
                                    <select id="memberId" name="member_id"
                                        class="form-select @error('member_id') is-invalid @enderror"
                                        aria-label="Member">
                                        <option value="" {{ old('member_id') ? '' : 'selected' }}>--- Select Member ---</option>
                                        @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} [ID: {{ $member->id }}]
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
                                    <strong>⚠️ No members available.</strong><br>
                                    Please add members first.
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
                                        value="{{ old('signature') }}" type="file" accept="image/*,.pdf"
                                        placeholder="Signature Copy">
                                    <label for="signCopy" class="form-label">Signature Copy</label>
                                    @error('signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        </fieldset>
                        <fieldset class="border p-3  rounded position-relative mb-3">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Account Information</legend>
                        <div class="row g-3">
                            {{-- @isset($accounts)
                            <div class="col-md-6 ">
                                @if ($accounts->isNotEmpty())
                                <div class="form-floating">
                                    <select id="accountId" name="account_id"
                                        class="form-select @error('account_id') is-invalid @enderror"
                                        aria-label="Account">
                                        <option value="" selected>--- Select Account ---</option>
                                        @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }} ({{ $account->account_type }})
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
                                    <strong>⚠️ No account available.</strong><br>
                                    Please add account first.
                                </div>
                                @endif
                            </div>
                            @endisset --}}

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="acc_no" id="accNo"
                                        class="form-control @error('acc_no') is-invalid @enderror"
                                        value="{{ old('acc_no', $nextAccNo) }}" type="text" placeholder="Account No.">
                                    <label for="accNo" class="form-label">Account No.</label>
                                    @error('acc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="name" id="Name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" type="text" placeholder="Name">
                                    <label for="Name" class="form-label">Name</label>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="interest_rate" id="interestRate"
                                        class="form-control @error('interest_rate') is-invalid @enderror"
                                        value="{{ old('interest_rate') }}" type="number" step="0.01" placeholder="Interest Rate">
                                    <label for="interestRate" class="form-label">Interest Rate</label>
                                    @error('interest_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="interest_payable" id="interestPayable"
                                        class="form-control @error('interest_payable') is-invalid @enderror"
                                        value="{{ old('interest_payable') }}" step="0.01" type="number"
                                        placeholder="Interest Payable">
                                    <label for="interestPayable" class="form-label">Interest Payable</label>
                                    @error('interest_payable')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="ac_start_date" id="acStartDate"
                                        class="form-control @error('ac_start_date') is-invalid @enderror"
                                        value="{{ old('ac_start_date',\Carbon\Carbon::today()->format('Y-m-d')) }}" type="date" placeholder="Account Start Date">
                                    <label for="acStartDate" class="form-label">Account Start Date</label>
                                    @error('ac_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="acc_closing_date" id="accClosingDate"
                                        class="form-control @error('acc_closing_date') is-invalid @enderror"
                                        value="{{ old('acc_closing_date') }}" type="date"
                                        placeholder="Account Closing Date">
                                    <label for="accClosingDate" class="form-label">Account Closing Date</label>
                                    @error('acc_closing_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="open_balance" id="openBalance"
                                        class="form-control @error('open_balance') is-invalid @enderror"
                                        value="{{ old('open_balance') }}" type="number" step="0.01" placeholder="Open Balance">
                                    <label for="openBalance" class="form-label">Open Balance</label>
                                    @error('open_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="balance" id="balance"
                                        class="form-control @error('balance') is-invalid @enderror"
                                        value="{{ old('balance') }}" type="number" step="0.01" placeholder="Balance">
                                    <label for="balance" class="form-label">Balance</label>
                                    @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>
                        <fieldset class="border p-3  rounded position-relative mb-3">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Other Information</legend>
                        <div class="row g-3">
                            {{-- @isset($agents)
                            <div class="col-md-3">
                                @if ($agents->isNotEmpty())
                                <div class="form-floating">
                                    <select id="agentId" name="agent_id"
                                        class="form-select @error('agent_id') is-invalid @enderror" aria-label="Agent">
                                        <option value="" selected>--- Select Agent ---</option>
                                        @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}"
                                            {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->name ?? $agent->user->name ?? $agent->agent_code }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="agentId" class="form-label">Agent</label>
                                    @error('agent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No agent available.</strong><br>
                                    Please add agent first.
                                </div>
                                @endif
                            </div>
                            @endisset --}}
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input id="pageNo" name="page_no"
                                        class="form-control @error('page_no') is-invalid @enderror"
                                        value="{{ old('page_no') }}" type="number" placeholder="Page No.">
                                    <label for="pageNo" class="form-label">Page No.</label>
                                    @error('page_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select id="depositType" name="deposit_type"
                                        class="form-select @error('deposit_type') is-invalid @enderror">
                                        <option value="" disabled {{ old('deposit_type') ? '' : 'selected' }}>--- Select Deposit Type ---</option>
                                        <option value="savings"
                                            {{ old('deposit_type') == 'savings' ? 'selected' : '' }}>Savings
                                        </option>
                                        <option value="fd" {{ old('deposit_type') == 'fd' ? 'selected' : '' }}>Fixed
                                            Deposit
                                        </option>
                                        <option value="rd" {{ old('deposit_type') == 'rd' ? 'selected' : '' }}>
                                            Recurring
                                            Deposit
                                        </option>
                                    </select>
                                    <label for="depositType" class="form-label">Deposit Type</label>
                                    @error('deposit_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3  d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input id="closingFlag" type="checkbox" name="closing_flag" value="1"
                                        {{ old('closing_flag') ? 'checked' : '' }}
                                        class="form-check-input @error('closing_flag') is-invalid @enderror">
                                    <label class="form-check-label" for="closingFlag">Closing Flag</label>
                                    @error('closing_flag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-switch ms-3">
                                    <input id="addToDemand" type="checkbox" name="add_to_demand" value="1"
                                        {{ old('add_to_demand') ? 'checked' : '' }}
                                        class="form-check-input @error('add_to_demand') is-invalid @enderror">
                                    <label class="form-check-label" for="addToDemand">Add to Demand</label>
                                    @error('add_to_demand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        </fieldset>
                        <fieldset class="border p-3  rounded position-relative mb-3">
                            <legend class="fw-semibold fs-6 px-2 w-auto position-absolute">Installment Information</legend>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select id="installmentType" name="installment_type"
                                        class="form-select @error('installment_type') is-invalid @enderror">
                                        <option value="" selected>--- Select Installment Type ---</option>
                                        <option value="Monthly"
                                            {{ old('installment_type') == 'Monthly' ? 'selected' : '' }}>Monthly
                                        </option>
                                        <option value="Quarterly"
                                            {{ old('installment_type') == 'Quarterly' ? 'selected' : '' }}>Quarterly
                                        </option>
                                        <option value="Half Yearly"
                                            {{ old('installment_type') == 'Half Yearly' ? 'selected' : '' }}>Half Yearly
                                        </option>
                                        <option value="Yearly"
                                            {{ old('installment_type') == 'Yearly' ? 'selected' : '' }}>Yearly
                                        </option>
                                    </select>
                                    <label for="installmentType" class="form-label">Installment Type</label>
                                    @error('installment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="installment_amount" id="installmentAmount"
                                        class="form-control @error('installment_amount') is-invalid @enderror"
                                        type="number" value="{{ old('description') }}" step="0.01" placeholder="Installment Amount">
                                    <label for="installmentAmount" class="form-label">Installment Amount</label>
                                    @error('installment_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="total_installments" id="totalInstallments"
                                        class="form-control @error('total_installments') is-invalid @enderror"
                                        type="number" value="{{ old('total_installments') }}"
                                        placeholder="Total Installments">
                                    <label for="totalInstallments" class="form-label">Total Installments</label>
                                    @error('total_installments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input name="total_payable_amount" id="totalPayableAmount"
                                        class="form-control @error('total_payable_amount') is-invalid @enderror"
                                        type="number" step="0.01" value="{{ old('total_payable_amount') }}"
                                        placeholder="Total Payable Amount">
                                    <label for="totalPayableAmount" class="form-label">Total Payable Amount</label>
                                    @error('total_payable_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row"> --}}
                            {{-- <div class="col-md-6 ">
                                <div class="form-floating">
                                    <input name="total_installments_paid" id="installmentsPaid"
                                        class="form-control @error('total_installments_paid') is-invalid @enderror"
                                        type="number" step="0.01" value="{{ old('total_installments_paid') }}"
                                        placeholder="Total Installments Paid">
                                    <label for="installmentsPaid" class="form-label">Total Installments Paid</label>
                                    @error('total_installments_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6 ">
                                <div class="form-floating">
                                    <input name="open_interest" id="openInterest"
                                        class="form-control @error('open_interest') is-invalid @enderror" type="number"
                                        placeholder="Open Interest" step="0.01" value="{{ old('open_interest') }}">
                                    <label for="openInterest" class="form-label">Open Interest</label>
                                    @error('open_interest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        {{-- </div> --}}
                        </fieldset>

                        <!-- Tabs -->
                        <div class="bg-secondary warning-tabs border rounded  p-2">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info fw-bold" id="nominee-tab"
                                        data-bs-toggle="tab" data-bs-target="#nominee-tab-pane" type="button" role="tab"
                                        aria-controls="nominee-tab-pane" aria-selected="true">Nominee
                                        Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info fw-bold" id="rd-tab" data-bs-toggle="tab"
                                        data-bs-target="#rd-tab-pane" type="button" role="tab"
                                        aria-controls="rd-tab-pane" aria-selected="false">RD Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info fw-bold" id="fd-tab" data-bs-toggle="tab"
                                        data-bs-target="#fd-tab-pane" type="button" role="tab"
                                        aria-controls="fd-tab-pane" aria-selected="false">FD Detail
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info fw-bold" id="saving-tab"
                                        data-bs-toggle="tab" data-bs-target="#saving-tab-pane" type="button" role="tab"
                                        aria-controls="saving-tab-pane" aria-selected="false">Saving Detail
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active p-3" id="nominee-tab-pane" role="tabpanel"
                                    aria-labelledby="nominee-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-center ">Nominee 1</h6>
                                            <div class="row g-3">
                                            <div class="form-floating col-md-6">
                                                <input name="nominees[0][nominee_name]" id="nominee1Name"
                                                    class="form-control @error('nominees.0.nominee_name') is-invalid @enderror"
                                                    type="text" placeholder="Nominee Name"
                                                    value="{{ old('nominees.0.nominee_name') }}">
                                                <label for="nominee1Name" class="form-label">Name</label>
                                                @error('nominees.0.nominee_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-6">
                                                <input name="nominees[0][nominee_naav]" id="marathiNominee1Name"
                                                    class="form-control @error('nominees.0.nominee_naav') is-invalid @enderror"
                                                    type="text" value="{{ old('nominees.0.nominee_naav') }}"
                                                    placeholder="नाव">
                                                <label for="marathiNominee1Name" class="form-label">नाव</label>
                                                @error('nominees.0.nominee_naav')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <input name="nominees[0][nominee_age]" id="nominee1Age"
                                                    class="form-control @error('nominees.0.nominee_age') is-invalid @enderror"
                                                    type="number" placeholder="Age"
                                                    value="{{ old('nominees.0.nominee_age') }}">
                                                <label for="nominee1Age" class="form-label">Age</label>
                                                @error('nominees.0.nominee_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
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
                                            <div class="form-floating col-md-4">
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
                                        <div class="col-md-6">
                                            <h6 class="text-center ">Nominee 2</h6>
                                            <div class="row g-3">
                                            <div class="form-floating col-md-6">
                                                <input name="nominees[1][nominee_name]" id="nominee2Name"
                                                    class="form-control @error('nominees.1.nominee_name') is-invalid @enderror"
                                                    value="{{ old('nominees.1.nominee_name') }}" type="text"
                                                    placeholder="Nominee Name">
                                                <label for="nominee2Name" class="form-label">Name</label>
                                                @error('nominees.1.nominee_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-6">
                                                <input name="nominees[1][nominee_naav]" id="marathiNominee2Name"
                                                    class="form-control @error('nominees.1.nominee_naav') is-invalid @enderror"
                                                    type="text" value="{{ old('nominees.1.nominee_naav') }}"
                                                    placeholder="नाव">
                                                <label for="marathiNominee2Name" class="form-label">नाव</label>
                                                @error('nominees.1.nominee_naav')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <input name="nominees[1][nominee_age]" id="nominee2Age"
                                                    class="form-control @error('nominees.1.nominee_age') is-invalid @enderror"
                                                    type="number" placeholder="Age"
                                                    value="{{ old('nominees.1.nominee_age') }}">
                                                <label for="nominee2Age" class="form-label">Age</label>
                                                @error('nominees.1.nominee_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-floating col-md-4">
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
                                            <div class="form-floating col-md-4">
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
                                            <div class="col-md-12">
                                                <label for="nominee2Photo" class="form-label text-white">Photo</label>
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
                                </div>

                                <div class="tab-pane fade p-3" id="rd-tab-pane" role="tabpanel" aria-labelledby="rd-tab"
                                    tabindex="0">
                                    <div class="row g-3">
                                        {{-- <div class="col-md-6 ">
                                            <div class="form-floating">
                                                <input name="open_interest_rd" id="openingInterest"
                                                    class="form-control @error('open_interest_rd') is-invalid @enderror"
                                                    value="{{ old('open_interest_rd') }}" step="0.01" type="number"
                                                    placeholder="Opening Interest" >
                                                <label for="openingInterest" class="form-label">Opening
                                                    Interest</label>
                                                @error('open_interest_rd')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="rd_term_months" id="rdTermMonths"
                                                    class="form-control @error('rd_term_months') is-invalid @enderror"
                                                    value="{{ old('rd_term_months') }}" type="number"
                                                    placeholder="RD Term Months" >
                                                <label for="rdTermMonths" class="form-label">RD Term Months</label>
                                                @error('rd_term_months')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="maturity_amount_rd" id="rdMaturityAmount"
                                                    class="form-control @error('maturity_amount_rd') is-invalid @enderror"
                                                    value="{{ old('maturity_amount_rd') }}" step="0.01" type="number"
                                                    placeholder="RD Maturity Amount" >
                                                <label for="rdMaturityAmount" class="form-label">RD Maturity
                                                    Amount</label>@error('maturity_amount_rd')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-3" id="fd-tab-pane" role="tabpanel" aria-labelledby="fd-tab"
                                    tabindex="0">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="maturity_amount_fd" id="fdMaturityAmount"
                                                    class="form-control @error('maturity_amount_fd') is-invalid @enderror"
                                                    value="{{ old('maturity_amount_fd') }}" step="0.01" type="number"
                                                    placeholder="Maturity Amount" >
                                                <label for="fdMaturityAmount" class="form-label">FD Maturity
                                                    Amount</label>
                                                @error('maturity_amount_fd')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="fd_term_months" id="fdTermMonths"
                                                    class="form-control @error('fd_term_months') is-invalid @enderror"
                                                    value="{{ old('fd_term_months') }}" type="number"
                                                    placeholder="FD Term Months" >
                                                <label for="fdTermMonths" class="form-label">FD Term Months</label>
                                                @error('fd_term_months')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input name="slip_no" id="slipNo"
                                                    class="form-control @error('slip_no') is-invalid @enderror"
                                                    value="{{ old('slip_no') }}" type="text"
                                                    placeholder="FD Term Months" >
                                                <label for="slipNo" class="form-label">Slip No.</label>
                                                @error('slip_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-3" id="saving-tab-pane" role="tabpanel"
                                    aria-labelledby="saving-tab" tabindex="0">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="balance_sv" id="svBalance"
                                                    class="form-control @error('balance_sv') is-invalid @enderror"
                                                    value="{{ old('balance') }}" step="0.01" type="text" placeholder="Balance" >
                                                <label for="svBalance" class="form-label">Balance</label>
                                                @error('balance_sv')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="interest_rate_sv" id="svInterestRate"
                                                    class="form-control @error('interest_rate_sv') is-invalid @enderror"
                                                    value="{{ old('interest_rate_sv') }}" step="0.01" type="text"
                                                    placeholder="Interest Rate" >
                                                <label for="svInterestRate" class="form-label">Interest Rate</label>
                                                @error('interest_rate_sv')
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
