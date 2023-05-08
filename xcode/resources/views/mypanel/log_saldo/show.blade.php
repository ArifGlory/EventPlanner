@extends('mylayouts.layout_panel')
@section('title', 'Detail Transaksi Point')
@push('css')
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">Detail Transaksi Point
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/transaksi-point')}}">List</a></li>
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
                                @if($row->log_saldo_bukti)
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <a href="{{getImageOri($row->log_saldo_bukti)}}" class="image-popup-no-margins">
                                                <img onerror="imgError(this)" class="profile-user-img img-fluid"
                                                     src="{{ getImageThumb($row->log_saldo_bukti) }}" alt="produk">
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="card-body p-0">
                                    <table class="table">

                                        <tr>
                                            <td style="width:30%">Nama Pengguna</td>
                                            <th style="width:70%">{{$row->name}}</th>
                                        </tr>

                                        <tr>
                                            <td>Nominal</td>
                                            <th>{{ format_angka_indo($row->log_saldo_nominal)  }}</th>
                                        </tr>

                                        <tr>
                                            <td>Status Transaksi</td>
                                            <th>{{$row->log_saldo_status}}</th>
                                        </tr>

                                        @if($row->log_saldo_status == "deposit")
                                            <tr>
                                                <td>Jenis Top-up</td>
                                                <th>{{$row->log_saldo_jenis_topup}}</th>
                                            </tr>
                                        @elseif($row->log_saldo_status == "cancel")
                                            <tr>
                                                <td>Alasan Pembatalan</td>
                                                <th>{{$row->log_saldo_cancel_reason}}</th>
                                            </tr>
                                        @endif


                                        <tr>
                                            <td>Deskripsi</td>
                                            <th>
                                                @php
                                                    echo nl2br($row->log_saldo_description)
                                                @endphp
                                            </th>
                                        </tr>

                                        <tr>
                                            <td>Waktu Transaksi</td>
                                            <th> {{ rubah_tanggal_indo($row->created_at)  }}</th>
                                        </tr>

                                    </table>
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
    <script type="text/javascript">
        $(document).ready(function () {
        });
    </script>

@endpush
