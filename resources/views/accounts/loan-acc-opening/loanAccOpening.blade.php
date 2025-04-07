<div class="modal fade" id="loanAccOpeningModal" tabindex="-1" aria-labelledby="loanAccOpeningModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" action="{{route('member-loan-accounts.store')}}" id="memberLoanAccForm">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <input type="hidden" id="loanAccId" name="id">
                    <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loanAccOpeningModalLabel">Add Loan Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="mx-auto p-5 my-model text-white">
                        <div class="row mb-2">
                            @isset($ledgers)
                            @if ($ledgers->isNotEmpty())
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="ledgerId">Ledger</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="ledgerId" name="ledger_id" class="w-100 px-2 py-1 @error('ledger_id') is-invalid @enderror">
                                    @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"  
                                        {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}>
                                        {{ $ledger->name }}
                                        </option>
                                    @endforeach
                                </select>
                                 @error('ledger_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @endif
                            @endisset
                            <div class="col-2 d-none d-xl-block">
                                <label for="photoCopy">Photo Copy</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="photo" id="photoCopy" class="w-100 px-2 py-1 @error('photo') is-invalid @enderror" value="{{ old('photo') }}" type="file" accept="image/*"
                                placeholder="Photo Copy">
                                @error('photo')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                             @isset($members)
                            @if ($members->isNotEmpty())
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="memberId">Member</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="memberId" name="member_id" class="w-100 px-2 py-1">
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}"  
                                        {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                 @error('member_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @endif
                            @endisset
                            <div class="col-2 d-none d-xl-block">
                                <label for="signCopy">Signature Copy</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                 <input name="signature" id="signCopy" class="w-100 px-2 py-1 @error('signature') is-invalid @enderror" value="{{ old('signature') }}" type="file" accept="image/*"
                                placeholder="Nominee Photo">
                                @error('signature')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                           @isset($accounts)
                            @if ($accounts->isNotEmpty())
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="accountId">Account</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="accountId" name="account_id" class="w-100 px-2 py-1 @error('account_id') is-invalid @enderror">
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"  
                                        {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                                 @error('account_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @endif
                            @endisset
                            <div class="col-2 d-none d-xl-block">
                                <label for="accNo">Account No.</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="acc_no" id="accNo" class="w-100 px-2 py-1 @error('acc_no') is-invalid @enderror" value="{{ old('acc_no') }}" type="text" placeholder="Account No.">
                                @error('acc_no')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                 <input name="name" id="name" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Name">
                                @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="loanType">Loan Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="loan_type" id="loanType" class="w-100 px-2 py-1 @error('loan_type') is-invalid @enderror">
                                    <option value="select">------ Select Loan Type ------</option>
                                    <option value="Personal Loan" {{ old('loan_type') == 'Personal Loan' ? 'selected' : '' }}>Personal Loan</option>
                                    <option value="Home Loan" {{ old('loan_type') == 'Home Loan' ? 'selected' : '' }}>Home Loan</option>
                                    <option value="Auto Loan" {{ old('loan_type') == 'Auto Loan' ? 'selected' : '' }}>Auto Loan</option>
                                    <option value="Business Loan" {{ old('loan_type') == 'Business Loan' ? 'selected' : '' }}>Business Loan</option>
                                    <option value="Gold Loan" {{ old('loan_type') == 'Gold Loan' ? 'selected' : '' }}>Gold Loan</option>
                                </select>
                                 @error('loan_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="interestRate">Interest Rate</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="interest_rate" id="interestRate" class="w-100 px-2 py-1 @error('interest_rate') is-invalid @enderror" value="{{ old('interest_rate') }}" type="number" placeholder="Interest Rate">
                                @error('interest_rate')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="acStartDate">Acc Start Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="acStartDate" name="ac_start_date" class="w-100 px-2 py-1 @error('ac_start_date') is-invalid @enderror" value="{{ old('ac_start_date') }}" type="date" placeholder="Acc Start Date">
                                @error('ac_start_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="emiAmount">EMI Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="emi_amount" id="emiAmount" class="w-100 px-2 py-1 @error('emi_amount') is-invalid @enderror" value="{{ old('emi_amount') }}" type="number" placeholder="EMI Amount">
                                @error('emi_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="openBalance">Open Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                               <input name="open_balance" id="openBalance" class="w-100 px-2 py-1 @error('open_balance') is-invalid @enderror" value="{{ old('open_balance') }}" type="number" placeholder="Open Balance ">
                                @error('open_balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="balance">Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="balance" id="balance" class="w-100 px-2 py-1 @error('balance') is-invalid @enderror" value="{{ old('balance') }}" type="number" placeholder="Balance">
                                @error('balance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="purpose">Purpose</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                 <select id="purpose" name="purpose" class="w-100 px-2 py-1">
                                    <option value="select">------ Select Loan Type ------</option>
                                    <option value="Agriculture" {{ old('purpose') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                                    <option value="Construction" {{ old('purpose') == 'Construction' ? 'selected' : '' }}>Construction</option>
                                    <option value="Cottage" {{ old('purpose') == 'Cottage' ? 'selected' : '' }}>Cottage</option>
                                    <option value="SSI Unit" {{ old('purpose') == 'SSI Unit' ? 'selected' : '' }}>SSI Unit</option>
                                    <option value="Dairy" {{ old('purpose') == 'Dairy' ? 'selected' : '' }}>Dairy</option>
                                </select>
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="principalAmount">Principle Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="principal_amount" id="principalAmount" class="w-100 px-2 py-1 @error('principal_amount') is-invalid @enderror" value="{{ old('principal_amount') }}" type="number" placeholder="Principle Amount">
                                @error('principal_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="startDate">Start Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="start_date" id="startDate" class="w-100 px-2 py-1 @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" type="date" placeholder="Start Date">
                                @error('start_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="endDate">End Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="end_date" id="endDate" class="w-100 px-2 py-1 @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" type="date" placeholder="End Date">
                                @error('end_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="tenure">Tenure</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="tenure" id="tenure" class="w-100 px-2 py-1 @error('tenure') is-invalid @enderror" value="{{ old('tenure') }}" type="number" placeholder="Tenure">
                                @error('tenure')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="priority">Priority</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="priority" id="priority" class="w-100 px-2 py-1 @error('priority') is-invalid @enderror" value="{{ old('priority') }}" type="number" placeholder="Priority">
                                @error('priority')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="loanAmount">Loan Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="loan_amount" id="loanAmount" class="w-100 px-2 py-1 @error('loan_amount') is-invalid @enderror" value="{{ old('loan_amount') }}" type="number" placeholder="Loan Amount">
                                @error('loan_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="collateralType">Collateral Type</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="collateralType" name="collateral_type" class="w-100 px-2 py-1 @error('collateral_type') is-invalid @enderror">
                                    <option value="select">------ Select Collateral Value ------</option>
                                    <option value="Gold" {{ old('collateral_type') == 'Gold' ? 'selected' : '' }}>Gold</option>
                                    <option value="Property" {{ old('collateral_type') == 'Property' ? 'selected' : '' }}>Property</option>
                                    <option value="Vehicle" {{ old('collateral_type') == 'Vehicle' ? 'selected' : '' }}>Vehicle</option>
                                    <option value="None" {{ old('collateral_type') == 'None' ? 'selected' : '' }}>None</option>
                                </select>
                                @error('collateral_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="collateralValue">Collateral Value</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="collateral_value" id="collateralValue" class="w-100 px-2 py-1 @error('collateral_value') is-invalid @enderror" value="{{ old('collateral_value') }}" type="number" placeholder="Collateral Value">
                                 @error('collateral_value')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block text-end">
                                <label for="pageNo">Page No.</label>
                            </div>
                            <div class="col-3 pe-0 pe-xl-5">
                                <input name="page_no" id="pageNo" class="w-100 px-2 py-1 @error('page_no') is-invalid @enderror" value="{{ old('page_no') }}" type="text" placeholder="Page No.">
                                @error('page_no')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col ps-5">
                                <input name="is_loss_asset" {{ old('is_loss_asset') ? 'checked' : '' }} id="isLossAsset" class="w-100 px-2 py-1 @error('is_loss_asset') is-invalid @enderror" value="1" type="checkbox" >
                                <label for="isLossAsset">Is Loss Asset</label>
                                @error('is_loss_asset')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <input name="case_flag" {{ old('case_flag') ? 'checked' : '' }} id="caseFlag" class="w-100 px-2 py-1 @error('case_flag') is-invalid @enderror" value="1" type="checkbox" >
                                <label for="caseFlag">Case Flag</label>
                                @error('case_flag')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="add_to_demand" {{ old('add_to_demand') ? 'checked' : '' }} id="addToDemand" class="w-100 px-2 py-1 @error('add_to_demand') is-invalid @enderror" value="1" type="checkbox" >
                                <label for="addToDemand">Add to Demand</label>
                                @error('add_to_demand')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="interest">Interest</label>
                            </div>
                            <div class="col-2 pe-0 pe-xl-5">
                                <input name="interest" id="interest" class="w-100 px-2 py-1 @error('interest') is-invalid @enderror" value="{{ old('interest') }}" type="number" placeholder="Interest">
                                @error('interest')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="penalInterest">Penal Interest</label>
                            </div>
                            <div class="col-2 pe-0 pe-xl-5">
                                <input name="penal_interest" id="penalInterest" class="w-100 px-2 py-1 @error('penal_interest') is-invalid @enderror" value="{{ old('penal_interest') }}" type="number" placeholder="Penal Interest">
                                @error('penal_interest')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="openInterest">Open Interest</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="open_interest" id="openInterest" class="w-100 px-2 py-1 @error('open_interest') is-invalid @enderror" value="{{ old('open_interest') }}" type="number" placeholder="Open Interest">
                                @error('open_interest')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="insurance">Insurance</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="insurance" id="insurance" class="w-100 px-2 py-1 @error('insurance') is-invalid @enderror" value="{{ old('insurance') }}" type="number" placeholder="Insurance">
                                @error('insurance')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="insuranceDate">Insurance Date</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="insurance_date" id="insuranceDate" class="w-100 px-2 py-1 @error('insurance_date') is-invalid @enderror" value="{{ old('insurance_date') }}" type="date" placeholder="Account No.">
                                @error('insurance_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-2  ps-5 d-none d-xl-block">
                                <label for="postage">Postage</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="postage" id="postage" class="w-100 px-2 py-1 @error('postage') is-invalid @enderror" value="{{ old('postage') }}" type="number" placeholder="Postage">
                                @error('postage')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="noticeFee">Notice Fee</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="notice_fee" id="noticeFee" class="w-100 px-2 py-1 @error('notice_fee') is-invalid @enderror" value="{{ old('notice_fee') }}" type="number" placeholder="Notice Fee">
                                @error('notice_fee')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>


                        <!-- Tabs -->
                        <div class="info-tabs border rounded mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 active text-info" id="nominee-tab"
                                        data-bs-toggle="tab" data-bs-target="#nominee-tab-pane" type="button" role="tab"
                                        aria-controls="nominee-tab-pane" aria-selected="true">Nominee Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="goldLoan-tab" data-bs-toggle="tab"
                                        data-bs-target="#goldLoan-tab-pane" type="button" role="tab"
                                        aria-controls="goldLoan-tab-pane" aria-selected="false">Gold Loan
                                        Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="guarantors-tab" data-bs-toggle="tab"
                                        data-bs-target="#guarantors-tab-pane" type="button" role="tab"
                                        aria-controls="guarantors-tab-pane" aria-selected="false">Guarantors
                                        Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="installments-tab" data-bs-toggle="tab"
                                        data-bs-target="#installments-tab-pane" type="button" role="tab"
                                        aria-controls="installments-tab-pane" aria-selected="false">Installments
                                        Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="resolution-tab" data-bs-toggle="tab"
                                        data-bs-target="#resolution-tab-pane" type="button" role="tab"
                                        aria-controls="resolution-tab-pane" aria-selected="false">Resolution
                                        Detail</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!-- Nominee Details -->
                                 <div class="tab-pane fade show active p-3" id="nominee-tab-pane" role="tabpanel"
                                    aria-labelledby="nominee-tab" tabindex="0">

                                    <div class="row px-5">
                                        <div class="col">
                                            <h6 class="text-center">Nominee 1</h6>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee1Name">Name</label>
                                                </div>
                                                <div class="col">
                                                    <input name="nominees[0][nominee_name]" id="nominee1Name" class="w-100 px-2 py-1 @error('nominees.0.nominee_name') is-invalid @enderror" type="text"
                                                        placeholder="Nominee Name" value="{{ old('nominees.0.nominee_name') }}">
                                                        @error('nominees.0.nominee_name')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="marathiNominee1Name">नाव</label>
                                                </div>
                                                <div class="col">
                                                    <input name="nominees[0][nominee_naav]" id="marathiNominee1Name" class="w-100 px-2 py-1 @error('nominees.0.nominee_naav') is-invalid @enderror" type="text" value="{{ old('nominees.0.nominee_naav') }}"
                                                        placeholder="नाव">
                                                        @error('nominees.0.nominee_naav')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee1Age">Age</label>
                                                </div>
                                                <div class="col">
                                                    <input name="nominees[0][nominee_age]" id="nominee1Age" class="w-100 px-2 py-1 @error('nominees.0.nominee_age') is-invalid @enderror" type="number"
                                                        placeholder="Age" value="{{ old('nominees.0.nominee_age') }}">
                                                        @error('nominees.0.nominee_age')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee1Gender">Gender</label>
                                                </div>
                                                <div class="col">
                                                    <select id="nominee1Gender" name="nominees[0][nominee_gender]" class="w-100 px-2 py-1 @error('nominees.0.nominee_gender') is-invalid @enderror">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    @error('nominees.0.nominee_gender')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee1Relation">Relation</label>
                                                </div>
                                                <div class="col">
                                                    <select id="nominee1Relation" name="nominees[0][relation]" class="w-100 px-2 py-1 @error('nominees.0.relation') is-invalid @enderror">
                                                        <option value="husband">Husband</option>
                                                        <option value="wife">Wife</option>
                                                        <option value="father">Father</option>
                                                        <option value="mother">Mother</option>
                                                        <option value="brother">Brother</option>
                                                        <option value="sister">Sister</option>
                                                        <option value="son">Son</option>
                                                        <option value="daughter">Daughter</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    @error('nominees.0.relation')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-2 d-none d-xl-block">
                                                        <label for="nominee1Photo">Photo</label>
                                                    </div>
                                                    <div class="col">
                                                        <input name="nominees[0][nominee_image]" id="nominee1Photo" value="{{ old('nominees.0.nominee_image') }}" class="w-100 px-2 py-1 @error('nominees.0.nominee_image') is-invalid @enderror" type="file"
                                                            accept="image/*" placeholder="Nominee Photo">
                                                            @error('nominees.0.nominee_image')
                                                            <div class="invalid-feedback">{{$message}}</div>
                                                            @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col">
                                            <h6 class="text-center">Nominee 2</h6>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee2Name">Name</label>
                                                </div>
                                                <div class="col">
                                                    <input name="nominees[1][nominee_name]" id="nominee2Name" class="w-100 px-2 py-1 @error('nominees.1.nominee_name') is-invalid @enderror" value="{{ old('nominees.1.nominee_name') }}" type="text"
                                                        placeholder="Nominee Name">
                                                        @error('nominees.1.nominee_name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="marathiNominee2Name">नाव</label>
                                                </div>
                                                <div class="col">
                                                    <input name="nominees[1][nominee_naav]" id="marathiNominee2Name" class="w-100 px-2 py-1 @error('nominees.1.nominee_naav') is-invalid @enderror" type="text" value="{{ old('nominees.1.nominee_naav') }}"
                                                        placeholder="नाव">
                                                        @error('nominees.1.nominee_naav')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee2Age">Age</label>
                                                </div>
                                                <div class="col">
                                                    <input name="nominees[1][nominee_age]" id="nominee2Age" class="w-100 px-2 py-1 @error('nominees.1.nominee_age') is-invalid @enderror" type="number"
                                                        placeholder="Age" value="{{ old('nominees.1.nominee_age') }}">
                                                        @error('nominees.1.nominee_age')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee2Gender">Gender</label>
                                                </div>
                                                <div class="col">
                                                    <select id="nominee2Gender" name="nominees[1][nominee_gender]" class="w-100 px-2 py-1 @error('nominees.1.nominee_gender') is-invalid @enderror">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    @error('nominees.1.nominee_gender')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-2 d-none d-xl-block">
                                                    <label for="nominee2Relation">Relation</label>
                                                </div>
                                                <div class="col">
                                                    <select id="nominee2Relation" name="nominees[1][relation]" class="w-100 px-2 py-1 @error('nominees.1.relation') is-invalid @enderror">
                                                        <option value="husband">Husband</option>
                                                        <option value="wife">Wife</option>
                                                        <option value="father">Father</option>
                                                        <option value="mother">Mother</option>
                                                        <option value="brother">Brother</option>
                                                        <option value="sister">Sister</option>
                                                        <option value="son">Son</option>
                                                        <option value="daughter">Daughter</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    @error('nominees.1.relation')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-2 d-none d-xl-block">
                                                        <label for="nominee2Photo">Photo</label>
                                                    </div>
                                                    <div class="col">
                                                        <input name="nominees[1][nominee_image]" id="nominee2Photo" value="{{ old('nominees.1.nominee_image') }}" class="w-100 px-2 py-1 @error('nominees.1.nominee_image') is-invalid @enderror" type="file"
                                                            accept="image/*" placeholder="Nominee Photo">
                                                            @error('nominees.1.nominee_image')
                                                            <div class="invalid-feedback">{{$message}}</div>
                                                            @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gold Loan Tab -->
                                <div class="tab-pane fade p-3" id="goldLoan-tab-pane" role="tabpanel"
                                    aria-labelledby="goldLoan-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="goldWeight">Gold Weight</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="goldWeight" name="gold_weight" id="accNo" class="w-100 px-2 py-1 @error('gold_weight') is-invalid @enderror" value="{{ old('gold_weight') }}" type="number" placeholder="Gold Weight">
                                            @error('gold_weight')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="goldPurity">Gold Purity</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select id="goldPurity" name="gold_purity" class="w-100 px-2 py-1 @error('city') is-invalid @enderror">
                                                <option value="18K" {{ old('gold_purity') == '18K' ? 'selected' : '' }}>18K</option>
                                                <option value="22K" {{ old('gold_purity') == '22K' ? 'selected' : '' }}>22K</option>
                                                <option value="24K" {{ old('gold_purity') == '24K' ? 'selected' : '' }}>24K</option>
                                            </select>
                                            @error('gold_purity')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="marketValue">Market Value</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="market_value" id="marketValue" class="w-100 px-2 py-1 @error('market_value') is-invalid @enderror" value="{{ old('market_value') }}" type="number" placeholder="Market Value">
                                            @error('market_value')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="pledgedDate">Pledge Date</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="pledged_date" id="pledgedDate" class="w-100 px-2 py-1 @error('pledged_date') is-invalid @enderror" value="{{ old('pledged_date') }}" type="date" placeholder="Pledge Date">
                                            @error('pledged_date')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="releaseStatus">Release State</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                           <select id="releaseStatus" name="release_status" class="w-100 px-2 py-1 @error('release_status') is-invalid @enderror">
                                                <option value="Pledged" {{ old('release_status') == 'Pledged' ? 'selected' : '' }}>Pledged</option>
                                                <option value="Released" {{ old('release_status') == 'Released' ? 'selected' : '' }}>Released</option>
                                            </select>
                                             @error('release_status')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 ps-5 d-none d-xl-block">
                                            <label for="releaseDate">Release Date</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="release_date" id="releaseDate" class="w-100 px-2 py-1 @error('release_date') is-invalid @enderror" value="{{ old('release_date') }}" type="date" placeholder="Release Date">
                                            @error('release_date')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Guarantors Tab -->
                                <div class="tab-pane fade p-3" id="guarantors-tab-pane" role="tabpanel"
                                    aria-labelledby="guarantors-tab" tabindex="0">
                                    <div class="row mb-1">
                                        @isset($members)
                                        @if ($members->isNotEmpty())
                                            <div class="col-2 ps-5 d-none d-xl-block">
                                                <label for="grMemberId">Member</label>
                                            </div>
                                            <div class="col pe-0 pe-xl-5">
                                                <select id="grMemberId" name="gr_member_id" class="w-100 px-2 py-1">
                                                    <option value="select" disabled>------ Select Member ------</option>
                                                    @foreach ($members as $member)
                                                        <option value="{{ $member->id }}"  
                                                        {{ old('member_id') == $member->id ? 'selected' : '' }}
                                                        >
                                                        {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('member_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                        @endisset
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="guarantorType">Guarantor Type</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select id="guarantorType" name="guarantor_type" class="w-100 px-2 py-1 @error('guarantor_type') is-invalid @enderror"">
                                                <option value="Primary" {{ old('guarantor_type') == 'Male' ? 'selected' : '' }}>Primary</option>
                                                <option value="Secondary" {{ old('guarantor_type') == 'Male' ? 'selected' : '' }}>Secondary</option>
                                                <option value="Tertiary" {{ old('gender') == 'Male' ? 'selected' : '' }}>Tertiary</option>
                                            </select>
                                            @error('guarantor_type')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="addedOn">Added On</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="added_on" id="addedOn" class="w-100 px-2 py-1 @error('added_on') is-invalid @enderror" value="{{ old('added_on') }}" type="date" placeholder="Added On">
                                            @error('added_on')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="releasedOn">Release Date</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="released_on" id="releasedOn" class="w-100 px-2 py-1 @error('released_on') is-invalid @enderror" value="{{ old('released_on') }}" type="date" placeholder="Release Date">
                                            @error('released_on')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Installments Tab -->
                                <div class="tab-pane fade p-3 px-5" id="installments-tab-pane" role="tabpanel"
                                    aria-labelledby="installments-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="installmentType">Installment Type</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <select id="installmentType" name="installment_type" class="w-100 px-2 py-1  @error('installment_type') is-invalid @enderror">
                                                <option value="select">------ Select Installment Type ------</option>
                                                <option value="Monthly" {{ old('installment_type') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                <option value="Quarterly" {{ old('installment_type') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                <option value="Yearly" {{ old('installment_type') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                            </select>
                                            @error('installment_type')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="matureDate">Mature Date</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="matureDate" name="mature_date" class="w-100 px-2 py-1 @error('mature_date') is-invalid @enderror" value="{{ old('mature_date') }}" type="date" placeholder="Mature Date">
                                            @error('mature_date')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="firstInstallmentDate">First Installment Date</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="firstInstallmentDate" name="first_installment_date" class="w-100 px-2 py-1 @error('first_installment_date') is-invalid @enderror" value="{{ old('first_installment_date') }}" type="date" placeholder="First Installment Date">
                                            @error('first_installment_date')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="totalInstallments">Total Installments</label>
                                        </div>
                                        <div class="col-4">
                                            <input name="total_installments" id="totalInstallments" class="w-100 px-2 py-1 @error('total_installments') is-invalid @enderror" value="{{ old('total_installments') }}" type="number" placeholder="Total Installments">
                                            @error('total_installments')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="installmentAmount">Installment Amount</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="installmentAmount" name="installment_amount" class="w-100 px-2 py-1 @error('installment_amount') is-invalid @enderror" value="{{ old('installment_amount') }}" type="number" placeholder="Installment Amount">
                                            @error('installment_amount')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="installmentWithInterest">Installment with Interest</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input id="installmentWithInterest" name="installment_with_interest" class="w-100 px-2 py-1 @error('installment_with_interest') is-invalid @enderror" value="{{ old('installment_with_interest') }}" type="number" placeholder="Installment with Interest">
                                            @error('installment_with_interest')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 d-none d-xl-block">
                                            <label for="installmentsPaid">Total Installments Paid</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="installmentsPaid" name="total_installments_paid" class="w-100 px-2 py-1 @error('total_installments_paid') is-invalid @enderror" value="{{ old('total_installments_paid') }}" type="number" placeholder="Total Installments Paid">
                                            @error('total_installments_paid')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Resolution Tab -->
                                <div class="tab-pane fade p-3 px-5" id="resolution-tab-pane" role="tabpanel"
                                    aria-labelledby="resolution-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 d-none d-xl-block">
                                            <label for="resolutionNo">Resolution No.</label>
                                        </div>
                                        <div class="col-4">
                                            <input id="resolutionNo" name="resolution_no" class="w-100 px-2 py-1 @error('resolution_no') is-invalid @enderror" value="{{ old('resolution_no') }}" type="text" placeholder="Resolution No.">
                                            @error('resolution_no')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 d-none d-xl-block">
                                            <label for="resolutionDate">Resolution Date</label>
                                        </div>
                                        <div class="col-4">
                                            <input name="resolution_date" id="resolutionDate" class="w-100 px-2 py-1 @error('resolution_date') is-invalid @enderror" value="{{ old('resolution_date') }}" type="date" placeholder="Resolution Date">
                                            @error('resolution_date')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>