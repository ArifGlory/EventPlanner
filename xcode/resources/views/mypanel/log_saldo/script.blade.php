<script type="text/javascript">
    $(document).ready(function () {
        table = $('#hideyori_datatable').DataTable({
            @include('mycomponents.configDatatablejs')
            ajax: {
                url: "{{ url('main/transaksi-point/data') }}",
                type: "GET",
                data: function (d) {
                    d.user_id = $('#user_id').val();
                }
            },

            order: [[1, "desc"]],


            columns: [
                {
                    className: 'dtr-control',
                    orderable: false,
                    searchable: false,
                    data: 'dtResponsive',
                    targets: 0
                },

                {

                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'dt-center'

                },
                {
                    data: 'created_at', name: 'created_at', responsivePriority: -1,
                },
                {
                    data: 'log_saldo_nominal',
                    name: 'log_saldo_nominal',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'log_saldo_status',
                    name: 'log_saldo_status',
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
                    log_saldo_id
                @endslot
            @endcomponent

        });
    });


    $('#causer_id').change(function () {
        reloadTable();
    });

    function loadindatatable() {
        exporTable();
    }



</script>
