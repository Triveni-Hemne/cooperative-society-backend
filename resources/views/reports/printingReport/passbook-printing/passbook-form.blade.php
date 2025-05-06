@extends('layouts.app')
@section('title', 'Passbook Printing')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
<div class="container">
    <h2 class="mb-4">Passbook Printing</h2>

    <form method="GET" action="{{ route('passbook.printing.result') }}" class="card p-3 shadow-sm">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Member</label>
                <select name="member_id" id="memberSelect" class="form-control" required>
                    <option value="" >-- Select Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Account Type</label>
                <select name="account_type" id="accountTypeSelect" class="form-control" required>
                    <option value="" >-- Select Type --</option>
                    <option value="loan">Loan</option>
                    <option value="deposit">Savings / RD / FD</option>
                    {{-- <option value="share">Share</option> --}}
                </select>
            </div>
            <div class="col-md-4">
                <label>Account</label>
                <select name="account_id" id="accountSelect" class="form-control" required>
                    <option value="" disabled>-- Select Account --</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" name="from_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" name="to_date" class="form-control">
            </div>
            @if(!empty($branches))
            <div class="col-md-3">
                <label class="">Branch</label>
                {{-- Branch --}}
                <select name="branch_id" class="form-select">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-6 text-end mt-4">
                <button type="submit" class="btn btn-primary">Show Passbook</button>
            </div>
        </div>
    </form>
</div>
@endsection

 <script>
       document.addEventListener("DOMContentLoaded", function () {
        
        const members = @json($members ?? []);
        const loanAccounts = @json($loanAccounts ?? []);
        const depositAccounts = @json($depositAccounts ?? []);
        const shareAccounts = @json($shareAccounts ?? []);


        const accountSelect = document.getElementById('accountSelect');

        function updateAccounts() {
            const memberId = document.getElementById('memberSelect').value;
            const type = document.getElementById('accountTypeSelect').value;
            accountSelect.innerHTML = '<option value="">-- Select Account --</option>';

            if (!memberId || !type) return;
            
            let accounts = [];
            console.log("Script Loaded");
            console.log("Type: " + type);

            if (type === 'loan') {
                accounts = loanAccounts.filter(acc => acc.member_id == memberId);
                accounts.forEach(acc => {
                    const opt = new Option(`Loan A/C: ${acc.acc_no}`, acc.id);
                    accountSelect.add(opt);

                });
            }

            if (type === 'deposit') {
                const dep = depositAccounts.filter(acc => acc.member_id == memberId);
                dep.forEach(acc => {
                    // const label = acc.account_type.toUpperCase();
                    const opt = new Option(`Deposit A/C: ${acc.acc_no}`, acc.id);
                    accountSelect.add(opt);
                });

                // const savings = savingAccounts.filter(acc => acc.member_id == memberId);
                // savings.forEach(acc => {
                //     const opt = new Option(`Savings A/C: ${acc.account_number}`, acc.id);
                //     accountSelect.add(opt);
                // });

                // const rd = recurringDeposits.filter(acc => acc.member_id == memberId);
                // rd.forEach(acc => {
                //     const opt = new Option(`RD A/C: ${acc.account_number}`, acc.id);
                //     accountSelect.add(opt);
                // });

                // const fd = fixedDeposits.filter(acc => acc.member_id == memberId);
                // fd.forEach(acc => {
                //     const opt = new Option(`FD A/C: ${acc.account_number}`, acc.id);
                //     accountSelect.add(opt);
                // });
            }

            // if (type === 'share') {
            //     const shares = shareAccounts.filter(acc => acc.member_id == memberId);
            //     shares.forEach(acc => {
            //         const opt = new Option(`Share Ledger: ${acc.ledger_id}`, acc.id);
            //         accountSelect.add(opt);
            //     });
            // }
        }

        document.getElementById('memberSelect').addEventListener('change', updateAccounts);
        document.getElementById('accountTypeSelect').addEventListener('change', updateAccounts);
         });
    </script>


