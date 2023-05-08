@extends('mylayouts.layout_panel')
<?php
$titlePage = 'Pengguna Aplikasi';
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
                        <p class="mb-3">daftar pengguna yang ada di dalam Sistem Xpoint </p>
                    </div>
                </div>

                <div class="col-lg-12">
                    @include('mycomponents.alert')
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card mt-2">
                        <div class="card-header border-bottom mt-2 mb-2 pt-2 pb-2">
                            <div class="row g-1">
                                <div class="col-lg-6 col-12">
                                    <div class="d-flex justify-content-start">
                                        <select class="form-control select2pengguna" name="roles"
                                                id="roles">
                                            <option value="">Seluruh Data</option>
                                            @foreach($listRole as $val)
                                                <option value="{{$val->id_role}}"> {{$val->role_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12">
                                    <div class="d-flex justify-content-end">
                                        <div id="div_ekspor" style="display: none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <table class="table table-striped table-bordered" style="width:100%" id="hideyori_datatable">
                                <thead class="bgcolortable text-white">
                                <tr>
                                    <th style="width: 5px" class="not-export-col">
                                    </th>
                                    <th style="width: 5px" class="not-export-col">
                                        @component('mycomponents.checkAll')
                                        @endcomponent
                                    </th>
                                    <th>user</th>
                                    <th>role</th>
                                    <th style="width: 150px">Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-footer">
                            <!--begin::Dropdown-->
                            <div class="row">


                                <div class="col-lg-6 col-xl-6 col-12">
                                    <div class="d-flex justify-content-start">

                                       {{-- <div id="div_opsi" style="display: none">
                                            @component('mycomponents.bulkAktiv3')
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
    <!-- DataTable with Buttons -->


@endsection
@push('scripts')
    @include('mycomponents.jsDatatable')
    <script src="{{ asset('assets/jshideyorix/mydatatable.js')}}"></script>
    <script src="{{ asset('assets/jshideyorix/deletertable.js')}}"></script>
    <script src="{{ asset('assets/jshideyorix/activatortable.js')}}"></script>
    @include('mypanel.user.script')
@endpush
