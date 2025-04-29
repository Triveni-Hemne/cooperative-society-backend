@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>General Ledger</h3>
    <div class="row">
        <!-- Search Bar -->
        <div class="col">
            <input type="search" id="searchInput" placeholder="Search Here..." class="w-100 px-3 py-2 rounded search-bar">
        </div>

        <!-- Add New Button (Moves Above Sidebar in Small Screens) -->
        <a href="#" class="col d-flex gap-2 text-decoration-none align-items-center justify-content-end py-1 ms-auto" data-bs-toggle="modal"
            data-bs-target="#generalLedgerModal">
            <p class="d-block d-md-none my-bg-primary rounded-circle d-flex justify-content-center align-items-center"
                style="width: 30px; height: 30px;">
                <i class="fa fa-plus text-white" style="font-size:20px"></i>
            </p>
            <p class="d-none d-md-block btn my-bg-primary text-light">
                <i class="fa fa-plus me-1" style=""></i>Add New
            </p> <!-- Hidden on small screens -->
        </a>
    </div>
</div>

<div class="d-flex flex-column justify-content-between" style="height: 82%">
    <!-- List of Directors -->
    <div class="border overflow-auto" style="height: 88%">
        <table id="tableFilter" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sr.No.</th>
                    <th scope="col">#</th>
                    <th scope="col">Ledger No.</th>
                    <th scope="col">Ledger Name</th>
                    <th scope="col">Parent Ledger Name</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Balance Type</th>
                    <th scope="col">Open Balance</th>
                    <th scope="col">Open Balance Type</th>
                    <th scope="col">Min. Balance</th>
                    <th scope="col">Min. Balance Type</th>
                    <th scope="col">Interest Rate</th>
                    <th scope="col">Add Interest to Balance</th>
                    <th scope="col">Open Date</th>
                    <th scope="col">Panel Rate</th>
                    <th scope="col">Ledger Type</th>
                    <th scope="col">CD Ratio</th>
                    <th scope="col">Group</th>
                    <th scope="col">Type</th>
                    <th scope="col">Interest Type</th>
                    <th scope="col">Subsidiary</th>
                    <th scope="col">Demand</th>
                    <th scope="col">Send SMS</th>
                    <th scope="col">Item Of</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($generalLedgers->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($generalLedgers as $generalLedger)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$generalLedger->id}}</td>
                    <td>{{$generalLedger->ledger_no}}</td>
                    <td>{{$generalLedger->name}}</td>
                    <td>{{ optional($generalLedger->parentLedger)->name ?? 'Ledger not found' }}</td>
                    <td>{{$generalLedger->balance}}</td>
                    <td>{{$generalLedger->balance_type}}</td>
                    <td>{{$generalLedger->open_balance}}</td>
                    <td>{{$generalLedger->open_balance_type}}</td>
                    <td>{{$generalLedger->min_balance}}</td>
                    <td>{{$generalLedger->min_balance_type}}</td>
                    <td>{{$generalLedger->interest_rate}}</td>
                    <td>{{$generalLedger->add_interest_to_balance}}</td>
                    <td>{{$generalLedger->open_date}}</td>
                    <td>{{$generalLedger->penal_rate}}</td>
                    <td>{{$generalLedger->gl_type}}</td>
                    <td>{{$generalLedger->cd_ratio}}</td>
                    <td>{{$generalLedger->group}}</td>
                    <td>{{$generalLedger->type}}</td>
                    <td>{{$generalLedger->interest_type}}</td>
                    <td>{{$generalLedger->subsidiary}}</td>
                    <td>{{$generalLedger->demand}}</td>
                    <td>{{$generalLedger->send_sms}}</td>
                    <td>{{$generalLedger->item_of}}</td>
                    <td>
                        <a href="#" data-id="{{$generalLedger->id}}" data-ledger-no="{{$generalLedger->ledger_no}}" data-name="{{$generalLedger->name}}" data-parent-ledger="{{optional($generalLedger->parentLedger)->id ?? ''}}" data-balance="{{$generalLedger->balance}}" data-balance-type="{{$generalLedger->balance_type}}" data-open-balance="{{$generalLedger->open_balance}}" data-open-balance-type="{{$generalLedger->open_balance_type}}" data-min-balance="{{$generalLedger->min_balance}}" data-min-balance-type="{{$generalLedger->min_balance_type}}" data-interest-rate="{{$generalLedger->interest_rate}}" data-add-interest-to-balance="{{$generalLedger->add_interest_to_balance}}" data-open-date="{{$generalLedger->open_date}}" data-penal-rate="{{$generalLedger->penal_rate}}" data-gl-type="{{$generalLedger->gl_type}}" data-cd-ratio="{{$generalLedger->cd_ratio}}" data-group="{{$generalLedger->group}}" data-type="{{$generalLedger->type}}" data-interest-type="{{$generalLedger->interest_type}}" data-subsidiary="{{$generalLedger->subsidiary}}" data-demand="{{$generalLedger->demand}}" data-send-sms="{{$generalLedger->send_sms}}" data-item-of="{{$generalLedger->item_of}}" data-route="{{ route('general-ledgers.destroy', $generalLedger->id) }}"
                            class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#generalLedgerModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" data-id="{{$generalLedger->id}}" data-route="{{ route('general-ledgers.destroy', $generalLedger->id) }}" data-name="{{ $generalLedger->name }}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a>
                    </td>
                </tr>
                @php $i++ @endphp
                 @endforeach
                 @else
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No ledgers added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr>    
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
        @include('layouts.pagination',['paginationVariable' =>'generalLedgers'])
    </div>
