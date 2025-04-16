<div class="modal fade" id="dayBeginsModal" tabindex="-1" aria-labelledby="dayBeginsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{route('day-begins.store')}}" id="dayBeginModalForm">
                <input type="hidden" id="dayBeginId" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="dayBeginsModalLabel">Add Day Begins</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <div class="mx-auto p-5 my-model text-white">
                          <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="createdBy">Created By</label>
                            </div>
                            <div class="col pe-0 pe-xl-5">
                                <input name="created_by" id="createdBy" class="w-100 px-2 py-1 @error('created_by') is-invalid @enderror" value="{{$user->name}}" type="text" disabled placeholder="Crated By">
                                @error('created_by')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="date">Date</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <input name="date" id="date" class="w-100 px-2 py-1  @error('date') is-invalid @enderror" value="{{ old('date') }}" type="date" placeholder="Date">
                                @error('date')
                                    <div class="invalid-feedback">{{$message}}</div>
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
                                 <select name="member_id" id="memberId"  class="w-100 px-2 py-1 @error('member_id') is-invalid @enderror">
                                    <option value="" disabled selected>---------- Select ----------</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}"  
                                        {{ old('member_id') == $member->id ? 'selected' : '' }}
                                        >
                                        {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                  @else
                                    <select class="w-100 px-2 py-1" disabled>
                                            <option>No members available. Please add members first.</option>
                                    </select>
                                    <small class="text-danger">⚠️ You must add members before submitting the form.</small>
                                @endif
                            </div>
                        @endisset
                        </div>

                        <div class="row mb-2">
                            <div class="col-2 ps-5 d-none d-xl-block">
                                <label for="status">Status</label>
                            </div>
                            <div class="col-4 pe-0 pe-xl-5">
                                <select id="status" name="status" class="w-100 px-2 py-1 @error('status') is-invalid @enderror" >
                                    <option value="">------ Select Status ------</option>
                                    <option value="Open" {{ old('status') == 'Open' ? 'selected' : '' }}>Open</option>
                                    <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status')
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