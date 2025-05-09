<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Nominee;
use App\Models\MemberBankDetail;
use App\Models\MemberFinancial;
use App\Models\Employee;
use App\Models\Center;
use App\Models\Branch;
use App\Models\User;
use App\Models\Department;
use App\Models\Division;
use App\Models\Subdivision;
use App\Models\Subcaste;
use App\Models\Director;
use App\Models\Designation;
use App\Models\MemberContactDetail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Notifications\MemberAccountCreated;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
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
       $members = Member::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->paginate(5);

    //    $members = Member::paginate(5);    
       $departments = Department::all();
       $subcates = Subcaste::all();
       $directors = Director::all();
       $centers = Center::all();
       $user = Auth::user();
       $divisions = Division::all();
       $subdivisions = Subdivision::all();
       $designations = Designation::all();

       $branches = $user->role === 'Admin' ? Branch::all() : null;
       
       return view('accounts.member.list', compact('departments','subcates','members','directors','centers','divisions','subdivisions','designations','user','branches'));
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
            // Employee Validation
            'emp_code' => 'required|string|max:50|unique:employees,emp_code',
            'designation_id' => 'required|exists:designations,id',
            'salary' => 'required|numeric',
            'other_allowance' => 'nullable|numeric',
            'division_id' => 'required|exists:divisions,id',
            'subdivision_id' => 'required|exists:subdivisions,id',
            'center_id' => 'required|exists:centers,id',
            'joining_date' => 'required|date',
            'transfer_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'gpf_no' => 'nullable|string|max:50|unique:employees,gpf_no',
            'hra' => 'nullable|numeric',
            'da' => 'nullable|numeric',

            // Member Validation
            'subcaste_id' => 'nullable|exists:subcastes,id',
            'department_id' => 'nullable|exists:departments,id',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'name' => 'required|string|max:255',
            'naav' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'age' => 'required|integer|min:0',
            'date_of_joining' => 'nullable|date',
            'religion' => 'nullable|string|max:100',
            'category' => 'required|in:ST,SC,OBC,General,NT,Other',
            'caste' => 'required|string|max:100',
            'm_reg_no' => 'nullable|string|max:50',
            'pan_no' => 'nullable|string|max:20',
            'adhar_no' => 'nullable|string|max:20',
            'created_by' => 'required|exists:users,id',

            // Contact Validation
            'address' => 'required|string',
            'marathi_address' => 'nullable|string',
            'city' => 'required|string|max:100',
            'mobile_no' => 'required|string|max:15',
            'phone_no' => 'nullable|string|max:15',

            // Nominee Validation
            'nominee_id' => 'nullable|exists:members,id',
            'depo_acc_id' => 'nullable|exists:member_depo_accounts,id',
            'nominee_name' => 'required|string|max:255',
            'nominee_naav' => 'nullable|string|max:255',
            'nominee_age' => 'required|integer',
            'nominee_gender' => 'required|in:Male,Female,Other',
            'relation' => 'required|string|max:50',
            'nominee_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nominee_address' => 'nullable|string|max:50',
            'nominee_marathi_address' => 'nullable|string|max:50',
            'nominee_adhar_no' => 'nullable|string|max:50',

            // Bank Details Validation
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'bank_account_no' => 'required|string|max:50|unique:member_bank_details,bank_account_no',
            'ifsc_code' => 'required|string|min:5|max:11',
            'proof_1_no' => 'nullable|string|unique:member_bank_details,proof_1_no',
            'proof_1_type' => 'nullable|string|max:50',
            'proof_1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'proof_2_no' => 'nullable|string|unique:member_bank_details,proof_2_no',
            'proof_2_type' => 'nullable|string|max:50',
            'proof_2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Financial Validation
            'director_id' => 'nullable|exists:directors,id',
            'share_amount' => 'numeric|min:0',
            'number_of_shares' => 'numeric|min:0',
            'welfare_fund' => 'nullable|numeric',
            'page_no' => 'nullable|string|max:50',
            'current_balance' => 'numeric|min:0',
            'monthly_balance' => 'numeric|min:0',
            'dividend_amount' => 'nullable|numeric|min:0',
            'monthly_deposit' => 'numeric|min:0',
            'demand' => 'nullable|string|in:yes,no',
            'type' => 'required|in:Share,Dividend,Deposit',
        ]);


        if ($request->hasFile('nominee_image')) {
            $validatedData['nominee_image'] = $request->file('nominee_image')->store('uploads/nominees', 'public');
        }

        if ($request->hasFile('proof_1_image')) {
            $validatedData['proof_1_image'] = $request->file('proof_1_image')->store('uploads/bank_proofs', 'public');
        }

        if ($request->hasFile('proof_2_image')) {
            $validatedData['proof_2_image'] = $request->file('proof_2_image')->store('uploads/bank_proofs', 'public');
        }


        $employee = Employee::create([
            'emp_code' => $validatedData['emp_code'],
            'designation_id' => $validatedData['designation_id'],
            'salary' => $validatedData['salary'],
            'other_allowance' => $validatedData['other_allowance'] ?? null,
            'division_id' => $validatedData['division_id'],
            'subdivision_id' => $validatedData['subdivision_id'],
            'center_id' => $validatedData['center_id'],
            'joining_date' => $validatedData['joining_date'],
            'transfer_date' => $validatedData['transfer_date'] ?? null,
            'retirement_date' => $validatedData['retirement_date'] ?? null,
            'gpf_no' => $validatedData['gpf_no'] ?? null,
            'hra' => $validatedData['hra'] ?? null,
            'da' => $validatedData['da'] ?? null,
        ]);

        $member = Member::create(array_merge(
            Arr::only($validatedData, [
                'subcaste_id', 'department_id', 'name', 'naav', 'dob', 'gender', 'age',
                'date_of_joining', 'religion', 'category', 'caste', 'm_reg_no', 'pan_no', 'adhar_no', 'created_by'
            ]),
            ['employee_id' => $employee->id]
        ));

        $contact = MemberContactDetail::create(array_merge(
            Arr::only($validatedData, ['address', 'marathi_address', 'city', 'mobile_no', 'phone_no']),
            ['member_id' => $member->id]
        ));

        $nominee = Nominee::create(array_merge(
            Arr::only($validatedData, [
                'nominee_id', 'depo_acc_id', 'nominee_name', 'nominee_naav', 'nominee_age',
                'nominee_gender', 'relation', 'nominee_image', 'nominee_address',
                'nominee_marathi_address', 'nominee_adhar_no'
            ]),
            ['member_id' => $member->id]
        ));

        $bankDetail = MemberBankDetail::create(array_merge(
            Arr::only($validatedData, [
                'bank_name', 'branch_name', 'bank_account_no', 'ifsc_code',
                'proof_1_no', 'proof_1_type', 'proof_1_image',
                'proof_2_no', 'proof_2_type', 'proof_2_image'
            ]),
            ['member_id' => $member->id]
        ));

        $financial = MemberFinancial::create(array_merge(
            Arr::only($validatedData, [
                'director_id', 'share_amount', 'number_of_shares', 'welfare_fund',
                'page_no', 'current_balance', 'monthly_balance',
                'dividend_amount', 'monthly_deposit', 'demand', 'type'
            ]),
            ['member_id' => $member->id]
        ));

        // $request->user()->notify(new AccountCreated($member));
        
        return redirect()->back()->with('success', 'Member added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::with(['employee', 'department'])->findOrFail($id);
        return response()->json($member);
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
        $member = Member::findOrFail($id);

        $employee_validated = $request->validate([
            'emp_code' => ['required', 'string', 'max:50', Rule::unique('employees', 'emp_code')->ignore($member->employee_id)],
            'designation_id' => 'required|exists:designations,id',
            'salary' => 'required|numeric',
            'other_allowance' => 'nullable|numeric',
            'division_id' => 'required|exists:divisions,id',
            'subdivision_id' => 'required|exists:subdivisions,id',
            'center_id' => 'required|exists:centers,id',
            'joining_date' => 'required|date',
            'transfer_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'gpf_no' => ['nullable', 'string', 'max:50', Rule::unique('employees', 'gpf_no')->ignore($member->employee_id)],
            'hra' => 'nullable|numeric',
            'da' => 'nullable|numeric',
        ]);
        
        $member_validated = $request->validate([
            'subcaste_id' => 'nullable|exists:subcastes,id',
            'department_id' => 'nullable|exists:departments,id',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'name' => 'required|string|max:255',
            'naav' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'age' => 'required|integer|min:0',
            'date_of_joining' => 'nullable|date',
            'religion' => 'nullable|string|max:100',
            'category' => 'required|in:ST,SC,OBC,General,NT,Other',
            'caste' => 'required|string|max:100',
            'm_reg_no' => 'nullable|string|max:50',
            'pan_no' => 'nullable|string|max:20',
            'adhar_no' => ['nullable', 'string', 'max:20', Rule::unique('members', 'adhar_no')->ignore($id)],
            'created_by' => 'required|exists:users,id',
        ]);

        $contact_validated = $request->validate([
            'address' => 'required|string',
            'marathiAddress' => 'nullable|string',
            'city' => 'required|string|max:100',
            'mobile_no' => 'required|string|max:15',
            'phone_no' => 'nullable|string|max:15',
        ]);

        $nominee_validated = $request->validate([
            'nominee_id' => 'nullable|exists:members,id',
            'depo_acc_id' => 'nullable|exists:member_depo_accounts,id',
            'nominee_name' => 'required|string|max:255',
            'nominee_naav' => 'nullable|string|max:255',
            'nominee_age' => 'required|integer',
            'nominee_gender' => 'required|in:Male,Female,Other',
            'relation' => 'required|string|max:50',
            'nominee_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nominee_address' => 'nullable|string|max:50',
            'nominee_marathi_address' => 'nullable|string|max:50',
            'nominee_adhar_no' => 'nullable|string|max:50',
        ]);

        $bankDetail_validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'bank_account_no' => ['required', 'string', 'max:50', Rule::unique('member_bank_details', 'bank_account_no')->ignore($member->id, 'member_id')],
            'ifsc_code' => 'required|string|min:5|max:11',
            'proof_1_no' => ['nullable', 'string', Rule::unique('member_bank_details', 'proof_1_no')->ignore($member->id, 'member_id'),
            ],
            'proof_1_type' => 'nullable|string|max:50',
            'proof_1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            'proof_2_no' => ['nullable', 'string', Rule::unique('member_bank_details', 'proof_2_no')->ignore($member->id, 'member_id'),
            ],
            'proof_2_type' => 'nullable|string|max:50',
            'proof_2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $financial_validated = $request->validate([
            'director_id' => 'nullable|exists:directors,id',
            'share_amount' => 'numeric|min:0',
            'number_of_shares' => 'numeric|min:0',
            'welfare_fund' => 'nullable|numeric',
            'page_no' => 'nullable|string|max:50',
            'current_balance' => 'numeric|min:0',
            'monthly_balance' => 'numeric|min:0',
            'dividend_amount' => 'nullable|numeric|min:0',
            'monthly_deposit' => 'numeric|min:0',
            'demand' => 'nullable|string|in:yes,no',
            'type' => 'in:Share,Dividend,Deposit'
        ]);

        // **Handle File Uploads Efficiently**
        $bankDetail_validated['proof_1_image'] = $this->handleFileUpload($request, 'proof_1_image', $member->bankDetail, 'uploads/bank_proofs');
        $bankDetail_validated['proof_2_image'] = $this->handleFileUpload($request, 'proof_2_image', $member->bankDetail, 'uploads/bank_proofs');
        $nominee_validated['nominee_image'] = $this->handleFileUpload($request, 'nominee_image', $member->nominee, 'uploads/nominees');

        // **Update Employee**
        $employee = Employee::findOrFail($member->employee_id);
        if($employee){
            $employee->update($employee_validated);
        }
        else{
            MemberContactDetail::create($employee_validated);
        }

        // **Update Member**
        $member->update($member_validated);

        // **Update Contact Details**
        $existingMemberContactDetail = MemberContactDetail::where('member_id', $member->id)->first();
        if ($member->contact) {
            $member->contact->update($contact_validated);
        } else {
            $contact_validated['member_id'] = $member->id;
            MemberContactDetail::create($contact_validated);
        }

        // **Update Nominee Details**
        $existingNominee = Nominee::where('member_id', $member->id)->first();
        if ($member->nominee) {
            $member->nominee->update($nominee_validated);
        } else {
            $nominee_validated['member_id'] = $member->id;
            Nominee::create($nominee_validated);
        }
        
        // **Update Bank Details**
        $existingBankDetail = MemberBankDetail::where('member_id', $member->id)->first();
        if ($existingBankDetail) {
            $member->bankdtl->update($bankDetail_validated);
        } else {
            $bankDetail_validated['member_id'] = $member->id;
            MemberBankDetail::create($bankDetail_validated);
        }

        // **Update Financial Details**
        $existingMemberFinancial = MemberFinancial::where('member_id', $member->id)->first();
        if ($existingMemberFinancial) {
            $member->financialdtl->update($financial_validated);
        } else {
            $financial_validated['member_id'] = $member->id;
            MemberFinancial::create($financial_validated);
        }

        return redirect()->back()->with('success', 'Member updated successfully');
    }

    // **Helper Method to Handle File Uploads**
    private function handleFileUpload($request, $field, $model, $path)
    {
        if ($request->hasFile($field)) {
            if ($model && $model->$field) {
                Storage::disk('public')->delete($model->$field);
            }
            return $request->file($field)->store($path, 'public');
        }
        return $model ? $model->$field : null;
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $member = Member::findOrFail($id);
        $member->delete();
        return redirect()->back()->with('success', 'Member deleted successfully');
    }
}