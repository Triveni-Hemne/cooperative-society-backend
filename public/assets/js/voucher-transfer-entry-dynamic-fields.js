

let selectedLedgerGroup = null; // Declare globally
document.getElementById('ledgerId').addEventListener('change', function () {
    const ledgerId = this.value;
    hideAllAccountFields();
    if (!ledgerId) return;
    document.getElementById('loadingSpinner').classList.remove('d-none')
    fetch(`/get-accounts-by-ledger/${ledgerId}`)
        .then(response => response.json())
        .then(data => {

            const ledgerName = data.ledger_name?.toLowerCase(); // assumes backend sends ledger name
            const isMasikVargani = ledgerName === 'masik vargani';

            if (isMasikVargani) {
                // Only show member dropdown
                document.getElementById('selectMember')?.classList.remove('d-none');
                updateSelect('memberId', data.members, data.group);
            }
            else {
                document.getElementById('selectMember')?.classList.add('d-none');
                if (data.general_accounts.length > 0) {
                    updateSelect('accountId', data.general_accounts, data.group);
                    document.getElementById('accountId')?.closest('.accountField')?.classList.remove('d-none');
                }
                else {
                    document.getElementById('accountId')?.closest('.accountField')?.classList.add('d-none');
                }

                if (data.deposit_accounts.length > 0) {
                    updateSelect('memberDepoAccountId', data.deposit_accounts, data.group);
                    document.getElementById('memberDepoAccountId')?.closest('.accountField')?.classList.remove('d-none');
                }
                else {
                    document.getElementById('memberDepoAccountId')?.closest('.accountField')?.classList.add('d-none');
                }

                if (data.loan_accounts.length > 0) {
                    updateSelect('memberLoanAccountId', data.loan_accounts, data.group);
                    document.getElementById('memberLoanAccountId')?.closest('.accountField')?.classList.remove('d-none');
                }
                else {
                    document.getElementById('memberLoanAccountId')?.closest('.accountField')?.classList.add('d-none');
                }
            }

            selectedLedgerGroup = data.group;

            // Step 4: Hide all detail field groups
            hideAllDetailFieldGroups();

        })
        .catch(error => console.error('Error fetching accounts:', error))
        .finally(() => {
            document.getElementById('loadingSpinner').classList.add('d-none');
        });
});

function updateSelect(selectId, items, group) {
    const select = document.getElementById(selectId);
    if (!select) return;
    if (selectId != "selectMember") {
        // Clear existing options
        select.innerHTML = `<option value="" selected>Select</option>`;

        // Add new options                                                                              
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.text = item.name + " [ ID : " + item.id + "]";
            select.appendChild(option);
        });
    }

    // Remove any existing listener by cloning and replacing the element
    const cloned = select.cloneNode(true);
    select.parentNode.replaceChild(cloned, select);

    // Add both handlers:
    cloned.addEventListener('change', function () {
        const selectedAccountID = this.value;
        const selectedAccountName = this.name;
        handleAccountSelection(selectedLedgerGroup); // for showing field group
        fetchAccountDetails(selectedAccountID, selectedAccountName, group); // fetch selected account's details
    });
}

function hideAllDetailFieldGroups() {
    document.getElementById('depositAccountFieldGroup')?.classList.add('d-none');
    document.getElementById('loanAccountFieldGroup')?.classList.add('d-none');
    document.getElementById('generalAccountFieldGroup')?.classList.add('d-none');
    document.getElementById('bankAccountFieldGroup')?.classList.add('d-none');
    document.getElementById('shareAccountFieldGroup')?.classList.add('d-none');
    document.getElementById('fundsAccountFieldGroup')?.classList.add('d-none');
    document.querySelectorAll('.commonFields').forEach(el => {
        el.classList.add('d-none');
    });
}

function hideAllAccountFields() {
    document.querySelectorAll('.accountField').forEach(el => {
        el.classList.add('d-none');
    });
}