</div>

<!-- Form Model -->
@include('master.general-ledger.generalLedger')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('generalLedgerModal'));
            modal.show();
        });
    </script>
@endif --}}
{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let generalLedgerId = this.getAttribute("data-id");
            let ledgerNo = this.getAttribute("data-ledger-no");
            let name = this.getAttribute("data-name");
            let parentLedger = this.getAttribute("data-parent-ledger");
            let balance = this.getAttribute("data-balance");
            let balanceType = this.getAttribute("data-balance-type");
            let openBalance = this.getAttribute("data-open-balance");
            let openBalanceType = this.getAttribute("data-open-balance-type");
            let minBalance = this.getAttribute("data-min-balance"); 
            let minBalanceType = this.getAttribute("data-min-balance-type"); 
            let interestRate = this.getAttribute("data-interest-rate"); 
            let addInterestToBalance = this.getAttribute("data-add-interest-to-balance"); 
            let openDate = this.getAttribute("data-open-date"); 
            let penalRate = this.getAttribute("data-penal-rate"); 
            let glType = this.getAttribute("data-gl-type"); 
            let cdRatio = this.getAttribute("data-cd-ratio");  
            let group = this.getAttribute("data-group");  
            let type = this.getAttribute("data-type");  
            let interestType = this.getAttribute("data-interest-type");  
            let subsidiary = this.getAttribute("data-subsidiary");  
            let demand = this.getAttribute("data-demand");  
            let sendSMS = this.getAttribute("data-send-sms");  
            let itemOf = this.getAttribute("data-item-of");  
            let route = this.getAttribute("data-route");  

            let modal = document.getElementById("generalLedgerModal");

            // Update modal title
            document.getElementById("generalLedgerModalLabel").textContent = "Edit General Ledger";

            // Populate form fields
            document.getElementById("generalLedgerId").value = generalLedgerId;
            document.getElementById("ledgerNo").value = ledgerNo;
            document.getElementById("Name").value = name;
            document.getElementById("parentLedger").value = parentLedger;
            console.log(parentLedger);
            
            document.getElementById("balance").value = balance;
            document.getElementById("balanceType").value = balanceType;
            document.getElementById("openBalance").value = openBalance;
            document.getElementById("openBalanceType").value = openBalanceType;
            document.getElementById("minBalance").value = minBalance;
            document.getElementById("minBalanceType").value = minBalanceType;
            document.getElementById("interestRate").value = interestRate;
            document.getElementById("addInterestToBalance").value = addInterestToBalance;
            document.getElementById("openDate").value = openDate;
            document.getElementById("penalRate").value = penalRate;
            document.getElementById("glType").value = glType;
            document.getElementById("cdRatio").value = cdRatio;
            document.getElementById("group").value = group;
            document.getElementById("type").value = type;
            document.getElementById("interestType").value = interestType;
            document.getElementById("subsidiary").value = subsidiary;
            document.getElementById("demand").value = demand;
            document.getElementById("sendSMS").value = sendSMS;
            document.getElementById("itemOf").value = itemOf;

            // Change form action to update route and set PUT method
            let form = document.getElementById("generalLedgerForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#generalLedgerModal .btn-primary").textContent = "Update General Ledger";

            let parentLedgerIdSelect = document.getElementById("parentLedger");
            let balanceTypeSelect = document.getElementById("balanceType");
            let openBalanceTypeSelect = document.getElementById("openBalanceType");
            let minBalanceTypeSelect = document.getElementById("minBalanceType");
            let interestTypeSelect = document.getElementById("interestType");
            let glTypeSelect = document.getElementById("glType");
            let cdRatioSelect = document.getElementById("cdRatio");
            let addInterestToBalanceSelect = document.getElementById("addInterestToBalance");
            let itemOfSelect = document.getElementById("itemOf");
            let groupSelect = document.getElementById("group");
            let subsidiarySelect = document.getElementById("subsidiary");
            let sendSMSSelect = document.getElementById("sendSMS");
            let typeSelect = document.getElementById("type");
            let demandSelect = document.getElementById("demand");
        });
    });

    // Reset modal when it's closed
    document.getElementById("generalLedgerModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("generalLedgerForm");

        // Reset form fields
        form.reset();

        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{route('general-ledgers.store')}}");

        // Reset modal title & button text
        document.getElementById("generalLedgerModalLabel").textContent = "Add General Ledger";
        document.querySelector("#generalLedgerModal .btn-primary").textContent = "Save Changes";
    });
});
</script>
@endsection
