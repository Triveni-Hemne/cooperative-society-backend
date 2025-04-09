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
                        @if ($users->isNotEmpty())
                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="name">User</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <select name="user_id" id="userId"  class="w-100 px-2 py-1 @error('user_id') is-invalid @enderror">
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
                        </div>
                        @endif
                        @endisset

                        <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="agentCode">Agent Code</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="agent_code" id="agentCode" class="w-100 px-2 py-1 @error('agent_code') is-invalid @enderror" value="{{ old('agent_code') }}" type="text" placeholder="Agent code">
                                @error('agent_code')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                         <div class="row mb-3">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="commitionRate">Commition Rate</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="commition_rate" id="commitionRate" class="w-100 px-2 py-1 @error('commition_rate') is-invalid @enderror" value="{{ old('commition_rate') }}" type="number" placeholder="commition Rate">
                                @error('commition_rate')
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

