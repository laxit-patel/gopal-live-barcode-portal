@extends('layouts.main')


@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack mb-3 mb-lg-5" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-5 py-2">
                <!--begin::Title-->
                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Login Form</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Home</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Loign</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Form</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-dark">{{ !empty($data) ? 'Update':'Create';}}</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div id="" class="card">
                {{-- <div id="" class="card-header p-4"> --}}
                {{-- </div> --}}
                <div class="card-body p-4">
                    <!--begin::Actions-->
                    <form action="{{route('login.save')}}" class="w-100" method="post">@csrf
                        <input name="login_id" value="{{ !empty($data) ? $data->login_id:0;}}" type="hidden" />
                        <div class="me-n7 pe-7">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 w-50">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="Name" name="name" value="{{ !empty($data) ? $data->name:'';}}" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <div class="fv-row mb-7 w-50">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Designation</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="Designation" name="designation" value="{{ !empty($data) ? $data->designation:'';}}" />
                                <!--end::Input-->
                            </div>
                            {{-- <div class="fv-row mb-7">
                                <label class="required fs-6 fw-bold mb-2">Role</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Designation" name="role" value="" />
                             </div> --}}
                            <div class="fv-row mb-7 w-50">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Username (Email ID)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" class="form-control form-control-solid" placeholder="Username" name="username" value="{{ !empty($data) ? $data->username:'';}}" />
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-7 w-50">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Password</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="password" class="form-control form-control-solid" placeholder="Password" name="password" value="" autocomplete="off" />
                                <!--end::Input-->
                            </div>
                            <div class="d-flex flex-column mb-7 fv-row w-50">
                                <button type="submit" class="btn btn-primary">Create Login</button>
                            </div>
                        </div>
                    </form>
                    <!--end::Actions-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->

@endsection


@section('scripts')

<script src="{{ url('/theme') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/export.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/add.js"></script>>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/list.js"></script>
<script src="{{ url('/theme') }}/assets/js/widgets.bundle.js"></script>
{{-- <script src="{{ url('/theme') }}/assets/js/custom/widgets.js"></script> --}}
{{-- <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/users-search.js"></script> --}}
@endsection
