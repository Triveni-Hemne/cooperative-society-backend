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

                        {{-- User Dropdown --}}
                        @isset($users)
                        <div class="form-floating mb-3">
                            @if ($users->isNotEmpty())
                            <select name="user_id" id="userId"
                                class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Select User</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                                @endforeach
                            </select>
                            <label for="userId">User</label>
                            @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="alert alert-warning">
                                <strong>⚠️ No users available.</strong><br>
                                Please add users first.
                            </div>
                            @endif
                        </div>
                        @endisset

                        {{-- Agent Code --}}
                        <div class="form-floating mb-3">
                            <input name="agent_code" id="agentCode" type="text"
                                class="form-control @error('agent_code') is-invalid @enderror" placeholder="Agent Code"
                                value="{{ old('agent_code') }}" required>
                            <label for="agentCode" class="form-label required">Agent Code</label>
                            @error('agent_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Commition Rate --}}
                        <div class="form-floating mb-3">
                            <input name="commition_rate" id="commitionRate" type="number"
                                class="form-control @error('commition_rate') is-invalid @enderror"
                                placeholder="Commition Rate" value="{{ old('commition_rate') }}" required>
                            <label for="commitionRate" class="form-label required">Commition Rate</label>
                            @error('commition_rate')
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