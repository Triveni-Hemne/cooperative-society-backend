<!-- Sidebar -->
<nav class="sidebar bg-dark text-white">
    <a href="/" class="text-white text-decoration-none d-flex align-items-center mb-4 dashboard-link">
        <span class="fs-4 fw-bold">📊 Dashboard</span>
    </a>

    <div class="accordion" id="sidebarAccordion">
        <!-- Master Section -->
        <div class="accordion-item bg-dark border-0">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#masterMenu">
                    🗂️ Master
                </button>
            </h2>
            <div id="masterMenu" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <a href="{{route('directors.index')}}" class="side-link">👤 Director</a>
                    <a href="{{route('divisions.index')}}" class="side-link">🏢 Division</a>
                    <a href="{{route('sub-divisions.index')}}" class="side-link">📍 Sub Division</a>
                    <a href="{{route('centers.index')}}" class="side-link">🏬 Center</a>
                    <a href="{{route('designations.index')}}" class="side-link">💼 Designation</a>
                    <a href="{{route('subcastes.index')}}" class="side-link">🧬 Subcaste</a>
                    <a href="{{route('general-ledgers.index')}}" class="side-link">📒 General Ledger</a>
                    <a href="{{route('agents.index')}}" class="side-link">🤝 Agent</a>
                    <a href="{{route('branches.index')}}" class="side-link">🏢 Branch</a>
                    <a href="{{route('departments.index')}}" class="side-link">🏛️ Department</a>
                </div>
            </div>
        </div>

        <!-- Accounts Section -->
        <div class="accordion-item bg-dark border-0">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#accountsMenu">
                    💳 Accounts
                </button>
            </h2>
            <div id="accountsMenu" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <a href="{{route('members.index')}}" class="side-link">👥 Manage Member</a>
                    <a href="{{route('member-depo-accounts.index')}}" class="side-link">🏦 Deposit Accounts</a>
                    <a href="{{route('member-loan-accounts.index')}}" class="side-link">💰 Loan Accounts</a>
                    <a href="{{route('accounts.index')}}" class="side-link">📑 General Accounts</a>
                    <a href="{{route('bank-investments.index')}}" class="side-link">🏦 Bank Investments</a>
                    <a href="{{route('standing-instructions.index')}}" class="side-link">📌 Standing Instructions</a>
                </div>
            </div>
        </div>

        <!-- Transactions Section -->
        <div class="accordion-item bg-dark border-0">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#transactionsMenu">
                    🔄 Transactions
                </button>
            </h2>
            <div id="transactionsMenu" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <a href="{{route('day-begins.index')}}" class="side-link">📅 Day Begins</a>
                    <a href="{{route('voucher-entry.index')}}" class="side-link">🧾 Voucher Entry</a>
                    <a href="{{route('transfer-entry.index')}}" class="side-link">💸 Transfer Entry</a>
                    <a href="{{route('branch-ledger.index')}}" class="side-link">📘 Branch Ledger</a>
                    <a href="{{route('day-end.index')}}" class="side-link">📆 Day Ends</a>
                    <a href="{{route('installment-transactions.index')}}" class="side-link">💳 Installment</a>
                </div>
            </div>
        </div>

        <!-- Interest -->
        <div class="my-2 ps-2">
            <a href="{{ route('interest.calculator') }}"
                class="nav-link text-white text-decoration-none d-block {{ request()->routeIs('interest.calculator') ? 'active' : '' }}">
                📈 Interest Calculator
            </a>
        </div>

        <!-- Reports Section -->
        <div class="accordion-item bg-dark border-0">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#reportsMenu">
                    📊 Reports
                </button>
            </h2>
            <div id="reportsMenu" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body">
                    <!-- Nested Reports Accordion -->
                    <div class="accordion" id="reportsAccordion">
                        <!-- Example Subcategory -->
                        <div class="accordion-item bg-dark border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#dailyReports">
                                    📅 Daily Reports
                                </button>
                            </h2>
                            <div id="dailyReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="{{route('cash-book.index')}}" class="side-link">💵 Cash Book</a>
                                    <a href="{{route('day-book.index')}}" class="side-link">📖 Day Book</a>
                                    <a href="{{route('sub-day-book.index')}}" class="side-link">📘 Sub Day Book</a>
                                    <a href="#" class="side-link">🧾 GL Statement Checking</a>
                                    <a href="#" class="side-link">✂️ Cut Book</a>
                                    <a href="#" class="side-link">📅 Demand Day Book</a>
                                </div>
                            </div>
                        </div>

                        <!-- Loan -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#loanReports">
                                    💳 Loan
                                </button>
                            </h2>
                            <div id="loanReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#" class="side-link">📄 Overdue Register</a>
                                    <a href="#" class="side-link">📋 NPA List</a>
                                    <a href="#" class="side-link">📈 Final NPA Chart</a>
                                    <a href="#" class="side-link">📊 Debit Loan Report</a>
                                    <a href="#" class="side-link">👥 Guarantor Register</a>
                                    <a href="#" class="side-link">🧾 Account Statement (Loan)</a>
                                </div>
                            </div>
                        </div>

                        <!-- Deposit -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#depositReports">
                                    🏦 Deposit
                                </button>
                            </h2>
                            <div id="depositReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#" class="side-link">📆 Deposit Maturity Register</a>
                                    <a href="#" class="side-link">📊 RD Chart</a>
                                    <a href="#" class="side-link">📈 FD Chart</a>
                                    <a href="#" class="side-link">📉 Interestwise Report</a>
                                    <a href="#" class="side-link">🧾 Interest Summary</a>
                                </div>
                            </div>
                        </div>

                        <!-- Share -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#shareReports">
                                    📈 Share
                                </button>
                            </h2>
                            <div id="shareReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#" class="side-link">📃 Share List</a>
                                    <a href="#" class="side-link">💰 Dividend Calculation</a>
                                    <a href="#" class="side-link">📊 Dividend Balance Report</a>
                                </div>
                            </div>
                        </div>

                        <!-- MIS -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#misReports">
                                    📊 MIS
                                </button>
                            </h2>
                            <div id="misReports" class="accordion-collapse collapse" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#" class="side-link">📑 Trial Balance</a>
                                    <a href="#" class="side-link">💳 Receipt Payment</a>
                                    <a href="#" class="side-link">📈 Profit Loss</a>
                                    <a href="#" class="side-link">📊 Balance Sheet</a>
                                    <a href="#" class="side-link">📉 CD Ratio</a>
                                    <a href="#" class="side-link">📋 MIS Report</a>
                                    <a href="#" class="side-link">📖 General Ledger Statements</a>
                                </div>
                            </div>
                        </div>

                        <!-- General -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#generalReports">
                                    ⚙️ General
                                </button>
                            </h2>
                            <div id="generalReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#" class="side-link">📄 Account Statement</a>
                                    <a href="#" class="side-link">📖 General Ledger Statement</a>
                                    <a href="#" class="side-link">👤 Member Statement</a>
                                    <a href="#" class="side-link">👥 Loan Guarantor Report</a>
                                    <a href="#" class="side-link">📋 Demand List</a>
                                </div>
                            </div>
                        </div>

                        <!-- Printing -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#printingReports">
                                    🖨️ Printing
                                </button>
                            </h2>
                            <div id="printingReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#" class="side-link">🖨️ Duplicate Printing</a>
                                    <a href="#" class="side-link">📒 Passbook Printing</a>
                                </div>
                            </div>
                        </div>


                        <!-- Audit -->
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#auditReports">
                                    🧾 Audit
                                </button>
                            </h2>
                            <div id="auditReports" class="accordion-collapse collapse"
                                data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <a href="#" class="side-link">📑 Trial Balance</a>
                                    <a href="#" class="side-link">📊 Balance Sheet</a>
                                    <a href="#" class="side-link">📈 Profit Loss</a>
                                </div>
                            </div>
                        </div> <!-- End of Reports Accordion -->

                        <!-- Repeat for Loan, Deposit, Share, MIS, etc... -->
                        <!-- Use unique IDs for each submenu collapse -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Custom CSS -->
