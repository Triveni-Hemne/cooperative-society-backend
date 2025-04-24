document.addEventListener("DOMContentLoaded", () => {
    // Loan Fields
    const principal = document.getElementById("principalAmount");
    const rate = document.getElementById("interestRate");
    const tenure = document.getElementById("tenure");
    const interestField = document.getElementById("interest");
    const emi = document.getElementById("emiAmount");
    const balance = document.getElementById("balance");
    const openBalance = document.getElementById("openBalance");
    const startDate = document.getElementById("startDate");
    const endDate = document.getElementById("endDate");
    const loanAmount = document.getElementById("loanAmount");
    const collateralValue = document.getElementById("collateralValue");

    // Installment Fields
    const installmentType = document.getElementById("installmentType");
    const firstInstallmentDate = document.getElementById(
        "firstInstallmentDate"
    );
    const totalInstallments = document.getElementById("totalInstallments");
    const matureDate = document.getElementById("matureDate");
    const installmentAmount = document.getElementById("installmentAmount");
    const installmentWithInterest = document.getElementById(
        "installmentWithInterest"
    );

    // === Loan Calculations ===
    function calculateLoanDetails() {
        const p = parseFloat(principal?.value) || 0;
        const r = parseFloat(rate?.value) || 0;
        const t = parseFloat(tenure?.value) || 0;

        const interest = (p * r * t) / 1200;
        const totalPayable = p + interest;
        const monthlyEMI = t > 0 ? totalPayable / t : 0;

        if (interestField) interestField.value = interest.toFixed(2);
        if (emi) emi.value = monthlyEMI.toFixed(2);

        updateLoanEndDate();
    }

    function updateLoanEndDate() {
        const start = startDate?.value;
        const t = parseInt(tenure?.value) || 0;

        if (start && t > 0) {
            const date = new Date(start);
            date.setMonth(date.getMonth() + t);
            endDate.value = date.toISOString().split("T")[0];
        }
    }

    function updateBalanceFromOpening() {
        if (balance && openBalance) {
            balance.value = openBalance.value;
        }
    }

    function checkCollateralSufficiency() {
        const loan = parseFloat(loanAmount?.value) || 0;
        const collateral = parseFloat(collateralValue?.value) || 0;

        if (loan > collateral && collateral !== 0) {
            collateralValue.style.borderColor = "red";
            collateralValue.title = "Collateral is less than loan amount!";
        } else {
            collateralValue.style.borderColor = "";
            collateralValue.title = "";
        }
    }

    // === Installment Calculations ===
    function calculateMatureDate() {
        const start = firstInstallmentDate?.value;
        const type = installmentType?.value;
        const total = parseInt(totalInstallments?.value) || 0;

        if (start && type && total > 0) {
            const date = new Date(start);
            const intervals = { Monthly: 1, Quarterly: 3, Yearly: 12 };
            const monthsToAdd = intervals[type] * total;
            date.setMonth(date.getMonth() + monthsToAdd);
            matureDate.value = date.toISOString().split("T")[0];
        }
    }

    function calculateInstallmentWithInterest() {
        const baseAmount = parseFloat(installmentAmount?.value) || 0;
        const interestRate = 5; // You can make this dynamic if needed
        const withInterest = baseAmount + (baseAmount * interestRate) / 100;
        installmentWithInterest.value = withInterest.toFixed(2);
    }

    // === Event Listeners ===
    principal?.addEventListener("input", calculateLoanDetails);
    rate?.addEventListener("input", calculateLoanDetails);
    tenure?.addEventListener("input", calculateLoanDetails);
    startDate?.addEventListener("change", updateLoanEndDate);
    openBalance?.addEventListener("input", updateBalanceFromOpening);
    loanAmount?.addEventListener("input", checkCollateralSufficiency);
    collateralValue?.addEventListener("input", checkCollateralSufficiency);

    installmentType?.addEventListener("change", calculateMatureDate);
    firstInstallmentDate?.addEventListener("change", calculateMatureDate);
    totalInstallments?.addEventListener("input", calculateMatureDate);
    installmentAmount?.addEventListener(
        "input",
        calculateInstallmentWithInterest
    );

    // === Initial Calculations on Page Load ===
    calculateLoanDetails();
    updateBalanceFromOpening();
    checkCollateralSufficiency();
    calculateMatureDate();
    calculateInstallmentWithInterest();
});
