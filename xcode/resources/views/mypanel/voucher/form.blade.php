@extends('mylayouts.layout_panel')
<?php
$modenya = $mode == 'add' ? 'tambah voucher' : 'ubah voucher';
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
                        <li class="breadcrumb-item"><a href="{{url('main')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/voucher')}}">List</a></li>
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
                                                                       href="{{getImageOri($voucher_image)}}">
                                                                        <img
                                                                            class="img-fluid rounded my-4 img-preview_gambar"
                                                                            src="{{getImageOri($voucher_image)}}" height="110"
                                                                            width="110"
                                                                            alt="User picture">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="status">Kategori </label>
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
                                                                <label class="form-label" for="status">Toko Pemilik </label>
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
                                                            <label class="form-label" for="mm_nama">Nama</label>
                                                            <input
                                                                class="form-control @error('voucher_name') is-invalid @enderror"
                                                                name="voucher_name" id="voucher_name" type="text"
                                                                value="{{ $voucher_name }}"
                                                                autofocus/>
                                                            @error('voucher_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="voucher_code">Kode Voucher (Opsional jika ada)</label>
                                                                <input
                                                                    class="form-control @error('voucher_code') is-invalid @enderror"
                                                                    name="voucher_code" id="voucher_code" type="text"
                                                                    value="{{ $voucher_code }}"
                                                                    autofocus/>
                                                                @error('voucher_code')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="voucher_url">URL Voucher <small>harus berupa link aktif</small></label>
                                                                <input
                                                                    class="form-control @error('voucher_url') is-invalid @enderror"
                                                                    name="voucher_url" id="voucher_url" type="text"
                                                                    value="{{ $voucher_url }}"
                                                                    autofocus/>
                                                                @error('voucher_url')
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
                                                                class="form-control @error('voucher_tags') is-invalid @enderror"
                                                                name="voucher_tags" id="voucher_tags" type="text"
                                                                value="{{ $voucher_tags }}"/>
                                                            @error('voucher_tags')
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
                                                                class="form-control @error('voucher_description') is-invalid @enderror"
                                                                id="exampleFormControlTextarea1" rows="3"
                                                                name="voucher_description">{{$voucher_description}}</textarea>
                                                            @error('voucher_description')
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
                                                            <label class="form-label" for="status">Tanggal Mulai Voucher</label>
                                                            <input
                                                                class="form-control @error('voucher_start_date') is-invalid @enderror"
                                                                name="voucher_start_date" id="voucher_start_date" type="date"
                                                                value="{{ $voucher_start_date }}"/>
                                                            @error('voucher_start_date')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="status">Tanggal Akhir Voucher</label>
                                                            <input
                                                                class="form-control @error('voucher_end_date') is-invalid @enderror"
                                                                name="voucher_end_date" id="voucher_end_date" type="date"
                                                                value="{{ $voucher_end_date }}"/>
                                                            @error('voucher_end_date')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="is_active">Gambar</label>
                                                            <br>
                                                            <small>Di isi jika ingin mengubah gambar</small>
                                                            <div class="custom-file">
                                                                <input id="voucher_image"
                                                                       class="custom-file-input @error('voucher_image') is-invalid @enderror"
                                                                       type="file" name="voucher_image"
                                                                       accept="image/*"
                                                                       onchange="previewImg('voucher_image')">
                                                                <label class="custom-file-label"
                                                                       for="voucher_image">PILIH</label>
                                                            </div>


                                                            @if($mode=='edit')
                                                                @if($voucher_image)
                                                                    @component('mycomponents.checkboxValue')
                                                                        @slot('variabel')
                                                                            gambar
                                                                        @endslot
                                                                        @slot('value')
                                                                            {{$voucher_image}}
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
