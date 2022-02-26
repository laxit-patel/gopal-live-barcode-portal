<div id="kt_header" class="header header-bg">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Brand-->
        <div class="header-brand me-5">
            <!--begin::Aside toggle-->
            <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
                <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_toggle">
                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
                            <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
            </div>
            <!--end::Aside toggle-->
            <!--begin::Logo-->
            <a href="{{url('/')}}">
                <img alt="Logo" src="{{ asset('theme/assets/media/logos/favicon.png') }}" class="h-25px h-lg-30px d-none d-md-block" />
                <img alt="Logo" src="{{ asset('theme/assets/media/logos/favicon.png') }}" class="h-25px d-block d-md-none" />
            </a>
            `
            <!--end::Logo-->
        </div>
        <!--end::Brand-->
        <div class="d-flex align-items-center me-2 me-lg-4">
            @if (Session()->has('loggedData'))
            @if(Route::currentRouteName()=='row.packing')
            <a href="{{ route('dashboard') }}" class="btn btn-primary border-0 px-3  mx-5 px-lg-6">Home</a>
            @else
            <a href="{{ route('row.packing') }}" class="btn btn-primary border-0 px-3 px-lg-6 mx-5">Display Data</a>
            @endif
            <a href="{{ route('logout') }}" class="btn btn-success border-0 px-3 px-lg-6">Logout</a>
            @else
            <a href="{{ route('login') }}" class="btn text-white btn-active-primary border-0 px-3 px-lg-6">Login</a>
            @endif
            @if(isset($display_choice) && !$display_choice )
            <a href="{{ route('row.packing') }}" class="btn text-white btn-active-danger border-0 px-3 px-lg-6 ms-2">Exit</a>
            @endif
        </div>
        <!--begin::Topbar-->
        {{-- <div class="topbar d-flex align-items-stretch">
            <!--begin::Item-->

            <div class="d-flex align-items-stretch me-2 me-lg-4">
                <!--begin::Search-->
                <div id="kt_header_search" class="d-flex align-items-center header-search w-lg-250px"
                    data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter"
                    data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto"
                    data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                    <!--begin::Tablet and mobile search toggle-->
                    <div data-kt-search-element="toggle" class="d-flex d-lg-none align-items-center">
                        <div class="btn btn-icon btn-borderless btn-active-primary bg-white bg-opacity-10">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 svg-icon-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                        transform="rotate(45 17.0365 15.1223)" fill="black" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <!--end::Tablet and mobile search toggle-->
                    <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                    <form data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-2 mb-lg-0"
                        autocomplete="off">
                        <select name="plant_id" onchange="getlinedata(this.value)" aria-label="Select a Plant"
                            data-control="select2" class="form-select form-select-solid fw-bolder">
                            <option value="">Select a Plant...</option>
                            @foreach ($plantData as $plant)
                                <option value="{{ $plant->plant_id }}">{{ $plant->plant_name }}</option>
        @endforeach
        </select>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Search-->
</div>
<div class="d-flex align-items-stretch me-2 me-lg-4">
    <!--begin::Search-->
    <div id="kt_header_search" class="d-flex align-items-center header-search w-lg-250px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
        <!--begin::Tablet and mobile search toggle-->
        <div data-kt-search-element="toggle" class="d-flex d-lg-none align-items-center">
            <div class="btn btn-icon btn-borderless btn-active-primary bg-white bg-opacity-10">
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 svg-icon-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Tablet and mobile search toggle-->
        <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
        <form data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-2 mb-lg-0" autocomplete="off">
            <select name="line_id" required id="displayLineData" aria-label="Select a Line" data-control="select2" class="form-select form-select-solid fw-bolder">
                <option value="">Select a Line...</option>
            </select>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Search-->
</div>

</div> --}}
<!--end::Topbar-->
</div>
<!--end::Container-->
</div>
