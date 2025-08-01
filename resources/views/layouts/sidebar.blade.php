<!-- Sidebar -->
<!-- Hamburger button (place this in your header or top bar) -->
<div class="d-flex justify-content-between">
    <button class="btn btn-dark m-2 d-lg-none navbar-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
  <span class="navbar-toggler-icon"></span>
</button>

<!-- Profile Section for large screen -->
        <div class="profile-dropdown position-relative d-block d-lg-none m-2">
            <div class="d-flex align-items-center profile-trigger dropdown-toggle" role="button"
                data-bs-toggle="dropdown">
               @if( Auth::user()->profile)
                    <img id="profilePreview" src="{{asset('storage/'.Auth::user()->profile)}}" class="rounded-circle border me-1"
                        width="40" height="40" style="cursor:pointer;">
                @else
                    <i class="bi bi-person-circle fs-1 me-1" style="cursor:pointer;"></i>
                @endif
                <span class="text-dark fw-bold me-3">{{ Auth::user()->name }}</span>
            </div>
            <div class="dropdown-menu custom-dropdown-menu">
                <!-- <a class="dropdown-item" href="#">Edit Profile</a> -->
                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit
                    Profile</a>
                <a class="dropdown-item text-danger fw-bold" href="{{ route('user.logout') }}">Logout</a>
            </div>
        </div>
</div>

<div class="offcanvas offcanvas-start bg-dark text-white d-lg-none" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="navbar-expand-lg sidebar bg-dark text-white">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            @include('layouts.side-navigation', ['prefix' => 'mobile'])
        </nav>
    </div>
</div>

<nav class="sidebar bg-dark text-white d-none d-lg-block">
@include('layouts.side-navigation', ['prefix' => 'desktop'])
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
    /* font-size: 16px; */
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
    display: block;
}

.side-link {
    display: block;
    color: #adb5bd;
    text-decoration: none;
    transition: color 0.2s, padding-left 0.2s;
}

.accordion-body a {
    /* font-size: 15px; */
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

/* Dashboard link hover effect */
.dashboard-link {
    transition: background-color 0.8s ease, color 0.8s ease;
}
</style>