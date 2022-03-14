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
                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Line Items</h1>
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
                    <li class="breadcrumb-item text-dark">Line Items</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
                <div class="d-flex align-items-center py-2">
                    <!--begin::Button-->
                    <a href="{{ route('dispatch') }}"  class="btn btn-primary" >Dispatch List</a>
                    <!--end::Button-->
                </div>
                <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            @include('layouts.success_message')

            <!--begin::Card-->
            <div class="card shadow-lg card-flush pt-3 mb-5 mb-lg-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="fw-bolder">Order Details </h2>&nbsp&nbsp<h5>(Total Box - <span id='count'>0</span>)</h5>
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                        @if ($OrderDetails->line_no)
                            @if (@$processing->status)
                                @if (@$processing->status == 1 && @$processing->status == 2)
                                loading
                                @else
                                <a href="{{ route('dispatch.read.stop',[
                                    'so' => @$OrderDetails->so_po_no,   
                                    ]) }}" type="button" class="btn btn-danger btn-hover-scale me-3">Stop</a>
                                @endif
                            @else
                            <a href="{{ route('dispatch.read',[
                                'so' => @$OrderDetails->so_po_no,
                                ]) }}" type="button" class="btn btn-primary btn-hover-scale me-3">Start</a>
                            @endif
                        @endif

                        <!--begin::Add user-->
                        @if($pendingLineItems > 0)
                        <a href="{{ route('push.po.items',[
                            'order' => @$OrderDetails->so_po_no,
                            'plant' => @$OrderDetails->plant,
                            'line' => @$OrderDetails->line_no,
                            ]) }}" type="button" class="btn btn-success btn-hover-scale">
                        <i class="fa fa-check"></i> Completed</a>
                        @endif
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0  ">

                    <div class="table-responsive">
                        <table class="table table-rounded table-striped border " id='table'>
                            <thead>
                                <tr class="fw-bolder  w-100 fs-6 text-gray-800 border-bottom border-gray-200">
                                    <th class="fw-bold">SO PO No.</th>
                                    <th class="fw-bold">PO NO</th>
                                    <th class="fw-bold">Plant</th>
                                    <th class="fw-bold">Line No.</th>
                                    <th class="fw-bold">Sales Org</th>
                                    <th class="fw-bold">Dist Chan</th>
                                    <th class="fw-bold">Amount</th>
                                </tr>
                               </thead>
                         <tbody>
                            <tr>
                                <td>{{ @$OrderDetails->so_po_no }}</td>
                                <td>{{ @$OrderDetails->po_no }}</td>
                                <td>{{ @$OrderDetails->plant }}</td>
                                <td>{{ @$OrderDetails->line_name }}</td>
                                <td>{{ @$OrderDetails->sales_org }}</td>
                                <td>{{ @$OrderDetails->dist_chan }}</td>
                                <td>{{ @$OrderDetails->total }}</td>
                            </tr>
                         </tbody>
                        </table>
                    </div>

                </div>
                <!--end::Card body-->
            </div>

            <div id="" class="card shadow-lg">
                <div class="card-body p-4">
                    <form action="{{route('dispatch.update')}}" class="w-100" method="post">@csrf
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-left">Material Code</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-left ">Barcode</th>
                                    <th class="text-left ">Sales Voucher</th>
                                    <th class="text-left ">SO Qty.</th>
                                    <th class="text-center ">Qty</th>
                                    <th class="text-center ">Pending Qty</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody id="displayData">
                                <?php $aa = 0;?>
                                @foreach ($lineItems as $k=>$item)
                                <?php $aa += ($item->read_qty) ? $item->read_qty : $item->countQty; ?>
                                <tr>
                                    <td class="text-left ">{{$item->product_id }}</td>
                                    <td class="text-left ">{{$item->description }}</td>
                                    <td class="text-left ">{{$item->barcode }}</td>
                                    <td class="text-left ">{{$item->sales_voucher }}</td>
                                    <td class="text-center ">{{$item->qty }}</td>
                                    <td class="text-center ">{{ ($item->read_qty) ? $item->read_qty : $item->countQty }}</td>
                                    <td class="text-center ">{{ ($item->read_qty) ? ($item->qty - $item->read_qty) : $item->pending }}</td>
                                </tr>
                                @endforeach
                                
                                @if($nagative)
                                    @foreach ($nagative as $key => $row)
                                    
                                        <tr class="bg-light-danger">
                                        <td class=' '>{{$row->material_code}}</td>
                                        <td>{{$row->description}}</td>
                                        <td>{{$row->barcode}}</td>
                                        <td></td>
                                        <td class='text-center '>{{$row->qty}}</td>
                                        <td class='text-center '>{{$row->countQty}}</td>
                                        <td class='text-center '>{{$row->pending}}</td>
                                        <td class='text-center '><?php echo  $row->countQty; ?></td>
                                        </tr>
                                    @endforeach
                                @endif
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
@endsection

@section('scripts')

<script src="{{ url('/theme') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/export.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/add.js"></script>
<script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/list.js"></script>
<script src="{{ url('/theme') }}/assets/js/widgets.bundle.js"></script>
<script src="{{ url('/theme') }}/assets/js/delete.js"></script>

<script>
     var baseUrl = '{{ url("/") }}';
     var plant = '{{ @$OrderDetails->plant }}';
     var line = '{{ @$OrderDetails->line_no }}';
     var po = '{{ @$OrderDetails->so_po_no }}';
    
    $(document).ready(function() {
        $('#count').html(<?=$aa?>);
        <?php if(@$lineItems[0]->status == 0 ){?>
        setInterval(function() {
                $.ajax({
                    url: baseUrl + '/dispatch/get/pending/'+plant+'/'+line+'/'+po
                    , type: 'GET' 
                    , dataType: 'json'
                    , success: function(response) {
                            //alert(response);
                        if (response) {
                            $('#displayData').html(response.html);
                            $('#count').html(response.count);
                            // $('#totalRecordAdded').html(parseInt($('#totalRecordAdded').html()) + parseInt(response.tasks.length));
                        }
                    },
                })
            }, 500);
            <?php }?>
        });
</script>
{{-- <script src="{{ url('/theme') }}/assets/js/custom/widgets.js"></script> --}}
{{-- <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/users-search.js"></script> --}}

@endsection
