<div class="modal fade" id="depositAccOpeningModal" tabindex="-1" aria-labelledby="depositAccOpeningModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form  method="POST" action="{{route('member-depo-accounts.store')}}" id="depositAccModalForm" enctype="multipart/form-data">
            <input type="hidden" id="memberDepoAccountId" name="id">
            <input type="hidden" name="_method" id="formMethod" value="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="depositAccOpeningModalLabel">Add Deposit Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                      <div class="row mb-2">
                        @isset($ledgers)
                        <div class="col-2 ps-5 d-none d-xl-block">
                             <label for="ledgerId">Ledger</label>
                        </div>
                        <div class="col pe-0 pe-xl-5">
                            @if ($ledgers->isNotEmpty())
                            <select id="ledgerId" name="ledger_id" class="w-100 px-2 py-1">
                                <option value="select" >------ Select Ledger ------</option>
                                @foreach ($ledgers as $ledger)
                                    <option value="{{ $ledger->id }}"  
                                    {{ old('ledger_id') == $ledger->id ? 'selected' : '' }}
                                    >
                                    {{ $ledger->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ledger_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @else
                            <select class="w-100 px-2 py-1" disabled>
                                <option>No ledgers available. Please add ledgers first.</option>
                            </select>
                            <small class="text-danger">⚠️ You must add ledgers before submitting the form.</small>
                            @endif
                        </div>
                         @endisset
                            <div class="col-2 d-none d-xl-block">
                                <label for="photoCopy">Photo Copy</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                 <input name="photo" id="photoCopy" class="w-100 px-2 py-1" type="file" accept="image/*">
                                    @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                         @isset($members)
                         <div class="col-2 ps-5 d-none d-xl-block">
                             <label for="memberId">Member</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                @if ($members->isNotEmpty())
                                <select id="memberId" name="member_id" class="w-100 px-2 py-1">
                                    <option value="select" >------ Select Member ------</option>
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
                                @else
                                    <select class="w-100 px-2 py-1" disabled>
                                        <option>No members available. Please add members first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add members before submitting the form.</small>
                                @endif
                            </div>
                          @endisset
                            <div class="col-2 d-none d-xl-block">
                                <label for="signCopy">Signature Copy</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="signature" id="signCopy" class="w-100 px-2 py-1" type="file" accept="image/*,.pdf"
                                    placeholder="Signature Copy">
                                @error('signature')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            @isset($accounts)
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="accountId">Account</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                @if ($accounts->isNotEmpty())
                                <select id="accountId" name="account_id" class="w-100 px-2 py-1">
                                    <option value="select" >------ Select Account ------</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"  
                                        {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @else
                                <select class="w-100 px-2 py-1" disabled>
                                        <option>No general accounts available. Please add general accounts first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add general accounts before submitting the form.</small>
                                @endif
                            </div>
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
                                <label for="interestRate">Interest Rate</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="interest_rate" id="interestRate" class="w-100 px-2 py-1 @error('interest_rate') is-invalid @enderror" value="{{ old('interest_rate') }}" type="number"
                                    placeholder="Interest Rate">
                                    @error('interest_rate')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="interestPayable">Interst Payable</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="interest_payable" id="interestPayable" class="w-100 px-2 py-1 @error('interest_payable') is-invalid @enderror" value="{{ old('interest_payable') }}" type="number"
                                    placeholder="Interst Payable">
                                    @error('interest_payable')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="acStartDate">Act Start Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="ac_start_date" id="acStartDate" class="w-100 px-2 py-1 @error('ac_start_date') is-invalid @enderror" value="{{ old('ac_start_date') }}" type="date" placeholder="Act Start Date">
                                @error('ac_start_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="accClosingDate">Acc. Closing Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="acc_closing_date" id="accClosingDate" class="w-100 px-2 py-1 @error('acc_closing_date') is-invalid @enderror" value="{{ old('acc_closing_date') }}" type="date"
                                    placeholder="Acc. Closing Date">
                                    @error('acc_closing_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="openBalance">Open Balance</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="open_balance" id="openBalance" class="w-100 px-2 py-1 @error('open_balance') is-invalid @enderror" value="{{ old('open_balance') }}" type="number"
                                    placeholder="Open Balance">
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
                         @isset($agents)
                         <div class="col-2 ps-5 d-none d-xl-block">
                             <label for="agentId">Agent</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                @if ($agents->isNotEmpty())
                                <select id="agentId" name="agent_id" class="w-100 px-2 py-1">
                                    <option value="select" >------ Select Agent ------</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}"  
                                        {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->user->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agent_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    @else
                                <select class="w-100 px-2 py-1" disabled>
                                        <option>No agents available. Please add agents first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add agents before submitting the form.</small>
                                    @endif
                                </div>
                            @endisset
                            <div class="col-2 d-none d-xl-block">
                                <label for="pageNo">Page No.</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="pageNo" name="page_no" id="pageNo" class="w-100 px-2 py-1 @error('page_no') is-invalid @enderror" value="{{ old('page_no') }}" type="number" placeholder="Page No.">
                                @error('page_no')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="depositType">Deposit Type</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="depositType" name="deposit_type" class="w-100 px-2 py-1">
                                    <option value="select" disabled>------ Select Deposit Type ------</option>
                                    <option value="savings"  {{ old('deposit_type') == 'savings' ? 'selected' : '' }}>Savings</option>
                                    <option value="fd" {{ old('deposit_type') == 'fd' ? 'selected' : '' }}>Fixed Deposit</option>
                                    <option value="rd" {{ old('deposit_type') == 'rd' ? 'selected' : '' }}>Recurring Deposit</option>
                                </select>
                                @error('deposit_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <input id="closingFlag" type="checkbox" name="closing_flag" value="1" {{ old('closing_flag') ? 'checked' : '' }} class="@error('closing_flag') is-invalid @enderror" id="closingFlag">
                                <label for="closingFlag">Closing Flag</label>
                                @error('closing_flag')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="addToDemand" type="checkbox" name="add_to_demand" value="1" {{ old('add_to_demand') ? 'checked' : '' }} class="@error('add_to_demand') is-invalid @enderror" id="addDemand">
                                <label for="addDemand">Add to Demand</label>
                                @error('add_to_demand')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="installmentType">Installment Type</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="installmentType" name="installment_type" class="w-100 px-2 py-1 @error('installment_type') is-invalid @enderror" >
                                    <option value="select" disabled>------ Select Installment Type ------</option>
                                    <option value="Monthly" {{ old('installment_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Quarterly" {{ old('installment_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="Yearly" {{ old('installment_type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('installment_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="installmentAmount">Installment Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="installment_amount" id="installmentAmount" class="w-100 px-2 py-1 @error('installment_amount') is-invalid @enderror" type="number" value="{{ old('description') }}"
                                    placeholder="Installment Amount">
                                    @error('installment_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="totalInstallments">Total Installments</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="total_installments" id="totalInstallments" class="w-100 px-2 py-1 @error('total_installments') is-invalid @enderror" type="number" value="{{ old('total_installments') }}"
                                    placeholder="Total Installments">
                                    @error('total_installments')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="totalPayableAmount">Total Payable Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="total_payable_amount" id="totalPayableAmount" class="w-100 px-2 py-1 @error('total_payable_amount') is-invalid @enderror" type="number" value="{{ old('total_payable_amount') }}"
                                    placeholder="Total Payable Amount">
                                    @error('total_payable_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="installmentsPaid">Total Installments Paid</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="total_installments_paid" id="installmentsPaid" class="w-100 px-2 py-1 @error('total_installments_paid') is-invalid @enderror" type="number" value="{{ old('total_installments_paid') }}"
                                    placeholder="Total Installments Paid">
                                    @error('total_installments_paid')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="openInterest">Open Interest</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="open_interest" id="openInterest" class="w-100 px-2 py-1 @error('open_interest') is-invalid @enderror" type="number" placeholder="Total Payable Amount" value="{{ old('open_interest') }}">
                                    @error('open_interest')
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
                                    <button class="nav-link w-100 text-info" id="rd-tab" data-bs-toggle="tab"
                                        data-bs-target="#rd-tab-pane" type="button" role="tab"
                                        aria-controls="rd-tab-pane" aria-selected="false">RD Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="fd-tab" data-bs-toggle="tab"
                                        data-bs-target="#fd-tab-pane" type="button" role="tab"
                                        aria-controls="fd-tab-pane" aria-selected="false">FD Detail</button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button class="nav-link w-100 text-info" id="saving-tab" data-bs-toggle="tab"
                                        data-bs-target="#saving-tab-pane" type="button" role="tab"
                                        aria-controls="saving-tab-pane" aria-selected="false">Saving Detail</button>
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

                                <!-- RD Tab -->
                                <div class="tab-pane fade p-3" id="rd-tab-pane" role="tabpanel" aria-labelledby="rd-tab"
                                    tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="openingInterest">Opening Interest</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="open_interest_rd" id="openingInterest" class="w-100 px-2 py-1 @error('open_interest_rd') is-invalid @enderror" value="{{ old('open_interest_rd') }}" type="number"
                                                placeholder="Opening Interest">
                                                @error('open_interest_rd')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="rdTermMonths">RD Term Months</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="rd_term_months" id="rdTermMonths" class="w-100 px-2 py-1 @error('rd_term_months') is-invalid @enderror" value="{{ old('rd_term_months') }}" type="number"
                                                placeholder="RD Term Months">
                                                @error('rd_term_months')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="rdMaturityAmount">Maturity Amount</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="maturity_amount_rd" id="rdMaturityAmount" class="w-100 px-2 py-1 @error('maturity_amount_rd') is-invalid @enderror" value="{{ old('maturity_amount_rd') }}" type="number"
                                                placeholder="RD Term Months">
                                                @error('maturity_amount_rd')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- FD Tab -->
                                <div class="tab-pane fade p-3" id="fd-tab-pane" role="tabpanel" aria-labelledby="fd-tab"
                                    tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="fdMaturityAmount">Maturity Amount</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="maturity_amount_fd" id="fdMaturityAmount" class="w-100 px-2 py-1 @error('maturity_amount_fd') is-invalid @enderror" value="{{ old('maturity_amount_fd') }}" type="number"
                                                placeholder="Maturity Amount">
                                                @error('maturity_amount_fd')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="fdTermMonths">FD Term Months</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="fd_term_months" id="fdTermMonths" class="w-100 px-2 py-1 @error('fd_term_months') is-invalid @enderror" value="{{ old('fd_term_months') }}" type="number"
                                                placeholder="FD Term Months">
                                                @error('fd_term_months')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- saving Tab -->
                                <div class="tab-pane fade p-3" id="saving-tab-pane" role="tabpanel"
                                    aria-labelledby="saving-tab" tabindex="0">
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="svBalance">Balance</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="balance_sv" id="svBalance" class="w-100 px-2 py-1 @error('balance_sv') is-invalid @enderror" value="{{ old('balance') }}" type="text"
                                                placeholder="balance_sv">
                                                @error('balance_sv')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 ps-5 d-none d-xl-block">
                                            <label for="svInterestRate">Interest Rate</label>
                                        </div>
                                        <div class="col-4 pe-0 pe-xl-5">
                                            <input name="interest_rate_sv" id="svInterestRate" class="w-100 px-2 py-1 @error('interest_rate_sv') is-invalid @enderror" value="{{ old('interest_rate_sv') }}" type="text"
                                                placeholder="Interest Rate">
                                                @error('interest_rate_sv')
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

