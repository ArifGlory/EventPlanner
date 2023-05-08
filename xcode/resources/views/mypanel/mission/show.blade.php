@extends('mylayouts.layout_panel')
@section('title', 'Detail Mission')
@push('css')
    @include('mycomponents.cssDatatable')
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">Detail Mission
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/mission')}}">List</a></li>
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
                                        <a href="{{getImageOri($row->mission_image)}}" class="image-popup-no-margins">
                                        <img onerror="imgError(this)" class="profile-user-img img-fluid"
                                             src="{{ getImageThumb($row->mission_image) }}" alt="mission">
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">

                                        <tr>
                                            <td style="width:30%">Nama</td>
                                            <th style="width:70%">{{$row->mission_name}}</th>
                                        </tr>

                                        <tr>
                                            <td style="width:30%">Total Reward Mission</td>
                                            <th style="width:70%">{{ format_angka_indo($row->mission_total_reward)  }} Point</th>
                                        </tr>
                                        <tr>
                                            <td style="width:30%">Maksimal Partisipan</td>
                                            <th style="width:70%">{{$row->mission_max_participant}}</th>
                                        </tr>
                                        <tr>
                                            <td style="width:30%">Reward per Partisipan</td>
                                            <th style="width:70%">{{ format_angka_indo($individual_reward)  }} Point</th>
                                        </tr>
                                        <tr>
                                            <td>Waktu expire</td>
                                            <th>{{ rubah_tanggal_indo($row->mission_end_date)  }}</th>
                                        </tr>

                                        <tr>
                                            <td>Deskripsi</td>
                                            <th>
                                               {!! $row->mission_description !!}
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
                                <div class="col-lg-12 col-12 mb-2">
                                    <div class="d-flex justify-content-end">
                                        <div id="div_ekspor" style="display: none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">

                            <table class="table table-striped table-bordered" style="width:100%" id="submission_datatable">
                                <thead class="bgcolortable">
                                <tr>
                                    <th style="width: 5px" class="not-export-col">
                                    </th>
                                    <th style="width: 5px" class="not-export-col">
                                        @component('mycomponents.checkAll')@endcomponent
                                    </th>
                                    <th style="width: 5px">No.</th>
                                    <th style="width: 100px">Nama</th>
                                    <th style="width: 100px">Akun Social Media</th>
                                    <th style="width: 100px">Bukti</th>
                                    <th style="width: 50px">Tanggal</th>
                                    {{--<th style="width: 50px">Status</th>--}}
                                    <th style="width: 75px" class="not-export-col">
                                        Action
                                    </th>
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
            table = $('#submission_datatable').DataTable({
                @include('mycomponents.configDatatablejs')
                ajax: {
                    url: "{{ url('main/mission/data-submission') }}",
                    type: "GET",
                    data: function (d) {
                        d.mission_id = '{{encodeId($row->mission_id)}}';
                    }
                },

                //order: [[3, "asc"]],


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
                        data: 'submission_user_socmed_account', name: 'submission_user_socmed_account',
                    },

                    {
                        data: 'submission_image', name: 'submission_image',
                    },

                    {
                        data: 'updated_at', name: 'updated_at',
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
                    submission_id
                    @endslot
                @endcomponent

            });
        });

        function loadindatatable() {
            exporTable();
            let urlData = '{{url('main/mission/update-status/')}}';
            initChangeStatus(urlData);
        }

        function bulkStatus(mode, teks) {
            var url = '{{ url('main/mission/bulkStatus') }}';
            bulkActive(mode, url, teks);
        }
    </script>

@endpush
