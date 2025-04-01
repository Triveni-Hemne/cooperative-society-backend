<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\SubdivisionController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SubcasteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
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
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MemberFinancialController;
use App\Http\Controllers\InterestLedgerController;
use App\Http\Controllers\DepositNomineeController;
use App\Http\Controllers\InstallmentTransactionController;
use App\Http\Controllers\RecurringDepositController;
use App\Http\Controllers\LoanGuarantorController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('index');
});


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
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
        Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout'); 
        
        Route::resource('directors', DirectorController::class)->names('directors');
        Route::resource('divisions', DivisionController::class)->names('divisions');
        Route::resource('subdivisions', SubdivisionController::class)->names('sub-divisions');
        Route::resource('centers', CenterController::class)->names('centers');
        Route::resource('designations', DesignationController::class)->names('designations');
        Route::Resource('subcastes', SubcasteController::class)->names('subcastes');
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
        Route::resource('transfer-entry', TransferEntryController::class)->names('transfer-entry');
        Route::resource('branch-ledger', BranchLedgerController::class)->names('branch-ledger');
        Route::resource('day-end', DayEndController::class)->names('day-end');
        // Route::resource('member-nominees', MemberNomineeController::class);
        Route::resource('member-contact-details', MemberContactDetailController::class);
        Route::resource('member-bank-details', MemberBankDetailController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('users', UserController::class);
        Route::resource('agents', AgentController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('member-financials', MemberFinancialController::class);
        Route::resource('installment-transactions', InstallmentTransactionController::class)->names('installment-transactions');
        Route::resource('recurring-deposits', RecurringDepositController::class);
        Route::resource('loan-guarantors', LoanGuarantorController::class);
        Route::get('/interest-calculator', function () {
            return view('interest.interest-calculator');
        })->name('interest.calculator');

    });
// });


/*
* Report Controllers*
*/
use App\Http\Controllers\Reports\DailyReportController;


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

use App\Http\Controllers\Reports\LoanController;

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


use App\Http\Controllers\Reports\DepositReportController;

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