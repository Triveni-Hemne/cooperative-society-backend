document.addEventListener("DOMContentLoaded", function () {
    const loanSelect = document.getElementById("loanId");
    const installmentAmountInput = document.getElementById("installmentAmount");
    const installmentWithInterestInput = document.getElementById(
        "installmentWithInterest"
    );
    const totalInstallmentsInput = document.getElementById("totalInstallments");
    const totalInstallmentsPaidInput = document.getElementById(
        "totalInstallmentsPaid"
    );
    const matureDateInput = document.getElementById("matureDate");
    const firstInstallmentDateInput = document.getElementById(
        "firstInstallmentDate"
    );

    if (
        typeof loanAccountsData !== "undefined" &&
        Array.isArray(loanAccountsData)
    ) {
        const loanMap = {};
        loanAccountsData.forEach((acc) => {
            loanMap[acc.id] = acc;
        });

        function fillLoanDetails(accountId) {
            const acc = loanMap[accountId];
            if (!acc) return;

            if (installmentAmountInput)
                installmentAmountInput.value = acc.installment_amount || "";
            if (installmentWithInterestInput)
                installmentWithInterestInput.value =
                    acc.installment_with_interest || "";
            if (totalInstallmentsInput)
                totalInstallmentsInput.value = acc.total_installments || "";
            if (totalInstallmentsPaidInput)
                totalInstallmentsPaidInput.value =
                    acc.total_installments_paid || "";
            if (matureDateInput) matureDateInput.value = acc.mature_date || "";
            if (firstInstallmentDateInput)
                firstInstallmentDateInput.value =
                    acc.first_installment_date || "";
        }

        // Fill on load if old selected
        const selectedId = loanSelect.value;
        if (selectedId) {
            fillLoanDetails(selectedId);
        }

        // Fill on change
        loanSelect.addEventListener("change", function () {
            fillLoanDetails(this.value);
        });
    }
});
