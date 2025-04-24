document.addEventListener("DOMContentLoaded", function () {
    const debitTransfer = document.getElementById("debitTransfer");
    const creditTransfer = document.getElementById("creditTransfer");
    const amount = document.getElementById("amount");

    function updateAmount() {
        const debit = parseFloat(debitTransfer.value) || 0;
        const credit = parseFloat(creditTransfer.value) || 0;
        // You can choose to sum them or take the higher one depending on your business logic
        const calculatedAmount = debit || credit;
        amount.value = calculatedAmount.toFixed(2);
    }

    debitTransfer.addEventListener("input", updateAmount);
    creditTransfer.addEventListener("input", updateAmount);
});
