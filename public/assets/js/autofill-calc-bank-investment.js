document.addEventListener("DOMContentLoaded", function () {
    // === Opening Balance ===
    const openingBalance = document.getElementById("openingBalance");
    const currentBalance = document.getElementById("currentBalance");

    function updateCurrentBalance() {
        const current = parseFloat(openingBalance.value) || 0;
        currentBalance.value = current.toFixed(2);
    }

    if (openingBalance && currentBalance) {
        openingBalance.addEventListener("input", updateCurrentBalance);
        updateCurrentBalance();
    }

    // === RD Maturity Calculation ===
    function calculateRDMaturity() {
        const monthly =
            parseFloat(document.getElementById("rdMonthlyDeposit")?.value) || 0;
        const months =
            parseInt(document.getElementById("rdMonths")?.value) || 0;
        const years = parseInt(document.getElementById("rdYears")?.value) || 0;
        const rate =
            parseFloat(document.getElementById("interestRate")?.value) || 0;

        const totalMonths = years * 12 + months;
        document.getElementById("rdTermMonths").value = totalMonths;

        const openingDate = document.getElementById("openingDate")?.value;
        if (openingDate && totalMonths > 0) {
            const date = new Date(openingDate);
            date.setMonth(date.getMonth() + totalMonths);
            const maturityDate = date.toISOString().split("T")[0];
            document.getElementById("rdMaturityDate").value = maturityDate;
        }

        const interest =
            (monthly * totalMonths * (totalMonths + 1) * rate) / (2 * 12 * 100);
        const maturity = monthly * totalMonths + interest;

        document.getElementById("rdInterestReceivable").value =
            interest.toFixed(2);
        document.getElementById("rdMaturityAmount").value = maturity.toFixed(2);
    }

    [
        "rdMonthlyDeposit",
        "rdMonths",
        "rdYears",
        "interestRate",
        "openingDate",
    ].forEach((id) => {
        const el = document.getElementById(id);
        if (el) el.addEventListener("input", calculateRDMaturity);
    });
    calculateRDMaturity();

    // === FD Maturity Calculation ===
    function updateFDMaturityDetails() {
        const amount =
            parseFloat(document.getElementById("fdAmount")?.value) || 0;
        const rate =
            parseFloat(document.getElementById("fdInterest")?.value) || 0;
        const months =
            parseInt(document.getElementById("fdMonths")?.value) || 0;
        const years = parseInt(document.getElementById("fdYears")?.value) || 0;
        const opening = document.getElementById("openingDate")?.value;

        const totalMonths = years * 12 + months;
        const totalYears = totalMonths / 12;

        if (opening) {
            const openDate = new Date(opening);
            openDate.setMonth(openDate.getMonth() + totalMonths);
            document.getElementById("fdMaturityDate").value = openDate
                .toISOString()
                .split("T")[0];
        }

        const interest = (amount * rate * totalYears) / 100;
        console.log(
            "amount: " +
                amount +
                " rate: " +
                rate +
                " totalYears: " +
                totalYears
        );

        document.getElementById("fdInterestReceivable").value =
            interest.toFixed(2);
        document.getElementById("fdMaturityAmount").value = (
            amount + interest
        ).toFixed(2);
    }

    ["fdAmount", "fdInterest", "fdMonths", "fdYears", "openingDate"].forEach(
        (id) => {
            const el = document.getElementById(id);
            if (el) el.addEventListener("input", updateFDMaturityDetails);
        }
    );
    updateFDMaturityDetails();
});
