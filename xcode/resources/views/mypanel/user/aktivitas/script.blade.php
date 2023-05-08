<script type="text/javascript">
    $(document).ready(function () {
        getRender(1);
    });


    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getRender(page);
    });

    function getRender(page) {
        var pagenya = page ? page : 1;
        $(".shimmer").show();
        var urlData = "{{ url('main/data-log-saya/'.$row->id) }}";
        $.ajax({
            url: urlData,
            type: "GET",
            data:
                {
                    page: pagenya,
                },
            success: function (data) {
                $('#render').html(data);
                $(".shimmer").hide();
            }
        });
    }

</script>
