<!-- <header class="container-fluid py-2 py-md-4 px-0 my-bg-primary">
    <div class="bg-white text-center pt-1 pt-md-2 mx-auto d-flex justify-content-evenly align-items-center">
        <h3 class="px-3 py-2 mb-1 mb-md-2 rounded text-white fw-bold my-bg-primary my-hero-text">
            महाराष्ट्र राज्य विद्युत क्षेत्र तांत्रिक कर्मचारी सहकारी पत संस्था मर्यादित, र. नं. 153
        </h3>
        <div class="profile">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                alt="profile">
            <button type="button" class="btn ms-3 logout-btn">Logout</button>
        </div>
    </div>
</header> -->

<!-- <header class="container-fluid py-2 py-md-4 px-0 my-bg-primary">
    <div
        class="bg-white text-center pt-2 mx-auto d-flex justify-content-between align-items-center flex-wrap header-content px-3">

        <h3 class="px-3 py-2 mb-1 mb-md-2 rounded text-white fw-bold my-bg-primary my-hero-text text-center">
            महाराष्ट्र राज्य विद्युत क्षेत्र तांत्रिक कर्मचारी सहकारी पत संस्था मर्यादित, र. नं. 153
        </h3>

        <div class="profile d-flex align-items-center">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                alt="profile">
            <a href="{{route('user.logout')}}"><button type="button" class="btn ms-2 logout-btn">Logout</button></a>
        </div>

    </div>
</header> -->

<header class="container-fluid py-3 px-0 my-bg-primary">
    <div class="d-flex justify-content-between align-items-center px-3">
        <!-- Title -->
        <h3 class="text-white fw-bold my-hero-text">
            महाराष्ट्र राज्य विद्युत क्षेत्र तांत्रिक कर्मचारी सहकारी पत संस्था मर्यादित, र. नं. 153
        </h3>

        <!-- Profile Section -->
        <div class="profile-dropdown position-relative">
            <div class="d-flex align-items-center profile-trigger dropdown-toggle" role="button"
                data-bs-toggle="dropdown">
                <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Profile" class="rounded-circle me-2" width="40" height="40">
                <span class="text-white fw-bold me-3">{{ Auth::user()->name }}</span>
            </div>
            <div class="dropdown-menu custom-dropdown-menu">
                <!-- <a class="dropdown-item" href="#">Edit Profile</a> -->
                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit
                    Profile</a>
                <a class="dropdown-item text-danger fw-bold" href="{{ route('user.logout') }}">Logout</a>
            </div>
        </div>
    </div>
</header>


<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editProfileForm" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header my-bg-primary text-white">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Profile Picture Upload -->
                    <!-- <div class="text-center mb-3">
                        <input type="file" id="profileImageInput" name="profile_picture" accept="image/*" hidden>
                        <label for="profileImageInput">
                            <img id="profilePreview" src="https://via.placeholder.com/100" class="rounded-circle border"
                                width="100" height="100" style="cursor:pointer;">
                        </label>
                        <div class="form-text">Click image to change</div>
                    </div> -->

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('profileImageInput').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('profilePreview').src = e.target.result;
    }
    reader.readAsDataURL(this.files[0]);
});
</script>