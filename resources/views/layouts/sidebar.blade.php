<!-- Navbar -->
<nav class="sidebar d-flex flex-column">
    <a href="/" class="d-flex align-items-center">
        <span class="fs-4 fw-bold">Dashboard</span>
    </a>
    <div class="accordion" id="sidebarAccordion">
        <!-- Master Menu -->
        <div class="accordion-item bg-transparent border-0 my-item">
            <h2 class="accordion-header">
                <button class="accordion-button bg-transparent text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#category1">
                    Master
                </button>
            </h2>
            <div id="category1" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <a href="{{route('directors.index')}}">Director</a>
                    <a href="{{route('divisions.index')}}">Division</a>
                    <a href="{{route('sub-divisions.index')}}">Sub Division</a>
                    <a href="{{route('centers.index')}}">Center</a>
                    <a href="{{route('designations.index')}}">Designation</a>
                    <a href="{{route('subcastes.index')}}">Subcaste</a>
                    <a href="#">Schedule Ledger</a>
                    <a href="{{route('general-ledgers.index')}}">General Ledger</a>
                </div>
            </div>
        </div>
        <!-- Accounts Menu -->
        <div class="accordion-item bg-transparent border-0 my-item">
            <h2 class="accordion-header">
                <button class="accordion-button bg-transparent text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#category2">
                    Accounts
                </button>
            </h2>
            <div id="category2" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <a href="{{route('members.index')}}">Manage Member</a>
                    <a href="{{route('member-depo-accounts.index')}}">Deposit Account Opening</a>
                    <a href="{{route('member-loan-accounts.index')}}">Loan Account Opening</a>
                    <a href="{{route('accounts.index')}}">General Accounts</a>
                    <a href="{{route('bank-investments.index')}}">Bank Investment</a>
                    <a href="{{route('standing-instructions.index')}}">Standing Instruction Master</a>
                </div>
            </div>
        </div>
        <!-- Transactions Menu -->
        <div class="accordion-item bg-transparent border-0 my-item">
            <h2 class="accordion-header">
                <button class="accordion-button bg-transparent text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#category3">
                    Transactions
                </button>
            </h2>
            <div id="category3" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <a href="{{route('day-begins.index')}}">Day Begins</a>
                    <a href="{{route('voucher-entry.index')}}">Voucher Entry</a>
                    <a href="{{route('transfer-entry.index')}}">Transfer Entry</a>
                    <!-- <a href="#">Clerk Entry</a> -->
                    <!-- <a href="#">Passing Transactions</a> -->
                    <!-- <a href="#">Standing Instruction Execution</a> -->
                    <!-- <a href="#">Auto Transfer</a> -->
                    <!-- <a href="#">Auto Transaction Entry</a> -->
                    <!-- <a href="#">All Demand List Posting</a> -->
                    <!-- <a href="#">Personal Demand Posting</a> -->
                    <!-- <a href="#">Demand List General</a> -->
                    <a href="{{route('branch-ledger.index')}}">Branch Ledger</a>
                    <a href="{{route('day-end.index')}}">Day Ends</a>
                </div>
            </div>
        </div>
        <!-- Interest Menu -->
        <div class="accordion-item bg-transparent border-0 my-menu-item">
            <a href="{{route('interest.calculator')}}" class="d-flex align-items-center ps-4 rounded-0">
                Interest
            </a>
        </div>
        <!-- Reports Menu -->
        <div class="accordion-item bg-transparent border-0 my-item">
            <h2 class="accordion-header">
                <button class="accordion-button bg-transparent text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#category4">
                    Reports
                </button>
            </h2>
            <div id="category4" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <div class="accordion" id="reportsAccordion">
                        <!-- Daily Reports -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-transparent text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#dailyReports">
                                    Daily Reports
                                </button>
                            </h2>
                            <div id="dailyReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#">Cash Book</a>
                                    <a href="#">Day Book</a>
                                    <a href="#">Sub Day Book</a>
                                    <a href="#">GL Statement Checking</a>
                                    <a href="#">Cut Book</a>
                                    <a href="#">Cut book and GL Balance Checking</a>
                                    <a href="#">Demand Day Book</a>
                                </div>
                            </div>
                        </div>
                        <!-- Loan -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-transparent text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#loanReports">
                                    Loan
                                </button>
                            </h2>
                            <div id="loanReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#">Loan Scheme</a>
                                    <a href="#">Overdue Register</a>
                                    <a href="#">NPA List</a>
                                    <a href="#">Final NPA Chart</a>
                                    <a href="#">Debit Loan Report</a>
                                    <a href="#">Guarantor Register</a>
                                    <a href="#">Account Statement</a>
                                </div>
                            </div>
                        </div>
                        <!-- Deposit -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-transparent text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#depositReports">
                                    Deposit
                                </button>
                            </h2>
                            <div id="depositReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#">Deposit Maturity Register</a>
                                    <a href="#">RD Chart</a>
                                    <a href="#">FD Chart</a>
                                    <a href="#">Interestwise Report</a>
                                    <a href="#">Recurring Deposit Interest Scheme</a>
                                    <a href="#">Interest Summary</a>
                                </div>
                            </div>
                        </div>
                        <!-- Share -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-transparent text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#shareReports">
                                    Share
                                </button>
                            </h2>
                            <div id="shareReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <!-- <div class="accordion-body">
                                    <a href="#">Shareholder Register</a>
                                    <a href="#">Dividend Details</a>
                                </div> -->
                            </div>
                        </div>
                        <!-- MIS -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-transparent text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#misReports">
                                    MIS
                                </button>
                            </h2>
                            <div id="misReports" class="accordion-collapse collapse" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#">Terij Patrak</a>
                                    <a href="#">Terij Balance Sheet</a>
                                    <a href="#">Trial Balance</a>
                                    <a href="#">N-Type Trial Balance</a>
                                    <a href="#">Receipt Payment</a>
                                    <a href="#">N-Type Receipt Payment</a>
                                    <a href="#">ScheduleWise Receipt Payment</a>
                                    <a href="#">Profit Loss Regular</a>
                                    <a href="#">Profit Loss N-Type</a>
                                    <a href="#">ScheduleWise Profit Loss</a>
                                    <a href="#">Monthly Profit Loss</a>
                                    <a href="#">Balance Sheet Regular</a>
                                    <a href="#">Balance Sheet N-Type</a>
                                    <a href="#">ScheduleWise Balance Sheet</a>
                                    <a href="#">CD Ratio</a>
                                    <a href="#">MIS Report</a>
                                </div>
                            </div>
                        </div>
                        <!-- General -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-transparent text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#generalReports">
                                    General
                                </button>
                            </h2>
                            <div id="generalReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#">Account Statement</a>
                                    <a href="#">MonthWise Account Statement</a>
                                    <a href="#">General Ledger Statement</a>
                                    <a href="#">Member Statement</a>
                                    <a href="#">All Member Statement</a>
                                    <a href="#">Member Statement Loan</a>
                                    <a href="#">Member List</a>
                                    <a href="#">Member Address List</a>
                                    <a href="#">Account Open Register</a>
                                    <a href="#">Account Close Register</a>
                                    <a href="#">DOB Report</a>
                                    <a href="#">Retirement Report</a>
                                    <a href="#">Loan Guarentor Report</a>
                                    <a href="#">Demand List VII</a>
                                    <a href="#">Demand List General All</a>
                                </div>
                            </div>
                        </div>
                        <!-- Printing -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-transparent text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#generalReports">
                                    Printing
                                </button>
                            </h2>
                            <div id="generalReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#">Duplicate Printing</a>
                                    <a href="#">Passbook Printing</a>
                                    <a href="#">FD Rec Printing General</a>
                                </div>
                            </div>
                        </div>
                        <!-- Audit -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-transparent text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#generalReports">
                                    Audit
                                </button>
                            </h2>
                            <div id="generalReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#">Trial Balance</a>
                                    <a href="#">Balance Sheet Regular</a>
                                    <a href="#">Balance Sheet N-Type</a>
                                    <a href="#">Profit Loss Regular</a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End of Reports Accordion -->
                </div>
            </div>
        </div>
        <!-- House Keeping Menu -->
        <div class="accordion-item bg-transparent border-0 my-item">
            <h2 class="accordion-header">
                <button class="accordion-button bg-transparent text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#category5">
                    House Keeping
                </button>
            </h2>
            <div id="category5" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <a href="#">Transaction Correction</a>
                    <a href="#">GL Posting and Delete Posting</a>
                    <a href="#">Legder Balance Correction</a>
                    <a href="#">Account wise Balance Correction</a>
                    <a href="#">Account Correction Ledger wise</a>
                    <a href="#">Year End Posting</a>
                    <a href="#">Delete Account</a>
                    <a href="#">Database Backup</a>
                    <a href="#">Open/Close Account</a>
                    <a href="#">Interest Correction</a>
                    <a href="#">Interest Correction Account wise</a>
                    <a href="#">Interest Correction Ledger wise</a>
                    <a href="#">Maturity Date Correction</a>
                    <a href="#">Expiry Date Correction</a>
                    <a href="#">Installment Amount Correction</a>
                </div>
            </div>
        </div>
        <!-- Utilities Menu -->
        <div class="accordion-item bg-transparent border-0 my-menu-item">
            <a href="#" class="d-flex align-items-center ps-4 rounded-0">
                Utilities
            </a>
        </div>
        <!-- Help Menu -->
        <div class="accordion-item bg-transparent border-0 my-menu-item">
            <a href="#" class="d-flex align-items-center ps-4 rounded-0">
                Help
            </a>
        </div>
    </div>
</nav>