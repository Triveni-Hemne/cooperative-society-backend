<div class="modal fade" id="personalDemandPostModal" tabindex="-1" aria-labelledby="personalDemandModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('demand-posting.store') }}" id="personalDemandModalForm" class="needs-validation"
                novalidate>
                <input type="hidden" id="personalDemandId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                     @csrf
                        @if(Session::has('error'))
                        <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                        @endif
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" ><i
                            class="bi bi-calendar-plus-fill me-2"></i><span id="personalDemandModalLabel">Add Personal/All Demand Post</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm py-0">
                        <div class="row g-3 pb-3">
                        <div class="col-md-3">
                        {{-- Created By --}}
                        <div class="form-floating ">
                            <input id="createdBy" class="form-control" value="{{ $user->name }}" type="text"
                                    readonly >
                            <label for="createdBy" class="form-label required">Created By</label>
                            <input name="created_by" id="createdById" class="form-control" value="{{ $user->id }}" type="text"
                                    hidden >
                            @error('created_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                         </div>
                        </div>
                         <div class="col-md-3">
                         <!-- Branch -->
                         @if(Auth::user()->role === 'Admin')
                            @if ($branches->isNotEmpty())
                                    <div class="form-floating ">
                                        <select name="branch_id" id="branch"
                                            class="form-select @error('branch_id') is-invalid @enderror" >
                                            <option value="" disabled selected>Select Branch</option>
                                            @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"  
                                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                            >
                                            {{ $branch->name }}
                                            </option>
                                        @endforeach
                            </select>
                            <label for="branch">Branch <span class="text-danger"> *</span></label>
                            @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        @else
                        <div class="alert alert-warning">
                            <strong>⚠️ No Branch available.</strong><br>
                            Please add Branch first.
                        </div>
                        @endif
                        @endif
                    </div>

                    <div class="col-md-3">
                        {{-- User Dropdown --}}
                        @isset($members)
                        @if ($members->isNotEmpty())
                        <div class="form-floating ">
                            <select name="member_id" id="member"
                                class="form-select @error('member_id') is-invalid @enderror" >
                                <option value=""   {{ old('member_id') ? '' : 'selected' }}>---------- Member Select ----------</option>
                                @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}</option>
                                @endforeach
                            </select>
                            <label for="member">Member</label>
                            @error('member_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <strong>⚠️ No members available.</strong><br>
                            Please add member first.
                        </div>
                        @endif
                        @endisset
                    </div>
                        
                        <div class="col-md-3">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <input name="month" id="month"
                                        class="form-control @error('month') is-invalid @enderror"
                                        value="{{ old('month') }}" type="month"  
                                placeholder="Month">
                                <label for="month" class="form-label ">Month</label>
                                @error('month')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <input name="from_date" id="fromDate"
                                        class="form-control @error('from_date') is-invalid @enderror"
                                        value="{{ old('from_date') }}" type="date" 
                                placeholder="From Date">
                                <label for="fromDate" class="form-label ">From Date</label>
                                @error('from_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <input name="to_date" id="toDate"
                                        class="form-control @error('to_date') is-invalid @enderror"
                                        value="{{ old('to_date') }}" type="date" 
                                placeholder="To Date">
                                <label for="toDate" class="form-label ">To Date</label>
                                @error('to_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                        {{-- <div class="col-md-6">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <input name="year" id="year"
                                        class="form-control @error('year') is-invalid @enderror"
                                        value="{{ old('year') }}" type="number"  
                                placeholder="Year">
                                <label for="year" class="form-label ">Year</label>
                                @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-3">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <input name="posting_date" id="postingDate"
                                        class="form-control @error('posting_date') is-invalid @enderror"
                                        value="{{ old('posting_date') }}" type="date" 
                                placeholder="Posting Date">
                                <label for="postingDate" class="form-label ">Posting Date</label>
                                @error('posting_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                        
                        <div class="col-md-3">
                        @isset($ledgers)
                            @if ($ledgers->isNotEmpty())
                            <div class="form-floating ">
                                <select name="ledger_id" id="ledger"
                                    class="form-select @error('user_id') is-invalid @enderror" >
                                    <option value="" disabled  {{ old('ledger_id') ? '' : 'selected' }}>---------- Ledger Select ----------</option>
                                    @foreach ($ledgers as $ledger)
                                    <option value="{{ $ledger->id }}" {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}>
                                        {{ $ledger->name }}</option>
                                    @endforeach
                                </select>
                                <label for="ledger">Ledger</label>
                                @error('ledger_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @else
                            <div class="alert alert-warning">
                                <strong>⚠️ No ledgers available.</strong><br>
                                Please add ledger first.
                            </div>
                            @endif
                        @endisset
                    </div>

                    <div class="col-md-3">
                        @isset($accounts)
                            @if ($accounts->isNotEmpty())
                            <div class="form-floating ">
                                <select name="account_id" id="account"
                                    class="form-select @error('account_id') is-invalid @enderror">
                                    <option value="" disabled  {{ old('account_id') ? '' : 'selected' }}>---------- General Account Select ----------</option>
                                    @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}</option>
                                    @endforeach
                                </select>
                                <label for="account">Account <span class="text-danger"> *</span></label>
                                @error('account_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @else
                            <div class="alert alert-warning">
                                <strong>⚠️ No Accounts available.</strong><br>
                                Please add Accounts first.
                            </div>
                            @endif
                        @endisset
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <select name="posting_type" id="postingType"
                                        class="form-control @error('posting_type') is-invalid @enderror"
                                        type="text"
                                placeholder="Posting Type.">
                                <option value="personal" {{ old('posting_type') == 'personal' ? 'selected' : '' }}>
                                    Personal</option>
                                <option value="bulk" {{ old('posting_type') == 'bulk' ? 'selected' : '' }}>
                                    Bulk</option>
                            </select>
                                <label for="postingType" class="form-label">Posting Type</label>
                                @error('posting_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                        <div class="col-md-3">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <input name="cheque_no" id="chequeNo"
                                        class="form-control @error('cheque_no') is-invalid @enderror"
                                        value="{{ old('cheque_no') }}" type="text"
                                placeholder="Cheque No.">
                                <label for="chequeNo" class="form-label">Check No.</label>
                                @error('cheque_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <select name="acc_type" id="acc_type"
                                        class="form-control @error('acc_type') is-invalid @enderror"
                                        type="text"
                                placeholder="Account Type.">
                                <option value="deposite" {{ old('acc_type') == 'deposite' ? 'selected' : '' }}>
                                    Deposite Account</option>
                                <option value="general" {{ old('acc_type') == 'deposite' ? 'selected' : '' }}>
                                    General Account</option>
                                <option value="loan" {{ old('acc_type') == 'deposite' ? 'selected' : '' }}>
                                            Loan Account</option>
                            </select>
                                <label for="acc_type" class="form-label">Account Type</label>
                                @error('acc_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-3">
                        <div class="form-floating ">
                            <div class="form-floating">
                            <input name="total_amount" id="totalAmount"
                                        class="form-control @error('total_amount') is-invalid @enderror"
                                        value="{{ old('total_amount') }}" type="number"
                                placeholder="Amount">
                                <label for="totalAmount" class="form-label">Amount</label>
                                @error('total_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-floating ">
                            <div class="form-check form-switch">
                                <input id="isTransferred" type="checkbox" name="is_transferred" value="1"
                                    {{ old('is_transferred') ? 'checked' : '' }}
                                    class="form-check-input @error('is_transferred') is-invalid @enderror">
                                <label class="form-check-label" for="isTransferred">Transfer</label>
                                @error('is_transferred')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Remark -->
                        <div class="form-floating ">
                            <textarea class="form-control @error('narration') is-invalid @enderror" placeholder="Narration" id="narration"
                            name="narration" style="height: 100px">{{ old('narration') }}</textarea>
                            <label for="narration">Narration</label>
                            @error('narration')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
                </div>

    <div class="modal-footer bg-white rounded-bottom-4 border-top">
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i>Cancel
        </button>
        <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-check-circle me-1"></i>Submit
        </button>
    </div>
    </form>
</div>
</div>
</div>