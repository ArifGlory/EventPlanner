@extends('mylayouts.layout_panel')
@section('title', 'Detail produk')
@push('css')
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">Detail produk
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/product')}}">List</a></li>
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
                                        <a href="{{getImageOri($row->product_image)}}" class="image-popup-no-margins">
                                        <img onerror="imgError(this)" class="profile-user-img img-fluid"
                                             src="{{ getImageThumb($row->product_image) }}" alt="produk">
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">

                                        <tr>
                                            <td style="width:30%">Nama</td>
                                            <th style="width:70%">{{$row->product_name}}</th>
                                        </tr>

                                        <tr>
                                            <td>Toko Penjual</td>
                                            <th>{{$store->store_name}}</th>
                                        </tr>

                                        <tr>
                                            <td>Kategori Produk</td>
                                            <th>{{$subcategory->subcategory_name}}</th>
                                        </tr>

                                        <tr>
                                            <td>Deskripsi</td>
                                            <th>
                                                @php
                                                    echo nl2br($row->product_description)
                                                @endphp
                                            </th>
                                        </tr>

                                        <tr>
                                            <td>Harga awal</td>
                                            <th>Rp. {{ format_angka_indo($row->product_old_price)  }}</th>
                                        </tr>

                                        <tr>
                                            <td>Harga diskon</td>
                                            <th>Rp. {{ format_angka_indo($row->product_price)  }}</th>
                                        </tr>

                                        <tr>
                                            <td>Waktu mulai diskon</td>
                                            <th> {{ rubah_tanggal_indo($row->product_discount_start_date)  }}</th>
                                        </tr>

                                        <tr>
                                            <td>Waktu expire diskon</td>
                                            <th>{{ rubah_tanggal_indo($row->product_discount_end_date)  }}</th>
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
