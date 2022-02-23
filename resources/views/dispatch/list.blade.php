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
                                    <td class="text-center ">{{$row->product_id }}</td>
                                    <td>{{$row->description }}</td>
                                    <td>{{$row->barcode }}</td>
                                    <td class="text-center ">{{$row->qty }}</td>
                                    <td class="text-center ">{{$row->unit }}</td>
                                    <td class="text-center ">{{$row->plant_id }}</td>
                                    <td class="text-center ">
                                        <button type="button" data-id="{{ $row->dispatch_id }}" class="btn btn-sm btn-primary btn-hover-grow" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            Map
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->
<div class="modal fade " tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form action="{{ route('dispatch.update.line') }}" method="post">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title">Line Mapping</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">

                
                    <input type="hidden" name="dispatch_id" id="dispatch_id">
                
                    <div class="mb-10">
                        <label for="" class="form-label">Select Plant</label>
                        <select name="plant_id" class="form-select" aria-label="Select example" onchange="fetchLine(this)">
                            <option selected disabled>Select Plant</option>
                            @foreach ($plantData as $plant)
                            <option value="{{ $plant->plant_id }}">{{ $plant->plant_name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="mb-10">
                        <label for="" class="form-label">Select Line</label>
                        <select name="line_id" class="form-select" id="line_selector">
                        </select>
                    </div> 
                

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')

<script src="{{ url('/theme') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/export.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/add.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/list.js"></script>
<script src="{{ url('/theme') }}/assets/js/widgets.bundle.js"></script>

<script>

    $('#kt_modal_1').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data('id'); 
        $(this).find('#dispatch_id').val(data);
    });

    function fetchLine(e)
    {
        $.ajax({
            url: "{{ route('plant.line.fetch') }}",
            type: "GET",
            data: {
                'plant':e.value
            },
            success: function(lines){
                $('#line_selector').find('option').remove().end()
                .append('<option selected disabled>Select Line</option>');
                $.each(lines, function(counter,line) {
                    $('#line_selector').append($('<option>', {
                        value: line['line_id'],
                        text: line['line_name']
                    }));
                });

            }
        });
    }

</script>
{{-- <script src="{{ url('/theme') }}/assets/js/custom/widgets.js"></script> --}}
{{-- <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/users-search.js"></script> --}}

@endsection
