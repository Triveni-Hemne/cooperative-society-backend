<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberDepoAccount;
use App\Models\Branch;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositReportController extends Controller
{
    public function getMaturingDeposits($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $query = DB::table('member_depo_accounts as mda')
            ->leftJoin('recurring_deposits as rd', 'rd.deposit_account_id', '=', 'mda.id')
            ->leftJoin('fixed_deposits as fd', 'fd.deposit_account_id', '=', 'mda.id')
            ->join('members as m', 'mda.member_id', '=', 'm.id') 
            ->leftJoin('users as u', 'm.created_by', '=', 'u.id') 
            ->where('mda.deposit_type', '!=', 'savings')
            ->whereRaw("DATE_ADD(mda.ac_start_date, INTERVAL COALESCE(rd.rd_term_months, fd.fd_term_months, 0) MONTH) <= ?", [$date])
            ->selectRaw("
                mda.acc_no,
                mda.name AS account_holder_name,
                mda.deposit_type,
                mda.ac_start_date AS start_date,
                DATE_ADD(mda.ac_start_date, INTERVAL COALESCE(rd.rd_term_months, fd.fd_term_months, 0) MONTH) AS maturity_date,
                mda.open_balance AS principal_amount,
                mda.interest_rate,
                COALESCE(rd.maturity_amount, fd.maturity_amount, 
                    (mda.open_balance + (mda.open_balance * mda.interest_rate / 100))) AS maturity_amount,
                CASE 
                    WHEN DATE_ADD(mda.ac_start_date, INTERVAL COALESCE(rd.rd_term_months, fd.fd_term_months, 0) MONTH) <= ? 
                    THEN 'Matured' ELSE 'Pending' 
                END AS status
            ", [$date]);

        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhereIn('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }

        $maturingDeposits = $query->orderBy('maturity_date', 'asc')->get();

        return compact('date', 'maturingDeposits', 'branches');
    }

    public function depositMaturityRegister(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        // Fetch matured deposits using the correct function
        $data = $this->getMaturingDeposits($date, $branchId);

        // Calculate total maturity amount
        $totalMaturityAmount = collect($data['maturingDeposits'])->sum('maturity_amount');

        return view('reports.depositReport.deposit-maturity.index', [
            'date' => $date,
            'maturingDeposits' => $data['maturingDeposits'],
            'totalMaturityAmount' => $totalMaturityAmount,
            'branches' => $data['branches']
        ]);
    }

    public function exportMaturityPDF(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getMaturingDeposits($date, $branchId);
        $type = $request->input('type', 'stream'); //default type stream
        // Calculate total maturity amount
        $totalMaturityAmount = collect($data['maturingDeposits'])->sum('maturity_amount');

        $pdf = Pdf::loadView('reports.depositReport.deposit-maturity.maturity_register_pdf',['date' => $date,'maturingDeposits' => $data['maturingDeposits'],'data'=> $data, 'totalMaturityAmount' => $totalMaturityAmount]);
        if($type == 'download'){
            return $pdf->download('deposit_maturity_register_' . $date . '.pdf');
        }
        return $pdf->stream('deposit_maturity_register_' . $date . '.pdf');
    }

    public function getRDChartData($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $rdAccounts = DB::table('recurring_deposits as rd')
            ->join('member_depo_accounts as mda', 'rd.deposit_account_id', '=', 'mda.id')
            ->join('members as m', 'mda.member_id', '=', 'm.id') 
            ->leftJoin('users as u', 'm.created_by', '=', 'u.id') 
            ->where('mda.deposit_type', 'rd')
            ->whereRaw("DATE_ADD(mda.ac_start_date, INTERVAL rd.rd_term_months MONTH) <= ?", [$date])
            ->selectRaw("
                mda.acc_no,
                mda.name AS account_holder_name,
                mda.installment_amount,
                mda.ac_start_date AS start_date,
                rd.rd_term_months AS duration_months,
                mda.interest_rate,
                rd.maturity_amount,
                DATE_ADD(mda.ac_start_date, INTERVAL rd.rd_term_months MONTH) AS maturity_date
            ");

        if ($branchId) {
            $rdAccounts->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhereIn('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }

        $rdAccounts = $rdAccounts->orderBy('maturity_date', 'asc')->get();

        // Calculate interest earned till date
        foreach ($rdAccounts as $account) {
            $monthsElapsed = now()->diffInMonths($account->start_date);
            $interestEarned = ($account->installment_amount * $monthsElapsed * $account->interest_rate) / 100;
            $account->interest_earned = number_format($interestEarned, 2);
            $account->total_balance = number_format($account->maturity_amount + $interestEarned, 2);
        }

        return compact('date', 'rdAccounts', 'branches');
    }

    public function showRDChart(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getRDChartData($date, $branchId);

        return view('reports.depositReport.rd-chart.index', [
            'date' => $date,
            'rdAccounts' => $data['rdAccounts'],
            'branches' => $data['branches']
        ]);
    }

    public function exportRDChartPDF(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getRDChartData($date, $branchId);
        $type = $request->input('type','stream'); //default type stream

        $pdf = Pdf::loadView('reports.depositReport.rd-chart.rd_chart_pdf', [
            'date' => $date,
            'rdAccounts' => $data['rdAccounts']
        ]);
        if($type == 'download'){
            return $pdf->download('rd_chart_' . $date . '.pdf');
        }
        return $pdf->stream('rd_chart_' . $date . '.pdf');
    }

    public function getFDChartData($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $fdAccounts = DB::table('fixed_deposits as fd')
            ->join('member_depo_accounts as mda', 'fd.deposit_account_id', '=', 'mda.id')
            ->join('members as m', 'mda.member_id', '=', 'm.id') 
            ->leftJoin('users as u', 'm.created_by', '=', 'u.id') 
            ->where('mda.deposit_type', 'fd') // Ensure FD accounts are fetched
            ->whereRaw("DATE_ADD(mda.ac_start_date, INTERVAL fd.fd_term_months MONTH) <= ?", [$date])
            ->selectRaw("
                mda.acc_no,
                mda.name AS account_holder_name,
                CAST(mda.open_balance AS DECIMAL(10,2)) AS deposit_amount,
                CAST(mda.interest_rate AS DECIMAL(10,2)) AS interest_rate,
                mda.ac_start_date AS start_date,
                fd.fd_term_months AS duration_months,
                DATE_ADD(mda.ac_start_date, INTERVAL fd.fd_term_months MONTH) AS maturity_date,
                CAST(fd.maturity_amount AS DECIMAL(10,2)) AS maturity_amount
            ");
            if ($branchId) {
                $fdAccounts->where(function ($q) use ($branchId) {
                    $q->where('m.branch_id', $branchId)
                    ->orWhereIn('m.created_by', function ($sub) use ($branchId) {
                        $sub->select('id')->from('users')->where('branch_id', $branchId);
                    });
                });
            }

        $fdAccounts = $fdAccounts->orderBy('maturity_date', 'asc')->get();

        // Ensure numeric calculations are done correctly
        foreach ($fdAccounts as $account) {
            $account->deposit_amount = (float) $account->deposit_amount;
            $account->interest_rate = (float) $account->interest_rate;
            $account->maturity_amount = (float) $account->maturity_amount;

            $monthsElapsed = now()->diffInMonths($account->start_date);
            $interestAccrued = ($account->deposit_amount * $monthsElapsed * $account->interest_rate) / (12 * 100);
            
            // Ensure values are stored as float
            $account->interest_accrued = (float) $interestAccrued;
            $account->total_balance = (float) ($account->deposit_amount + $interestAccrued);
        }

        return compact('date', 'fdAccounts', 'branches');
    }


    public function showFDChart(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getFDChartData($date, $branchId);

        return view('reports.depositReport.fd-chart.index', [
            'date' => $date,
            'fdAccounts' => $data['fdAccounts'],
            'branches' => $data['branches']
        ]);
    }

    public function exportFDChartPDF(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getFDChartData($date, $branchId);
        $type = $request->input('type', 'stream'); //default type stream
        $pdf = Pdf::loadView('reports.depositReport.fd-chart.fd_chart_pdf', [
            'date' => $date,
            'fdAccounts' => $data['fdAccounts']
        ]);
        if($type=='download'){
            return $pdf->download('fd_chart_' . $date . '.pdf');
        }
        return $pdf->stream('fd_chart_' . $date . '.pdf');
    }

    public function getInterestWiseRDData($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        $rdAccounts = DB::table('recurring_deposits as rd')
            ->join('member_depo_accounts as mda', 'rd.deposit_account_id', '=', 'mda.id')
            ->join('members as m', 'mda.member_id', '=', 'm.id') 
            ->leftJoin('users as u', 'm.created_by', '=', 'u.id') 
            ->where('mda.deposit_type', 'rd')
            ->whereRaw("DATE_ADD(mda.ac_start_date, INTERVAL rd.rd_term_months MONTH) <= ?", [$date])
            ->selectRaw("
                mda.acc_no,
                mda.name AS account_holder_name,
                CAST(mda.interest_rate AS DECIMAL(10,2)) AS interest_rate,
                CAST(mda.installment_amount AS DECIMAL(10,2)) AS monthly_deposit,
                CAST(rd.maturity_amount AS DECIMAL(10,2)) AS maturity_amount,
                DATE_ADD(mda.ac_start_date, INTERVAL rd.rd_term_months MONTH) AS maturity_date
            ");

        if ($branchId) {
            $rdAccounts->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhereIn('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }

        $rdAccounts = $rdAccounts->orderBy('maturity_date', 'asc')->get();

        // Group accounts by interest rate
        $interestRateGroups = [];
        foreach ($rdAccounts as $account) {
            $rate = $account->interest_rate;

            if (!isset($interestRateGroups[$rate])) {
                $interestRateGroups[$rate] = [
                    'interest_rate' => $rate,
                    'total_deposits' => 0,
                    'total_interest_earned' => 0,
                    'total_maturity_amount' => 0,
                    'accounts' => []
                ];
            }

            // Estimate interest earned
            $monthsElapsed = now()->diffInMonths($account->maturity_date); // or use actual elapsed months if needed
            $interestEarned = ($account->monthly_deposit * $monthsElapsed * $rate) / 100;

            $interestRateGroups[$rate]['total_deposits'] += $account->monthly_deposit;
            $interestRateGroups[$rate]['total_interest_earned'] += $interestEarned;
            $interestRateGroups[$rate]['total_maturity_amount'] += $account->maturity_amount;
            $interestRateGroups[$rate]['accounts'][] = $account;
        }

        return compact('date', 'interestRateGroups', 'branches');
    }

    public function showInterestWiseRDReport(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getInterestWiseRDData($date,$branchId);

        return view('reports.depositReport.interest-wise.index', [
            'date' => $date,
            'interestRateGroups' => $data['interestRateGroups'],
            'branches' => $data['branches']
        ]);
    }


    public function exportInterestWiseRDPDF(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getInterestWiseRDData($date,$branchId);
        $type = $request->input('type', 'stream'); //default type stream
        $pdf = Pdf::loadView('reports.depositReport.interest-wise.interest_wise_pdf', [
            'date' => $date,
            'interestRateGroups' => $data['interestRateGroups']
        ]);
        if($type == 'download'){
            return $pdf->download('rd_interest_report_' . $date . '.pdf');
        }
        return $pdf->stream('rd_interest_report_' . $date . '.pdf');
    }

    public function getInterestSummaryData($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $rdAccounts = DB::table('recurring_deposits as rd')
            ->join('member_depo_accounts as mda', 'rd.deposit_account_id', '=', 'mda.id')
            ->join('members as m', 'mda.member_id', '=', 'm.id') 
            ->leftJoin('users as u', 'm.created_by', '=', 'u.id') 
            ->where('mda.deposit_type', 'rd')
            ->whereRaw("DATE_ADD(mda.ac_start_date, INTERVAL rd.rd_term_months MONTH) <= ?", [$date])
            ->selectRaw("
                mda.acc_no,
                mda.name AS account_holder_name,
                CAST(mda.interest_rate AS DECIMAL(10,2)) AS interest_rate,
                CAST(mda.installment_amount AS DECIMAL(10,2)) AS monthly_deposit,
                CAST(rd.maturity_amount AS DECIMAL(10,2)) AS maturity_amount
            ")
            ->get();

        // Initialize an array to hold summarized data for each interest rate range
        $interestSummary = [
            'Below 5%' => ['total_deposits' => 0, 'total_interest_earned' => 0, 'total_maturity_amount' => 0, 'accounts_count' => 0],
            '5% - 5.99%' => ['total_deposits' => 0, 'total_interest_earned' => 0, 'total_maturity_amount' => 0, 'accounts_count' => 0],
            '6% - 6.99%' => ['total_deposits' => 0, 'total_interest_earned' => 0, 'total_maturity_amount' => 0, 'accounts_count' => 0],
            '7% and above' => ['total_deposits' => 0, 'total_interest_earned' => 0, 'total_maturity_amount' => 0, 'accounts_count' => 0],
        ];

        // Process each account and categorize them based on interest rate ranges
        foreach ($rdAccounts as $account) {
            $rateRange = $this->getInterestRateRange($account->interest_rate);

            // Calculate interest earned (Assuming yearly calculation for simplicity)
            $monthsElapsed = 12;  // Assuming full year deposits
            $interestEarned = ($account->monthly_deposit * $monthsElapsed * $account->interest_rate) / 100;

            // Add to the appropriate category
            $interestSummary[$rateRange]['total_deposits'] += $account->monthly_deposit;
            $interestSummary[$rateRange]['total_interest_earned'] += $interestEarned;
            $interestSummary[$rateRange]['total_maturity_amount'] += $account->maturity_amount;
            $interestSummary[$rateRange]['accounts_count']++;
        }

        return [
            'date' => $date,
            'summaryData' => $interestSummary,
            'branches' => $branches
        ];
    }

    /**
     * Helper function to categorize interest rate into ranges
     */
    private function getInterestRateRange($rate)
    {
        if ($rate < 5) {
            return 'Below 5%';
        } elseif ($rate >= 5 && $rate < 6) {
            return '5% - 5.99%';
        } elseif ($rate >= 6 && $rate < 7) {
            return '6% - 6.99%';
        } else {
            return '7% and above';
        }
    }

    public function showInterestSummaryReport(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getInterestSummaryData($date,$branchId);

        return view('reports.depositReport.interest-summary.index', [
            'date' => $date,
            'summaryData' => $data['summaryData'],
            'branches' => $data['branches']
        ]);
    }

    public function exportInterestSummaryPDF(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getInterestSummaryData($date,$branchId);
        $type = $request->input('type', 'stream'); //default type stream

        // dd($data['summaryData']);
        $pdf = Pdf::loadView('reports.depositReport.interest-summary.interest_summary_pdf', [
            'date' => $date,
            'summaryData' => $data['summaryData']
        ]);
         if($type == 'download'){
            return $pdf->download('interest_summary_' . $date . '.pdf');
        }
        return $pdf->stream('interest_summary_' . $date . '.pdf');
    }


}