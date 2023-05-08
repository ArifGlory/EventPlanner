function impor() {
    $('#modal_impor').modal();
    $('#modal_impor').appendTo("body");
    $('#modal_impor').modal('show'); // show bootstrap modal
    $('#form_impor')[0].reset(); // reset form on modals
    $('.custom-file-input').removeClass('is-invalid'); // clear error class
    $('#error_file').text('');
    //resetFile('file')
    document.getElementById("file").value=null;
    $('.custom-file-label').text('PILIH');
}

changeTextFile('file');

function imporData(url) {
    var formData = new FormData($('#form_impor')[0]);
    var _method = "POST";


    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': token
        },
        url: url,
        type: 'POST',
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.status) //if success close modal and reload ajax table
            {
                reloadTable();
                tampilPesan(data.tipe, data.message, '');
                $('#modal_impor').modal('hide');
            }
        },
        error: function (error) {

            responseData = error.responseJSON;
            var size = Object.keys(responseData.errors).length;
            if (size > 0) {

                var isian = Object.keys(responseData.errors);
                for (var i = 0; i < size; i++) {
                    //var message_error = responseData.errors.isian[i];
                    if (i == 0) {
                        $('[name="' + isian[i] + '"]').focus();
                    }
                    $('[name="' + isian[i] + '"]').addClass('is-invalid'); //select parent twice to
                    $('#error_' + isian[i] + '').text(responseData.errors[isian[i]]);
                }
            } else {
                tampilPesan('error', error.responseText, '');
            }

        }

    });
}
