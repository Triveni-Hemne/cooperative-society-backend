<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberLoanAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
    //
   public function getOverdueLoans($date)
    {
        $overdueLoans = DB::table('member_loan_accounts')
            ->where('status', 'Active') // Consider only active loans
            ->whereRaw('DATEDIFF(?, end_date) > 0', [$date]) // Loan is overdue
            ->selectRaw("
                acc_no,
                name AS borrower_name,
                ac_start_date AS loan_sanction_date,
                loan_amount,
                emi_amount,
                end_date AS due_date,
                balance,
                DATEDIFF(?, end_date) AS days_overdue,
                (emi_amount * DATEDIFF(?, end_date) / 30) AS overdue_amount,
                ((emi_amount * DATEDIFF(?, end_date) / 30) * penal_interest / 100) AS penalty_amount
            ", [$date, $date, $date])
            ->orderBy('days_overdue', 'desc')
            ->get();

        return compact('date', 'overdueLoans');
    }

    public function overdueRegister(Request $request)
    {
        $date = $request->input('date', today()->toDateString());

        // Fetch overdue loans based on due date and status
        $overdueLoans = MemberLoanAccount::where('end_date', '<', $date)
                                        ->where('status', 'Active') // Adjust based on how overdue loans are marked
                                        ->get();

        // Calculate total overdue amount
        $totalOverdueAmount = $overdueLoans->sum('balance'); // or any relevant field like 'loan_amount'
        // Calculate total penalty (assuming `penal_interest` is the penalty field)
        $totalPenalty = $overdueLoans->sum('penal_interest');

       return view('reports.loanReport.overdue-register.index', compact('date', 'overdueLoans', 'totalOverdueAmount', 'totalPenalty'));
    }

    public function exportOverduePDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $data = $this->getOverdueLoans($date);
        $type = $request->input('type', 'stream');
        $pdf = Pdf::loadView('reports.loanReport.overdue-register.overdue_register_pdf', $data);
        if($type == 'download'){
            return $pdf->download('overdue_report_' . $date . '.pdf');
        }
        return $pdf->stream('overdue_report_' . $date . '.pdf');
    }

    public function getNPAList($date)
    {
        return DB::table('member_loan_accounts')
            ->where('status', 'Active') // Ensure status is a string
            ->whereRaw('DATEDIFF(?, end_date) > 90', [$date]) // Only overdue loans
            ->selectRaw("
                acc_no,
                name AS borrower_name,
                loan_amount,
                end_date AS first_default_date,
                balance AS outstanding_balance,
                DATEDIFF(?, end_date) AS days_overdue,
                CASE 
                    WHEN DATEDIFF(?, end_date) BETWEEN 91 AND 364 THEN 'Substandard'
                    WHEN DATEDIFF(?, end_date) BETWEEN 365 AND 1094 THEN 'Doubtful'
                    WHEN DATEDIFF(?, end_date) >= 1095 THEN 'Loss'
                END AS npa_classification
            ", [$date, $date, $date, $date])
            ->orderBy('days_overdue', 'desc')
            ->get();
    }

    public function npaList(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $overdueLoans = $this->getNPAList($date);

        return view('reports.loanReport.npa-list.index', compact('date', 'overdueLoans'));
    }


    public function exportNPAPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $overdueLoans = $this->getNPAList($date);
        $type = $request->input('type', 'stream');
        // dd($type);
        $data = [
            'date' => $date,
            'overdueLoans' => $overdueLoans
        ];

        $pdf = Pdf::loadView('reports.loanReport.npa-list.npa_list_pdf', $data);
        if($type == 'download'){
            return $pdf->download('npa_list_' . $date . '.pdf');
        }
        return $pdf->stream('npa_list_' . $date . '.pdf');
    }

    public function getFinalNPAChartData($date)
    {
        // Fetch total loans issued
        $totalLoans = DB::table('member_loan_accounts')
            ->where('status', 'Active')
            ->count();

        // Fetch total NPA loans
        $totalNPALoans = DB::table('member_loan_accounts')
            ->where('status', 'Active')
            ->whereRaw('DATEDIFF(?, end_date) > 90', [$date])
            ->count();

        // Fetch total outstanding loan amount
        $totalOutstanding = DB::table('member_loan_accounts')
            ->where('status', 'Active')
            ->sum('balance');

        // Fetch total overdue loan amount
        $totalOverdue = DB::table('member_loan_accounts')
            ->where('status', 'Active')
            ->whereRaw('DATEDIFF(?, end_date) > 0', [$date])
            ->sum('balance');    

        // Calculate NPA percentage
        $npaPercentage = ($totalLoans > 0) ? ($totalNPALoans / $totalLoans) * 100 : 0;

        // Fetch NPA classification counts
        $npaCounts = DB::table('member_loan_accounts')
            ->where('status', 'Active')
            ->whereRaw('DATEDIFF(?, end_date) > 90', [$date])
            ->selectRaw("
                SUM(CASE WHEN DATEDIFF(?, end_date) BETWEEN 91 AND 364 THEN 1 ELSE 0 END) AS substandard,
                SUM(CASE WHEN DATEDIFF(?, end_date) BETWEEN 365 AND 1094 THEN 1 ELSE 0 END) AS doubtful,
                SUM(CASE WHEN DATEDIFF(?, end_date) >= 1095 THEN 1 ELSE 0 END) AS loss
            ", [$date, $date, $date])
            ->first();
        // dd($npaCounts);


        return [
            'date' => $date,
            'totalLoans' => $totalLoans,
            'totalNPALoans' => $totalNPALoans,
            'totalOutstanding' => $totalOutstanding,
            'totalOverdue' => $totalOverdue,
            'npaPercentage' => number_format($npaPercentage, 2),
            'npaCounts' => [
                'substandard' => $npaCounts->substandard ?? 0,
                'doubtful' => $npaCounts->doubtful ?? 0,
                'loss' => $npaCounts->loss ?? 0,
            ],
        ];
    }

    public function finalNPAChart(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        // $date = ;
        $npaData = $this->getFinalNPAChartData($date);
        
        return view('reports.loanReport.final-npa-chart.index', compact('npaData'));
    }

    public function exportFinalNPAChartPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $npaData = $this->getFinalNPAChartData($date);
        $type = $request->input('type', 'stream');
        $pdf = Pdf::loadView('reports.loanReport.final-npa-chart.final_npa_chart_pdf', compact('npaData'));
        if($type == 'download'){
            return $pdf->download('final_npa_chart_' . $date . '.pdf');
        }
        return $pdf->stream('final_npa_chart_' . $date . '.pdf');
    }

    public function getDebitLoanReportData($fromDate, $toDate)
    {
        return DB::table('member_loan_accounts')
            ->select(
                'acc_no as loan_account_no',
                'name as borrower_name',
                'start_date as disbursement_date', // Loan disbursed date
                'loan_amount as loan_amount_disbursed', // Amount disbursed
                'interest_rate',
                'tenure'
            )
            ->whereBetween('start_date', [$fromDate, $toDate]) // Filter by disbursement period
            ->orderBy('start_date', 'desc')
            ->get();
    }

    public function debitLoanReport(Request $request)
    {
        // Get date range from request or default to current month
        $fromDate = $request->input('from_date', today()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', today()->endOfMonth()->toDateString());

        $debitLoans = $this->getDebitLoanReportData($fromDate, $toDate);
        // return compact('fromDate', 'toDate', 'debitLoans');
        return view('reports.loanReport.debit-loan.index', compact('fromDate', 'toDate', 'debitLoans'));
    }

    public function exportDebitLoanReportPDF(Request $request)
    {
        $fromDate = $request->input('from_date', today()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', today()->endOfMonth()->toDateString());
        $type = $request->input('type', 'stream');
        $debitLoans = $this->getDebitLoanReportData($fromDate, $toDate);

        $data = [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'debitLoans' => $debitLoans
        ];

        $pdf = Pdf::loadView('reports.loanReport.debit-loan.debit_loan_pdf', $data);
        if($type == 'download'){
            return $pdf->download('debit_loan_report_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
        return $pdf->stream('debit_loan_report_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

    public function getGuarantorRegisterData()
    {
        $guarantors = DB::table('member_loan_accounts')
            ->join('members as borrowers', 'member_loan_accounts.member_id', '=', 'borrowers.id')
            ->join('loan_guarantors', 'member_loan_accounts.id', '=', 'loan_guarantors.loan_id')
            ->join('members as guarantors', 'loan_guarantors.member_id', '=', 'guarantors.id')
            ->select(
                'member_loan_accounts.acc_no as loan_account_no',
                'borrowers.name as borrower_name',
                'guarantors.name as guarantor_name',
                // 'guarantors.phone as guarantor_contact',
                // 'loan_guarantors.relationship as guarantor_relationship',
                // 'loan_guarantors.income as guarantor_income'
            )
            ->get();

        return compact('guarantors');
    }

    public function guarantorRegister()
    {
        $data = $this->getGuarantorRegisterData();
        return view('reports.loanReport.gaurantor-register.index', $data);
    }

    public function exportGuarantorRegisterPDF(Request $request)
    {
        $data = $this->getGuarantorRegisterData();
        $type = $request->input('type', 'stream');

        $pdf = Pdf::loadView('reports.loanReport.gaurantor-register.guarantor_register_pdf', $data);
        if($type == 'download'){
            return $pdf->download('guarantor_register.pdf');
        }
        return $pdf->stream('guarantor_register.pdf');
    }

    public function getLoanAccountStatement($loanAccNo)
    {
        // Fetch loan details
        $accounts = MemberLoanAccount::all();
        $loan = DB::table('member_loan_accounts')
            ->where('acc_no', $loanAccNo)
            ->first();

        if (!$loan) {
            return []; // Handle case where loan account doesn't exist
        }

        // Fetch transaction history (Assuming transactions are stored in `general_ledgers`)
        $transactions = DB::table('general_ledgers')
            ->where('id', $loan->ledger_id)
            ->orderBy('created_at', 'asc')
            ->get();
        // Calculate total payments made
        $totalPaid = $transactions->where('transaction_type', 'Payment')->sum('amount');

        // Calculate outstanding balance
        $outstandingBalance = $loan->loan_amount - $totalPaid;

        // Calculate interest accrued (assuming interest is applied monthly)
        $interestAccrued = ($loan->loan_amount * $loan->interest_rate / 100) * ($loan->tenure / 12);

        return compact('loan', 'transactions', 'totalPaid', 'outstandingBalance', 'interestAccrued');
    }

    public function loanAccountStatement(Request $request)
    {
        $loanAccNo = $request->input('loan_acc_no');
        
        $data = $this->getLoanAccountStatement($loanAccNo);
        
        // if (!$data) {
        //     return back()->with('error', 'Loan account not found.');
        // }
        // return "account Statement";

        return view('reports.loanReport.account-statement.index', $data);
    }

    public function exportLoanAccountStatementPDF(Request $request)
    {
        $loanAccNo = $request->input('loan_acc_no');
        
        $data = $this->getLoanAccountStatement($loanAccNo);

        if (!$data) {
            return back()->with('error', 'Loan account not found.');
        }

        $pdf = Pdf::loadView('reports.loanReport.account-statement.loan_account_statement_pdf', $data);
        return $pdf->stream('loan_account_statement_' . $loanAccNo . '.pdf');
    }



}