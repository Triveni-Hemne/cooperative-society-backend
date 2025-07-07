
<a href="#" 
   class="d-flex gap-2 text-decoration-none align-items-center justify-content-end ms-auto"
   data-bs-toggle="modal"
   data-bs-target="{{ $target }}" id="{{$id}}">
    
    <p class="d-block d-md-none my-bg-primary rounded-circle d-flex justify-content-center align-items-center"
        style="width: 30px; height: 30px;">
        <i class="fa fa-plus text-white" style="font-size:20px"></i>
    </p>
    
    <p class="d-none d-md-block btn my-bg-primary text-light">
        <i class="fa fa-plus me-1"></i>{{ $text }}
    </p>
</a>
