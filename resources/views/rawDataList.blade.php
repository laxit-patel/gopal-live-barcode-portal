<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../">
    <title>Display List</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ url('/theme') }}/assets/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ url('/theme') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/theme') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        
        thead th {
          position: sticky;
          top: 0;
        }
        table {
          border-collapse: collapse;        
          width: 100%;
        }
        th,
        td {
          padding: 8px 15px;
          border: 2px solid #529432;
        }
        th {
          background: #ABDD93;
        }
      </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-tablet-and-mobile-fixed aside-enabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            @include('layouts.partials.header')
            <div class="wrapper d-flex flex-column flex-row-fluid w-100" style="padding-left: 0px;" id="kt_wrapper">
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" style="padding: 0px;" id="kt_content">
                    <!--begin::Toolbar-->
                    @if($display_choice)
                    <div class="toolbar d-flex flex-stack mb-3 mb-lg-5" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap">
                            <form action="{{route('row.packing')}}" class="w-100" method="get">
                                <div class="d-flex align-items-center py-2 w-50">
                                    <div class="d-flex flex-column mb-7 fv-row w-50 ">
                                        <select name="plant_id" onchange="getlinedata(this.value)" aria-label="Select a Plant" data-control="select2" class="form-select form-select-solid fw-bolder">
                                            <option value="">Select a Plant...</option>
                                            @foreach ($plantData as $plant)
                                            <option {{Request::get('plant_id')==$plant->plant_id?'selected=""':''}} value="{{ $plant->plant_id }}">{{ $plant->plant_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex flex-column mb-7 fv-row w-50 mx-2">
                                        <select name="line_id" required id="line_id" aria-label="Select a Line" data-control="select2" class="form-select form-select-solid fw-bolder">
                                            <option value="">Select a Line...</option>
                                            @foreach ($lineData as $line)
                                            @if(Request::get('plant_id') ==$line->plant_id)
                                            <option {{Request::get('line_id')==$line->line_id?'selected=""':''}} value="{{ $line->line_id }}">{{ $line->line_name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex flex-column mb-7 fv-row w-50">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <!--end::Actions-->
                        </div>
                        <!--end::Container-->
                    </div>
                    @endif
                    <!--end::Toolbar-->
                    <!--begin::Post-->
                    @if(!empty(Request::get('plant_id')) && !empty(Request::get('line_id')))
                            <table class="table g-5 font-weight-bolder table-bordered rounded align-middle table-sm   " id="displayData">
                                <!--begin::Table head-->
                                
                                @if(isset($display_type) && $display_type == 'dispatch')
                                <thead >
                                    <tr class='bg-light-primary fs-2 text-start text-gray-800 fw-bolder fs-7 text-uppercase gs-0'>
                                    <td class='text-end'>Customer Name</td>
                                    <td colspan='' >{{@$customer[0]->name}}  </td>
                                    <td></td>
                                    <td></td>
                                    <td class='text-end'>Customer Number</td>
                                    <td colspan='' >{{ @$customer[0]->customer_number }}</td>
                                    </tr>
                                    <tr class='bg-light-primary fs-2 text-start text-gray-500 fw-bolder fs-7 text-uppercase gs-0'>
                                        <th class='text-center'>Product Code</th>
                                        <th >Product Name</th>
                                        <th >Barcode</th>
                                        <th class='text-center '>SO. Qty</th>
                                        <th class='text-center '>Qty</th>
                                        <th class='text-center '>Pending</th>
                                    </tr>
                                    </thead>
                                @else
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="bg-light-primary fs-2 text-start text-gray-500 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="text-center">Product Code</th>
                                        <th class="">Product Name</th>
                                        <th class="">Barcode</th>
                                        <th class="text-center ">No. Of Boxes</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                @endif
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class=""  style="min-height: auto">
                                    @if(count($productData))
                                    
                                    @if(isset($display_type) && $display_type == 'dispatch')

                                    

                                    @foreach($productData as $k=>$product)
                                    
                                    <tr class="fs-2 fw-bold text-gray-700">
                                        <td class="text-center">{{$product->product_id}}</td>
                                        <td class="">{{$product->description}}</td>
                                        <td class="">{{$product->barcode}}</td>
                                        <td class="text-center fw-boldest">{{$product->qty}}</td>
                                        <td class="text-center fw-boldest">{{$product->countQty}}</td>
                                        <td class="text-center fw-boldest">{{$product->pending}}</td>
                                    </tr>
                                    @endforeach

                                    @if($pending)
                                    @foreach ($pending as $key => $row)
                            
                                        <tr class='fs-2 text-gray-700 fw-bold bg-light-danger'>
                                        <td class='text-center '>{{$row->product_id}}</td>
                                        <td>{{$row->description}}</td>
                                        <td>{{$row->barcode}}</td>
                                        <td class='text-center fw-boldest fs-2'>{{$row->qty}}</td>
                                        <td class='text-center fw-boldest fs-2'>{{$row->countQty}}</td>
                                        <td class='text-center fw-boldest fs-2'>{{$row->pending}}</td>
                                        </tr>
                                    @endforeach
                                    @endif

                                    @elseif( isset($display_type) && $display_type == 'packing')
                                    @foreach($productData as $k=>$product)
                                    <tr class="fs-2 fw-bold text-gray-700">
                                        <td class="text-center">{{$product->material_code}}</td>
                                        <td class="">{{$product->description}}</td>
                                        <td class="">{{$product->barcode}}</td>
                                        <td class="text-center fw-boldest">{{$product->countQty}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in table</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            @endif
                    <!--end::Post-->
                </div>
                <!--end::Content-->

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Scrolltop-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = '{{ url("/theme") }}/assets/';
        var baseUrl = '{{ url("/") }}';

    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ url('/theme') }}/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ url('/theme') }}/assets/js/scripts.bundle.js"></script>

    <script src="{{ url('/theme') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/export.js"></script>
    <script src="{{ url('/theme') }}/assets/js/custom/apps/customers/add.js"></script>
    <script src="{{ url('/theme') }}/assets/js/custom/apps/customers/list/list.js"></script>
    <script src="{{ url('/theme') }}/assets/js/widgets.bundle.js"></script>
    {{-- <script src="{{ url('/theme') }}/assets/js/custom/widgets.js"></script> --}}
    {{-- <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/users-search.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
 
        $(document).ready(function() {
            var no = 0;
            var lastid = parseInt('<?php echo count($productData)?$productData[0]->dispatch_id:0;?>');
            var plant_id = '<?php echo Request::get("plant_id");?>';
            var line_id = '<?php echo Request::get("line_id");?>';
            if (plant_id != '' & line_id != '') {
                setInterval(function() {
                    $.ajax({
                        url: baseUrl + '/display-data/get/yes/' + lastid
                        , type: 'GET'
                        , data: {
                            'plant_id': plant_id
                            , 'line_id': line_id
                        }
                        , dataType: 'json'
                        , success: function(response) {
                             //alert(response);
                            if (response) {
                                $('#displayData').html(response);
                                // $('#totalRecordAdded').html(parseInt($('#totalRecordAdded').html()) + parseInt(response.tasks.length));
                            }
                        }
                        , error: function(err) {

                        }
                    })
                }, 300);
            }
            // getBarcode();

        });

        function getBarcode() {
            return false;
            var pageType = '/<?php echo $pageType;?>';
            $.ajax({
                url: baseUrl + pageType + '/getBarcode'
                , type: 'GET'
                , dataType: 'json'
                , success: function() {
                    // console.log(response);
                    getBarcode();
                }
                , error: function(err) {
                    console.log('Error: ' + err);
                    getBarcode();
                }
            })
        }

        function getlinedata(id) {
            $('#line_id').empty();
            for (var i = 0; i < lineArray.length; i++) {
                if (lineArray[i]['plant_id'] == id) {
                    $('#line_id').append('<option value="' + lineArray[i]['line_id'] + '">' + lineArray[i]['line_name'] +
                        '</option>');
                }
            }
        }

        var lineArray = '<?php echo json_encode($lineData); ?>';
        lineArray = JSON.parse(lineArray);

    </script>

    <script src="{{ url('/theme') }}/assets/js/widgets.bundle.js"></script>
    <script src="{{ url('/theme') }}/assets/js/custom/widgets.js"></script>
    <script src="{{ url('/theme') }}/assets/js/custom/apps/chat/chat.js"></script>
    <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/create-campaign.js"></script>
    <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