function handleAccountSelection(group) {
    hideAllDetailFieldGroups();
    document.querySelectorAll('.commonFields').forEach(el => {
        el.classList.remove('d-none');
    });
    switch (group) {
        case 'Deposit':
            document.getElementById('depositAccountFieldGroup')?.classList.remove('d-none');
            break;
        case 'Loan':
            document.getElementById('loanAccountFieldGroup')?.classList.remove('d-none');
            break;
        case 'General':
            document.getElementById('generalAccountFieldGroup')?.classList.remove('d-none');
            break;
        case 'Bank':
            document.getElementById('bankAccountFieldGroup')?.classList.remove('d-none');
            break;
        case 'Share':
            document.getElementById('shareAccountFieldGroup')?.classList.remove('d-none');
            break;
        case 'Funds':
            document.getElementById('fundsAccountFieldGroup')?.classList.remove('d-none');
            break;
    }
}

async function fetchAccountDetails(accountId, accountName, group) {

    if (!accountId && !accountName && !group) return;
    try {
        const response = await fetch(`/get-account-details/${accountId}/${accountName}`);
        const data = await response.json();
        // Step 1: Hide all detail boxes
        document.querySelectorAll('.account-details').forEach(el => el.classList.add('d-none'));

        const excludedKeys = ['id', 'created_at', 'updated_at', 'ledger_id', 'images', 'member_id', 'account_id', 'acc_no', 'deposit_type', 'name', 'closing_flag', 'add_to_demand', 'agent_id', 'page_no', 'installment_type', 'acc_closing_date', 'open_interest', 'loan_type', 'purpose', 'principal_amount', 'priority', 'is_loss_asset', 'case_flag', 'postage', 'insurance', 'notice_fee', 'insurance_date', 'account_no', 'account_name', 'account_type', 'employee_id', 'branch_id', 'naav', 'dob', 'gender', 'age', 'date_of_joining', 'religion', 'caste', 'category_id', 'm_reg_no', 'pan_no', 'adhar_no', 'status', 'created_by', 'member_branch_id', 'designation_id', 'cpf_no', 'division_id', 'subdivision_id', 'membership_date'];

        // Step 2: Map accountName to the correct field group detail section
        const detailBoxId = mapAccountName(group);
        if (!detailBoxId) return;

        const detailBox = document.getElementById(detailBoxId);
        if (!detailBox) return;
        // Remove all child nodes except <legend>
        [...detailBox.children].forEach(child => {
            if (child.tagName.toLowerCase() !== 'legend') {
                detailBox.removeChild(child);
            }
        });

        // Create labeled input fields
        Object.entries(data).forEach(([key, value]) => {
            if (excludedKeys.includes(key)) return;
            const col = document.createElement('div');
            col.className = 'col-md-2 mb-3';
            const groupDiv = document.createElement('div');
            groupDiv.className = 'form-floating';
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.id = `readOnly-${detailBoxId}-${key}`;
            input.value = value ?? '';
            input.readOnly = true;
            input.disabled = true;

            const label = document.createElement('label');
            label.setAttribute('for', input.id);
            label.textContent = toTitleCase(key);

            col.appendChild(groupDiv);
            groupDiv.appendChild(input);
            groupDiv.appendChild(label);
            detailBox.appendChild(col);
        });

        // Now append extra group-specific fields
        await appendExtraFields(detailBox, detailBoxId, group);

        detailBox.classList.remove('d-none');

    } catch (error) {
        console.error('Error fetching account details:', error);
    } finally {
        document.getElementById('loadingSpinner').classList.add('d-none');
    }
}

