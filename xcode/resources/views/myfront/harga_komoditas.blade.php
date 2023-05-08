@extends('mylayouts.layout_front_sb')
@section('title', 'Pelaku Usaha')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="#beranda">
        <div class="container pt-5 pb-5 pt-md-5 pb-md-10">
            <div class="row gx-lg-8 gx-xl-12 gy-10 mb-5 align-items-center">
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start order-2 order-lg-0"
                     data-cues="slideInDown" data-group="page-title" data-delay="600">
                    <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0">Harga Komoditas</h1>
                    <p class="lead fs-lg mb-7">Data harga komoditas ternak sesuai dengan Sistem
                        <a target="_blank" href="https://simponiternak.pertanian.go.id/harga-daerah.php"> Simponi Ternak </a>
                    </p>
                </div>
                <!-- /column -->
                <div class="col-lg-7" data-cue="slideInDown">
                    <lottie-player
                        src="{{asset('statis/illustrations/money.json')}}"
                        background="transparent" speed="1" style="width: 100%; height: 400px;"
                        loop
                        autoplay></lottie-player>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0">
                <div class="col-lg-12">
                    <h3 class="display-4 mb-2 text-center">Perkembangan Harga Komoditas</h3>
                </div>
                <div class="col-lg-12">
                    <table id="harga_datatable" class="table table-striped table-responsive">
                        <thead>
                        <tr>
                            <th style="width: 5px">No</th>
                            <th style="width: 100px">Komoditas</th>
                            <th style="width: 150px">Kabupaten</th>
                            <th style="width: 100px">Tingkat Harga</th>
                            <th style="width: 100px">Harga</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>

    <script type="text/javascript">
        table = $('#harga_datatable').DataTable({
            aLengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            paging: true,
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            order: [[1, "asc"]],


            ajax: {
                url: "{{ url('data-harga') }}",
                type: "GET",
                data: function (d) {

                }
            },

            columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },

                {
                    data: 'komoditas',
                    name: 'komoditas',
                },

                {
                    data: 'kabupaten',
                    name: 'kabupaten',
                },

                {
                    data: 'tingkat_harga',
                    name: 'tingkat_harga',
                },


                {
                    data: 'harga',
                    name: 'harga',
                },


            ],
            language: {
                paginate: {
                    previous: 'Prev',
                    next: 'Next'
                },
                aria: {
                    paginate: {
                        previous: 'Previous',
                        next: 'Next'
                    }
                }
            },
            rowCallback: function (row, data) {

            },
            drawCallback: function () {


            },
            "error": function (xhr, error, thrown) {
                console.log("Error occurred!");
                console.log(xhr, error, thrown);
            }
        });


        table.on('responsive-display', function (e, datatable, row, showHide, update) {

        });
    </script>
@endpush
