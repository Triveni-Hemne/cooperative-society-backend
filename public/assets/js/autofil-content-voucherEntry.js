document.addEventListener("DOMContentLoaded", function () {
    const accountSelect = document.getElementById("accountId");
    const depoAccountIdSelect = document.getElementById("memberDepoAccountId");
    const memberLoanAccountIdSelect = document.getElementById(
        "memberLoanAccountId"
    );

    if (typeof accountsData !== "undefined") {
        const accountMap = {};
        accountsData.forEach((account) => {
            accountMap[account.id] = account;
        });
        accountSelect.addEventListener("change", function () {
            const selectedId = this.value;
            const account = accountMap[selectedId];

            if (account) {
                depoAccountIdSelect.selectedIndex = 0; // Reset to first option
                memberLoanAccountIdSelect.selectedIndex = 0; // Reset to first option
            }
        });
    }

    if (typeof loanAccountsData !== "undefined") {
        const loanAccountMap = {};
        loanAccountsData.forEach((account) => {
            loanAccountMap[account.id] = account;
        });
        memberLoanAccountIdSelect.addEventListener("change", function () {
            const selectedId = this.value;
            const account = loanAccountMap[selectedId];

            if (account) {
                depoAccountIdSelect.selectedIndex = 0; // Reset to first option
                accountSelect.selectedIndex = 0; // Reset to first option
            }
        });
    }

    if (typeof depoAccountsData !== "undefined") {
        const depoAccountMap = {};
        depoAccountsData.forEach((account) => {
            depoAccountMap[account.id] = account;
        });
        depoAccountIdSelect.addEventListener("change", function () {
            const selectedId = this.value;
            const account = depoAccountMap[selectedId];

            if (account) {
                memberLoanAccountIdSelect.selectedIndex = 0; // Reset to first option
                accountSelect.selectedIndex = 0; // Reset to first option
            }
        });
    }
});
