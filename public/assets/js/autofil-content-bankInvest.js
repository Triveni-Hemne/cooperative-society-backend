document.addEventListener("DOMContentLoaded", function () {
    const accountSelect = document.getElementById("accountId");
    const depoAccountIdSelect = document.getElementById("depoAccountId");
    const nameInput = document.getElementById("Name");
    const interestRateInput = document.getElementById("interestRate");
    const openingDateInput = document.getElementById("openingDate");
    const openingBalanceInput = document.getElementById("openingBalance");
    const currentBalanceInput = document.getElementById("currentBalance");

    if (typeof accountsData !== "undefined") {
        const accountMap = {};
        accountsData.forEach((account) => {
            accountMap[account.id] = account;
        });
        accountSelect.addEventListener("change", function () {
            const selectedId = this.value;
            const account = accountMap[selectedId];

            if (account) {
                nameInput.value = account.name || "";
                interestRateInput.value = account.interest_rate || "";
                openingDateInput.value = account.start_date || "";
                openingBalanceInput.value = account.open_balance || "";
                currentBalanceInput.value = account.balance || "";

                depoAccountIdSelect.selectedIndex = 0; // Reset to first option
            } else {
                nameInput.value = "";
                interestRateInput.value = "";
                openingDateInput.value = "";
                openingBalanceInput.value = "";
                currentBalanceInput.value = "";
            }
        });
    }

    if (typeof depoAccountsData !== "undefined") {
        const accountMap = {};
        depoAccountsData.forEach((account) => {
            accountMap[account.id] = account;
        });
        depoAccountIdSelect.addEventListener("change", function () {
            const selectedId = this.value;
            const account = accountMap[selectedId];

            if (account) {
                nameInput.value = account.name || "";
                interestRateInput.value = account.interest_rate || "";
                openingDateInput.value = account.ac_start_date || "";
                openingBalanceInput.value = account.open_balance || "";
                currentBalanceInput.value = account.balance || "";

                accountSelect.selectedIndex = 0; // Reset to first option
            } else {
                nameInput.value = "";
                interestRateInput.value = "";
                openingDateInput.value = "";
                openingBalanceInput.value = "";
                currentBalanceInput.value = "";
            }
        });
    }
});
