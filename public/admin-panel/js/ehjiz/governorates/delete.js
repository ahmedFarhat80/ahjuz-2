"use strict";

$(function() {
    $('#governorates-table').on('click', '[data-kt-governorate-table-filter="delete_row"]', function (e) {
        handleDeleteRows(e)    
    } );
});

function handleDeleteRows(e) {
e.preventDefault();
var table = document.querySelector('#governorates-table')
var datatable = $(table).DataTable();
// Select parent row
const parent = e.target.closest('tr');
const form = e.target.closest('form');

// Get governorate name
const governorateName = parent.querySelectorAll('td')[2].innerText;

Swal.fire({
    title: ` هل أنت متأكد أنك تريد <br> حذف المحافظة "${governorateName}"؟`,
    icon: "warning",
    showCancelButton: true,
    buttonsStyling: false,
    confirmButtonText: "نعم، احذف",
    cancelButtonText: "لا، الغ",
    customClass: {
        confirmButton: "btn fw-bold btn-danger",
        cancelButton: "btn fw-bold btn-active-light-primary"
    }
}).then(function (result) {
    if (result.value) {
    
            axios.post(form.getAttribute('action'), new FormData(form))
            .then(function (response) {

                Swal.fire({
                    title: `تم الحذف`,
                    icon: "success",
                    buttonsStyling: false,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,  
                })

                datatable.row($(parent)).remove().draw();
                // datatable.ajax.reload();

            })
            .catch(function (error) {
                if (error.response) {
                    Swal.fire({
                        text: 'خطأ',
                        showConfirmButton: false,
                        icon: "error",
                        timer: 2000,
                        timerProgressBar: true,                                
                    });
                }
            })    

    } else if (result.dismiss === 'cancel') {
        Swal.fire({
            title: "لم يتم الحذف",
            icon: "error",
            buttonsStyling: false,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,  
        });
    }
});
}