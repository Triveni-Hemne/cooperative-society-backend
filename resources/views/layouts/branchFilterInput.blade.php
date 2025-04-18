@isset($branches)
<form method="GET" action="{{ $action }}" class="align-items-center mb-3 input-group">
    <select name="branch_id" id="branch_id" class="form-select">
        <option value="">-- All Branches --</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                Branch : {{ $branch->name }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-funnel-fill me-1"></i> Filter
    </button>
</form>
@endisset
