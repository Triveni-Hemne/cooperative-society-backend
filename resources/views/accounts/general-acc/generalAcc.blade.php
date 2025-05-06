<div class="modal fade" id="generalAccModal" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="generalAccModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" enctype="multipart/form-data" action="{{ route('accounts.store') }}"
                id="generalAccForm">
                @csrf
                <input type="hidden" id="genAccId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4 border-0">
                    <h1 class="modal-title fs-5 fw-bold" id="generalAccModalLabel">
                        <i class="bi bi-journal-bookmark-fill me-2"></i> Add General Account
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    @if(Session::has('error'))
                    <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                    @endif
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="row mb-3">
                            @isset($ledgers)
                            <div class="col-md-6">
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

                            @isset($members)
                            <div class="col-md-6">
                                @if ($members->isNotEmpty())
                                <div class="form-floating">
                                    <select id="memberId" name="member_id"
                                        class="form-select @error('member_id') is-invalid @enderror"
                                        aria-label="Member">
                                        <option value="" {{ old('member_id') ? '' : 'selected' }}>--- Select Member ---</option>
                                        @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="memberId" class="form-label">Member</label>
                                    @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No member available.</strong><br>
                                    Please add member first.
                                </div>
                                @endif
                            </div>
                            @endisset
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="account_no" id="accountNo"
                                        class="form-control @error('account_no') is-invalid @enderror"
                                        value="{{ old('account_no') }}" type="text" placeholder="Account No." required>
                                    <label for="accountNo" class="form-label">Account No.</label>
                                    @error('account_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="account_name" id="accountName"
                                        class="form-control @error('account_name') is-invalid @enderror" type="text"
                                        value="{{ old('account_name') }}" placeholder="Account Name" required>
                                    <label for="accountName" class="form-label">Account Name</label>
                                    @error('account_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="name" id="Name"
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
                                    <select id="accountType" name="account_type"
                                        class="form-select @error('account_type') is-invalid @enderror"
                                        aria-label="Account Type">
                                        <option value="" {{ old('account_type') ? '' : 'selected' }}>--- Select Account Type ---</option>
                                        <option value="Deposit"
                                            {{ old('account_type') == 'Deposit' ? 'selected' : '' }}>
                                            Deposit
                                        </option>
                                        <option value="Loan" {{ old('account_type') == 'Loan' ? 'selected' : '' }}>Loan
                                        </option>
                                        <option value="Savings"
                                            {{ old('account_type') == 'Savings' ? 'selected' : '' }}>
                                            Savings
                                        </option>
                                        <option value="Investment"
                                            {{ old('account_type') == 'Investment' ? 'selected' : '' }}>Investment
                                        </option>
                                    </select>
                                    <label for="accountType" class="form-label">Account Type</label>
                                    @error('account_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
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
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="start_date" id="startDate"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}" type="date" placeholder="Start Date" required>
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
                                    <input name="open_balance" id="openBalance"
                                        class="form-control @error('open_balance') is-invalid @enderror"
                                        value="{{ old('open_balance') }}" type="number" placeholder="Opening Balance" required>
                                    <label for="openBalance" class="form-label">Opening Balance</label>
                                    @error('open_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="balance" id="balance"
                                        class="form-control @error('balance') is-invalid @enderror"
                                        value="{{ old('balance') }}" type="number" placeholder="Balance" required>
                                    <label for="balance" class="form-label">Balance</label>
                                    @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            @isset($agents)
                            <div class="col-md-6">
                                @if ($agents->isNotEmpty())
                                <div class="form-floating">
                                    <select id="agentId" name="agent_id"
                                        class="form-select @error('agent_id') is-invalid @enderror" aria-label="Agent">
                                        <option value="" {{ old('agent_id') ? '' : 'selected' }}>--- Select Agent ---</option>
                                        @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}"
                                            {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->name }}
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
                            @endisset
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input @error('closing_flag') is-invalid @enderror"
                                        type="checkbox" role="switch" id="closingFlag" name="closing_flag" value="1"
                                        {{ old('closing_flag') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="closingFlag">Closing Flag</label>
                                    @error('closing_flag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-switch ms-3">
                                    <input class="form-check-input @error('add_to_demand') is-invalid @enderror"
                                        type="checkbox" role="switch" id="addToDemand" name="add_to_demand" value="1"
                                        {{ old('add_to_demand') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="addToDemand">Add to Demand</label>
                                    @error('add_to_demand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="installmentType" name="installment_type"
                                        class="form-select @error('installment_type') is-invalid @enderror"
                                        aria-label="Installment Type">
                                        <option value="" {{ old('installment_type') ? '' : 'selected' }}>--- Select Installment Type ---</option>
                                        <option value="Monthly"
                                            {{ old('installment_type') == 'Monthly' ? 'selected' : '' }}>Monthly
                                        </option>
                                        <option value="Quarterly"
                                            {{ old('installment_type') == 'Quarterly' ? 'selected' : '' }}>Quarterly
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
                                    <input name="installment_amount" id="installmentAmount"
                                        class="form-control @error('installment_amount') is-invalid @enderror"
                                        value="{{ old('installment_amount') }}" type="number"
                                        placeholder="Installment Amount">
                                    <label for="installmentAmount" class="form-label">Installment Amount</label>
                                    @error('installment_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="total_installments_paid" id="totalInstallmentsPaid"
                                        class="form-control @error('total_installments_paid') is-invalid @enderror"
                                        value="{{ old('total_installments_paid') }}" type="number"
                                        placeholder="Total Installments Paid" required>
                                    <label for="totalInstallmentsPaid" class="form-label">Total Installments
                                        Paid</label>
                                    @error('total_installments_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="closing_date" id="closingDate"
                                        class="form-control @error('closing_date') is-invalid @enderror"
                                        value="{{ old('closing_date') }}" type="date" placeholder="Closing Date">
                                    <label for="closingDate" class="form-label">Closing Date</label>
                                    @error('closing_date')
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

<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const generalAccModal = document.getElementById('generalAccModal');
    if (generalAccModal) {
        generalAccModal.addEventListener('show.bs.modal', event => {
            const relatedTarget = event.relatedTarget;
            const id = relatedTarget.getAttribute('data-bs-id');
            const ledgerId = relatedTarget.getAttribute('data-bs-ledger_id');
            const memberId = relatedTarget.getAttribute('data-bs-member_id');
            const accountNo = relatedTarget.getAttribute('data-bs-account_no');
            const accountName = relatedTarget.getAttribute('data-bs-account_name');
            const name = relatedTarget.getAttribute('data-bs-name');
            const accountType = relatedTarget.getAttribute('data-bs-account_type');
            const interestRate = relatedTarget.getAttribute('data-bs-interest_rate');
            const startDate = relatedTarget.getAttribute('data-bs-start_date');
            const openBalance = relatedTarget.getAttribute('data-bs-open_balance');
            const balance = relatedTarget.getAttribute('data-bs-balance');
            const agentId = relatedTarget.getAttribute('data-bs-agent_id');
            const closingFlag = relatedTarget.getAttribute('data-bs-closing_flag');
            const addToDemand = relatedTarget.getAttribute('data-bs-add_to_demand');
            const installmentType = relatedTarget.getAttribute('data-bs-installment_type');
            const installmentAmount = relatedTarget.getAttribute('data-bs-installment_amount');
            const totalInstallmentsPaid = relatedTarget.getAttribute('data-bs-total_installments_paid');
            const closingDate = relatedTarget.getAttribute('data-bs-closing_date');
            const modalTitle = generalAccModal.querySelector('#generalAccModalLabel');
            const genAccIdInput = generalAccModal.querySelector('#genAccId');
            const formMethod = generalAccModal.querySelector('#formMethod');
            const ledgerIdInput = generalAccModal.querySelector('#ledgerId');
            const memberIdInput = generalAccModal.querySelector('#memberId');
            const accountNoInput = generalAccModal.querySelector('#accountNo');
            const accountNameInput = generalAccModal.querySelector('#accountName');
            const nameInput = generalAccModal.querySelector('#name');
            const accountTypeInput = generalAccModal.querySelector('#accountType');
            const interestRateInput = generalAccModal.querySelector('#interestRate');
            const startDateInput = generalAccModal.querySelector('#startDate');
            const openBalanceInput = generalAccModal.querySelector('#openBalance');
            const balanceInput = generalAccModal.querySelector('#balance');
            const agentIdInput = generalAccModal.querySelector('#agentId');
            const closingFlagInput = generalAccModal.querySelector('#closingFlag');
            const addToDemandInput = generalAccModal.querySelector('#addToDemand');
            const installmentTypeInput = generalAccModal.querySelector('#installmentType');
            const installmentAmountInput = generalAccModal.querySelector('#installmentAmount');
            const totalInstallmentsPaidInput = generalAccModal.querySelector('#totalInstallmentsPaid');
            const closingDateInput = generalAccModal.querySelector('#closingDate');

            if (id) {
                modalTitle.textContent = 'Edit General Account';
                genAccIdInput.value = id;
                formMethod.value = 'PUT';
                if (ledgerId) ledgerIdInput.value = ledgerId;
                if (memberId) memberIdInput.value = memberId;
                accountNoInput.value = accountNo || '';
                accountNameInput.value = accountName || '';
                nameInput.value = name || '';
                if (accountType) accountTypeInput.value = accountType;
                interestRateInput.value = interestRate || '';
                startDateInput.value = startDate || '';
                openBalanceInput.value = openBalance || '';
                balanceInput.value = balance || '';
                if (agentId) agentIdInput.value = agentId;
                closingFlagInput.checked = closingFlag == 1;
                addToDemandInput.checked = addToDemand == 1;
                if (installmentType) installmentTypeInput.value = installmentType;
                installmentAmountInput.value = installmentAmount || '';
                totalInstallmentsPaidInput.value = totalInstallmentsPaid || '';
                closingDateInput.value = closingDate || '';
            } else {
                modalTitle.textContent = 'Add General Account';
                genAccIdInput.value = '';
                formMethod.value = 'POST';
                document.getElementById('generalAccForm').reset();
            }
        });
    }
});
</script> -->