<div class="aside-menu flex-column-fluid ps-5 pe-3" id="kt_aside_menu">
    <!--begin::Aside Menu-->
    <div class="w-100 hover-scroll-overlay-y d-flex pe-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_footer, #kt_header" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper" data-kt-scroll-offset="102">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded fw-bold" id="#kt_aside_menu" data-kt-menu="true">

            <a href="">
                <img alt="Logo" src="{{ asset('theme/assets/media/logos/gopal.png') }}" class="mx-auto d-none d-md-block h-100" />
                <img alt="Logo" src="{{ asset('theme/assets/media/logos/gopal.png') }}" class="mx-auto d-block d-md-none" />
            </a>

            <div class="menu-item">
                <a class="menu-link {{ Request::routeIs(['dashboard', 'dashboard.*']) ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                        <span class="svg-icon svg-icon-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                                <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Dashboards</span>
                </a>
            </div>
            {{-- <div class="menu-item">
                <a class="menu-link {{ Request::routeIs(['row.packing', 'row.packing.*']) ? 'active' : '' }}"
            href="{{ route('row.packing') }}">
            <span class="menu-icon">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                <span class="svg-icon svg-icon-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                        <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </span>
            <span class="menu-title">Packing / Production</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['row.dispatch', 'row.dispatch.*']) ? 'active' : '' }}" href="{{ route('row.dispatch') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Dispatch</span>
            </a>
        </div> --}}
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['plant', 'plant.*']) ? 'active' : '' }}" href="{{ route('plant') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Plant</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['line', 'line.*']) ? 'active' : '' }}" href="{{ route('line') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Line</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['barcode', 'barcode.*']) ? 'active' : '' }}" href="{{ route('barcode') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Barcode</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['production', 'production.*']) ? 'active' : '' }}" href="{{ route('production') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Production</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['dispatch', 'dispatch.*']) ? 'active' : '' }}" href="{{ route('dispatch') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Dispatch</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['product', 'product.*']) ? 'active' : '' }}" href="{{ route('product') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Product</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['configuration', 'configuration.*']) ? 'active' : '' }}" href="{{ route('configuration') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Configuration</span>
            </a>
        </div>
        @if(session()->get('loggedData')['role'] == 'admin')
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['login', 'login.*']) ? 'active' : '' }}" href="{{ route('login.list') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Manage Login</span>
            </a>
        </div>
        @endif

        @if(session()->get('loggedData')['role'] == 'admin')
        <div class="menu-item">
            <a class="menu-link {{ Request::routeIs(['access', 'access.*']) ? 'active' : '' }}" href="{{ route('access.list') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Manage Access</span>
            </a>
        </div>
        @endif
        <div class="menu-item">
            <a class="menu-link" href="{{ route('logout') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Sign out</span>
            </a>
        </div>
    </div>
    <!--end::Menu-->
</div>
<!--end::Aside Menu-->

</div>
