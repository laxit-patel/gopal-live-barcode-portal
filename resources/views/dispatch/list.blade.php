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
                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Final Dispatch Data</h1>
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
                    <li class="breadcrumb-item text-muted">Dispatch</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-dark">Update Data</li>
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
                <div class="card-body p-4">
                    <form action="{{route('dispatch.update')}}" class="w-100" method="post">@csrf
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center">#</th>
                                    <th class="text-left">Product Code</th>
                                    <th class="">Product Name</th>
                                    <th class="">Barcode</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center ">Plant Code</th>
                                    <th class="text-center ">Line Code</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody id="displayData">
                                @foreach ($dispatchData as $k=>$row)
                                <tr>
                                    <td class="text-center ">{{$k+1}}</td>
                                    <td class="text-center ">{{$row->material_code }}</td>
                                    <td>{{$row->description }}</td>
                                    <td>{{$row->barcode }}</td>
                                    <td class="text-center ">{{$row->qty }}</td>
                                    <td class="text-center ">{{$row->unit }}</td>
                                    <td class="text-center ">{{$row->plant_id }}</td>
                                    <td class="text-center "><select name="line_id[{{$row->dispatch_id }}]" class="form-control">
                                            <option value=""></option>
                                            @foreach ($lineData as $line)
                                            @if($line->plant_id==$row->plant_id)
                                            <option value="{{$line->line_id}}">{{$line->line_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>

                        <div class="d-flex flex-column mb-7 text-center">
                            <div class="w-25">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
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
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/add.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/list.js"></script>
<script src="{{ url('/theme') }}/assets/js/widgets.bundle.js"></script>
{{-- <script src="{{ url('/theme') }}/assets/js/custom/widgets.js"></script> --}}
{{-- <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/users-search.js"></script> --}}

@endsection