// Helper to make keys like "holder_name" => "Holder Name"
function toTitleCase(str) {
    return str.replace(/_/g, ' ')
        .replace(/\w\S*/g, txt => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
}

function appendCustomField(detailBox, detailBoxId, labelText, type, customClass = '', name = '', value = '') {
    const col = document.createElement('div');
    col.className = `col-md-2 mb-3 ${customClass}`;
    const groupDiv = document.createElement('div');
    groupDiv.className = 'form-floating';
    const input = document.createElement('input');
    input.type = `${type}`;
    input.className = 'form-control';
    const finalFieldKey = name || labelText.toLowerCase().replace(/\s+/g, '_');
    input.name = `${name}`;
    input.id = `${name.toLowerCase().replace(/\s+/g, '-')}`;
    console.log(input.id);

    input.value = oldValues?.[finalFieldKey] ?? value ?? '';
    if (validationErrors && validationErrors[name]) {
        input.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = validationErrors[finalFieldKey][0];
        groupDiv.appendChild(errorDiv);
    }
    const label = document.createElement('label');
    label.setAttribute('for', input.id);
    label.textContent = labelText;

    col.appendChild(groupDiv);
    groupDiv.appendChild(input);
    groupDiv.appendChild(label);
    detailBox.appendChild(col);
}


// Step 2: Map accountName to the correct field group detail section
function mapAccountName(group) {
    let detailBoxId;
    switch (group) {
        case 'Deposit':
            detailBoxId = 'depositAccountFieldGroup';
            break;
        case 'Loan':
            detailBoxId = 'loanAccountFieldGroup';
            break;
        case 'General':
            detailBoxId = 'generalAccountFieldGroup';
            break;
        case 'Bank':
            detailBoxId = 'bankAccountFieldGroup';
            break;
        case 'Funds':
            detailBoxId = 'fundsAccountFieldGroup';
            break;
        case 'Share':
            detailBoxId = 'shareAccountFieldGroup';
            break;
        default:
            return; // invalid name
    }
    return detailBoxId;
}

// Now append extra group-specific fields
async function appendExtraFields(detailBox, detailBoxId, group) {
    switch (group) {
        case 'Loan':
            appendCustomField(detailBox, detailBoxId, 'Cheque No.', 'text', '', 'cheque_no', '');
            appendCustomField(detailBox, detailBoxId, 'Amount', 'number', '', 'amount', '');
            appendCustomField(detailBox, detailBoxId, 'Balance', 'number', '', 'balance', '');
            appendCustomField(detailBox, detailBoxId, 'Interest', 'number', '', 'interest', '');
            appendCustomField(detailBox, detailBoxId, 'Penal', 'text', '', 'penal', '');
            appendCustomField(detailBox, detailBoxId, 'Post/Court', 'text', '', 'post_court', '');
            appendCustomField(detailBox, detailBoxId, 'Insurance', 'text', '', 'insurance', '');
            appendCustomField(detailBox, detailBoxId, 'Notice Fee', 'number', '', 'notice_fee', '');
            appendCustomField(detailBox, detailBoxId, 'Other', 'number', '', 'other', '');
            appendCustomField(detailBox, detailBoxId, 'Trans. Charges', 'number', '', 'trans_chargs', '');
            break;

        case 'Deposit':
            appendCustomField(detailBox, detailBoxId, 'Cheque No.', 'text', '', 'cheque_no', '');
            appendCustomField(detailBox, detailBoxId, 'Balance', 'number', '', 'balance', '');
            appendCustomField(detailBox, detailBoxId, 'Int. Payable', 'number', '', 'int_payable', '');
            appendCustomField(detailBox, detailBoxId, 'Interest Paid', 'text', '', 'int_paid', '');
            appendCustomField(detailBox, detailBoxId, 'Penal Interest', 'text', '', 'penal_interest', '');
            appendCustomField(detailBox, detailBoxId, 'Total Amount', 'number', '', 'total_amount', '');
            break;
        case 'General':
        case 'Bank':
        case 'Funds':
        case 'Share':
            appendCustomField(detailBox, detailBoxId, 'Cheque No.', 'text', '', 'cheque_no', '');
            appendCustomField(detailBox, detailBoxId, 'Amount', 'number', '', 'amount', '');
            appendCustomField(detailBox, detailBoxId, 'Balance', 'number', '', 'balance', '');
            break;
        default:
            break;
    }
}




