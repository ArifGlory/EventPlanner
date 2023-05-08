@extends('mylayouts.layout_panel')
<?php
$titlePage = 'catatan aktivitas';
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
                        <p class="mb-3">berikut data catatan aktivitas menurut waktu kejadian.</p>
                    </div>
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
                                        <select class="select2 form-control" id="causer_id"
                                                name="causer_id" multiple>
                                            <option value="">-Seluruh-</option>
                                            @foreach($listUser as $nama => $value)
                                                <option
                                                    value={{$value}}>{{$nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12">
                                    <div class="d-flex justify-content-end align-items-center">
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


                                    <th style="width: 150px">Waktu</th>
                                    <th>Catatan</th>
                                    <th>Oleh</th>



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
    @include('mypanel.aktivitas.script')
@endpush
