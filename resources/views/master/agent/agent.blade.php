<div class="modal fade" id="agentModal" tabindex="-1" aria-labelledby="agentModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('agents.store') }}" id="agentModalForm" class="needs-validation"
                novalidate>
                <input type="hidden" id="agentId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf

                @if(Session::has('error'))
                <div class="alert alert-danger rounded-0 m-0">{{ Session::get('error') }}</div>
                @endif

                <div class="modal-header bg-gradient bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="agentModalLabel"><i class="bi bi-person-plus-fill me-2"></i> Add
                        Agent</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="row g-3 mb-3">
                            {{-- User Dropdown --}}
                            @isset($users)
                            <div class="col-md-6">
                                @if ($users->isNotEmpty())
                                <div class="form-floating">
                                    <select name="user_id" id="userId"
                                        class="form-select @error('user_id') is-invalid @enderror">
                                        <option value="" disabled selected>Select User</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="userId">User</label>
                                    @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <strong>⚠️ No users available.</strong><br>
                                    Please add users first.
                                </div>
                                @endif
                            </div>
                            @endisset

                            {{-- Branch --}}
                            @if(Auth::user()->role === 'Admin')
                            @isset($branches)
                            <div class="col-md-6">
                                @if ($branches->isNotEmpty())
                                <div class="form-floating">
                                    <select name="branch_id" id="branchId"
                                        class="form-select @error('branch_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"  
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                        >
                                        {{ $branch->name }}
                                        </option>
                                    @endforeach
                                    </select>
                                    <label for="branchId">Branch</label>
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
                            </div>
                            @endisset
                            @endif
                        </div>                    
                            
                        <div class="row g-3 mb-3">
                            {{-- Agent Code --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input name="agent_code" id="agentCode" type="text"
                                        class="form-control @error('agent_code') is-invalid @enderror"
                                        placeholder="Agent Code" value="{{ old('agent_code') }}" required>
                                    <label for="agentCode" class="form-label required">Agent Code</label>
                                    @error('agent_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Commition Rate --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input name="commission_rate" id="commissionRate" type="number"
                                        class="form-control @error('commission_rate') is-invalid @enderror"
                                        placeholder="Commition Rate" value="{{ old('commission_rate') }}" required>
                                    <label for="commissionRate" class="form-label required">Commition Rate</label>
                                    @error('commission_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                            <label for="name" class="form-label required">Full Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email (Optional) --}}
                        <div class="form-floating mb-3">
                            <input name="email" id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                value="{{ old('email') }}">
                            <label for="email">Email</label>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mobile Numbers --}}
                        <div class="form-floating mb-3">
                            <input name="phone" id="phone" type="number"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="Phone"
                                value="{{ old('phone') }}" required>
                            <label for="phone" class="form-label required">Phone</label>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address (English) --}}
                        <div class="form-floating mb-3">
                            <textarea id="address" name="address"
                                class="form-control @error('address') is-invalid @enderror" placeholder="Address"
                                style="height: 100px; resize: none;" required>{{ old('address') }}</textarea>
                            <label for="address">Address</label>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Joining Date -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="joining_date" id="joiningDate"
                                        class="form-control @error('joining_date') is-invalid @enderror"
                                        value="{{ old('joining_date') }}" type="date">
                                    <label for="joiningDate">Joining Date</label>
                                    @error('joining_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Resignation Date -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="resignation_date" id="resignationDate"
                                        class="form-control @error('resignation_date') is-invalid @enderror"
                                        value="{{ old('resignation_date') }}" type="date">
                                    <label for="resignationDate">Resignation Date</label>
                                    @error('resignation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                        <option value="">------ Status ------</option>
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    <label for="status">Status</label>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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