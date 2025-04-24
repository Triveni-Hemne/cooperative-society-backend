document.addEventListener("DOMContentLoaded", function () {
    // Monthly Balance = Monthly Deposit + Welfare Fund
    const monthlyDeposit = document.getElementById("monthlyDeposit");
    const welfareFund = document.getElementById("welfareFund");
    const monthlyBalance = document.getElementById("monthlyBalance");

    function updateMonthlyBalance() {
        const deposit = parseFloat(monthlyDeposit.value) || 0;
        const welfare = parseFloat(welfareFund.value) || 0;
        monthlyBalance.value = (deposit + welfare).toFixed(2);
    }

    monthlyDeposit.addEventListener("input", updateMonthlyBalance);
    welfareFund.addEventListener("input", updateMonthlyBalance);

    // Current Balance = Share Amount × Number of Shares
    const shareAmount = document.getElementById("shareAmount");
    const numberOfShares = document.getElementById("numberOfShares");
    const currentBalance = document.getElementById("currentBalance");

    function updateCurrentBalance() {
        const amount = parseFloat(shareAmount.value) || 0;
        const shares = parseFloat(numberOfShares.value) || 0;
        currentBalance.value = (amount * shares).toFixed(2);
    }

    shareAmount.addEventListener("input", updateCurrentBalance);
    numberOfShares.addEventListener("input", updateCurrentBalance);

    // Autofill for Account Type
    const typeSelect = document.getElementById("type");
    const dividendAmount = document.getElementById("dividendAmount");

    typeSelect.addEventListener("change", function () {
        const type = this.value;
        if (type === "Dividend") {
            dividendAmount.value = 100; // You can replace this with any logic or default value
        } else {
            dividendAmount.value = "";
        }
    });
});
