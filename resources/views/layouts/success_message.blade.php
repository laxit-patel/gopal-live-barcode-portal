<!-- use it to display success message after database insertion -->
<!-- to fire this message, simply add this code at the end of controller method -> [ return redirect('/any route you want to redirect on')->with('message','Custom Message'); ] -->
  
     @if (Session::has('message'))
    <div class="alert alert-custom alert-primary fade show" role="alert">
        <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
        <div class="alert-text">{!! Session::get('message') !!}</div>
        {{-- <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div> --}}
    </div>
	@endif

    @if (Session::has('error'))
    <div class="alert alert-custom alert-danger fade show" role="alert">
        <div class="alert-icon"><i class="flaticon2-warning"></i></div>
        <div class="alert-text">{!! Session::get('error') !!}</div>
        {{-- <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div> --}}
    </div>
	@endif

    @if (Session::has('success'))
    <div class="alert alert-custom alert-success fade show" role="alert">
        <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
        <div class="alert-text">{!! Session::get('success') !!}</div>
        {{-- <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div> --}}
    </div>
	@endif

    @if($errors->any())
    <div class="alert alert-custom alert-danger fade show" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <ul class="alert-text">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        {{-- <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div> --}}
    </div>
    @endif