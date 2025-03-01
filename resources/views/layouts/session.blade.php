<div class="position-absolute top-0 start-50 translate-middle-x mt-3 w-50" style="z-index: 1100;">
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
</div>