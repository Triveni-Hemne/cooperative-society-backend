@extends('layouts.app')
@section('title', 'Cooperative Society Bank')

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/index.css')}}">

<style>
.hidden {
    display: none;
}

.btn-group-custom .btn {
    width: 50%;
}
</style>
@endsection

@section('content')
<div class="container ">
    <h3 class=" mb-5">Interest Calculator</h3>

    <!-- Buttons to Toggle Calculators -->
    <div class="btn-group w-100 btn-group-custom mb-3">
        <button class="btn btn-primary active" id="simpleBtn" onclick="showCalculator('simple')">Simple
            Interest</button>
        <button class="btn btn-secondary" id="compoundBtn" onclick="showCalculator('compound')">Compound
            Interest</button>
    </div>

    <!-- Simple Interest Calculator -->
    <div id="simpleCalculator" class="p-4 border rounded bg-light">
        <div class="mb-3">
            <label class="form-label">Principal Amount (₹)</label>
            <input type="number" class="form-control" id="simplePrincipal" placeholder="Enter principal">
        </div>

        <div class="mb-3">
            <label class="form-label">Rate of Interest (%)</label>
            <input type="number" class="form-control" id="simpleRate" placeholder="Enter rate">
        </div>

        <div class="mb-3">
            <label class="form-label">Time (Years)</label>
            <input type="number" class="form-control" id="simpleTime" placeholder="Enter time">
        </div>

        <button class="btn btn-success w-100" onclick="calculateSimpleInterest()">Calculate</button>
        <p class="mt-3 fw-bold text-center" id="simpleResult"></p>
    </div>

    <!-- Compound Interest Calculator -->
    <div id="compoundCalculator" class="p-4 border rounded bg-light hidden">
        <div class="mb-3">
            <label class="form-label">Principal Amount (₹)</label>
            <input type="number" class="form-control" id="compoundPrincipal" placeholder="Enter principal">
        </div>

        <div class="mb-3">
            <label class="form-label">Rate of Interest (%)</label>
            <input type="number" class="form-control" id="compoundRate" placeholder="Enter rate">
        </div>

        <div class="mb-3">
            <label class="form-label">Time (Years)</label>
            <input type="number" class="form-control" id="compoundTime" placeholder="Enter time">
        </div>

        <div class="mb-3">
            <label class="form-label">Times Compounded per Year</label>
            <input type="number" class="form-control" id="compoundTimes" placeholder="Enter times compounded per year">
        </div>

        <button class="btn btn-success w-100" onclick="calculateCompoundInterest()">Calculate</button>
        <p class="mt-3 fw-bold text-center" id="compoundResult"></p>
    </div>
</div>
@endsection

@section('customeJs')
@endsection



<script>
function showCalculator(type) {
    // Toggle visibility of calculators
    if (type === "simple") {
        document.getElementById("simpleCalculator").classList.remove("hidden");
        document.getElementById("compoundCalculator").classList.add("hidden");

        // Toggle active button
        document.getElementById("simpleBtn").classList.add("btn-primary");
        document.getElementById("simpleBtn").classList.remove("btn-secondary");
        document.getElementById("compoundBtn").classList.remove("btn-primary");
        document.getElementById("compoundBtn").classList.add("btn-secondary");
    } else {
        document.getElementById("compoundCalculator").classList.remove("hidden");
        document.getElementById("simpleCalculator").classList.add("hidden");

        // Toggle active button
        document.getElementById("compoundBtn").classList.add("btn-primary");
        document.getElementById("compoundBtn").classList.remove("btn-secondary");
        document.getElementById("simpleBtn").classList.remove("btn-primary");
        document.getElementById("simpleBtn").classList.add("btn-secondary");
    }
}

function calculateSimpleInterest() {
    let principal = parseFloat(document.getElementById("simplePrincipal").value);
    let rate = parseFloat(document.getElementById("simpleRate").value);
    let time = parseFloat(document.getElementById("simpleTime").value);

    if (isNaN(principal) || isNaN(rate) || isNaN(time)) {
        alert("Please enter valid numbers");
        return;
    }

    let SI = (principal * rate * time) / 100;
    document.getElementById("simpleResult").innerText = `Simple Interest: ₹${SI.toFixed(2)}`;
}

function calculateCompoundInterest() {
    let principal = parseFloat(document.getElementById("compoundPrincipal").value);
    let rate = parseFloat(document.getElementById("compoundRate").value);
    let time = parseFloat(document.getElementById("compoundTime").value);
    let n = parseFloat(document.getElementById("compoundTimes").value);

    if (isNaN(principal) || isNaN(rate) || isNaN(time) || isNaN(n)) {
        alert("Please enter valid numbers");
        return;
    }

    let CI = principal * Math.pow(1 + rate / (100 * n), n * time) - principal;
    document.getElementById("compoundResult").innerText = `Compound Interest: ₹${CI.toFixed(2)}`;
}
</script>
</script>