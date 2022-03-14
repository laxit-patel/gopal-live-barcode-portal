@extends('layouts.main')

@section('style')
<link href="{{ url('/assets') }}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<!--begin::Content-->
<div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
    <!--begin::Container-->
    <div class="container" id="kt_docs_content_container">
        <!--begin::Card-->
        <div class="card card-docs mb-2">
            <!--begin::Card Body-->
            <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
                
                <!--begin::Section-->
                <div class="pt-10">
                    
                    <!--begin::Block-->
                    <div class="py-5">
                        <table class="table align-middle table-row-dashed fs-6 gy-3"
                            id="subdatatable">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px">Order ID</th>
                                    <th class="text-end min-w-100px">Created</th>
                                    <th class="text-end min-w-150px">Customer</th>
                                    <th class="text-end min-w-100px">Total</th>
                                    <th class="text-end min-w-100px">Profit</th>
                                    <th class="text-end min-w-50px">Status</th>
                                    <th class="text-end"></th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bolder text-gray-600">
                                <!--begin::SubTable template-->
                                <tr data-kt-docs-datatable-subtable="subtable_template"
                                    class="bg-lighten d-none">
                                    <td colspan="2">
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="#" class="symbol symbol-50px">
                                                <img src="assets/media/stock/ecommerce/" alt=""
                                                    data-kt-docs-datatable-subtable="template_image" />
                                            </a>
                                            <div class="d-flex flex-column text-muted">
                                                <a href="#"
                                                    class="text-dark text-hover-primary fw-bolder"
                                                    data-kt-docs-datatable-subtable="template_name">Product
                                                    name</a>
                                                <div class="fs-7"
                                                    data-kt-docs-datatable-subtable="template_description">
                                                    Product description</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-dark fs-7">Cost</div>
                                        <div class="text-muted fs-7 fw-bolder"
                                            data-kt-docs-datatable-subtable="template_cost">1</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-dark fs-7">Qty</div>
                                        <div class="text-muted fs-7 fw-bolder"
                                            data-kt-docs-datatable-subtable="template_qty">1</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-dark fs-7">Total</div>
                                        <div class="text-muted fs-7 fw-bolder"
                                            data-kt-docs-datatable-subtable="template_total">name</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-dark fs-7 me-3">On hand</div>
                                        <div class="text-muted fs-7 fw-bolder"
                                            data-kt-docs-datatable-subtable="template_stock">32</div>
                                    </td>
                                    <td></td>
                                </tr>
                                <!--end::SubTable template-->
                                <tr>
                                    <!--begin::Order ID-->
                                    <td>
                                        <a href="#" class="text-dark text-hover-primary">#XGT-346</a>
                                    </td>
                                    <!--end::Order ID-->
                                    <!--begin::Crated date-->
                                    <td class="text-end">26 November 2021, 6:58 am</td>
                                    <!--end::Created date-->
                                    <!--begin::Customer-->
                                    <td class="text-end">
                                        <a href="" class="text-dark text-hover-primary">Emma Smith</a>
                                    </td>
                                    <!--end::Customer-->
                                    <!--begin::Total-->
                                    <td class="text-end">$630.00</td>
                                    <!--end::Total-->
                                    <!--begin::Profit-->
                                    <td class="text-end">
                                        <span class="text-dark fw-bolder">$86.70</span>
                                    </td>
                                    <!--end::Profit-->
                                    <!--begin::Status-->
                                    <td class="text-end">
                                        <span
                                            class="badge py-3 px-4 fs-7 badge-light-warning">Pending</span>
                                    </td>
                                    <!--end::Status-->
                                    <!--begin::Actions-->
                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                                            data-kt-docs-datatable-subtable="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12"
                                                        height="2" rx="1" transform="rotate(-90 11 18)"
                                                        fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                    <!--end::Actions-->
                                </tr>
                                <tr>
                                    <!--begin::Order ID-->
                                    <td>
                                        <a href="#" class="text-dark text-hover-primary">#YHD-047</a>
                                    </td>
                                    <!--end::Order ID-->
                                    <!--begin::Crated date-->
                                    <td class="text-end">26 November 2021, 6:06 am</td>
                                    <!--end::Created date-->
                                    <!--begin::Customer-->
                                    <td class="text-end">
                                        <a href="" class="text-dark text-hover-primary">Melody Macy</a>
                                    </td>
                                    <!--end::Customer-->
                                    <!--begin::Total-->
                                    <td class="text-end">$25.00</td>
                                    <!--end::Total-->
                                    <!--begin::Profit-->
                                    <td class="text-end">
                                        <span class="text-dark fw-bolder">$4.20</span>
                                    </td>
                                    <!--end::Profit-->
                                    <!--begin::Status-->
                                    <td class="text-end">
                                        <span
                                            class="badge py-3 px-4 fs-7 badge-light-primary">Confirmed</span>
                                    </td>
                                    <!--end::Status-->
                                    <!--begin::Actions-->
                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                                            data-kt-docs-datatable-subtable="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12"
                                                        height="2" rx="1" transform="rotate(-90 11 18)"
                                                        fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                    <!--end::Actions-->
                                </tr>
                                <tr>
                                    <!--begin::Order ID-->
                                    <td>
                                        <a href="#" class="text-dark text-hover-primary">#SRR-678</a>
                                    </td>
                                    <!--end::Order ID-->
                                    <!--begin::Crated date-->
                                    <td class="text-end">26 November 2021, 2:58 am</td>
                                    <!--end::Created date-->
                                    <!--begin::Customer-->
                                    <td class="text-end">
                                        <a href="" class="text-dark text-hover-primary">Max Smith</a>
                                    </td>
                                    <!--end::Customer-->
                                    <!--begin::Total-->
                                    <td class="text-end">$1,630.00</td>
                                    <!--end::Total-->
                                    <!--begin::Profit-->
                                    <td class="text-end">
                                        <span class="text-dark fw-bolder">$203.90</span>
                                    </td>
                                    <!--end::Profit-->
                                    <!--begin::Status-->
                                    <td class="text-end">
                                        <span
                                            class="badge py-3 px-4 fs-7 badge-light-warning">Pending</span>
                                    </td>
                                    <!--end::Status-->
                                    <!--begin::Actions-->
                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                                            data-kt-docs-datatable-subtable="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12"
                                                        height="2" rx="1" transform="rotate(-90 11 18)"
                                                        fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                    <!--end::Actions-->
                                </tr>
                                <tr>
                                    <!--begin::Order ID-->
                                    <td>
                                        <a href="#" class="text-dark text-hover-primary">#PXF-534</a>
                                    </td>
                                    <!--end::Order ID-->
                                    <!--begin::Crated date-->
                                    <td class="text-end">25 November 2021, 6:58 am</td>
                                    <!--end::Created date-->
                                    <!--begin::Customer-->
                                    <td class="text-end">
                                        <a href="" class="text-dark text-hover-primary">Sean Bean</a>
                                    </td>
                                    <!--end::Customer-->
                                    <!--begin::Total-->
                                    <td class="text-end">$119.00</td>
                                    <!--end::Total-->
                                    <!--begin::Profit-->
                                    <td class="text-end">
                                        <span class="text-dark fw-bolder">$12.00</span>
                                    </td>
                                    <!--end::Profit-->
                                    <!--begin::Status-->
                                    <td class="text-end">
                                        <span
                                            class="badge py-3 px-4 fs-7 badge-light-success">Shipped</span>
                                    </td>
                                    <!--end::Status-->
                                    <!--begin::Actions-->
                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                                            data-kt-docs-datatable-subtable="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12"
                                                        height="2" rx="1" transform="rotate(-90 11 18)"
                                                        fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                    <!--end::Actions-->
                                </tr>
                                <tr>
                                    <!--begin::Order ID-->
                                    <td>
                                        <a href="#" class="text-dark text-hover-primary">#XGD-249</a>
                                    </td>
                                    <!--end::Order ID-->
                                    <!--begin::Crated date-->
                                    <td class="text-end">24 November 2021, 6:58 am</td>
                                    <!--end::Created date-->
                                    <!--begin::Customer-->
                                    <td class="text-end">
                                        <a href="" class="text-dark text-hover-primary">Brian Cox</a>
                                    </td>
                                    <!--end::Customer-->
                                    <!--begin::Total-->
                                    <td class="text-end">$660.00</td>
                                    <!--end::Total-->
                                    <!--begin::Profit-->
                                    <td class="text-end">
                                        <span class="text-dark fw-bolder">$52.26</span>
                                    </td>
                                    <!--end::Profit-->
                                    <!--begin::Status-->
                                    <td class="text-end">
                                        <span
                                            class="badge py-3 px-4 fs-7 badge-light-success">Shipped</span>
                                    </td>
                                    <!--end::Status-->
                                    <!--begin::Actions-->
                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                                            data-kt-docs-datatable-subtable="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12"
                                                        height="2" rx="1" transform="rotate(-90 11 18)"
                                                        fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                    <!--end::Actions-->
                                </tr>
                                <tr>
                                    <!--begin::Order ID-->
                                    <td>
                                        <a href="#" class="text-dark text-hover-primary">#SKP-035</a>
                                    </td>
                                    <!--end::Order ID-->
                                    <!--begin::Crated date-->
                                    <td class="text-end">23 November 2021, 6:58 am</td>
                                    <!--end::Created date-->
                                    <!--begin::Customer-->
                                    <td class="text-end">
                                        <a href="" class="text-dark text-hover-primary">Brian Cox</a>
                                    </td>
                                    <!--end::Customer-->
                                    <!--begin::Total-->
                                    <td class="text-end">$290.00</td>
                                    <!--end::Total-->
                                    <!--begin::Profit-->
                                    <td class="text-end">
                                        <span class="text-dark fw-bolder">$29.00</span>
                                    </td>
                                    <!--end::Profit-->
                                    <!--begin::Status-->
                                    <td class="text-end">
                                        <span
                                            class="badge py-3 px-4 fs-7 badge-light-danger">Rejected</span>
                                    </td>
                                    <!--end::Status-->
                                    <!--begin::Actions-->
                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                                            data-kt-docs-datatable-subtable="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12"
                                                        height="2" rx="1" transform="rotate(-90 11 18)"
                                                        fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="6" y="11" width="12" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                    <!--end::Actions-->
                                </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Block-->
                    
                </div>
                <!--end::Section-->
            </div>
            <!--end::Card Body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Content-->
@endsection


@section('scripts')

<script>
    const AjaxRoute = "{{ route('production') }}";
</script>

<script src="{{ url('/theme') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{ url('/theme') }}/assets/js/datatables/rawProduction.js"></script>
{{-- <script src="{{ url('/theme') }}/assets/js/datatables/subtable.js"></script> --}}

<script>


    

</script>
{{-- <script src="{{ url('/theme') }}/assets/js/custom/widgets.js"></script> --}}
{{-- <script src="{{ url('/theme') }}/assets/js/custom/utilities/modals/users-search.js"></script> --}}

@endsection
