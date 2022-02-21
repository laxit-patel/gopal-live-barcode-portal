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
                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Configuration List</h1>
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
                    <li class="breadcrumb-item text-muted">Configuration</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-dark">List</li>
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
            <div class="card">
                @include('layouts.success_message')
                <div class="card-body w-50">
                    <form action="{{route('configuration')}}" method="post">@csrf
                        <input name="id" value="{{!empty($data->configurations_id)?$data->configurations_id:0}}" type="hidden" />
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold mb-2">
                                <span class="required">Production Voucher</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="productionVoucher" required class="form-select form-select-solid fw-bolder">
                                <option value="">Select a Type...</option>
                                <option value="everyMinute" {{$data->productionVoucher=='everyMinute'?'selected=""':''}}>Every Minute</option>
                                <option value="everyTwoMinutes" {{$data->productionVoucher=='everyTwoMinutes'?'selected=""':''}}>Every Two Minutes</option>
                                <option value="everyThreeMinutes" {{$data->productionVoucher=='everyThreeMinutes'?'selected=""':''}}>Every Three Minutes</option>
                                <option value="everyFourMinutes" {{$data->productionVoucher=='everyFourMinutes'?'selected=""':''}}>Every Four Minutes</option>
                                <option value="everyFiveMinutes" {{$data->productionVoucher=='everyFiveMinutes'?'selected=""':''}}>Every Five Minutes</option>
                                <option value="everyTenMinutes" {{$data->productionVoucher=='everyTenMinutes'?'selected=""':''}}>Every Ten Minutes</option>
                                <option value="everyFifteenMinutes" {{$data->productionVoucher=='everyFifteenMinutes'?'selected=""':''}}>Every Fifteen Minutes</option>
                                <option value="everyThirtyMinutes" {{$data->productionVoucher=='everyThirtyMinutes'?'selected=""':''}}>Every Thirty Minutes</option>
                                <option value="hourly" {{$data->productionVoucher=='hourly'?'selected=""':''}}>Hourly</option>
                                <option value="everyTwoHours" {{$data->productionVoucher=='everyTwoHours'?'selected=""':''}}>Every Two Hours</option>
                                <option value="everyThreeHours" {{$data->productionVoucher=='everyThreeHours'?'selected=""':''}}>Every Three Hours</option>
                                <option value="everyFourHours" {{$data->productionVoucher=='everyFourHours'?'selected=""':''}}>Every Four Hours</option>
                                <option value="everySixHours" {{$data->productionVoucher=='everySixHours'?'selected=""':''}}>Every Six Hours</option>
                                <option value="daily" {{$data->productionVoucher=='daily'?'selected=""':''}}>Daily</option>
                                <option value="Off" {{$data->productionVoucher=='Off'?'selected=""':''}}>OFF</option>
                            </select>
                        </div>
                        {{-- <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold mb-2">
                                <span class="required">Dispatch Voucher</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="dispatchVoucher" required class="form-select form-select-solid fw-bolder">
                                <option value="">Select a Type...</option>
                                <option value="everyMinute">Every Minute</option>
                                <option value="everyTwoMinutes">Every Two Minutes</option>
                                <option value="everyThreeMinutes">Every Three Minutes</option>
                                <option value="everyFourMinutes">Every Four Minutes</option>
                                <option value="everyFiveMinutes">Every Five Minutes</option>
                                <option value="everyTenMinutes">Every Ten Minutes</option>
                                <option value="everyFifteenMinutes">Every Fifteen Minutes</option>
                                <option value="everyThirtyMinutes">Every Thirty Minutes</option>
                                <option value="hourly">Hourly</option>
                                <option value="everyTwoHours">Every Two Hours</option>
                                <option value="everyThreeHours">Every Three Hours</option>
                                <option value="everyFourHours">Every Four Hours</option>
                                <option value="everySixHours">Every Six Hours</option>
                                <option value="daily">Daily</option>
                                <option value="Off">OFF</option>
                            </select>
                        </div> --}}
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold mb-2">
                                <span class="required">Raw Packing</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="rawPacking" required class="form-select form-select-solid fw-bolder">
                                <option value="">Select a Type...</option>
                                {{-- <option value="everyMinute">Every Minute</option>
                                <option value="everyTwoMinutes">Every Two Minutes</option>
                                <option value="everyThreeMinutes">Every Three Minutes</option>
                                <option value="everyFourMinutes">Every Four Minutes</option>
                                <option value="everyFiveMinutes">Every Five Minutes</option>
                                <option value="everyTenMinutes">Every Ten Minutes</option>
                                <option value="everyFifteenMinutes">Every Fifteen Minutes</option>
                                <option value="everyThirtyMinutes">Every Thirty Minutes</option>
                                <option value="hourly">Hourly</option>
                                <option value="everyTwoHours">Every Two Hours</option>
                                <option value="everyThreeHours">Every Three Hours</option>
                                <option value="everyFourHours">Every Four Hours</option>
                                <option value="everySixHours">Every Six Hours</option>
                                <option value="daily">Daily</option> --}}
                                <option value="On" {{$data->rawPacking=='On'?'selected=""':''}}>ON</option>
                                <option value="Off" {{$data->rawPacking=='Off'?'selected=""':''}}>OFF</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row w-50">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>


                    <div class="d-flex flex-column mb-7 fv-row w-50">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">Raw Packing Table</span>
                        </label>
                        <a href="{{route('raw.production.clear')}}" class="btn btn-danger">Clear Data</a>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row w-50">
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">Raw Dispatch Table</span>
                        </label>
                        <a href="{{route('raw.dispatch.clear')}}" class="btn btn-danger">Clear Data</a>
                    </div>
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
