@extends('mylayouts.layout_panel')
@section('title', 'Detail Toko/Umkm')
@push('css')
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">Detail Toko/Umkm
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/stores')}}">List</a></li>
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
                                        <a href="{{getImageOri($row->store_logo)}}" class="image-popup-no-margins">
                                        <img onerror="imgError(this)" class="profile-user-img img-fluid"
                                             src="{{ getImageThumb($row->store_logo) }}" alt="Toko/Umkm">
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">

                                        <tr>
                                            <td style="width:30%">Nama</td>
                                            <th style="width:70%">{{$row->store_name}}</th>
                                        </tr>

                                        <tr>
                                            <td>Tipe</td>
                                            <th>{{$row->store_type}}</th>
                                        </tr>

                                        <tr>
                                            <td>Deskripsi</td>
                                            <th>{{$row->store_description}}</th>
                                        </tr>

                                        <tr>
                                            <td>Telepon</td>
                                            <th>{{$row->store_phone}}</th>
                                        </tr>

                                        <tr>
                                            <td>Link Toko</td>
                                            <th>{{$row->store_url}}</th>
                                        </tr>

                                        <tr>
                                            <td>Tags</td>
                                            <th>
                                                @for($i = 0;$i < count($tags); $i++)
                                                    <span class="badge badge-success"> {{$tags[$i]}} </span>
                                                @endfor
                                            </th>
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
