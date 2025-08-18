<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\SubdivisionController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\AgentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\GeneralLedgerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDepoAccountController;
use App\Http\Controllers\MemberLoanAccountController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BankInvestmentController;
use App\Http\Controllers\StandingInstructionController;
use App\Http\Controllers\DayBeginController;
use App\Http\Controllers\VoucherEntryController;
use App\Http\Controllers\TransferEntryController;
use App\Http\Controllers\BranchLedgerController;
use App\Http\Controllers\DayEndController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberContactDetailController;
use App\Http\Controllers\MemberBankDetailController;
use App\Http\Controllers\EmployeeController;
// use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MemberFinancialController;
use App\Http\Controllers\InterestLedgerController;
use App\Http\Controllers\DepositNomineeController;
use App\Http\Controllers\InstallmentTransactionController;
use App\Http\Controllers\LoanInstallmentController;
use App\Http\Controllers\RecurringDepositController;
use App\Http\Controllers\LoanGuarantorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonalDemandPostingController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Route::group(['prefix' => 'admin'], function () {
    // Guest Middleware
    Route::group(['middleware' => 'guest:admin'], function () {
        Route::get('/login', [UserLoginController::class, 'index'])->name('user.login');
        Route::post('/authenticate', [UserLoginController::class, 'authenticate'])->name('user.authenticate');
    });
    // Authenticated Middleware
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('user.dashboard');
        Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout'); 
        
        Route::resource('directors', DirectorController::class)->names('directors');
        Route::resource('divisions', DivisionController::class)->names('divisions');
        Route::resource('subdivisions', SubdivisionController::class)->names('sub-divisions');
        Route::resource('designations', DesignationController::class)->names('designations');
        Route::Resource('categories', CategoryController::class)->names('categories');
        // Route::resource('schedule-ledgers', ScheduleLedgerController::class);
        Route::resource('general-ledgers', GeneralLedgerController::class)->names('general-ledgers');
        Route::Resource('members', MemberController::class)->names('members');
        Route::resource('member-depo-accounts', MemberDepoAccountController::class)->names('member-depo-accounts');
        Route::resource('member-loan-accounts', MemberLoanAccountController::class)->names('member-loan-accounts');
        Route::resource('accounts', AccountController::class)->names('accounts');
        Route::resource('bank-investments', BankInvestmentController::class)->names('bank-investments');
        Route::resource('standing-instructions', StandingInstructionController::class)->names('standing-instructions');
        Route::resource('day-begins', DayBeginController::class)->names('day-begins');
        Route::resource('voucher-entry', VoucherEntryController::class)->names('voucher-entry');
        Route::get('/get-accounts-by-ledger/{ledger}', [VoucherEntryController::class, 'getAccountsByLedger']);
        Route::get('/get-account-details/{id}/{name}', [VoucherEntryController::class, 'getAccountsDetails']);
        Route::resource('transfer-entry', TransferEntryController::class)->names('transfer-entry');
        Route::resource('branch-ledger', BranchLedgerController::class)->names('branch-ledger');
        Route::resource('day-end', DayEndController::class)->names('day-end');
        // Route::resource('member-nominees', MemberNomineeController::class);
        Route::resource('member-contact-details', MemberContactDetailController::class);
        Route::resource('member-bank-details', MemberBankDetailController::class);
        Route::resource('employees', EmployeeController::class)->names('employees');
        // Route::resource('departments', DepartmentController::class);
        // Route::resource('agents', AgentController::class);
        Route::resource('branches', BranchController::class)->names('branches');
        Route::resource('member-financials', MemberFinancialController::class);
        Route::resource('installment-transactions', InstallmentTransactionController::class)->names('installment-transactions');
        Route::resource('loan-installments', LoanInstallmentController::class)->names('loan-installments');
        Route::resource('recurring-deposits', RecurringDepositController::class);
        Route::resource('loan-guarantors', LoanGuarantorController::class);
        Route::get('/interest-calculator', function () {
            return view('interest.interest-calculator');
        })->name('interest.calculator');
        Route::resource('users', UserController::class)->names('users');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::resource('personal-all-demand-posting', PersonalDemandPostingController::class)->names('demand-posting');
        Route::get('/opening-balance', [DayBeginController::class, 'getOpeningBalance']);
    });

    
    /*
    * Report Controllers & Routes*
    */
    use App\Http\Controllers\Reports\DailyReportController;
    use App\Http\Controllers\Reports\LoanController;
    use App\Http\Controllers\Reports\DepositReportController;
    use App\Http\Controllers\Reports\ShareReportController;
    use App\Http\Controllers\Reports\MISReportController;
    use App\Http\Controllers\Reports\GeneralReportController;
    use App\Http\Controllers\Reports\PrintingReportController;
    use App\Http\Controllers\Reports\AuditReportController;
    Route::group(['middleware' => 'auth:admin'], function () {

    Route::prefix('daily-reports')->group(function () {
        Route::controller(DailyReportController::class)->group(function () {
            Route::get('cash-book', 'cashBook')->name('cash-book.index');
            Route::get('cash-book/export/pdf', 'exportPDF')->name('cash-book.pdf');
            // Route::get('cash-book/export/excel', 'exportExcel')->name('cash-book.excel');

            Route::get('day-book', 'dayBook')->name('day-book.index');
            Route::get('day-book/export/pdf', 'exportDayBookPDF')->name('day-book.pdf');
            // Route::get('day-book/export/excel', 'exportDayBookExcel')->name('day-book.excel');

            Route::get('sub-day-book', 'subDayBook')->name('sub-day-book.index');
            Route::get('sub-day-book/export/pdf', 'exportSubDayBookPDF')->name('sub-day-book.pdf');
            // Route::get('sub-day-book/export/excel', 'exportSubDayBookExcel')->name('sub-day-book.excel');

            Route::get('gl-statement-checking', 'glStatementChecking')->name('gl-statement-checking.index');
            Route::get('gl-statement-checking/export/pdf', 'exportGLStatementPDF')->name('gl-statement-checking.pdf');
            // Route::get('gl-statement-checking/export/excel', 'exportGLStatementExcel')->name('gl-statement-checking.excel');

            Route::get('cut-book', 'cutBookReport')->name('cut-book.index');
            Route::get('cut-book/export/pdf', 'exportCutBookPDF')->name('cut-book.pdf');

            Route::get('demand-day-book', 'demandDayBook')->name('demand-day-book.index');
            Route::get('demand-day-book/export/pdf', 'exportDemandDayBookPDF')->name('demand-day-book.pdf');
        });
    });


    Route::prefix('loan-reports')->group(function () {
        Route::controller(LoanController::class)->group(function () {
            Route::get('overdue-register', 'overdueRegister')->name('overdue-register.index');
            Route::get('overdue-register/export/pdf', 'exportOverduePDF')->name('overdue-register.pdf');

            Route::get('npa-list', 'npaList')->name('npa-list.index');
            Route::get('npa-list/export/pdf', 'exportNPAPDF')->name('npa-list.pdf');

            Route::get('final-npa-chart', 'finalNPAChart')->name('final-npa-chart.index');
            Route::get('final-npa-chart/export/pdf', 'exportFinalNPAChartPDF')->name('final-npa-chart.pdf');

            Route::get('debit-laon', 'debitLoanReport')->name('debit-laon.index');
            Route::get('debit-laon/export/pdf', 'exportDebitLoanReportPDF')->name('debit-laon.pdf');

            Route::get('guarantor-register', 'guarantorRegister')->name('guarantor-register.index');
            Route::get('guarantor-register/export/pdf', 'exportGuarantorRegisterPDF')->name('guarantor-register.pdf');

            Route::get('loan-statements', 'loanAccountStatement')->name('loan-statements.index');
            Route::get('loan-statements/export/pdf', 'exportLoanAccountStatementPDF')->name('loan-statements.pdf');
        });
    });



    Route::prefix('deposit-reports')->group(function () {
        Route::controller(DepositReportController::class)->group(function () {
            Route::get('deposit-maturity', 'depositMaturityRegister')->name('deposit-maturity.index');
            Route::get('deposit-maturity/export/pdf', 'exportMaturityPDF')->name('deposit-maturity.pdf');

            Route::get('rd-chart', 'showRDChart')->name('rd-chart.index');
            Route::get('rd-chart/export/pdf', 'exportRDChartPDF')->name('rd-chart.pdf');

            Route::get('fd-chart', 'showFDChart')->name('fd-chart.index');
            Route::get('fd-chart/export/pdf', 'exportFDChartPDF')->name('fd-chart.pdf');

            Route::get('interestwise-reccuring', 'showInterestWiseRDReport')->name('interestwise-reccuring.index');
            Route::get('interestwise-reccuring/export/pdf', 'exportInterestWiseRDPDF')->name('interestwise-reccuring.pdf');

            Route::get('interest-summary', 'showInterestSummaryReport')->name('interest-summary.index');
            Route::get('interest-summary/export/pdf', 'exportInterestSummaryPDF')->name('interest-summary.pdf');
        });
    });


    Route::prefix('share-reports')->group(function () {
        Route::controller(ShareReportController::class)->group(function () {
            Route::get('share-list', 'shareListReport')->name('share-list.index');
            Route::get('share-list/export/pdf', 'exportShareListPDF')->name('share-list.pdf');

            Route::get('dividend-calculation', 'calculateDividendReport')->name('dividend-calculation.index');
            Route::get('dividend-calculation/export/pdf', 'calculateDividendPDF')->name('dividend-calculation.pdf');

            Route::get('dividend-balance', 'viewDividendBalanceReport')->name('dividend-balance.index');
            Route::get('dividend-balance/export/pdf', 'exportDividendBalancePDF')->name('dividend-balance.pdf');
        });
    });


    Route::prefix('MIS-reports')->group(function () {
        Route::controller(MISReportController::class)->group(function () {
            Route::get('trial-balance', 'viewTrialBalance')->name('mis-trial-balance.index');
            Route::get('trial-balance/export/pdf', 'exportTrialBalancePDF')->name('mis-trial-balance.pdf');

            Route::get('receipt-payment', 'viewReceiptPaymentReport')->name('receipt-payment.index');
            Route::get('receipt-payment/export/pdf', 'exportReceiptPaymentPDF')->name('receipt-payment.pdf');

            Route::get('mis-profit-loss', 'viewProfitLoss')->name('mis-profit-loss.index');
            Route::get('mis-profit-loss/export/pdf', 'exportProfitLossPDF')->name('mis-profit-loss.pdf');

            Route::get('balance-sheet', 'viewBalanceSheet')->name('mis-balance-sheet.index');
            Route::get('balance-sheet/export/pdf', 'exportBalanceSheetPDF')->name('mis-balance-sheet.pdf');

            Route::get('cd-ratio', 'viewCDRatio')->name('cd-ratio.index');
            Route::get('cd-ratio/export/pdf', 'exportCDRatioPDF')->name('cd-ratio.pdf');

            Route::get('mis-report', 'viewMISReport')->name('mis-report.index');
            Route::get('mis-report/export/pdf', 'exportMISReportPDF')->name('mis-report.pdf');

            Route::get('gl-statements', 'viewGeneralLedgerStatementReport')->name('gl-statements.index');
            Route::get('gl-statements/export/pdf', 'exportGeneralLedgerStatementReportPDF')->name('gl-statements.pdf');
        });
    });


    Route::prefix('general-reports')->group(function () {
        Route::controller(GeneralReportController::class)->group(function () {
            Route::get('account-statement', 'accountStatement')->name('account-statement.index');
            Route::get('account-statement/export/pdf', 'exportAccountStatementPDF')->name('account-statement.pdf');

            Route::get('gl-statement', 'generalLedgerStatement')->name('gl-statement.index');
            Route::get('gl-statement/export/pdf', 'exportGeneralLedgerPDF')->name('gl-statement.pdf');

            Route::get('member-statement', 'memberStatement')->name('member-statement.index');
            Route::get('member-statement/export/pdf', 'exportMemberStatementPDF')->name('member-statement.pdf');

            Route::get('loan-garantor', 'loanGuarantorReport')->name('loan-garantor.index');
            Route::get('loan-garantor/export/pdf', 'exportLoanGuarantorPDF')->name('loan-garantor.pdf');

            Route::get('demand-list', 'demandList')->name('demand-list.index');
            Route::get('demand-list/export/pdf', 'exportDemandListPDF')->name('demand-list.pdf');
        });
    });


    Route::prefix('printing-reports')->group(function () {
        Route::controller(PrintingReportController::class)->group(function () {
            Route::get('duplicate-printing', 'viewDuplicate')->name('duplicate-printing.index');
            Route::get('duplicate-printing/export/pdf/{id}', 'exportDuplicatePDF')->name('duplicate-printing.pdf.single');
            Route::get('duplicate-printing/export/pdf', 'exportDuplicateListPDF')->name('duplicate-printing.pdf.all');
            
            // Passbook Printing Routes
            Route::get('passbook-printing', 'viewPassbookForm')->name('passbook.printing.form');
            Route::get('passbook-printing/result', 'generatePassbook')->name('passbook.printing.result');
            Route::get('passbook-printing/pdf', 'exportPassbookPDF')->name('passbook.printing.pdf');
        });
    });


    Route::prefix('audit-reports')->group(function () {
        Route::controller(AuditReportController::class)->group(function () {
            Route::get('trial-balance', 'generateTrialBalance')->name('trial-balance.index');
            Route::get('trial-balance/export/pdf', 'exportTrialBalancePDF')->name('trial-balance.pdf'); 
            
            Route::get('balance-sheet', 'generateBalanceSheet')->name('balance-sheet.index');
            Route::get('balance-sheet/export/pdf', 'exportBalanceSheetPDF')->name('balance-sheet.pdf'); 
            
            Route::get('audit-profit-loss', 'generateProfitLoss')->name('profit-loss.index');
            Route::get('audit-profit-loss/export/pdf', 'exportProfitLossPDF')->name('profit-loss.pdf'); 
        });

    });
    });

// });