<div class="modal fade" id="agentModal" tabindex="-1" aria-labelledby="agentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('agents.store')}}" id="agentModalForm">
                <input type="hidden" id="agentId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="agentModalLabel">Add Agent</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                        @isset($users) 
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">User</label>
                            </div>
                            @if ($users->isNotEmpty())
                            <div class="col pe-0 pe-xl-5">
                                <select name="user_id" id="userId"  class="w-100 px-2 py-1 @error('user_id') is-invalid @enderror" >
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"  
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}
                                        >
                                        {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            @else
                             <div class="col pe-0 pe-xl-5">
                                <select class="w-100 px-2 py-1" disabled>
                                    <option>No users available. Please add users first.</option>
                                </select>
                                <small class="text-danger">⚠️ You must add users before submitting the form.</small>
                            </div>
                            @endif
                        </div>
                        @endisset

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="agentCode">Agent Code</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="agent_code" id="agentCode" class="w-100 px-2 py-1 @error('agent_code') is-invalid @enderror" value="{{ old('agent_code') }}" type="text" placeholder="Agent code" required>
                                @error('agent_code')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                         <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="commissionRate">Commition Rate</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="commission_rate" id="commissionRate" class="w-100 px-2 py-1 @error('commission_rate') is-invalid @enderror" value="{{ old('commission_rate') }}" type="number" placeholder="commission Rate" required>
                                @error('commission_rate')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                         <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="Name" class="">Full Name</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="Name" type="text" name="name" class="w-100 px-2 py-1 @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                         <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="Email" class="">Email Address</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="Email" type="email" name="email" class="w-100 px-2 py-1 @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="phone" class="">Phone</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="phone" type="text" name="phone" class="w-100 px-2 py-1 @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                         <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="address" class="">Address</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="address" type="text" name="address" class="w-100 px-2 py-1 @error('address') is-invalid @enderror" value="{{ old('address') }}">
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                      @if(Auth::user()->role === 'Admin')
                        <div class="row mb-2">
                             @isset($branches) 
                             <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="branchId">Branch</label>
                                </div>
                                <div class="col pe-0 pe-xl-5">
                                @if ($branches->isNotEmpty())
                                 <select name="branch_id" id="branchId"  class="w-100 px-2 py-1 @error('branch_id') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('branch_id') ? '' : 'selected' }}>---------- Select ----------</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"  
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                        >
                                        {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                  @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No branches available. Please add branches first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add branches before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="joiningDate" class="">Joining Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="joiningDate" type="date" name="joining_date" class="w-100 px-2 py-1 @error('joining_date') is-invalid @enderror" value="{{ old('joining_date') }}">
                                @error('joining_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="resignationDate" class="">Resignation Date</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input id="resignationDate" type="date" name="resignation_date" class="w-100 px-2 py-1 @error('resignation_date') is-invalid @enderror" value="{{ old('resignation_date') }}">
                                @error('resignation_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                          <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                 <label for="status" class="">Status</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                 <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

