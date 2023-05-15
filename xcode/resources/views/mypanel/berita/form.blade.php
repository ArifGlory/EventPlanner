@extends('mylayouts.layout_panel')
<?php
$modenya = $mode == 'add' ? 'tambah berita' : 'ubah berita';
$titlePage = $modenya;
?>
@section('title', ucwords($titlePage))
@push('css')
    <link rel="stylesheet" href="{{asset('backtemplate/plugins/summernote/summernote.css')}}">
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
                        <li class="breadcrumb-item"><a href="{{url('main/berita')}}">List</a></li>
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
                                                                       href="{{getImageOri($berita_image)}}">
                                                                        <img
                                                                            class="img-fluid rounded my-4 img-preview_gambar"
                                                                            src="{{getImageOri($berita_image)}}"
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
                                                            <label class="form-label" for="berita_category_id">Kategori </label>
                                                            <select style="width:100%"
                                                                    class="select2 form-control  @error('berita_category_id') is-invalid @enderror"
                                                                    name="berita_category_id" id="berita_category_id">
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
                                                            @error('berita_category_id')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="mm_nama">Judul Berita</label>
                                                            <input
                                                                class="form-control @error('berita_title') is-invalid @enderror"
                                                                name="event_name" id="event_name" type="text"
                                                                value="{{ $berita_title }}"
                                                                autofocus/>
                                                            @error('berita_title')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="bobot">Isi Berita</label>
                                                            <textarea
                                                                class="form-control @error('berita_content') is-invalid @enderror"
                                                                id="my-summernote" name="berita_content">{{$berita_content}}</textarea>
                                                            @error('berita_content')
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
                                                            <label class="form-label" for="is_active">Gambar berita</label>
                                                            <br>
                                                            <small>Di isi jika ingin mengubah gambar berita
                                                                event</small>
                                                            <div class="custom-file">
                                                                <input id="berita_image"
                                                                       class="custom-file-input @error('berita_image') is-invalid @enderror"
                                                                       type="file" name="berita_image"
                                                                       accept="image/*"
                                                                       onchange="previewImg('berita_image')">
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
    <script src="{{asset('backtemplate/plugins/summernote/summernote.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            changeTextFile('berita_image');
            $("#my-summernote").summernote();
        });
    </script>

@endpush
