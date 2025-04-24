document.addEventListener("DOMContentLoaded", () => {
    // ==== Fixed Deposit (FD) Elements ====
    const fdPrincipal = document.getElementById("fdPrincipal");
    const fdTermMonths = document.getElementById("fdTermMonths");
    const fdInterestRate = document.getElementById("fdInterestRate");
    const fdMaturityAmount = document.getElementById("fdMaturityAmount");

    // ==== Recurring Deposit (RD) Elements ====
    const rdInstallmentAmount = document.getElementById("installmentAmount");
    const rdTermMonths = document.getElementById("rdTermMonths");
    const rdInterestRate = document.getElementById("interestRate");
    const rdMaturityAmount = document.getElementById("rdMaturityAmount");

    const rdTotalInstallments = document.getElementById("totalInstallments");
    const rdTotalPayableAmount = document.getElementById("totalPayableAmount");
    const rdInstallmentsPaid = document.getElementById("installmentsPaid");
    const rdOpenInterest = document.getElementById("openInterest");
    const rdInterestPayable = document.getElementById("interestPayable");

    // ==== FD Maturity Calculation ====
    function calculateFDMaturity() {
        const p = parseFloat(fdPrincipal?.value) || 0;
        const t = parseFloat(fdTermMonths?.value) || 0;
        const r = parseFloat(fdInterestRate?.value) || 0;

        const interest = (p * r * t) / (12 * 100);
        const maturityAmount = p + interest;

        if (fdMaturityAmount) {
            fdMaturityAmount.value = maturityAmount.toFixed(2);
        }
    }

    // ==== RD Maturity Calculation ====
    function calculateRDMaturity() {
        const monthly = parseFloat(rdInstallmentAmount?.value) || 0;
        const months = parseFloat(rdTermMonths?.value) || 0;
        const rate = parseFloat(rdInterestRate?.value) || 0;

        const interest =
            (monthly * months * (months + 1) * rate) / (2 * 12 * 100);
        const maturity = monthly * months + interest;

        if (rdMaturityAmount) {
            rdMaturityAmount.value = maturity.toFixed(2);
        }
    }

    // ==== RD Extra Calculations ====
    function updateTotalPayable() {
        const amount = parseFloat(rdInstallmentAmount?.value) || 0;
        const installments = parseFloat(rdTotalInstallments?.value) || 0;
        const total = amount * installments;

        if (rdTotalPayableAmount) {
            rdTotalPayableAmount.value = total.toFixed(2);
        }

        updateOpenInterest();
        updateInterestPayable();
    }

    function updateOpenInterest() {
        const totalPayable = parseFloat(rdTotalPayableAmount?.value) || 0;
        const paid = parseFloat(rdInstallmentsPaid?.value) || 0;
        const perInstallment = parseFloat(rdInstallmentAmount?.value) || 0;

        const open = totalPayable - paid * perInstallment;

        if (rdOpenInterest) {
            rdOpenInterest.value = open.toFixed(2);
        }
    }

    function updateInterestPayable() {
        const total = parseFloat(rdTotalPayableAmount?.value) || 0;
        const rate = parseFloat(rdInterestRate?.value) || 0;

        const interest = (total * rate) / 100;

        if (rdInterestPayable) {
            rdInterestPayable.value = interest.toFixed(2);
        }
    }

    // ==== Event Bindings ====
    // FD
    fdPrincipal?.addEventListener("input", calculateFDMaturity);
    fdTermMonths?.addEventListener("input", calculateFDMaturity);
    fdInterestRate?.addEventListener("input", calculateFDMaturity);

    // RD
    rdInstallmentAmount?.addEventListener("input", () => {
        calculateRDMaturity();
        updateTotalPayable();
    });

    rdTermMonths?.addEventListener("input", calculateRDMaturity);
    rdInterestRate?.addEventListener("input", () => {
        calculateRDMaturity();
        updateInterestPayable();
    });

    rdTotalInstallments?.addEventListener("input", updateTotalPayable);
    rdTotalPayableAmount?.addEventListener("input", () => {
        updateOpenInterest();
        updateInterestPayable();
    });

    rdInstallmentsPaid?.addEventListener("input", updateOpenInterest);

    // ==== Initial Auto-Calculation on Load ====
    calculateFDMaturity();
    calculateRDMaturity();
    updateTotalPayable();
    updateOpenInterest();
    updateInterestPayable();
});
