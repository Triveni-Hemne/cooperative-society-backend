document.addEventListener("DOMContentLoaded", function () {
    const memberSelect = document.getElementById("memberId");
    const nameInput = document.getElementById("Name");
    const accountSelect = document.getElementById("accountId");
    const accNoInput = document.getElementById("accNo");
    const interestRateInput = document.getElementById("interestRate");
    const acStartDateInput = document.getElementById("acStartDate");
    const openBalanceInput = document.getElementById("openBalance");
    const balanceInput = document.getElementById("balance");

    if (typeof memberData !== "undefined") {
        const memberMap = {};
        memberData.forEach((member) => {
            memberMap[member.id] = member;
        });
        memberSelect.addEventListener("change", function () {
            const selectedId = this.value;
            const member = memberMap[selectedId];

            if (member) {
                nameInput.value = member.name || "";

                // Filter accounts belonging to selected member
                accountSelect.innerHTML = `<option value="">Select Account</option>`; // Reset

                generalAccData.forEach((account) => {
                    if (account.member_id == selectedId) {
                        const option = document.createElement("option");
                        option.value = account.id;
                        option.textContent =
                            account.name + " (" + account.account_type + ")";
                        accountSelect.appendChild(option);
                    }
                });
            } else {
                // Show all accounts again if no member is selected
                nameInput.value = "";
                accountSelect.innerHTML = `<option value="">Select Account</option>`;
                generalAccData.forEach((account) => {
                    const option = document.createElement("option");
                    option.value = account.id;
                    option.textContent =
                        account.name + " (" + account.account_type + ")";
                    accountSelect.appendChild(option);
                });
            }
        });
    }

    if (typeof generalAccData !== "undefined") {
        const generalAccMap = {};
        generalAccData.forEach((account) => {
            generalAccMap[account.id] = account;
        });
        accountSelect.addEventListener("change", function () {
            const selectedId = this.value;
            const account = generalAccMap[selectedId];

            if (account) {
                nameInput.value = account.name || "";
                accNoInput.value = account.account_no || "";
                interestRateInput.value = account.interest_rate || "";
                acStartDateInput.value = account.start_date || "";
                openBalanceInput.value = account.open_balance || "";
                balanceInput.value = account.balance || "";
                nameInput.value = account.name || "";
            } else {
                nameInput.value = "";
                accNoInput.value = "";
                interestRateInput.value = "";
                acStartDateInput.value = "";
                openBalanceInput.value = "";
                balanceInput.value = "";
                nameInput.value = "";
            }
        });
    }
});
