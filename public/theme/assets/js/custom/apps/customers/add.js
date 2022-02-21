"use strict"; var KTModalCustomersAdd = function () {
    var t, e, o, n, r, i; return {
        init: function () {
            i = new bootstrap.Modal(document.querySelector("#kt_modal_add_customer")), r = document.querySelector("#kt_modal_add_customer_form"), e = r.querySelector("#kt_modal_add_customer_cancel"), o = r.querySelector("#kt_modal_add_customer_close"), n = FormValidation.formValidation(r, {
                fields: {
                    name: { validators: { notEmpty: { message: "Name is required" } } },
                    email: { validators: { notEmpty: { message: "Customer email is required" } } },
                    "first-name": { validators: { notEmpty: { message: "First name is required" } } },
                    "last-name": { validators: { notEmpty: { message: "Last name is required" } } },
                    country: { validators: { notEmpty: { message: "Country is required" } } },
                    address1: { validators: { notEmpty: { message: "Address 1 is required" } } },
                    city: { validators: { notEmpty: { message: "City is required" } } },
                    state: { validators: { notEmpty: { message: "State is required" } } },
                    postcode: { validators: { notEmpty: { message: "Postcode is required" } } }
                }, plugins: {
                    trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" })
                }
            }),
                $(r.querySelector('[name="country"]')).on("change", (function () {
                    n.revalidateField("country")
                })), e.addEventListener("click", (function (t) {
                    t.preventDefault(), Swal.fire({ text: "Are you sure you would like to cancel?", icon: "warning", showCancelButton: !0, buttonsStyling: !1, confirmButtonText: "Yes, cancel it!", cancelButtonText: "No, return", customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" } }).then((function (t) { t.value ? (r.reset(), i.hide()) : "cancel" === t.dismiss && Swal.fire({ text: "Your form has not been cancelled!.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } }) }))
                })), o.addEventListener("click", (function (t) {
                    t.preventDefault(), Swal.fire({ text: "Are you sure you would like to cancel?", icon: "warning", showCancelButton: !0, buttonsStyling: !1, confirmButtonText: "Yes, cancel it!", cancelButtonText: "No, return", customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" } }).then((function (t) { t.value ? (r.reset(), i.hide()) : "cancel" === t.dismiss && Swal.fire({ text: "Your form has not been cancelled!.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } }) }))
                }))
        }
    }
}(); KTUtil.onDOMContentLoaded((function () { KTModalCustomersAdd.init() }));