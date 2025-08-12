<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee; 
use Illuminate\Validation\Rule;
use App\Models\Nominee;
use App\Models\MemberBankDetail;
use App\Models\MemberFinancial;
use App\Models\Branch;
use App\Models\User;
use App\Models\Department;
use App\Models\Category;
use App\Models\Member;
use App\Models\Division;
use App\Models\Subdivision;
use App\Models\Subcaste;
use App\Models\Director;
use App\Models\Designation;
use App\Models\MemberContactDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
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
       $employees = Member::whereNotNull('employee_id')->when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->latest()->paginate(5);

       $departments = Department::all();
       $directors = Director::all();
       $user = Auth::user();
       $categories = Category::all();
       $divisions = Division::all();
       $subdivisions = Subdivision::all();
       $designations = Designation::all();

       $branches = $user->role === 'Admin' ? Branch::all() : null;
       
       return view('master.employee.list', compact('departments','employees','directors','divisions','subdivisions','designations','user','branches', 'categories'));
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
            'emp_code' => 'nullable|string|max:50|unique:employees,emp_code',
            'other_allowance' => 'nullable|numeric',
            'division_id' => 'nullable|exists:divisions,id',
            'subdivision_id' => 'nullable|exists:subdivisions,id',
            // 'center_id' => 'nullable|exists:centers,id',
            'joining_date' => 'nullable|date',
            'transfer_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'retirement_date' => 'nullable|date',
            'hra' => 'nullable|numeric',
            'designation_id' => 'nullable|exists:designations,id',
            'da' => 'nullable|numeric',
            'cpf_no' => 'nullable|string|max:50|unique:employees,gpf_no',
            
            // Member Validation
            'department_id' => 'nullable|exists:departments,id',
            'branch_id' => auth()->user()->role === 'Admin'
            ? ['required', Rule::exists('branches', 'id')]
            : ['nullable', Rule::exists('branches', 'id')],
            'created_by' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'naav' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'age' => 'required|integer|min:0',
            'date_of_joining' => 'nullable|date',
            'm_reg_no' => 'nullable|string|max:50',
            'caste' => 'required|string|max:100',
            'religion' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'member_branch_id' => 'required|exists:branches,id',
            'photo' => 'nullable|image|max:2048',
            'signature' => 'nullable|image|max:2048',
            'pan_no' => 'nullable|string|max:20',
            'adhar_no' => 'nullable|string|max:20',
            'designation_id' => 'nullable|exists:designations,id',
            'cpf_no' => 'nullable|string|max:50|unique:employees,gpf_no',
            'division_id' => 'nullable|exists:divisions,id',
            'subdivision_id' => 'nullable|exists:subdivisions,id',

            // Contact Validation
            'address' => 'required|string',
            'marathi_address' => 'nullable|string',
            'city' => 'required|string|max:100',
            'mobile_no' => 'required|string|max:15',
            'phone_no' => 'nullable|string|max:15',

            // Nominee Validation
            'nominee_id' => 'nullable|exists:members,id',
            'depo_acc_id' => 'nullable|exists:member_depo_accounts,id',
            'nominee_name' => 'nullable|string|max:255',
            'nominee_naav' => 'nullable|string|max:255',
            'nominee_age' => 'nullable|integer',
            'nominee_gender' => 'nullable|in:Male,Female,Other',
            'relation' => 'nullable|string|max:50',
            'nominee_image' => 'nullable|image|max:2048',
            'nominee_signature' => 'nullable|image|max:2048',
            'nominee_address' => 'nullable|string|max:50',
            'nominee_marathi_address' => 'nullable|string|max:50',
            'nominee_adhar_no' => 'nullable|string|max:50',

            // Bank Details Validation
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50|unique:member_bank_details,bank_account_no',
            'ifsc_code' => 'nullable|string|min:5|max:11',
            'proof_1_no' => 'nullable|string|unique:member_bank_details,proof_1_no',
            'proof_1_type' => 'nullable|string|max:50',
            'proof_1_image' => 'nullable|image|max:2048',
            'proof_2_no' => 'nullable|string|unique:member_bank_details,proof_2_no',
            'proof_2_type' => 'nullable|string|max:50',
            'proof_2_image' => 'nullable|image|max:2048',
            
        ]);


        // dd($validatedData);
        if ($request->hasFile('photo')) {
           $photoPath = $validatedData['photo'] = $request->file('photo')->store('uploads/member', 'public');
        }
        if ($request->hasFile('signature')) {
            $signaturePath = $validatedData['signature'] = $request->file('signature')->store('uploads/member', 'public');
        }
        if ($request->hasFile('nominee_image')) {
            $validatedData['nominee_image'] = $request->file('nominee_image')->store('uploads/nominees', 'public');
        }
        if ($request->hasFile('nominee_signature')) {
            $validatedData['nominee_signature'] = $request->file('nominee_signature')->store('uploads/nominees', 'public');
        }
        if ($request->hasFile('proof_1_image')) {
            $validatedData['proof_1_image'] = $request->file('proof_1_image')->store('uploads/bank_proofs', 'public');
        }

        if ($request->hasFile('proof_2_image')) {
            $validatedData['proof_2_image'] = $request->file('proof_2_image')->store('uploads/bank_proofs', 'public');
        }

            $employee = Employee::create([
                'emp_code' => $validatedData['emp_code'] ?? null,
                'salary' => $validatedData['salary'] ?? null,
                'other_allowance' => $validatedData['other_allowance'] ?? null,
                'division_id' => $validatedData['division_id'] ?? null,
                'subdivision_id' => $validatedData['subdivision_id'] ?? null,
                'center_id' => $validatedData['center_id'] ?? null,
                'joining_date' => $validatedData['joining_date'] ?? null,
                'transfer_date' => $validatedData['transfer_date'] ?? null,
                'retirement_date' => $validatedData['retirement_date'] ?? null,
                'hra' => $validatedData['hra'] ?? null,
                'da' => $validatedData['da'] ?? null,
                'cpf_no' => $validatedData['cpf_no'] ?? null,
                'designation_id' => $validatedData['designation_id'] ?? null,
            ]);
        
        $member = Member::create(array_merge(
            Arr::only($validatedData, [
                'branch_id', 'created_by', 'name', 'naav', 'gender', 'dob', 'age',
                'date_of_joining', 'm_reg_no', 'caste', 'religion', 'category_id',
                'member_branch_id', 'pan_no', 'adhar_no', 'membership_date', 'division_id', 'subdivision_id'
            ]),
            [
                'images' => json_encode([
                    'photo' => $photoPath ?? null,
                    'signature' => $signaturePath ?? null
                ])
                ,
                'employee_id' => $employee->id
            ]
            
        ));

        $contact = MemberContactDetail::create(array_merge(
            Arr::only($validatedData, ['address', 'marathi_address', 'city', 'mobile_no', 'phone_no']),
            ['member_id' => $member->id]
        ));

        $nominee = Nominee::create(array_merge(
            Arr::only($validatedData, [
                'nominee_name', 'nominee_naav', 'nominee_age',
                'nominee_gender', 'relation', 'nominee_image','nominee_signature', 'nominee_address',
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
        return redirect()->back()->with('success', 'Employee added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with('designation')->findOrFail($id);
        return response()->json($employee);
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
            'emp_code' => ['nullable', 'string', 'max:50', Rule::unique('employees', 'emp_code')->ignore($member->employee_id)],
            'designation_id' => 'nullable|exists:designations,id',
            'salary' => 'nullable|numeric',
            'other_allowance' => 'nullable|numeric',
            'division_id' => 'nullable|exists:divisions,id',
            'subdivision_id' => 'nullable|exists:subdivisions,id',
            'center_id' => 'nullable|exists:centers,id',
            'joining_date' => 'nullable|date',
            'transfer_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'gpf_no' => ['nullable', 'string', 'max:50', Rule::unique('employees', 'gpf_no')->ignore($member->employee_id)],
            'hra' => 'nullable|numeric',
            'da' => 'nullable|numeric',
        ]);
        
        $member_validated = $request->validate([
            // 'subcaste_id' => 'nullable|exists:subcastes,id',
            'department_id' => 'nullable|exists:departments,id',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'created_by' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'naav' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'age' => 'required|integer|min:0',
            'date_of_joining' => 'nullable|date',
            'm_reg_no' => 'nullable|string|max:50',
            'caste' => 'required|string|max:100',
            'religion' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'member_branch_id' => 'required|exists:branches,id',
            'photo' => 'nullable|image|max:2048',
            'signature' => 'nullable|image|max:2048',
            'pan_no' => 'nullable|string|max:20',
            // 'adhar_no' => 'nullable|string|max:20',
            'adhar_no' => ['nullable', 'string', 'max:20', Rule::unique('members', 'adhar_no')->ignore($id)],
            'designation_id' => 'nullable|exists:designations,id',
            'cpf_no' => 'nullable|string|max:50|unique:employees,gpf_no',
            'division_id' => 'nullable|exists:divisions,id',
            'subdivision_id' => 'nullable|exists:subdivisions,id',
            // 'membership_date' => 'required|date',
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
            'nominee_name' => 'nullable|string|max:255',
            'nominee_naav' => 'nullable|string|max:255',
            'nominee_age' => 'nullable|integer',
            'nominee_gender' => 'nullable|in:Male,Female,Other',
            'relation' => 'nullable|string|max:50',
            'nominee_image' => 'nullable|image|max:2048',
            'nominee_signature' => 'nullable|image|max:2048',
            'nominee_address' => 'nullable|string|max:50',
            'nominee_marathi_address' => 'nullable|string|max:50',
            'nominee_adhar_no' => 'nullable|string|max:50',
        ]);

        $bankDetail_validated = $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'bank_account_no' => ['nullable', 'string', 'max:50', Rule::unique('member_bank_details', 'bank_account_no')->ignore($member->id, 'member_id')],
            'ifsc_code' => 'nullable|string|min:5|max:11',
            'proof_1_no' => ['nullable', 'string', Rule::unique('member_bank_details', 'proof_1_no')->ignore($member->id, 'member_id'),
            ],
            'proof_1_type' => 'nullable|string|max:50',
            'proof_1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            'proof_2_no' => ['nullable', 'string', Rule::unique('member_bank_details', 'proof_2_no')->ignore($member->id, 'member_id'),
            ],
            'proof_2_type' => 'nullable|string|max:50',
            'proof_2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // **Handle File Uploads Efficiently**
        $bankDetail_validated['photo'] = $this->handleFileUpload($request, 'photo', $member->bankDetail, 'uploads/member');
        $bankDetail_validated['signature'] = $this->handleFileUpload($request, 'signature', $member->bankDetail, 'uploads/member');
        $nominee_validated['nominee_image'] = $this->handleFileUpload($request, 'nominee_image', $member->nominee, 'uploads/nominees');
        $nominee_validated['nominee_signature'] = $this->handleFileUpload($request, 'nominee_signature', $member->nominee, 'uploads/nominees');
        $bankDetail_validated['proof_1_image'] = $this->handleFileUpload($request, 'proof_1_image', $member->bankDetail, 'uploads/bank_proofs');
        $bankDetail_validated['proof_2_image'] = $this->handleFileUpload($request, 'proof_2_image', $member->bankDetail, 'uploads/bank_proofs');

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

        return redirect()->back()->with('success', 'Employe updated successfully');
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
         $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}