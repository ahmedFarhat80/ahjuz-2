"use strict";
var KTModalcouponsAdd = function() {
    var t, e, o, n, r, i;
    return {
        init: function() {
            i = new bootstrap.Modal(document.querySelector("#kt_modal_add_coupon")),
            r = document.querySelector("#kt_modal_add_coupon_form"),
            t = r.querySelector("#kt_modal_add_coupon_submit"),
            e = r.querySelector("#kt_modal_add_coupon_cancel"),
            o = r.querySelector("#kt_modal_add_coupon_close"),
            n = FormValidation.formValidation(r, {
                fields: {
                    code: {
                        validators: {
                            notEmpty: {
                                message: "الرمز مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    type: {
                        validators: {
                            notEmpty: {
                                message: "النوع مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    value: {
                        validators: {
                            notEmpty: {
                                message: "القيمة مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    max_use_count: {
                        validators: {
                            notEmpty: {
                                message: "أقصى عدد مرات الاستخدام مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    starts_at: {
                        validators: {
                            notEmpty: {
                                message: "تاريخ البدء مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    ends_at: {
                        validators: {
                            notEmpty: {
                                message: "تاريخ النهاية مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    status: {
                        validators: {
                            blank: {
                                message: ""
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }),
            t.addEventListener("click", (function(e) {
                e.preventDefault(),
                n && n.validate().then((function(e) {
                    console.log("validated!"),
                    "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"),
                    t.disabled = !0,
                    setTimeout((function() {
                        t.removeAttribute("data-kt-indicator"),

                        axios.post(r.getAttribute('action'), new FormData(r))
                        .then(function (response) {
                            Swal.fire({
                              title: "تم إنشاء الكوبون بنجاح",
                              icon: "success",
                              showConfirmButton: false,
                              timer: 2000,
                              timerProgressBar: true,  
                            }).then((function(e) {
                                (r.reset(), i.hide())
                                var table = document.querySelector('.dataTable')
                                $(table).DataTable().draw();                               
                            }
                            ));
                        })
                        .catch(function (error) {
                            
                            // let dataMessage = error.response.data.message;
                            let dataMessage = '';
                            let dataErrors = error.response.data.errors;

                            for (const errorsKey in dataErrors) {

                                // if (!dataErrors.hasOwnProperty(errorsKey)) continue;

                                dataMessage = dataErrors[errorsKey].map((v) => "<br>" + v).join("")
                                n.updateValidatorOption(errorsKey, 'blank', 'message', dataMessage)
                                    .updateFieldStatus(errorsKey, 'Invalid', 'blank');
                            }

                            if (error.response) someErrors()                           
                        })
                        .then((function(e) {
                             (t.disabled = !1)
                          }
                        ));
                    }
                    ), 2e3)) : someErrors();
                }
                ))
            }
            )),
            e.addEventListener("click", (t) => cancel(t, r, i, n)),
            o.addEventListener("click", (t) => cancel(t, r, i, n))
        }
    }
}();

function cancel(t, r, i, n) {
    t.preventDefault(),
    Swal.fire({
        text: "هل تريد الإلغاء",
        icon: "warning",
        showCancelButton: !0,
        buttonsStyling: !1,
        confirmButtonText: "نعم، الغ",
        cancelButtonText: "لا، ارجع",
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-active-light"
        }
    }).then((function(t) {
        t.value ? (r.reset(),
        i.hide(), n.resetForm()) : ""
    }
    ))
}
function someErrors() {
    Swal.fire({
        text: "تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
        icon: "error",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,                                
  })
}
KTUtil.onDOMContentLoaded((function() {
    KTModalcouponsAdd.init()
}
));
