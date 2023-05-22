@extends('mylayouts.layout_panel')
@section('title', 'Detail event')
@push('css')
    @include('mycomponents.cssDatatable')
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">Detail event
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/event')}}">List</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row g-3">
                        <div class="col-lg-12 mb-3">
                            <div class="card card-primary">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <a href="{{getImageOri($row->event_poster)}}" class="image-popup-no-margins">
                                        <img onerror="imgError(this)" class="profile-user-img img-fluid"
                                             src="{{ getImageThumb($row->event_poster) }}" alt="event">
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">

                                        <tr>
                                            <td style="width:30%">Nama</td>
                                            <th style="width:70%">{{$row->event_name}}</th>
                                        </tr>

                                        <tr>
                                            <td>Kategori</td>
                                            <th>{{$row->category_name}}</th>
                                        </tr>
                                        <tr>
                                            <td>Talent</td>
                                            <th>{{$row->event_talent}}</th>
                                        </tr>
                                        <tr>
                                            <td>Lokasi</td>
                                            <th>{{$row->event_lokasi}}</th>
                                        </tr>
                                        <tr>
                                            <td>Deskripsi</td>
                                            <th>
                                                @php
                                                    echo nl2br($row->event_description)
                                                @endphp
                                            </th>
                                        </tr>

                                        <tr>
                                            <td>Harga Tiket</td>
                                            <th>Rp. {{ format_angka_indo($row->event_harga_tiket)  }}</th>
                                        </tr>

                                        <tr>
                                            <td>Stok tiket</td>
                                            <th> {{$row->event_stok_tiket}} buah </th>
                                        </tr>

                                        <tr>
                                            <td>Tanggal event </td>
                                            <th>{{ rubah_tanggal_indo($row->event_waktu)  }}</th>
                                        </tr>
                                        <tr>
                                            <td>Waktu event </td>
                                            <th> Pukul {{  $event_time}}</th>
                                        </tr>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-12 mb-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5>Transaksi pembelian tiket</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Transaksi pembelian tiket event ini
                                                <br>
                                                mohon segera ditindaklanjuti pembelian yang masih menunggu verifikasi
                                            </p>
                                            <table class="table table-striped table-bordered" style="width:100%" id="transaksi_datatable">
                                                <thead class="bgcolortable">
                                                <tr>
                                                    <th style="width: 5px" class="not-export-col">
                                                    </th>
                                                    <th style="width: 5px" class="not-export-col">
                                                        @component('mycomponents.checkAll')@endcomponent
                                                    </th>
                                                    <th style="width: 5px">No.</th>
                                                    <th style="width: 100px">Nama</th>
                                                    <th style="width: 50px">Jumlah</th>
                                                    <th style="width: 50px">Total Bayar</th>
                                                    <th style="width: 50px">Bukti</th>
                                                    <th style="width: 75px" class="not-export-col">
                                                        Action
                                                    </th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('mycomponents.jsDatatable')
    <script src="{{ asset('assets/jshideyorix/mydatatable.js')}}"></script>
    <script src="{{ asset('assets/jshideyorix/deletertable.js')}}"></script>
    <script src="{{ asset('assets/jshideyorix/activatortable.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            table = $('#transaksi_datatable').DataTable({
                @include('mycomponents.configDatatablejs')
                ajax: {
                    url: "{{ url('main/event/data/transaksi') }}",
                    type: "GET",
                    data: function (d) {
                        //d.created_by = $('#created_by').val();
                        d.event_id = {{$row->event_id}};

                    }
                },

                order: [[1, "asc"]],


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
                        data: 'name', name: 'name',
                    },
                    {
                        data: 'jumlah', name: 'jumlah',
                    },

                    {
                        data: 'total_bayar', name: 'total_bayar',
                    },

                    {
                        data: 'bukti_bayar', name: 'bukti_bayar',
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'dt-center'
                    },


                ],

            });
        });
    </script>

@endpush
