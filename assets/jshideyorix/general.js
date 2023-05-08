var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

function tampilPesan(tipe, title, desc) {
    Toast.fire({
        icon: tipe,
        title: title,
        text: desc,
        // position: "top-end",
        showConfirmButton: !1,
        timer: 1000,
    })
}


$("input").change(function () {
    // $(this).closest('.form-group').find('input.form-control').removeClass('is-invalid');
    // $(this).closest('.form-group').find('div.invalid-feedback').text('');
    $(this).removeClass('is-invalid');
    $(this).find('div.invalid-feedback').text('');
});
$("select").change(function () {
    $(this).removeClass('is-invalid');
    $(this).find('div.invalid-feedback').text('');
});
function imgError(image) {
    image.onerror = "";
    image.src = "/statis/default.jpg";
    return true;
}









