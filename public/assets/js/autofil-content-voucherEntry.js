document.addEventListener("DOMContentLoaded", function () {

    const transactionType = document.getElementById("transactionType");
    const receiptNo = document.getElementById("receiptId");
    const paymentNo = document.getElementById("paymentId");

    document.addEventListener("change", function (e) {
        if (e.target.id === "accountId") {
            $('#memberDepoAccountId').val('').trigger('change.select2');
            $('#memberLoanAccountId').val('').trigger('change.select2');
        }
        if (e.target.id === "memberLoanAccountId") {
            $('#memberDepoAccountId').val('').trigger('change.select2');
            $('#accountId').val('').trigger('change.select2');
        }
        if (e.target.id === "memberDepoAccountId") {
            $('#memberLoanAccountId').val('').trigger('change.select2');
            $('#accountId').val('').trigger('change.select2');
        }
    });

    function fetchBalances(accountId) {
        let ledgerId = $('#ledgerId').val(); // or #ledgerSelect if that's your real ID
        let date = $('#date').val();     // or #voucherDate if that's your real ID

        if (!ledgerId || !accountId) return;

        $.get(`/account-balances?ledger_id=${ledgerId}&account_id=${accountId}&date=${date}`, function (data) {
            $('#openingBalance').val(data.opening_balance);
            $('#currentBalance').val(data.current_balance);
        });
    }

    // Delegated event listener works with Select2
    $(document).on("change", "#accountId, #memberDepoAccountId, #memberLoanAccountId", function () {
        let accountId = $(this).val();
        console.log("Selected Account ID:", accountId);

        fetchBalances(accountId);
    });


    function toggleTransactionFields() {
        const type = transactionType.value;

        if (type == 'Receipt') {
            receiptNo.disabled = false;
            paymentNo.disabled = true;
            paymentNo.value = "";
            fetchNextNo("Receipt");  // 👈 auto-generate receipt no
        }
        else if (type == 'Payment') {
            receiptNo.disabled = true;
            paymentNo.disabled = false;
            receiptNo.value = "";
            fetchNextNo("Payment");  // 👈 auto-generate receipt no
        }
        else {
            receiptNo.disabled = true;
            paymentNo.disabled = true;
            paymentNo.value = "";
            receiptNo.value = "";
        }
    }

    // 🔹 Fetch next number from backend
    function fetchNextNo(type) {
        fetch(`/transactions/next-no?type=${type}`)
            .then(response => response.json())
            .then(data => {
                if (type === "Receipt") {
                    receiptNo.value = data.next_no ?? "";
                } else if (type === "Payment") {
                    paymentNo.value = data.next_no ?? "";
                }
            })
            .catch(err => console.error("Error fetching next no:", err));
    }

    toggleTransactionFields();

    // Run when transaction type changes
    transactionType.addEventListener("change", toggleTransactionFields);

});







