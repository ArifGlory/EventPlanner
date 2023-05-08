function active(paramId, urlnya, mode, teks) {
    var id = paramId;
    var token = $('meta[name="csrf-token"]').attr('content');
    Swal.fire({
        title: 'do you want to ' + teks + ' this data?',
        text: "check again",
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.value) {
            $.ajax(
                {
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url: urlnya + '/' + id,
                    type: 'GET',
                    dataType: "JSON",
                    data: {
                        id: id,
                        mode: mode,
                        teks: teks,
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.status) {
                            reloadTable();
                            tampilPesan(data.tipe, data.title, data.message);
                        } else {
                            tampilPesan(data.tipe, data.title, data.message);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        tampilPesan('error', error.status + ' ' + error.statusText, error.responseJSON);
                        //alert('error :: ' + error.responseJSON);
                    }
                });

        } else if (result.dismiss === "cancel") {
            tampilPesan('info', 'cancel for ' + teks, '');
        }
    });
}


function bulkActive(mode, urlnya, teks) {
    var list_id = [];
    $(".data-check:checked").each(function () {
        list_id.push(this.value);
    });
    var token = $('meta[name="csrf-token"]').attr('content');
    if (list_id.length > 0) {
        Swal.fire({
            title: 'Yakin akan ' + teks + ' : ' + list_id.length + ' data yg telah dipilih ?',
            text: "Cek kembali data anda",
            type: "warning",
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url: urlnya,
                    type: "POST",
                    data: {
                        id: list_id,
                        nilai: mode,
                        teks: teks,
                    },
                    dataType: "JSON",


                    success: function (data) {
                        console.log(data);
                        console.log('sebelum', array_data);
                        array_data = [];
                        console.log('sesudah', array_data);
                        if (data.status) {
                            reloadTable();
                            tampilPesan('success', 'SUKSES Berhasil ' +teks, list_id.length + ' data');

                        } else {
                            tampilPesan('error', 'Gagal '+teks, list_id.length + ' data');
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        tampilPesan('error', error.status + ' ' + error.statusText, error.responseJSON);
                        //alert('error :: ' + error.responseJSON);
                    }
                });
            } else if (result.dismiss === "cancel") {
                tampilPesan('info', 'data dibatalkan untuk ' + teks, '');
            }
        });
    } else {
        tampilPesan('info', 'Silahkan pilih data yang akan ' + teks, '');
    }
}
