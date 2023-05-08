<?php ?>
            rowCallback: function (row, data) {
            cellValue = data['{{$primarykey}}'];
            // console.log(cellValue);
            var html = $(row);
            if (array_data.includes(cellValue, 0)) {
            var input = html.find('input[type=checkbox]').prop('checked', 'checked')
            }
            },
            drawCallback: function () {
            $('.data-check').on('change', function () {
            console.log($(this).val());
            if ($(this).is(':checked')) {
            array_data.push($(this).val())
            } else {
            var index = array_data.indexOf($(this).val());
            if (index !== -1) {
            array_data.splice(index, 1);
            }
            }
            });
            var totalData = table.page.info().recordsTotal;
            if (totalData > 0) {
            loadindatatable();
            } else {
            $('#div_trash').hide();
            $('#div_opsi').hide();
            $('#div_ekspor').hide();
            }
            },
            "error": function (xhr, error, thrown) {
            console.log("Error occurred!");
            console.log(xhr, error, thrown);
            }
