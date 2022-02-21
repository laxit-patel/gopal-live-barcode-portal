<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../">
    <title>@yield('title')</title>
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
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    {{-- <link href="{{ url('/theme') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
    <link href="{{ url('/theme') }}/assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" /> --}}
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ url('/theme') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/theme') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-tablet-and-mobile-fixed aside-enabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            {{-- <div id="kt_aside" class="aside py-9" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
                <!--begin::Aside menu-->
                @include('layouts.partials.sidebar')
                <!--end::Aside menu-->
            </div> --}}
            <!--end::Aside-->
            <!--begin::Wrapper-->
            @include('layouts.partials.header')
            <div class="wrapper d-flex flex-column flex-row-fluid w-100" style="padding-left: 0px;" id="kt_wrapper">
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    <div class="toolbar d-flex flex-stack mb-3 mb-lg-5" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap">
                            <!--begin::Page title-->
                            {{-- <div class="page-title d-flex flex-column me-5 py-2">
                                <!--begin::Title-->
                                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Row Packing / Production</h1>
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
                                    <li class="breadcrumb-item text-muted">Production</li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-dark">Row Packing</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div> --}}
                            <!--end::Page title-->
                            <!--begin::Actions-->
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
                    <!--end::Toolbar-->
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl">
                            <!--begin::Row-->
                            @if(!empty(Request::get('plant_id')) && !empty(Request::get('line_id')))
                            <div id="" class="card">
                                {{-- <div id="" class="card-header p-4"> --}}
                                {{-- </div> --}}
                                <div class="card-body p-4">
                                    <div class="d-flex flex-column fv-row w-100">
                                        <b>Total No of Items added - <small id="totalRecordAdded">{{count($productData)?count($productData):0}}</small></b>
                                    </div>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="text-center">#</th>
                                                <th class="text-center">Product Code</th>
                                                <th class="">Product Name</th>
                                                <th class="">Barcode</th>
                                                <th class="">UOM</th>
                                                {{-- <th class="text-center ">No of Package per Box</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="" id="displayData">
                                            @if(count($productData))
                                            @foreach($productData as $k=>$product)
                                            <tr>
                                                <td class="text-center">{{count($productData)-$k}}</td>
                                                <td class="text-center">{{$product->material_code}}</td>
                                                <td class="">{{$product->description}}</td>
                                                <td class="">{{$product->barcode}}</td>
                                                <td class="">Box</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="6" class="text-center">No data available in table</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                            </div>

                            @endif
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->

                <!--begin::Footer-->
                @include('layouts.partials.footer')
                <!--end::Footer-->
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
            var no = parseInt('<?php echo count($productData);?>');
            var lastid = parseInt('<?php echo count($productData)?$productData[0]["raw_packing_id"]:0;?>');
            var plant_id = '<?php echo Request::get("plant_id");?>';
            var line_id = '<?php echo Request::get("line_id");?>';
            setInterval(function() {
                $.ajax({
                    url: baseUrl + '/row-packing-production/get/yes/' + lastid
                    , type: 'GET'
                    , data: {                        'plant_id': plant_id, 'line_id': line_id
                    }
                    , dataType: 'json'
                    , success: function(response) {
                        //  alert(response);
                        if (response.tasks.length > 0) {
                            var tasks = '';
                            for (var i = 0; i < response.tasks.length; i++) {
                                if (no == 0) {
                                    $('#displayData').empty();
                                }
                                tasks = tasks + '<tr>';
                                tasks = tasks + '<td class="text-center">' + (no + 1) + '</td>';
                                tasks = tasks + '<td class="text-center">' + response.tasks[i]['material_code'] + '</td>';
                                tasks = tasks + '<td>' + response.tasks[i]['description'] + '</td>';
                                tasks = tasks + '<td>' + response.tasks[i]['barcode'] + '</td>';
                                tasks = tasks + '<td>Box</td>';
                                // tasks = tasks + '<td></td>';
                                tasks = tasks + '</tr>';
                                no++;
                            }
                            lastid = response.tasks[0]['raw_packing_id'];
                            $('#displayData>tr:first').before(tasks);
                            $('#totalRecordAdded').html(parseInt($('#totalRecordAdded').html()) + parseInt(response.tasks.length));
                        }
                    }
                    , error: function(err) {

                    }
                })
            }, 10000);
            // var lineArray = <?php echo json_encode($lineData); ?>;
        });

        function getlinedata(id) {
            $('#line_id').empty();
            for (var i = 0; i < lineArray.length; i++) {
                if (lineArray[i]['plant_id'] == id) {
                    $('#line_id').append('<option value="' + lineArray[i]['line_id'] + '">' + lineArray[i]['line_name'] +
                        '</option>');
                }
            }
        }

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


<script>
    var lineArray = '<?php echo json_encode($lineData); ?>';
    lineArray = JSON.parse(lineArray);

</script>
