<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Member;
use App\Models\Account;
use App\Models\MemberLoanAccount;
use App\Models\MemberDepoAccount;
use Illuminate\Validation\Rule;
use App\Models\GeneralLedger;
use App\Models\Branch;
use App\Models\PersonalDemandPosting;
use App\Models\PersonalDemandPostingEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonalDemandPostingController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = null;
        // Determine branch filter based on role
        if ($user->role === 'Admin') {
            $branchId = $request->branch_id; // admin can filter via dropdown
        } else {
            $branchId = $user->branch_id; // normal user only sees their branch
        }

       $postings = PersonalDemandPosting::with('member.user')
       ->when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->latest()->paginate(5);
        
        $accounts = Account::with('member.user')
       ->when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
       
        $ledgers = GeneralLedger::all();
        // $departments = Department::all();
        $members = Member::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
       
        $branches = $user->role === 'Admin' ? Branch::all() : null;

        return view('transactions.personal-all-demand-posting.list', compact('postings','ledgers','members','branches', 'accounts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            // 'department_id' => 'nullable|integer',
            'member_id'     => 'nullable|integer',
            'month'         => 'nullable|string',
            'from_date'     => 'nullable|date',
            'to_date'       => 'nullable|date|after_or_equal:from_date',
            'year'          => 'nullable|digits:4',
            'posting_date'  => 'nullable|date',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'ledger_id' => 'nullable|integer|exists:general_ledgers,id',
            'account_id'    => 'required|string',
            'posting_type' => 'nullable|string',
            // 'acc_type'    => 'nullable|string',
            'created_by' => 'required|integer|exists:users,id',
            'cheque_no'     => 'nullable|string',
            'narration'     => 'nullable|string',
            'is_transferred'=> 'nullable|boolean',
            'total_amount'=> 'nullable|numeric|min:0',
            // 'entries'       => 'nullable|array|min:1',
            // 'entries.*.gl_code'      => 'nullable|string',
            // 'entries.*.gl_name'      => 'nullable|string',
            // 'entries.*.account_code' => 'nullable|string',
            // 'entries.*.amount'       => 'nullable|numeric|min:0',
            // 'entries.*.balance'      => 'nullable|numeric|min:0',
        ]);
        // return dd($validated);

            $posting = PersonalDemandPosting::create([
                // 'department_id'  => $validated['department_id'],
                'member_id'      => $validated['member_id'],
                'month'          => $validated['month'] ?? null,
                // 'acc_type'      => $validated['acc_type'] ,
                'from_date'      => $validated['from_date'] ?? null,
                'to_date'        => $validated['to_date'] ?? null,
                // 'year'           => $validated['year']?? null,
                'posting_date'   => $validated['posting_date'],
                'ledger_id'      => $validated['ledger_id'],
                'account_id'     => $validated['account_id'],
                'posting_type'     => $validated['posting_type'],
                'cheque_no'      => $validated['cheque_no'] ?? null,
                'narration'      => $validated['narration'] ?? null,
                'is_transferred' => $request->has('is_transferred'),
                // 'total_amount'   => collect($validated['entries'])->sum('amount'),
                'created_by'   => $validated['created_by'],
                'branch_id'   => $validated['branch_id'],
                'total_amount'   => $validated['total_amount'] ?? 0,
            ]);

            // Create detail entries
            // foreach ($validated['entries'] as $entry) {
            //     $posting->entries()->create([
            //         'gl_code'      => $entry['gl_code'],
            //         'gl_name'      => $entry['gl_name'],
            //         'account_code' => $entry['account_code'],
            //         'amount'       => $entry['amount'],
            //         'balance'      => $entry['balance'],
            //     ]);
            // }

            return redirect()->route('demand-posting.index')
                ->with('success', 'Demand list posted successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $postings = PersonalDemandPosting::find($id);
        // if (!$postings) return response()->json(['message' => 'Not Found'], 404);
        
        $validated = $request->validate([
            // 'department_id' => 'nullable|integer',
            'member_id'     => 'nullable|integer',
            'month'         => 'nullable|string',
            'from_date'     => 'nullable|date',
            'to_date'       => 'nullable|date|after_or_equal:from_date',
            // 'year'          => 'nullable|digits:4',
            'posting_date'  => 'nullable|date',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'ledger_id' => 'nullable|integer|exists:general_ledgers,id',
            'account_id'    => 'required|string',
            'posting_type' => 'nullable|string',
            // 'acc_type'    => 'nullable|string',
            'created_by' => 'required|integer|exists:users,id',
            'cheque_no'     => 'nullable|string',
            'narration'     => 'nullable|string',
            'is_transferred'=> 'nullable|boolean',
            'total_amount'=> 'nullable|numeric|min:0',
            // 'entries'       => 'nullable|array|min:1',
            // 'entries.*.gl_code'      => 'nullable|string',
            // 'entries.*.gl_name'      => 'nullable|string',
            // 'entries.*.account_code' => 'nullable|string',
            // 'entries.*.amount'       => 'nullable|numeric|min:0',
            // 'entries.*.balance'      => 'nullable|numeric|min:0',
        ]);
        
        $postings->update($request->all());
        // return response()->json($subdivision, 200);
        return redirect()->route('demand-posting.index')->with('success', 'Demand Posting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $subdivision = Subdivision::findOrFail($id);
        // $subdivision->delete();
        // return redirect()->back()->with('success', 'Subdivision deleted successfully');
    }
}