<div class="modal fade" id="branchLedgerModal" tabindex="-1" aria-labelledby="branchLedgerModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{route('branch-ledger.store')}}" id="branchLedgerModalForm">
                <input type="hidden" id="branchLedgerId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="branchLedgerModalLabel">Add Branch Ledger</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        @csrf
                        @if(Session::has('error'))
                        <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                        @endif

                        <div class="row g-3 mb-3">
                            <!-- Created By -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="created_by" id="createdBy"
                                        class="form-control @error('created_by') is-invalid @enderror"
                                        value="{{$user->name}}" type="text" disabled>
                                    <label for="createdBy">Created By</label>
                                    @error('created_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Branch Code -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="branch_code" id="branchCode"
                                        class="form-control @error('branch_code') is-invalid @enderror"
                                        value="{{ old('branch_code') }}" type="text" placeholder="Branch Code">
                                    <label for="branchCode">Branch Code</label>
                                    @error('branch_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ledger Selection -->
                        @isset($ledgers)
                        @if ($ledgers->isNotEmpty())
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="glId" name="gl_id"
                                        class="form-select @error('gl_id') is-invalid @enderror">
                                        <option value="">------ Select Ledger ------</option>
                                        @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}"
                                            {{ old('gl_id') == $ledger->id ? 'selected' : '' }}>
                                            {{ $ledger->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="glId">Ledger</label>
                                    @error('gl_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <strong>⚠️ No Ledger available.</strong><br>
                            Please add Ledger first.
                        </div>
                        @endif
                        @endisset

                        <div class="row g-3 mb-3">
                            <!-- Open Date -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="open_date" id="openDate"
                                        class="form-control @error('open_date') is-invalid @enderror"
                                        value="{{ old('open_date') }}" type="date">
                                    <label for="openDate">Open Date</label>
                                    @error('open_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Open Balance -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="open_balance" id="openBalance"
                                        class="form-control @error('open_balance') is-invalid @enderror"
                                        value="{{ old('open_balance') }}" type="number" placeholder="Open Balance">
                                    <label for="openBalance">Open Balance</label>
                                    @error('open_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Balance -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="balance" id="balance"
                                        class="form-control @error('balance') is-invalid @enderror"
                                        value="{{ old('balance') }}" type="number" placeholder="Balance">
                                    <label for="balance">Balance</label>
                                    @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Balance Type -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="balanceType" name="balance_type"
                                        class="form-select @error('balance_type') is-invalid @enderror">
                                        <option value="">------ Select Balance Type ------</option>
                                        <option value="Credit" {{ old('balance_type') == 'Credit' ? 'selected' : '' }}>
                                            Credit</option>
                                        <option value="Debit" {{ old('balance_type') == 'Debit' ? 'selected' : '' }}>
                                            Debit</option>
                                    </select>
                                    <label for="balanceType">Balance Type</label>
                                    @error('balance_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Item Type -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="itemType" name="item_type"
                                        class="form-select @error('item_type') is-invalid @enderror">
                                        <option value="">------ Select Item Type ------</option>
                                        <option value="Asset" {{ old('item_type') == 'Asset' ? 'selected' : '' }}>Asset
                                        </option>
                                        <option value="Liability"
                                            {{ old('item_type') == 'Liability' ? 'selected' : '' }}>Liability</option>
                                        <option value="Income" {{ old('item_type') == 'Income' ? 'selected' : '' }}>
                                            Income</option>
                                        <option value="Expense" {{ old('item_type') == 'Expense' ? 'selected' : '' }}>
                                            Expense</option>
                                    </select>
                                    <label for="itemType">Item Type</label>
                                    @error('item_type')
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