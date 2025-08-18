document.addEventListener("DOMContentLoaded", function () {
    const branchSelect = document.getElementById("branchId");
    const userSelect = document.getElementById("userId");
    const openingBalanceInput = document.getElementById("openingCashBalance");

    function fetchOpeningBalance() {
        let branchId = branchSelect?.value || null;
        let userId = userSelect?.value || null;

        // Build query string safely
        let params = new URLSearchParams();
        if (branchId) params.append("branch_id", branchId);
        if (userId) params.append("user_id", userId);

        fetch(`/opening-balance?${params.toString()}`)
            .then(res => res.json())
            .then(data => {
                openingBalanceInput.value = data.opening_cash_balance ?? 0.00;
            })
            .catch(() => {
                openingBalanceInput.value = 0.00;
            });
    }


    if (branchSelect) branchSelect.addEventListener("change", fetchOpeningBalance);
    if (userSelect) userSelect.addEventListener("change", fetchOpeningBalance);

    // Auto-fetch on page load for non-admin
});
