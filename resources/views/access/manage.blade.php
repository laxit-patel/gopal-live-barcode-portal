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
                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Role</h1>
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
            <div class="d-flex align-items-center py-2">
                <!--begin::Button-->
                <a href="{{ route('access.role') }}"  class="btn btn-primary me-2" >Roles</a>
                <a href="{{ route('access.list') }}"  class="btn btn-primary" >Access List</a>
                <!--end::Button-->
            </div>
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
                    @include('layouts.success_message')
                    <!--begin::Actions-->
                    <form action="{{route('access.create')}}" class="w-100" method="post">@csrf
                        
                        <div class="me-n7 pe-7">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 w-50">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Select Role</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select" name="role_id" aria-label="Select example">
                                    <option selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->role_id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row w-50 ">
                                <select name="plant_id" onchange="getlinedata(this.value)" aria-label="Select a Plant" data-control="select2" class="form-select form-select-solid fw-bolder">
                                    <option value="">Select a Plant...</option>
                                    @foreach ($plants as $plant)
                                    <option {{Request::get('plant_id')==$plant->plant_id?'selected=""':''}} value="{{ $plant->plant_id }}">{{ $plant->plant_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-7 fv-row w-50 ">
                                <select name="line_id" required id="line_id" aria-label="Select a Line" data-control="select2" class="form-select form-select-solid fw-bolder">
                                    <option value="">Select a Line...</option>
                                    @foreach ($lines as $line)
                                    @if(Request::get('plant_id') ==$line->plant_id)
                                    <option {{Request::get('line_id')==$line->line_id?'selected=""':''}} value="{{ $line->line_id }}">{{ $line->line_name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex flex-column mb-7 fv-row w-50">
                                <button type="submit" class="btn btn-primary">Grant Access</button>
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

<script>

function getlinedata(id) {
            $('#line_id').empty();
            for (var i = 0; i < lineArray.length; i++) {
                if (lineArray[i]['plant_id'] == id) {
                    $('#line_id').append('<option value="' + lineArray[i]['line_id'] + '">' + lineArray[i]['line_name'] +
                        '</option>');
                }
            }
        }

        var lineArray = '<?php echo json_encode($lines); ?>';
        lineArray = JSON.parse(lineArray);

</script>
@endsection