<style>
.sidebar {
    width: 260px;
    background-color: #212529;
    color: white;
}

.accordion-button {
    font-weight: 600;
    font-size: 16px;
    transition: background 0.2s;
}

.accordion-button:hover,
.accordion-button:not(.collapsed) {
    background-color: #343a40;
}

/* Hover effect with opacity for accordion buttons */
.accordion-button:hover,
.accordion-button:not(.collapsed):hover {
    background-color: rgba(255, 255, 255, 0.1);
    /* subtle white opacity */
}

/* Active/open accordion menu background */
.accordion-button:not(.collapsed) {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Hover effect with opacity for side links */
.side-link:hover {
    color: white;
    padding-left: 10px;
    background-color: rgba(255, 255, 255, 0.05);
    /* subtle white opacity */
    border-radius: 4px;
    padding: 6px 8px;
    margin-left: -8px;
    margin-right: -8px;
    display: block;
}

.side-link {
    display: block;
    color: #adb5bd;
    padding: 6px 0;
    text-decoration: none;
    transition: color 0.2s, padding-left 0.2s;
}

.accordion-body a {
    font-size: 15px;
}

/* Make the accordion arrow white */
.accordion-button::after {
    filter: brightness(0) invert(1);
}

/* More specific dashboard link hover effect */
a.dashboard-link:hover {
    background-color: white !important;
    color: black !important;
    border-radius: 4px;
    padding: 6px 8px;
    display: inline-block;
}

/* Smooth transition for accordion collapse */
.accordion-collapse {
    transition: height 0.3s ease;
}

/* Hover effect with opacity for accordion buttons */
.accordion-button {
    transition: background-color 0.8s ease;
}

.accordion-button:hover,
.accordion-button:not(.collapsed):hover {
    background-color: rgba(255, 255, 255, 0.1);
    /* subtle white opacity */
}

/* Hover effect with opacity for side links */
.side-link {
    transition: color 0.8s ease, padding-left 0.3s ease, background-color 0.8s ease;
}

.side-link:hover {
    color: white;
    padding-left: 10px;
    background-color: rgba(255, 255, 255, 0.05);
    /* subtle white opacity */
    border-radius: 4px;
    padding: 6px 8px;
    margin-left: -8px;
    margin-right: -8px;
    display: block;
}

/* Dashboard link hover effect */
.dashboard-link {
    transition: background-color 0.8s ease, color 0.8s ease;
}

.dashboard-link:hover {
    background-color: white;
    color: black;
    border-radius: 4px;
    padding: 6px 8px;
    display: inline-block;
}
</style>