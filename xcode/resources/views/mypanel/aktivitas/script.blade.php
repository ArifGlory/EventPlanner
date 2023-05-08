<script type="text/javascript">
    $(document).ready(function () {
        table = $('#hideyori_datatable').DataTable({
            @include('mycomponents.configDatatablejs')
            ajax: {
                url: "{{ url('main/aktivitas/data') }}",
                type: "GET",
                data: function (d) {
                    d.causer_id = $('#causer_id').val();
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
                    data: 'created_at', name: 'created_at', responsivePriority: -1,
                },
                {
                    data: 'description',
                    name: 'description',
                    //responsivePriority: -1,
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name',
                },



            ],
            @component('mycomponents.callbackDatatablejs')
                @slot('primarykey')
                id
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


    function deleteData(paramId) {
        var url = '{{ url('main/aktivitas/delete/') }}';
        deleteDataTable(paramId, url);
    }

    function bulkDelete() {
        var url = '{{ url('main/aktivitas/bulkDelete/') }}';
        bulkDeleteTable(url)
    }


</script>
