function active(paramId, urlnya, mode, teks) {
    var id = paramId;
    var token = $('meta[name="csrf-token"]').attr('content');
    Swal.fire({
        title: 'Apakah anda ingin ' + teks + ' data ini',
        text: "cek kembali data anda",
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
                            getRender(1);
                            tampilPesan('success', 'SUKSES', data.pesan);
                        } else {
                            tampilPesan('error', data.pesan);
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
                        mode: mode,
                        teks: teks,
                    },
                    dataType: "JSON",

                    success: function (data) {
                        console.log(data);
                        console.log('sebelum', arrayList);
                        arrayList = [];
                        console.log('sesudah', arrayList);
                        if (data.status) {
                            getRender(1);
                            tampilPesan('success', 'SUKSES Berhasil ' + teks, list_id.length + ' data');
                            $('#check-all').prop('checked', false); // Unchecks
                            $('.check-all').prop('checked', false); // Unchecks

                        } else {
                            tampilPesan('error', 'Gagal ' + teks, list_id.length + ' data');
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
        tampilPesan('info', 'Silahkan pilih data yang akan' + teks, '');
    }
}
