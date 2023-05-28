@extends('mylayouts.layout_panel')
<?php
$titlePage = "Formulir Decline";
?>
@section('title', ucwords($titlePage))
@push('css')

@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">Penolakan Pembayaran tiket {{$transaksi->name}} </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/event')}}">List</a></li>
                        <li class="breadcrumb-item active">{{ucwords($titlePage)}}</li>
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
                            <form class="form" id="form"
                                  method="post"
                                  enctype="multipart/form-data"
                                  action="{{$action}}" autocomplete="off">
                                {{csrf_field()}}
                                @if($mode=='edit')
                                    {{ method_field('PUT') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('mycomponents.alert')
                                    </div>
                                    <div class="col-lg-8 mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <h5>{{$transaksi->name}}</h5>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jumlah Pembelian</label>
                                                            <h5>{{$transaksi->jumlah}} buah tiket</h5>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Total Pembayaran</label>
                                                            <h5>Rp. {{ format_angka_indo($transaksi->total_bayar)  }}</h5>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <input name="id" value="{{ encodeId($transaksi->transaksi_event_id)  }}" type="hidden">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="decline_reason">Alasan Penolakan</label>
                                                            <textarea class="form-control @error('decline_reason') is-invalid @enderror"
                                                                name="decline_reason" id="decline_reason" required></textarea>
                                                            @error('decline_reason')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex justify-content-end">
                                                    @if($mode=='add')
                                                        <button type="reset" class="btn btn-secondary"
                                                                style="margin-right: 20px">
                                                            Reset Form
                                                        </button>
                                                    @endif
                                                    @component('mycomponents.btnsubmit')
                                                        @slot('variabel')
                                                            @if($mode=='add') Simpan  @else
                                                                Update @endif
                                                        @endslot
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <div class="col-lg-4 mt-3">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h5>Bukti Pembayaran</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="text-center">
                                                            <a href="{{getImageOri($transaksi->bukti_bayar)}}" class="image-popup-no-margins">
                                                                <img onerror="imgError(this)" class="img-fluid"
                                                                     src="{{ getImageThumb($transaksi->bukti_bayar) }}" alt="event">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--end::Card-->
                                    </div>
                                </div>
                            </form>
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
