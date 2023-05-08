<script type="text/javascript">

    $(".select2pengguna").select2({
        placeholder: "FILTER ROLES",
        allowClear:true,
    });
    $(document).ready(function () {
        table = $('#hideyori_datatable').DataTable({
            @include('mycomponents.configDatatablejs')
            ajax: {
                url: "{{ url('main/pengguna/data') }}",
                type: "GET",
                data: function (d) {
                    d.roles = $("#roles").val();
                }
            },

            order: [[2, "asc"]],

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
                    data: 'name', name: 'name', responsivePriority: -1,
                },

                {
                    data: 'role_name',
                    name: 'role_name',
                    orderable: false,
                    searchable: false,
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
                id
            @endslot
            @endcomponent

        });
    });


    $('#roles').change(function () {
        reloadTable();
    });

    function loadindatatable() {
        initMagnific();
        exporTable();
        let urlData = '{{url('main/pengguna/update-status/')}}';
        initChangeStatus(urlData);
    }

    function bulkStatus(mode, teks) {
        var url = '{{ url('main/pengguna/bulkStatus/') }}';
        bulkActive(mode, url, teks);
    }
</script>
