<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberDepoAccount;
use App\Models\GeneralLedger;
use App\Models\Member;
use App\Models\Account;
use App\Models\Nominee;
use App\Models\Branch;
use App\Models\Agent;
use App\Models\SavingsAccount;
use App\Models\FixedDeposit;
use App\Models\RecurringDeposit;
use Illuminate\Support\Facades\Auth;


class MemberDepoAccountController extends Controller
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
       $depo_accounts = MemberDepoAccount::with('fixedDeposit', 'recurringDeposit', 'saveDeposit', 'member.user')
       ->when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->latest()->paginate(5);

        // $depo_accounts = MemberDepoAccount::with('fixedDeposit','recurringDeposit','saveDeposit')->paginate(5);
        $ledgers = GeneralLedger::all();
        // $members = Member::all();
        $members = Member::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
        $accounts = Account::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
        $agents = Agent::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        return view('accounts.deposit-acc-opening.list',compact('depo_accounts','ledgers','members','accounts','agents','branches'));

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

        $validatedData = $request->validate([
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'nullable|exists:members,id',
            // 'account_id' => 'nullable|exists:accounts,id',
            'acc_no' => 'required|string|max:255|unique:member_depo_accounts,acc_no',
            // 'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric|min:0|max:999.99',
            'interest_payable' => 'required|numeric',
            'ac_start_date' => 'required|date',
            'acc_closing_date' => 'nullable|date|after_or_equal:ac_start_date',
            'open_balance' => 'required|numeric',
            'balance' => 'required|numeric',
            'agent_id' => 'nullable|string',
            'page_no' => 'nullable|numeric',
            'deposit_type' => 'required|in:fd,rd,savings',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly,Half Yearly',
            'installment_amount' => 'nullable|numeric',
            'total_installments' => 'nullable|numeric',
            'total_payable_amount' => 'nullable|numeric',
            // 'total_installments_paid' => 'nullable|numeric',
            // 'open_interest' => 'nullable|numeric',
            'closing_flag' => 'nullable|boolean',
            'add_to_demand' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            // nominee fields Fields
            'nominees' => 'required|array|min:1|max:2',    
            'nominees.*' => 'array',
            'nominees.*.nominee_name' => 'required|string|max:255',
            'nominees.*.nominee_naav' => 'nullable|string|max:255',
            'nominees.*.nominee_age' => 'required|integer|min:1|max:120',
            'nominees.*.nominee_gender' => 'required|in:Male,Female,Other',
            'nominees.*.relation' => 'required|in:husband,wife,father,mother,brother,sister,son,daughter,other',
            'nominees.*.nominee_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',

            // RD Fields
            // 'open_interest_rd' => 'required_if:deposit_type,rd|nullable|numeric|min:0',
            'rd_term_months' => 'required_if:deposit_type,rd|nullable|integer|min:1',
            'maturity_amount_rd' => 'required_if:deposit_type,rd|nullable|numeric|min:0',
            'slip_no' => 'required_if:deposit_type,fd|nullable|string|min:1',
            
            // FD Fields
            'maturity_amount_fd' => 'required_if:deposit_type,fd|nullable|numeric|min:0',
            'fd_term_months' => 'required_if:deposit_type,fd|nullable|integer|min:1',
            
            // Saving Fields
            'balance_sv' => 'required_if:deposit_type,savings|nullable|numeric|min:0',
            'interest_rate_sv' => 'required_if:deposit_type,savings|nullable|numeric|min:0|max:100',
        ]);
            // dd(is_array($request->input('nominees')), $request->input('nominees'));
            
            $photoPath = null;
            $signaturePath = null;
            
            // Check if photo is uploaded and store it
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('uploads/photos');
            }
            
            // Check if signature is uploaded and store it
            if ($request->hasFile('signature')) {
                $signaturePath = $request->file('signature')->store('uploads/signatures');
            }
            
            // Create Deposit Account
        $account = MemberDepoAccount::create([
            'ledger_id' => $validatedData['ledger_id'],
            'member_id' => $validatedData['member_id']?? null,
            'account_id' => $validatedData['account_id']?? null,
            'acc_no' => $validatedData['acc_no'],
            'name' => $validatedData['name'] ?? null,
            'interest_rate' => $validatedData['interest_rate'] ?? null,
            'installment_type' => $validatedData['installment_type'] ?? null,
            'installment_amount' => $validatedData['installment_amount'] ?? null,
            'total_installments' => $validatedData['total_installments'] ?? null,
            'total_payable_amount' => $validatedData['total_payable_amount'] ?? null,
            'open_interest' => $validatedData['open_interest'] ?? null,
            'interest_payable' => $validatedData['interest_payable'] ?? null,
            'ac_start_date' => $validatedData['ac_start_date'] ,
            'acc_closing_date' => $validatedData['acc_closing_date'] ?? null,
            'open_balance' => $validatedData['open_balance'],
            'balance' => $validatedData['balance'] ?? null,
            'agent_id' => $validatedData['agent_id'] ?? null,
            'page_no' => $validatedData['page_no'] ?? null,
            'deposit_type' => $validatedData['deposit_type'],
            'closing_flag' => $validatedData['closing_flag'] ?? 0,
            'add_to_demand' => $validatedData['add_to_demand'] ?? 0,
            'images' => json_encode(['photo' => $photoPath, 'signature' => $signaturePath]),
        ]);
        
        
        foreach ($validatedData['nominees'] as $nominee) {
            $imagePath = null;
            
            if (!empty($nominee['nominee_image']) && $nominee['nominee_image'] instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $nominee['nominee_image']->store('nominee_images', 'public');
            }
            
            Nominee::create([
                'depo_acc_id' => $account->id,
                'nominee_name' => $nominee['nominee_name'],
                'nominee_naav' => $nominee['nominee_naav'] ?? null,
                'nominee_age' => $nominee['nominee_age'],
                'nominee_gender' => $nominee['nominee_gender'],
                'relation' => $nominee['relation'],
                'nominee_image' => $imagePath, // Save image path if exists
            ]);
        }
        
        
        // Handle Fixed Deposit (FD)
        if ($validatedData['deposit_type'] === 'fd') {
            FixedDeposit::create([
                'deposit_account_id' => $account->id,
                'fd_term_months' => $validatedData['fd_term_months'],
                'maturity_amount' => $validatedData['maturity_amount_fd'],
                'slip_no' => $validatedData['slip_no'],
            ]);
        }
        
        // Handle Recurring Deposit (RD)
        if ($validatedData['deposit_type'] === 'rd') {
            RecurringDeposit::create([
                'deposit_account_id' => $account->id,
                'rd_term_months' => $validatedData['rd_term_months'],
                // 'open_interest' => $validatedData['open_interest'],
                'maturity_amount' => $validatedData['maturity_amount_rd'],
            ]);
        }
        // return $request->all();
        
        // Handle Savings Account
        if ($validatedData['deposit_type'] === 'savings') {
            SavingsAccount::create([
                'deposit_account_id' => $account->id,
                'balance' => $validatedData['balance_sv'],
                'interest_rate' => $validatedData['interest_rate_sv'],
                
            ]);
        }
        
        return redirect()->back()->with('success', 'Deposite Account added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = MemberDepoAccount::findOrFail($id);
        return response()->json($account);
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
         $account = MemberDepoAccount::findOrFail($id);

        $validatedData = $request->validate([
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'nullable|exists:members,id',
            // 'account_id' => 'nullable|exists:accounts,id',
            'acc_no' => "required|string|max:255|unique:member_depo_accounts,acc_no,{$id}",
            // 'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric|min:0|max:999.99',
            'interest_payable' => 'required|numeric',
            'ac_start_date' => 'required|date',
            'acc_closing_date' => 'nullable|date|after_or_equal:ac_start_date',
            'open_balance' => 'required|numeric',
            'balance' => 'required|numeric',
            'agent_id' => 'nullable|string',
            'page_no' => 'nullable|numeric',
            'deposit_type' => 'required|in:fd,rd,savings',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly,Half Yearly',
            'installment_amount' => 'nullable|numeric',
            'total_installments' => 'nullable|numeric',
            'total_payable_amount' => 'nullable|numeric',
            // 'total_installments_paid' => 'nullable|numeric',
            // 'open_interest' => 'nullable|numeric',
            'closing_flag' => 'nullable|boolean',
            'add_to_demand' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Nominees
            'nominees' => 'nullable|array|min:1|max:2',
            'nominees.*' => 'array',
            'nominees.*.nominee_name' => 'nullable|string|max:255',
            'nominees.*.nominee_naav' => 'nullable|string|max:255',
            'nominees.*.nominee_age' => 'nullable|integer|min:1|max:120',
            'nominees.*.nominee_gender' => 'nullable|in:Male,Female,Other',
            'nominees.*.relation' => 'nullable|in:husband,wife,father,mother,brother,sister,son,daughter,other',
            'nominees.*.nominee_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',

            // RD Fields
            // 'open_interest_rd' => 'required_if:deposit_type,rd|nullable|numeric|min:0',
            'rd_term_months' => 'required_if:deposit_type,rd|nullable|integer|min:1',
            'maturity_amount_rd' => 'required_if:deposit_type,rd|nullable|numeric|min:0',

            // FD Fields
            'maturity_amount_fd' => 'required_if:deposit_type,fd|nullable|numeric|min:0',
            'fd_term_months' => 'required_if:deposit_type,fd|nullable|integer|min:1',
            'slip_no' => 'required_if:deposit_type,fd|nullable|string|min:1',

            // Savings Fields
            'balance_sv' => 'required_if:deposit_type,savings|nullable|numeric|min:0',
            'interest_rate_sv' => 'required_if:deposit_type,savings|nullable|numeric|min:0|max:100',
        ]);

        // Handle image updates
        $photoPath = $account->photo;
        $signaturePath = $account->signature;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads/photos');
        }
        
        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->store('uploads/signatures');
        }

        // Update Deposit Account
        $account->update([
            'ledger_id' => $validatedData['ledger_id'],
            'member_id' => $validatedData['member_id'] ?? null,
            'account_id' => $validatedData['account_id'] ?? null,
            'acc_no' => $validatedData['acc_no'],
            'name' => $validatedData['name'] ?? null,
            'interest_rate' => $validatedData['interest_rate'] ?? null,
            'installment_type' => $validatedData['installment_type'] ?? null,
            'installment_amount' => $validatedData['installment_amount'] ?? null,
            'total_installments' => $validatedData['total_installments'] ?? null,
            'total_payable_amount' => $validatedData['total_payable_amount'] ?? null,
            'open_interest' => $validatedData['open_interest'] ?? null,
            'interest_payable' => $validatedData['interest_payable'] ?? null,
            'ac_start_date' => $validatedData['ac_start_date'],
            'acc_closing_date' => $validatedData['acc_closing_date'] ?? null,
            'open_balance' => $validatedData['open_balance'],
            'balance' => $validatedData['balance'] ?? null,
            'agent_id' => $validatedData['agent_id'] ?? null,
            'page_no' => $validatedData['page_no'] ?? null,
            'deposit_type' => $validatedData['deposit_type'],
            'closing_flag' => $validatedData['closing_flag'] ?? 0,
            'add_to_demand' => $validatedData['add_to_demand'] ?? 0,
            'images' => json_encode(['photo' => $photoPath, 'signature' => $signaturePath]),
        ]);

        // Update Nominees
        // $account->nominees()->delete(); // Remove existing nominees before updating
        foreach ($validatedData['nominees'] as $index => $nominee) {
            $existingNominee = Nominee::where('depo_acc_id', $account->id)->skip($index)->first();

            // Retain old image path if no new image is uploaded
            $imagePath = $existingNominee ? $existingNominee->nominee_image : null;

            if (!empty($nominee['nominee_image']) && $nominee['nominee_image'] instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $nominee['nominee_image']->store('nominee_images', 'public');
            }

            // Update or Create Nominee
            Nominee::updateOrCreate(
                [
                    'depo_acc_id' => $account->id,
                    'nominee_name' => $nominee['nominee_name'], // Unique criteria can be added
                ],
                [
                    'nominee_naav' => $nominee['nominee_naav'] ?? null,
                    'nominee_age' => $nominee['nominee_age'],
                    'nominee_gender' => $nominee['nominee_gender'],
                    'relation' => $nominee['relation'],
                    'nominee_image' => $imagePath, // Save existing or new image path
                ]
            );
        }


        // Handle Fixed Deposit (FD)
        if ($validatedData['deposit_type'] === 'fd') {
            FixedDeposit::updateOrCreate(
                ['deposit_account_id' => $account->id],
                [
                    'fd_term_months' => $validatedData['fd_term_months'],
                    'maturity_amount' => $validatedData['maturity_amount_fd'],
                    'slip_no' => $validatedData['slip_no'],
                ]
            );
        } else {
            FixedDeposit::where('deposit_account_id', $account->id)->delete();
        }

        // Handle Recurring Deposit (RD)
        if ($validatedData['deposit_type'] === 'rd') {
            RecurringDeposit::updateOrCreate(
                ['deposit_account_id' => $account->id],
                [
                    'rd_term_months' => $validatedData['rd_term_months'],
                    // 'open_interest' => $validatedData['open_interest'],
                    'maturity_amount' => $validatedData['maturity_amount_rd'],
                ]
            );
        } else {
            RecurringDeposit::where('deposit_account_id', $account->id)->delete();
        }

        // Handle Savings Account
        if ($validatedData['deposit_type'] === 'savings') {
            SavingsAccount::updateOrCreate(
                ['deposit_account_id' => $account->id],
                [
                    'balance' => $validatedData['balance_sv'],
                    'interest_rate' => $validatedData['interest_rate_sv'],
                ]
            );
        } else {
            SavingsAccount::where('deposit_account_id', $account->id)->delete();
        }

        return redirect()->back()->with('success', 'Deposit Account updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = MemberDepoAccount::findOrFail($id);
        $account->delete();
        return redirect()->back()->with('success', 'Deposite Account deleted successfully');;
    }
}