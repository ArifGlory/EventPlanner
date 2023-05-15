@extends('mylayouts.layout_panel')
<?php
$modenya = $mode == 'add' ? 'tambah event' : 'ubah event';
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
                                                    @if($mode=='edit')
                                                        <div class="col-lg-12">
                                                            <div class="user-picture-section mb-3">
                                                                <div class=" d-flex align-items-center flex-column">
                                                                    <a class="image-popup-no-margins"
                                                                       href="{{getImageOri($event_poster)}}">
                                                                        <img
                                                                            class="img-fluid rounded my-4 img-preview_gambar"
                                                                            src="{{getImageOri($event_poster)}}"
                                                                            height="110"
                                                                            width="110"
                                                                            alt="User picture">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="event_category_id">Kategori
                                                                Event </label>
                                                            <select style="width:100%"
                                                                    class="select2 form-control  @error('event_category_id') is-invalid @enderror"
                                                                    name="event_category_id" id="event_category_id">
                                                                @if($mode == "edit")
                                                                    <option value="{{$selected_category->category_id}}">
                                                                        Terpilih
                                                                        - {{$selected_category->category_name}}</option>
                                                                @endif
                                                                @foreach($category as $val)
                                                                    <option
                                                                        value="{{$val->category_id}}"> {{$val->category_name}} </option>
                                                                @endforeach
                                                            </select>
                                                            @error('event_category_id')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="mm_nama">Nama Event</label>
                                                            <input
                                                                class="form-control @error('event_name') is-invalid @enderror"
                                                                name="event_name" id="event_name" type="text"
                                                                value="{{ $event_name }}"
                                                                autofocus/>
                                                            @error('event_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> Harga Tiket <small>harga sebelum
                                                                    diskon</small> </label>

                                                            <input
                                                                class="form-control @error('event_harga_tiket') is-invalid @enderror"
                                                                name="event_harga_tiket" id="event_harga_tiket"
                                                                type="number"
                                                                value="{{ $event_harga_tiket }}"/>
                                                            @error('event_harga_tiket')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> Stok tiket <small>anda dapat
                                                                    membatasi jumlah tiket dengan batasan
                                                                    tertenu</small> </label>

                                                            <input
                                                                class="form-control @error('event_stok_tiket') is-invalid @enderror"
                                                                name="event_stok_tiket" id="event_stok_tiket"
                                                                type="number"
                                                                value="{{ $event_stok_tiket }}"/>
                                                            @error('event_stok_tiket')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="product_url">Waktu
                                                                Event</label>
                                                            <input
                                                                class="form-control @error('event_waktu') is-invalid @enderror"
                                                                name="event_waktu" id="product_url"
                                                                type="datetime-local"
                                                                value="{{ $event_waktu }}"
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
                                                                class="form-control @error('event_description') is-invalid @enderror"
                                                                id="exampleFormControlTextarea1" rows="3"
                                                                name="event_description">{{$event_description}}</textarea>
                                                            @error('event_description')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="bobot">Lokasi event</label>
                                                            <textarea
                                                                class="form-control @error('event_lokasi') is-invalid @enderror"
                                                                id="exampleFormControlTextarea1" rows="3"
                                                                name="event_lokasi">{{$event_lokasi}}</textarea>
                                                            @error('event_lokasi')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="bobot">Talent</label>
                                                                <small>Artis atau yang memeriahkan acara event</small>
                                                                <textarea
                                                                    class="form-control @error('event_talent') is-invalid @enderror"
                                                                    id="exampleFormControlTextarea1" rows="3"
                                                                    name="event_talent">{{$event_talent}}</textarea>
                                                                @error('event_talent')
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
                                                            <label class="form-label" for="is_active">Poster
                                                                Event</label>
                                                            <br>
                                                            <small>Di isi jika ingin mengubah gambar poster
                                                                event</small>
                                                            <div class="custom-file">
                                                                <input id="product_image"
                                                                       class="custom-file-input @error('event_poster') is-invalid @enderror"
                                                                       type="file" name="event_poster"
                                                                       accept="image/*"
                                                                       onchange="previewImg('event_poster')">
                                                                <label class="custom-file-label"
                                                                       for="event_poster">PILIH</label>
                                                            </div>


                                                            @if($mode=='edit')
                                                                @if($event_poster)
                                                                    @component('mycomponents.checkboxValue')
                                                                        @slot('variabel')
                                                                            gambar
                                                                        @endslot
                                                                        @slot('value')
                                                                            {{$event_poster}}
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
                                                            @if($mode=='add')
                                                                Simpan
                                                            @else
                                                                Update
                                                            @endif
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
            changeTextFile('event_poster');
        });
    </script>

@endpush
