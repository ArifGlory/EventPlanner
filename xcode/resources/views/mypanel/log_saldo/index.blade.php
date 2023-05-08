@extends('mylayouts.layout_panel')
<?php
$titlePage = 'Transaksi Point';
?>
@section('title', ucwords($titlePage))
@push('css')
    @include('mycomponents.cssDatatable')
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">{{ucwords($titlePage)}}
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ucwords($titlePage)}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row g-1">
                <div class="col-lg-6 col-12">
                    <div class="d-flex justify-content-start">
                        <p class="mb-3">berikut data riwayat penggunaan saldo point menurut waktu kejadian.</p>
                    </div>
                </div>
            </div>
            <div class="row g-1">


                <div class="col-lg-12 col-12">
                    <div class="d-flex justify-content-end">

                        @component('mycomponents.btnAdd')
                            @slot('link')
                                {{url('main/transaksi-point/form')}}
                            @endslot
                        @endcomponent

                    </div>
                </div>


                <div class="col-lg-12">
                    @include('mycomponents.alert')
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom mt-2 mb-2 pt-2 pb-2">
                            <div class="row g-1">
                                <div class="col-lg-6 col-12">
                                    <div class="d-flex justify-content-start">
                                        <select class="select2 form-control" id="user_id"
                                                name="user_id">
                                            <option value="">-Seluruh-</option>
                                            @foreach($listUser as $val)
                                                <option
                                                    value={{$val->id}}>{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-2">
                                    <div class="d-flex justify-content-end">
                                        <div id="div_ekspor" style="display: none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <table class="table table-striped table-bordered" style="width:100%" id="hideyori_datatable">
                                <thead class="bgcolortable">
                                <tr>
                                    <th style="width: 5px" class="not-export-col">
                                    </th>
                                    <th style="width: 5px">No.</th>
                                    <th style="width: 150px">Waktu</th>
                                    <th>Nominal</th>
                                    <th>Nama</th>
                                    <th>Status</th>
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

@endsection
@push('scripts')
    @include('mycomponents.jsDatatable')
    <script src="{{ asset('assets/jshideyorix/mydatatable.js')}}"></script>
    <script src="{{ asset('assets/jshideyorix/deletertable.js')}}"></script>
    @include('mypanel.log_saldo.script')
@endpush
