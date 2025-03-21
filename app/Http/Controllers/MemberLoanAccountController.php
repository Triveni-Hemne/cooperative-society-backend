<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberLoanAccount;
use App\Models\Member;
use App\Models\Account;
use App\Models\GeneralLedger;
use App\Models\Nominee;
use App\Models\GoldLoanDetail;
use App\Models\LoanGuarantor;
use App\Models\LoanInstallment;
use App\Models\LoanResolutionDetail;


class MemberLoanAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $loanAccounts = MemberLoanAccount::with(['member', 'ledger'])->paginate(5);
       $ledgers = GeneralLedger::all();
       $members = Member::all();
       $accounts = Account::all();
        return view('accounts.loan-acc-opening.list', compact('loanAccounts','ledgers','members','accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $members = Member::all();
        $ledgers = GeneralLedger::all();
        return $ledgers;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'nullable|exists:members,id',
            'account_id' => 'nullable|exists:accounts,id',
            'acc_no' => 'required|string|max:50|unique:member_loan_accounts,acc_no',
            'loan_type' => 'required|in:Personal Loan,Home Loan,Auto Loan,Business Loan,Gold Loan',
            'name' => 'required|string|max:255',
            'ac_start_date' => 'required|date',
            'open_balance' => 'required|numeric',
            'purpose' => 'required|in:Agriculture,Construction,Cottage,SSI Unit,Dairy',
            'principal_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric|min:0|max:999.99',
            'tenure' => 'required|integer',
            'emi_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'balance' => 'required|numeric',
            'priority' => 'required|integer|min:-128|max:127',
            'loan_amount' => 'required|numeric',
            'collateral_type' => 'required|in:Gold,Property,Vehicle,None',
            'collateral_value' => 'numeric',
            'add_to_demand' => 'boolean',
            'is_loss_asset' => 'boolean',
            'case_flag' => 'boolean',
            'page_no' => 'nullable|string|max:50',
            'interest' => 'required|numeric',
            'postage' => 'nullable|numeric',
            'insurance' => 'nullable|numeric',
            'open_interest' => 'nullable|numeric',
            'penal_interest' => 'nullable|numeric',
            'notice_fee' => 'nullable|numeric',
            'insurance_date' => 'nullable|date',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            // nominee fields Fields
            'nominees' => 'required|array|min:1|max:2',    
            'nominees.*' => 'array',
            'nominees.*.nominee_name' => 'required|string|max:255',
            'nominees.*.nominee_naav' => 'nullable|string|max:255',
            'nominees.*.nominee_age' => 'required|integer|min:1|max:120',
            'nominees.*.nominee_gender' => 'required|in:Male,Female,Other',
            'nominees.*.relation' => 'required|in:husband,wife,father,mother,brother,sister,son,daughter,other',
            'nominees.*.nominee_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',

            // gold laon detail fields Fields
            // 'loan_id' => 'required|exists:member_loan_accounts,id',
            'gold_weight' => 'required_if:loan_type,Gold Loan|numeric|min:0',
            'gold_purity' => 'required_if:loan_type,Gold Loan|in:18K,22K,24K',
            'market_value' => 'required_if:loan_type,Gold Loan|numeric|min:0',
            'pledged_date' => 'required_if:loan_type,Gold Loan|date',
            'release_status' => 'required_if:loan_type,Gold Loan|in:Pledged,Released',
            'release_date' => 'nullable|date|after_or_equal:pledged_date',

            // laon garantor detail fields Fields
            // 'loan_id' => 'required|exists:member_loan_accounts,id',
            'member_id' => 'required|exists:members,id',
            'guarantor_type' => 'required|in:Primary,Secondary,Tertiary',
            'added_on' => 'required|date',
            'released_on' => 'nullable|date|after_or_equal:added_on',
            
            // installment detail fields Fields
            // 'loan_id' => 'required|exists:member_loan_accounts,id',
            'installment_type' => 'required|in:Monthly,Quarterly,Yearly',
            'mature_date' => 'nullable|date',
            'first_installment_date' => 'nullable|date',
            'total_installments' => 'required|integer|min:1',
            'installment_amount' => 'required|numeric|min:0',
            'installment_with_interest' => 'required|numeric|min:0',
            'total_installments_paid' => 'required|integer|min:0',
            
            // resolution detail fields Fields
            // 'loan_id' => 'required|exists:member_loan_accounts,id',
            'resolution_no' => 'required|string|max:50|unique:loan_resolution_details,resolution_no',
            'resolution_date' => 'required|date',
            
        ]);
        
        $photoPath = null;
        $signaturePath = null;
        
        // Check if photo is uploaded and store it
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->storeAs('uploads/photos', time() . '_' . $request->file('photo')->getClientOriginalName(), 'public');
        }

        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->storeAs('uploads/photos', time() . '_' . $request->file('signature')->getClientOriginalName(), 'public');
        }
         

            // Create Deposit Account
            $account = MemberLoanAccount::create([
            'ledger_id' => $validatedData['ledger_id'],
            'member_id' => $validatedData['member_id']?? null,
            'account_id' => $validatedData['account_id']?? null,
            'acc_no' => $validatedData['acc_no'],
            'name' => $validatedData['name'] ?? null,
            'loan_type' => $validatedData['loan_type'],
            'purpose' => $validatedData['purpose']?? null,
            'principal_amount' => $validatedData['principal_amount']?? null,
            'tenure' => $validatedData['tenure']?? null,
            'emi_amount' => $validatedData['emi_amount']?? null,
            'start_date' => $validatedData['start_date']?? null,
            'end_date' => $validatedData['end_date']?? null,
            'priority' => $validatedData['priority']?? null,
            'collateral_type' => $validatedData['collateral_type']?? null,
            'collateral_value' => $validatedData['collateral_value']?? null,
            'loan_amount' => $validatedData['loan_amount']?? null,
            'interest_rate' => $validatedData['interest_rate'] ?? null,
            
            'open_interest' => $validatedData['open_interest'] ?? null,
            'ac_start_date' => $validatedData['ac_start_date'] ,
            'acc_closing_date' => $validatedData['acc_closing_date'] ?? null,
            'open_balance' => $validatedData['open_balance'],
            'balance' => $validatedData['balance'] ?? null,
            'page_no' => $validatedData['page_no'] ?? null,
            'interest' => $validatedData['interest'] ?? null,
            'postage' => $validatedData['postage'] ?? null,
            'insurance' => $validatedData['insurance'] ?? null,
            'penal_interest' => $validatedData['penal_interest'] ?? null,
            'notice_fee' => $validatedData['notice_fee'] ?? null,
            'insurance_date' => $validatedData['insurance_date'] ?? null,
            'is_loss_asset' => $validatedData['is_loss_asset']?? 0,
            'case_flag' => $validatedData['case_flag'] ?? 0,
            'add_to_demand' => $validatedData['add_to_demand'] ?? 0,
            'images' => json_encode(['photo' => $photoPath, 'signature' => $signaturePath]),
        ]); 

        
        foreach ($validatedData['nominees'] as $nominee) {
            $imagePath = null;
            
            if (!empty($nominee['nominee_image']) && $nominee['nominee_image'] instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $nominee['nominee_image']->store('nominee_images', 'public');
            }
            
            Nominee::create([
                'loan_acc_id' => $account->id,
                'nominee_name' => $nominee['nominee_name'] ,
                'nominee_naav' => $nominee['nominee_naav'] ?? null,
                'nominee_age' => $nominee['nominee_age'],
                'nominee_gender' => $nominee['nominee_gender'],
                'relation' => $nominee['relation'],
                'nominee_image' => $imagePath, // Save image path if exists
            ]);
        }

        if($validatedData['loan_type'] === 'Gold Loan'){
            GoldLoanDetail::create([
                'loan_id' => $account->id,
                'gold_weight' => $validatedData['gold_weight'],
            'gold_purity' => $validatedData['gold_purity'],
            'market_value' => $validatedData['market_value'],
            'pledged_date' => $validatedData['pledged_date'],
            'release_status' => $validatedData['release_status'],
            'release_date' => $validatedData['release_date']  ?? null,
        ]);
       }

        LoanGuarantor::create([
            'loan_id' => $account->id,
            'member_id' => $validatedData['member_id'],
            'guarantor_type' => $validatedData['guarantor_type'],
            'added_on' => $validatedData['added_on'],
            'released_on' => $validatedData['released_on'] ?? null,
        ]);

         LoanInstallment::create([
            'loan_id' => $account->id,
            'installment_type' => $validatedData['installment_type'],
            'mature_date' => $validatedData['mature_date'] ?? null,
            'first_installment_date' => $validatedData['first_installment_date'] ?? null,
            'total_installments' => $validatedData['total_installments'],
            'installment_amount' => $validatedData['installment_amount'],
            'installment_with_interest' => $validatedData['installment_with_interest'],
            'total_installments_paid' => $validatedData['total_installments_paid'] ?? null,
        ]);

         LoanResolutionDetail::create([
           'loan_id' => $account->id,
            'resolution_no' => $validatedData['resolution_no'],
            'resolution_date' => $validatedData['resolution_date'],
        ]);
        // return $request->all();

        return redirect()->back()->with('success', 'Loan account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $loanAccount = MemberLoanAccount::find($id);

        if (!$loanAccount) {
            return response()->json(['message' => 'Loan account not found'], 404);
        }

        return response()->json($loanAccount, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $members = Member::all();
        $ledgers = GeneralLedger::all();
        return $ledgers;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'interest_rate' => 'numeric|min:0',
            'tenure' => 'integer|min:1',
            'balance' => 'numeric|min:0',
            'loan_amount' => 'numeric|min:0',
            'collateral_value' => 'numeric|min:0',
            'status' => 'in:Active,Closed,Defaulted',
        ]);

        $memberLoanAccount->update($request->all());

        return redirect()->route('member-loan-accounts.index')->with('success', 'Loan account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $memberLoanAccount->delete();
        return $memberLoanAccount;
    }
}