$('#branchId, #date').on('change', function () {
    let branchId = $('#branchId').val();
    let date = $('#date').val();

    if (branchId && date) {
        $.get(`/dayend/calculate?branch_id=${branchId}&date=${date}`, function (data) {
            // $('#openingCash').val(data.opening_cash);
            $('#totalReceipts').val(data.total_receipts);
            $('#totalPayments').val(data.total_payments);
            $('#ClosingCashBalance').val(data.closing_cash);
            $('#totalDebitRs').val(data.total_receipts_rs);
            $('#totalCreditRs').val(data.total_payments_rs);
        });
    }
});
