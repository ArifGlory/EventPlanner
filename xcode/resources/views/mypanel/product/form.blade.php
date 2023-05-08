@extends('mylayouts.layout_panel')
<?php
$modenya = $mode == 'add' ? 'tambah product' : 'ubah product';
$titlePage = $modenya;
?>
@section('title', ucwords($titlePage))
@push('css')

@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">{{ucwords($titlePage)}}
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/product')}}">List</a></li>
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
                                                    @if($mode=='edit')
                                                        <div class="col-lg-12">
                                                            <div class="user-picture-section mb-3">
                                                                <div class=" d-flex align-items-center flex-column">
                                                                    <a class="image-popup-no-margins"
                                                                       href="{{getImageOri($product_image)}}">
                                                                        <img
                                                                            class="img-fluid rounded my-4 img-preview_gambar"
                                                                            src="{{getImageOri($product_image)}}" height="110"
                                                                            width="110"
                                                                            alt="User picture">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="status">Kategori Produk </label>
                                                                <select style="width:100%"
                                                                        class="select2 form-control  @error('subcategory_id') is-invalid @enderror"
                                                                        name="subcategory_id" id="subcategory_id">
                                                                    @if($mode == "edit")
                                                                        <option value="{{$selected_subcategory->subcategory_id}}"> Terpilih -  {{$selected_subcategory->subcategory_name}}</option>
                                                                    @endif
                                                                    @foreach($subcategory as $val)
                                                                        <option value="{{$val->subcategory_id}}"> {{$val->subcategory_name}} </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('subcategory_id')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="status">Toko Pemilik Produk </label>
                                                                <select style="width:100%"
                                                                        class="select2 form-control  @error('store_id') is-invalid @enderror"
                                                                        name="store_id" id="store_id">
                                                                    @if($mode == "edit")
                                                                        <option value="{{$selected_stores->store_id}}"> Terpilih - {{$selected_stores->store_name}}</option>
                                                                    @endif
                                                                    @foreach($stores as $val)
                                                                        <option value="{{$val->store_id}}"> {{$val->store_name}} </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('store_id')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="mm_nama">Nama Product</label>
                                                            <input
                                                                class="form-control @error('product_name') is-invalid @enderror"
                                                                name="product_name" id="product_name" type="text"
                                                                value="{{ $product_name }}"
                                                                autofocus/>
                                                            @error('product_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="kode_pejantan"> Tags </label>
                                                            <br>
                                                            <small>Setiap kata dipisahkan dengan tanda koma</small>
                                                            <input
                                                                class="form-control @error('product_tags') is-invalid @enderror"
                                                                name="product_tags" id="product_tags" type="text"
                                                                value="{{ $product_tags }}"/>
                                                            @error('product_tags')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> Harga Awal <small>harga sebelum diskon</small> </label>

                                                            <input
                                                                class="form-control @error('product_old_price') is-invalid @enderror"
                                                                name="product_old_price" id="product_old_price" type="number"
                                                                value="{{ $product_old_price }}"/>
                                                            @error('product_old_price')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> Harga Diskon <small>harga setelah diskon</small> </label>

                                                                <input
                                                                    class="form-control @error('product_price') is-invalid @enderror"
                                                                    name="product_price" id="product_price" type="number"
                                                                    value="{{ $product_price }}"/>
                                                                @error('product_price')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="product_url">Link URL Product</label>
                                                                <input
                                                                    class="form-control @error('product_url') is-invalid @enderror"
                                                                    name="product_url" id="product_url" type="text"
                                                                    value="{{ $product_url }}"
                                                                    autofocus/>
                                                                @error('product_url')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="bobot">Deskripsi</label>
                                                            <textarea
                                                                class="form-control @error('product_description') is-invalid @enderror"
                                                                id="exampleFormControlTextarea1" rows="3"
                                                                name="product_description">{{$product_description}}</textarea>
                                                            @error('product_description')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <div class="col-lg-4 mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="status">Tanggal Mulai Diskon</label>
                                                            <input
                                                                class="form-control @error('product_discount_start_date') is-invalid @enderror"
                                                                name="product_discount_start_date" id="product_discount_start_date" type="date"
                                                                value="{{ $product_discount_start_date }}"/>
                                                            @error('product_discount_start_date')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="status">Tanggal Akhir Diskon</label>
                                                            <input
                                                                class="form-control @error('product_discount_end_date') is-invalid @enderror"
                                                                name="product_discount_end_date" id="product_discount_end_date" type="date"
                                                                value="{{ $product_discount_end_date }}"/>
                                                            @error('product_discount_end_date')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="is_active">Gambar Produk</label>
                                                            <br>
                                                            <small>Di isi jika ingin mengubah gambar produk</small>
                                                            <div class="custom-file">
                                                                <input id="product_image"
                                                                       class="custom-file-input @error('product_image') is-invalid @enderror"
                                                                       type="file" name="product_image"
                                                                       accept="image/*"
                                                                       onchange="previewImg('product_image')">
                                                                <label class="custom-file-label"
                                                                       for="product_image">PILIH</label>
                                                            </div>


                                                            @if($mode=='edit')
                                                                @if($product_image)
                                                                    @component('mycomponents.checkboxValue')
                                                                        @slot('variabel')
                                                                            gambar
                                                                        @endslot
                                                                        @slot('value')
                                                                            {{$product_image}}
                                                                        @endslot
                                                                        @slot('teks')
                                                                            hapus gambar lama
                                                                        @endslot
                                                                    @endcomponent
                                                                @endif
                                                            @endif
                                                            @error('gambar')
                                                            <p style="color: red">{{ $message }}</p>
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
            changeTextFile('gambar');
        });
    </script>

@endpush
