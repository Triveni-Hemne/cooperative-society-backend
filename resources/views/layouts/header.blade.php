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
        <div class="d-flex align-items-center">
            <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Profile" class="rounded-circle me-2" width="40" height="40">
            <span class="text-white fw-bold me-3">{{ Auth::user()->name }}</span>
            <a href="{{ route('user.logout') }}" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</header>