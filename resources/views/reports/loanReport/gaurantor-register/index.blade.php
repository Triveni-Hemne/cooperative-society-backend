@extends('layouts.app')
@section('title', 'Loan Gaurantors Register')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/index.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Guarantor Register</h2>

    <!-- Export PDF Button -->
    <div class="export-btns d-flex justify-content-end">
        <a href="{{ route('guarantor-register.pdf', ['type' => 'stream']) }}" class="btn btn-secondary mb-3 me-1" target="_blank"><i class="bi bi-printer"></i>Print</a>
        <a href="{{ route('guarantor-register.pdf', ['type' => 'download']) }}" class="btn btn-danger mb-3" target=""><i class="bi bi-file-earmark-pdf"></i>Export PDF</a>
    </div>

    <!-- Guarantor Register Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Loan Account No</th>
                <th>Borrower Name</th>
                <th>Guarantor Name</th>
                <th>Contact</th>
                <th>Relationship</th>
                <th>Income</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guarantors as $guarantor)
            <tr>
                <td>{{ $guarantor->loan_account_no }}</td>
                <td>{{ $guarantor->borrower_name }}</td>
                <td>{{ $guarantor->guarantor_name }}</td>
                <td>{{ $guarantor->guarantor_contact ?? '' }}</td>
                <td>{{ $guarantor->guarantor_relationship ?? ''}}</td>
                <td>{{ number_format($guarantor->guarantor_income ?? 0, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No guarantor records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection