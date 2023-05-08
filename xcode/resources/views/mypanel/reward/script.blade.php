<script type="text/javascript">


    $(document).ready(function () {
        table = $('#hideyori_datatable').DataTable({
            @include('mycomponents.configDatatablejs')
            ajax: {
                url: "{{ url('main/reward/data') }}",
                type: "GET",
                data: function (d) {
                    //d.created_by = $('#created_by').val();
                    //d.jenis_id = $('#select_jenis_id').val();

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
                    data: 'reward_name', name: 'reward_name',
                },

                {
                    data: 'reward_point_condition', name: 'reward_point_condition',
                },

                {
                    data: 'reward_status', name: 'reward_status',
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
                reward_id
            @endslot
            @endcomponent

        });
    });


    function loadindatatable() {
        exporTable();
        let urlData = '{{url('main/reward/update-status/')}}';
        initChangeStatus(urlData);
    }

    function bulkStatus(mode, teks) {
        var url = '{{ url('main/reward/bulkStatus') }}';
        bulkActive(mode, url, teks);
    }
</script>
