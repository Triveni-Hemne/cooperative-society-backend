<div class="modal fade" id="generalAccModal" tabindex="-1" aria-labelledby="generalAccModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" enctype="multipart/form-data" action="{{route('accounts.store')}}" id="generalAccForm">
            @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <input type="hidden" id="genAccId" name="id">
                    <input type="hidden" name="_method" id="formMethod" value="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="generalAccModalLabel">Add General Account</h1>
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
                        </div>

                        <div class="row mb-2">
                           <div class="col-2 d-none d-xl-block">
                                <label for="accountNo">Account No.</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="account_no" id="accountNo" class="w-100 px-2 py-1 @error('account_no') is-invalid @enderror" value="{{ old('account_no') }}" type="text" placeholder="Account No.">
                                @error('account_no')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="accountName">Acc. Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="account_name" id="accountName" class="w-100 px-2 py-1 @error('account_name') is-invalid @enderror" type="text" value="{{ old('account_name') }}" placeholder="Name">
                                @error('account_name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
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
                                <label for="accountType">Account Type</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="accountType" name="account_type" class="w-100 px-2 py-1 @error('account_type') is-invalid @enderror">
                                    <option value="select">------ Select Type ------</option>
                                    <option value="Deposit" {{ old('account_type') == 'Deposit' ? 'selected' : '' }}>Deposit</option>
                                    <option value="Loan" {{ old('account_type') == 'Loan' ? 'selected' : '' }}>Loan</option>
                                    <option value="Savings" {{ old('account_type') == 'Savings' ? 'selected' : '' }}>Savings</option>
                                    <option value="Investment" {{ old('account_type') == 'Investment' ? 'selected' : '' }}>Investment</option>
                                </select>
                                @error('account_type')
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
                                <label for="startDate">Start Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="start_date" id="startDate" class="w-100 px-2 py-1 @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" type="date" placeholder="Start Date">
                                 @error('start_date')
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
                            @if ($agents->isNotEmpty())
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="agentId">Agent</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select id="agentId" name="agent_id" class="w-100 px-2 py-1 @error('agent_id') value="{{ old('agent_id') }}" is-invalid @enderror">
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}"  
                                        {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                 @error('agent_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @endif
                            @endisset
                            <div class="col">
                                <input type="checkbox" {{ old('closing_flag') ? 'checked' : '' }}  name="closing_flag" class="@error('closing_flag') is-invalid @enderror" value="1" id="closingFlag">
                                <label for="closingFlag">Closing Flag</label>
                                @error('closing_flag')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input type="checkbox" {{ old('add_to_demand') ? 'checked' : '' }}  name="add_to_demand" class="@error('add_to_demand') is-invalid @enderror"  value="1"id="addToDemand">
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
                            <div class="col pe-0 pe-xl-5"> 
                                <select id="installmentType" name="installment_type" class="w-100 px-2 py-1 @error('installment_type') is-invalid @enderror" >
                                    <option value="select">------ Select Installment Type ------</option>
                                    <option value="Monthly" {{ old('installment_type') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Quarterly" {{ old('installment_type') == 'Quarterly' ? 'selected' : '' }}>Quaterky</option>
                                    <option value="Yearly" {{ old('installment_type') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('installment_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="installmentAmount">Installment Amount</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="installment_amount" id="installmentAmount" class="w-100 px-2 py-1 @error('installment_amount') is-invalid @enderror" value="{{ old('installment_amount') }}" type="number"
                                    placeholder="Installment Amount">
                                    @error('installment_amount')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="totalInstallmentsPaid">Total Installment Paid</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="total_installments_paid" id="totalInstallmentsPaid" class="w-100 px-2 py-1 @error('total_installments_paid') is-invalid @enderror" value="{{ old('total_installments_paid') }}" type="number"
                                    placeholder="Total Installment Paid">
                                    @error('total_installments_paid')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                            <div class="col-2 d-none d-xl-block">
                                <label for="closingDate">Closing Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="closing_date" id="closingDate" class="w-100 px-2 py-1 @error('closing_date') is-invalid @enderror" value="{{ old('closing_date') }}" type="date" placeholder="Closing Date">
                                @error('closing_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
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