@include('layouts.session')

@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">
@endsection

@section('content')
<div>
    <!-- Heading -->
    <div class="mb-4 heading">
        <h3>Loan Account Opening</h3>
    </div>

    <!-- Search Bar and Add New Button -->
    <div class="d-flex justify-content-between mb-3">
        <input type="search" id="searchInput" placeholder="Search Here..." class="w-50 px-3 py-1 rounded">

        <div>
            <a href="#" class="d-flex justify-content-between gap-2 text-decoration-none d-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#loanAccOpeningModal">
                <p style="width: 30px; height: 30px"
                    class="bg-success rounded-circle d-flex justify-content-center align-items-center">
                    <i class="fa fa-plus text-white" style="font-size:20px"></i>
                </p>
                <p>Add New</p>
            </a>
        </div>
    </div>
</div>

<div class="d-flex flex-column justify-content-between" style="height: 82%">
    <!-- List of Directors -->
    <div class="border overflow-auto" style="height: 88%">
        <table id="tableFilter" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                 @if ($loanAccounts->isNotEmpty())
                 @php $i = 1; @endphp
                 @foreach ($loanAccounts as $account)
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>
                        <a href="#" class="text-decoration-none me-4" data-bs-toggle="modal"
                            data-bs-target="#loanAccOpeningModal">
                            <i class="fa fa-edit text-primary" style="font-size:20px"></i>
                        </a>
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class=" fa fa-trash-o text-danger" style="font-size:20px"></i>
                        </a>
                    </td>
                </tr>
                @php $i++ @endphp
                 @endforeach
                 @else
                    <tr><td colspan="15" class="text-center"><h5>Data Not Found !</h5></td></tr>   
                 @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
            @include('layouts.pagination', ['paginationVariable' => 'loanAccounts'])
    </div>
</div>

<!-- Form Model -->
@include('accounts.loan-acc-opening.loanAccOpening')

<!-- Delete Confirmation Model -->
@include('layouts.deleteModal')
@endsection

@section('customeJs')
@endsection