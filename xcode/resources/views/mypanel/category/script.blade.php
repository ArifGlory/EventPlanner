<script type="text/javascript">


    $(document).ready(function () {
        table = $('#hideyori_datatable').DataTable({
            @include('mycomponents.configDatatablejs')
            ajax: {
                url: "{{ url('main/category/data') }}",
                type: "GET",
                data: function (d) {
                    //d.created_by = $('#created_by').val();

                }
            },

            order: [[3, "asc"]],


            columns: [
                {
                    className: 'dtr-control',
                    orderable: false,
                    searchable: false,
                    data: 'dtResponsive',
                    targets: 0
                },

                {

                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    className: 'dt-center'
                },


                {

                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'dt-center'

                },


                {
                    data: 'category_name', name: 'category_name',
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'dt-center'
                },


            ],
            @component('mycomponents.callbackDatatablejs')
                @slot('primarykey')
                category_id
        @endslot
            @endcomponent

        });
    });


    $('#select_jenis_id').change(function () {
        reloadTable();
    });

    function loadindatatable() {
        exporTable();
        let urlData = '{{url('main/category/update-status/')}}';
        initChangeStatus(urlData);
    }

    function bulkStatus(mode, teks) {
        var url = '{{ url('main/category/bulkStatus') }}';
        bulkActive(mode, url, teks);
    }
</script>
