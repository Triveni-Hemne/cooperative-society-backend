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
use App\Http\Controllers\MemberNomineeController;
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
        Route::resource('member-nominees', MemberNomineeController::class);
        Route::resource('member-contact-details', MemberContactDetailController::class);
        Route::resource('member-bank-details', MemberBankDetailController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('users', UserController::class);
        Route::resource('agents', AgentController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('member-financials', MemberFinancialController::class);
        Route::resource('installment-transactions', InstallmentTransactionController::class);
        Route::resource('recurring-deposits', RecurringDepositController::class);
        Route::resource('loan-guarantors', LoanGuarantorController::class);


    });
// });