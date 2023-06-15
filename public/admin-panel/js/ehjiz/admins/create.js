"use strict";
var KTModaladminsAdd = function() {
    var t, e, o, n, r, i;
    return {
        init: function() {
            i = new bootstrap.Modal(document.querySelector("#kt_modal_add_admin")),
            r = document.querySelector("#kt_modal_add_admin_form"),
            t = r.querySelector("#kt_modal_add_admin_submit"),
            e = r.querySelector("#kt_modal_add_admin_cancel"),
            o = r.querySelector("#kt_modal_add_admin_close"),
            n = FormValidation.formValidation(r, {
                fields: {
                  name: {
                        validators: {
                            notEmpty: {
                                message: "الاسم مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: "رقم الهاتف مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: "البريد الالكتروني مطلوب"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "كلمة المرور مطلوبة"
                            },
                            blank: {
                                message: ""
                            }
                        }
                    },
                    
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: "تأكيد كلمة المرور مطلوب"
                            },
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
                              title: "تم إنشاء المشرف بنجاح",
                              icon: "success",
                              showConfirmButton: false,
                              timer: 2000,
                              timerProgressBar: true,  
                            }).then((function(e) {
                              (r.reset(), i.hide())                               
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
    KTModaladminsAdd.init()
}
));
