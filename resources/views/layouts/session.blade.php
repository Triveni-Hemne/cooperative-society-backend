{{-- <div class="position-absolute top-0 start-50 translate-middle-x mt-3 w-50" style="z-index: 1100;">
    @if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">{{Session::get('error')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">{{Session::get('success')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div> --}}

<div class="position-fixed top-0 ms-auto translate-middle-x my-5 py-5" style="z-index: 1100;right:-150">
    @if(Session::has('error'))
        <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ Session::get('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(Session::has('success'))
        <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ Session::get('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>
