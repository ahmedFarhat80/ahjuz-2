"use strict";

$(function() {
    $('#bookings-table').on('click', '[data-kt-booking-table-filter="delete_row"]', function (e) {
        handleDeleteRows(e)    
    } );
});

function handleDeleteRows(e) {
e.preventDefault();
var table = document.querySelector('#bookings-table')
var datatable = $(table).DataTable();
// Select parent row
const parent = e.target.closest('tr');
const form = e.target.closest('form');

// Get booking name
const bookingName = parent.querySelectorAll('td')[0].innerText;

Swal.fire({
    title: ` هل أنت متأكد أنك تريد <br> إلغاء الحجز "${bookingName}"؟`,
    icon: "warning",
    showCancelButton: true,
    buttonsStyling: false,
    confirmButtonText: "نعم، إلغِ",
    cancelButtonText: "لا، تراجع",
    customClass: {
        confirmButton: "btn fw-bold btn-danger",
        cancelButton: "btn fw-bold btn-active-light-primary"
    }
}).then(function (result) {
    if (result.value) {
    
            axios.post(form.getAttribute('action'), new FormData(form))
            .then(function (response) {
                
                Swal.fire({
                    title: `تم الإلغاء`,
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
            title: "لم يتم الإلغاء",
            icon: "error",
            buttonsStyling: false,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,  
        });
    }
});
}