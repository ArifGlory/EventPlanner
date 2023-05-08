@extends('mylayouts.layout_panel')
@section('title', 'Detail Reward')
@push('css')
    @include('mycomponents.cssDatatable')
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">Detail Reward
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/reward')}}">List</a></li>
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
                        <div class="col-lg-12">
                            @include('mycomponents.alert')
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="card card-primary">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <a href="{{getImageOri($row->reward_image)}}" class="image-popup-no-margins">
                                        <img onerror="imgError(this)" class="profile-user-img img-fluid"
                                             src="{{ getImageThumb($row->reward_image) }}" alt="Reward">
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">

                                        <tr>
                                            <td style="width:30%">Nama</td>
                                            <th style="width:70%">{{$row->reward_name}}</th>
                                        </tr>

                                        <tr>
                                            <td style="width:30%">Syarat Point Dibutuhkan</td>
                                            <th style="width:70%">{{ format_angka_indo($row->reward_point_condition)  }} Point</th>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            @if($row->reward_status == 1)
                                                <th> <h6><span class="badge badge-primary">Aktif</span></h6> </th>
                                            @else
                                                <th> <h6><span class="badge badge-warning">Non-Aktif</span></h6> </th>
                                            @endif
                                        </tr>

                                        <tr>
                                            <td>Deskripsi</td>
                                            <th>
                                               {!! $row->reward_description !!}
                                            </th>
                                        </tr>


                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-2">
                        <div class="card-header border-bottom mt-2 mb-2 pt-2 pb-2">
                            <div class="row g-1">
                                <div class="col-md-6">
                                    <h5>Penerima Reward</h5>
                                </div>
                                <div class="col-lg-12 col-12 mb-2">
                                    <div class="d-flex justify-content-end">
                                        <div id="div_ekspor" style="display: none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">

                            <table class="table table-striped table-bordered" style="width:100%" id="reward_datatable">
                                <thead class="bgcolortable">
                                <tr>
                                    <th style="width: 5px" class="not-export-col">
                                    </th>
                                    <th style="width: 5px" class="not-export-col">
                                        @component('mycomponents.checkAll')@endcomponent
                                    </th>
                                    <th style="width: 5px">No.</th>
                                    <th style="width: 100px">Nama</th>
                                    <th style="width: 100px">Email</th>
                                    <th style="width: 100px">Wallet Address</th>
                                    <th style="width: 50px">Tanggal</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="card-footer">
                            <!--begin::Dropdown-->
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 col-12">
                                    <div class="d-flex justify-content-start">

                                        {{--<div id="div_opsi" style="display: none">
                                            @component('mycomponents.bulkAktiv2')
                                            @endcomponent
                                        </div>--}}

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
            table = $('#reward_datatable').DataTable({
                @include('mycomponents.configDatatablejs')
                ajax: {
                    url: "{{ url('main/reward/data-penerima') }}",
                    type: "GET",
                    data: function (d) {
                        d.reward_id = '{{encodeId($row->reward_id)}}';
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
                        data: 'name', name: 'name',
                    },
                    {
                        data: 'email', name: 'email',
                    },

                    {
                        data: 'wallet_address', name: 'wallet_address',
                    },

                    {
                        data: 'created_at', name: 'created_at',
                    },


                ],
                @component('mycomponents.callbackDatatablejs')
                    @slot('primarykey')
                    subreward_id
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

@endpush
