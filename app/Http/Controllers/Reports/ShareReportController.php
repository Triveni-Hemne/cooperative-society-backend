<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ShareReportController extends Controller
{
    public function getShareList($date)
    {
        $shareholders = DB::table('members')
        ->join('member_financials', 'members.id', '=', 'member_financials.member_id')
        ->select(
            'members.id AS member_id',
            'members.name AS member_name',
            'member_financials.id AS share_id',
            'member_financials.type AS share_type',
            'member_financials.number_of_shares',
            'member_financials.share_amount'
        )
        ->where('members.status', 'Active')
        ->get();
        
        // Calculate total shares and total members
        $totalShares = $shareholders->sum(fn($shareholder) => $shareholder->number_of_shares * $shareholder->share_amount);
        $totalMembers = $shareholders->count(); // Count of members

        // Calculate total shares and total members
        return compact('shareholders', 'date', 'totalShares', 'totalMembers');
    }

    public function shareListReport(Request $request)
    {
        $date = $request->input('date', today()->toDateString());

        // Fetch shareholder data
        $data = $this->getShareList($date);
        
        // Pass the data to the view
        return view('reports.shareReport.share-list.index', $data);
    }

    public function exportShareListPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $data = $this->getShareList($date);

        $pdf = Pdf::loadView('reports.shareReport.share-list.share_list_pdf', $data);
        return $pdf->stream('share_list_report_' . $date . '.pdf');
    }

    public function calculateDividend($date)
    {
        // Fetch active shareholders and their shares
        $shareholders = DB::table('members')
            ->join('member_financials', 'members.id', '=', 'member_financials.member_id')
            ->select(
                'members.id AS member_id',
                'members.name AS member_name',
                'member_financials.id AS share_id',
                'member_financials.type AS share_type',
                'member_financials.number_of_shares',
                'member_financials.share_amount'
            )
            ->where('members.status', 'Active')
            ->get();

        // Define total dividend pool (configurable)
        $totalDividendPool = 100000; // Example: ₹1,00,000

        // Compute total shares
        $totalShares = $shareholders->sum('number_of_shares');

        // Avoid division by zero
        $dividendRatePerShare = $totalShares > 0 ? $totalDividendPool / $totalShares : 0;

        // Compute dividend for each shareholder
        $shareholders = $shareholders->map(function ($shareholder) use ($dividendRatePerShare) {
            $shareholder->dividend_amount = $shareholder->number_of_shares * $dividendRatePerShare;
            return $shareholder;
        });

        // Compute total dividend distributed
        $totalDividendDistributed = $shareholders->sum('dividend_amount');

        return compact('shareholders', 'date', 'totalDividendPool', 'dividendRatePerShare', 'totalDividendDistributed');
    }

    public function calculateDividendReport(Request $request)
    {
        $date = $request->input('date', today()->toDateString());

        // Fetch shareholder data
        $data = $this->calculateDividend($date);
        
        // Pass the data to the view
        return view('reports.shareReport.dividend-calculation.index', $data);
    }

    public function calculateDividendPDF(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $data = $this->calculateDividend($date);

        $pdf = Pdf::loadView('reports.shareReport.dividend-calculation.dividend_calculation_pdf', $data);
        return $pdf->stream('dividend_report_' . $date . '.pdf');
    }

    public function getDividendBalanceReport($date)
    {
        // Fetch active shareholders and their shares
        $shareholders = DB::table('members')
            ->join('member_financials', 'members.id', '=', 'member_financials.member_id')
            ->select(
                'members.id AS member_id',
                'members.name AS member_name',
                'member_financials.id AS share_id',
                'member_financials.type AS share_type',
                'member_financials.number_of_shares',
                'member_financials.share_amount',
                'member_financials.dividend_amount AS distributed_dividend'
            )
            ->where('members.status', 'Active')
            ->get();

        // Define total dividend pool (configurable)
        $totalDividendPool = 100000; // Example: ₹1,00,000

        // Compute total shares
        $totalShares = $shareholders->sum('number_of_shares');

        // Avoid division by zero
        $dividendRatePerShare = $totalShares > 0 ? $totalDividendPool / $totalShares : 0;

        // Compute remaining dividend balance for each shareholder
        $shareholders = $shareholders->map(function ($shareholder) use ($dividendRatePerShare) {
            $entitledDividend = $shareholder->number_of_shares * $dividendRatePerShare;
            $remainingDividend = $entitledDividend - ($shareholder->distributed_dividend ?? 0);
            $shareholder->entitled_dividend = $entitledDividend;
            $shareholder->remaining_dividend = max($remainingDividend, 0); // Ensure non-negative balance
            return $shareholder;
        });

        // Compute total distributed and remaining balance
        $totalDistributed = $shareholders->sum('distributed_dividend');
        $totalRemaining = $shareholders->sum('remaining_dividend');

        return compact('shareholders', 'date', 'totalDividendPool', 'dividendRatePerShare', 'totalDistributed', 'totalRemaining');
    }

    public function viewDividendBalanceReport(Request $request)
    {
        $date = $request->input('date', today()->toDateString());

        // Fetch dividend balance data
        $data = $this->getDividendBalanceReport($date);
        
        // Pass the data to the view
        return view('reports.shareReport.dividend-balance.index', $data);
    }

    public function exportDividendBalancePDF(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $data = $this->getDividendBalanceReport($date);

        $pdf = Pdf::loadView('reports.shareReport.dividend-balance.dividend_balance_pdf', $data);
        return $pdf->stream('dividend_balance_report_' . $date . '.pdf');
    }



}