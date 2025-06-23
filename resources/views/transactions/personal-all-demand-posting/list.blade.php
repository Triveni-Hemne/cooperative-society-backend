@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div class="mb-3">
    <h3>Personal/All Demand Posts</h3>
    <div class="row">
        <div class="col-8 col-lg-5 mb-3">
            @include('layouts.tableSearchInput')
        </div>
        <div class="col-8 col-lg-5">   
            @include('layouts.branchFilterInput', [
                'action' => route('demand-posting.index')
            ])
        </div>
        <div class="col col-md-2">
        @include('layouts.add-button', [
                'target' => '#personalDemandPostModal',
                'text' => 'Add New'
            ])
        </div>
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
                    <th scope="col">Member Name</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Month</th>
                    <th scope="col">Year</th>
                    <th scope="col">From Date</th>
                    <th scope="col">To Date</th>
                    <th scope="col">Posting Date</th>
                    <th scope="col">Is Transfered</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Ledger Name</th>
                    <th scope="col">Account</th>
                    <th scope="col">Posting Type</th>
                    <th scope="col">Check No</th>
                    <th scope="col">Narration</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                 @if ($postings->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($postings as $posting)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$posting->id}}</td>
                    <td>{{$posting->member->name ?? ''}}</td>
                    <td>{{$posting->creator->name ?? ''}}</td>
                    <td>{{$posting->branch->name ??''}}</td>
                    <td>{{$posting->month ??''}}</td>
                    <td>{{$posting->year ??''}}</td>
                    <td>{{$posting->from_date ?? ''}}</td>  
                    <td>{{$posting->to_date ?? ''}}</td>  
                    <td>{{$posting->posting_date ?? ''}}</td>  
                    <td>{{$posting->is_transferred ?? ''}}</td>  
                    <td>{{$posting->total_amount ?? ''}}</td>  
                    <td>{{$posting->ledger->name ?? ''}}</td>  
                    <td>{{$posting->account->name ?? ''}}</td>  
                    <td>{{$posting->posting_type ?? ''}}</td>  
                    <td>{{$posting->check_no ?? ''}}</td>  
                    <td>{{$posting->narration ?? ''}}</td>  
                    <td>
                        <a href="#" data-id="{{$posting->id }}" data-member="{{$posting->member_id}}" data-created-by="{{$posting->created_by ?? ''}}" data-branch="{{$posting->branch_id ?? ''}}"  data-month="{{$posting->month ?? ''}}"  data-year="{{$posting->year ?? ''}}"  data-from-date="{{$posting->from_date ?? ''}}" data-to-date="{{$posting->to_date ?? ''}}"  data-posting-date="{{$posting->posting_date ?? ''}}" data-is-transferred="{{$posting->is_transferred ?? ''}}" data-total-amount="{{$posting->total_amount ?? ''}}" data-ledger="{{$posting->ledger_id ?? ''}}" data-account="{{$posting->account_id ?? ''}}" data-posting-type="{{$posting->posting_type ?? ''}}" data-check-no="{{$posting->check_no ?? ''}}" data-narration="{{$posting->narration ?? ''}}" data-route="{{ route('demand-posting.update', $posting->id) }}" class="text-decoration-none me-4 edit-btn" data-bs-toggle="modal"
                            data-bs-target="#personalDemandPostModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        {{-- <a href="#" data-id="{{$posting->id }}" data-route="{{ route('demand-posting.destroy', $posting->id) }}" data-name="{{$posting->user->name ?? ''}}"  class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a> --}}
                    </td>
                </tr>
                @php $i++ @endphp
                 @endforeach
                 @else
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #888;">
                            <i class="fa fa-info-circle" style="margin-right: 6px;"></i>
                            No day begins added yet. Click <strong>“Add New”</strong> to create one.
                        </td>
                    </tr> 
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
           @include('layouts.pagination', ['paginationVariable' => 'postings'])
    </div>
</div>

<!-- Form Model -->
@include('transactions.personal-all-demand-posting.personal-all-demand-posting')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
{{-- @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = new bootstrap.Modal(document.getElementById('personalDemandModal'));
            modal.show();
        });
    </script>
@endif --}}
{{-- Script to send data to the edit modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let member = this.getAttribute("data-member");
            let createdBy = this.getAttribute("data-created-by");
            let branch = this.getAttribute("data-branch");
            let month = this.getAttribute("data-month");
            let year = this.getAttribute("data-year");
            let fromDate = this.getAttribute("data-from-date");
            let toDate = this.getAttribute("data-to-date");
            let postingDate = this.getAttribute("data-posting-date");
            let isTransferred = this.getAttribute("data-is-transferred");
            let totalAmount = this.getAttribute("data-total-amount");
            let ledger = this.getAttribute("data-ledger");
            let account = this.getAttribute("data-account");
            let postingType = this.getAttribute("data-posting-type");
            let chequeNo = this.getAttribute("data-check-no");
            let narration = this.getAttribute("data-narration");
            let route = this.getAttribute("data-route");

            let modal = document.getElementById("personalDemandPostModal");

            // Update modal title
            document.getElementById("personalDemandModalLabel").textContent = "Edit Personal/All Post";

            // Populate form fields
            document.getElementById("personalDemandId").value = id;
            document.getElementById("member").value = member;
            document.getElementById("createdBy").value = createdBy;
            document.getElementById("branch").value = branch;
            document.getElementById("month").value = month;
            document.getElementById("year").value = year;
            if (fromDate && !isNaN(new Date(fromDate))) {
                document.getElementById("fromDate").value = new Date(fromDate).toISOString().split('T')[0];
            }
            if (toDate && !isNaN(new Date(toDate))) {
                document.getElementById("toDate").value = new Date(toDate).toISOString().split('T')[0];
            }
            if (postingDate && !isNaN(new Date(postingDate))) {
                document.getElementById("postingDate").value = new Date(postingDate).toISOString().split('T')[0];
            }
            document.getElementById("isTransferred").checked = isTransferred == 1;
            document.getElementById("totalAmount").value = totalAmount;
            document.getElementById("ledger").value = ledger;
            document.getElementById("account").value = account;
            document.getElementById("postingType").value = postingType;
            document.getElementById("chequeNo").value = chequeNo;
            document.getElementById("narration").value = narration;
            
            // Change form action to update route and set PUT method
            let form = document.getElementById("personalDemandModalForm");
            form.setAttribute("action", route);
            document.getElementById("formMethod").value = "PUT";

            // Change submit button text
            document.querySelector("#personalDemandPostModal .btn-success").innerHTML  = '<i class="bi bi-check-circle me-1"></i>Submit';
        });
    });

    // Reset modal when it's closed
    document.getElementById("personalDemandPostModal").addEventListener("hidden.bs.modal", function () {
        let form = document.getElementById("personalDemandModalForm");

        // Reset form fields
        form.reset();
        
        // Reset method and form action
        document.getElementById("formMethod").value = "POST";
        form.setAttribute("action", "{{ route('demand-posting.store') }}");

        // Reset modal title & button text
        document.getElementById("personalDemandModalLabel").textContent = "Add Personal/All Demand Post";
        document.querySelector("#personalDemandPostModal .btn-success").innerHTML  = `<i class="bi bi-check-circle me-1"></i>Submit`;
    });
});
</script>
@endsection
