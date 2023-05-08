@extends('mylayouts.layout_panel')
<?php
$modenya = $mode == 'add' ? 'tambah reward' : 'ubah reward';
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
                        <li class="breadcrumb-item"><a href="{{url('main')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('main/reward')}}">List</a></li>
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
                                            <div class="card-header bg-primary">
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if($mode=='edit')
                                                        <div class="col-lg-12">
                                                            <div class="user-picture-section mb-3">
                                                                <div class=" d-flex align-items-center flex-column">
                                                                    <a class="image-popup-no-margins"
                                                                       href="{{getImageOri($reward_image)}}">
                                                                        <img
                                                                            class="img-fluid rounded my-4 img-preview_gambar"
                                                                            src="{{getImageOri($reward_image)}}" height="110"
                                                                            width="110"
                                                                            alt="User picture">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="mm_nama">Nama</label>
                                                            <input
                                                                class="form-control @error('reward_name') is-invalid @enderror"
                                                                name="reward_name" id="reward_name" type="text"
                                                                value="{{ $reward_name }}"
                                                                autofocus/>
                                                            @error('reward_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="reward_point_condition">Syarat Point Dibutuhkan</label>
                                                                <input
                                                                    class="form-control @error('reward_point_condition') is-invalid @enderror"
                                                                    name="reward_point_condition" id="reward_point_condition" type="number"
                                                                    value="{{ $reward_point_condition }}"
                                                                    autofocus/>
                                                                @error('reward_total_reward')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="bobot">Deskripsi</label>
                                                            <textarea class="form-control @error('reward_description') is-invalid @enderror"
                                                                id="my-summernote"
                                                                name="reward_description">{{$reward_description}}</textarea>
                                                            @error('reward_description')
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
                                                            <label class="form-label" for="status">Status Keaktifan Reward</label>
                                                            <select class="form-control" name="reward_status">
                                                                @if($mode=='edit')
                                                                    @if($reward_status == 1)
                                                                        <option value="1">Terpilih -  Aktif</option>
                                                                    @else
                                                                        <option value="0">Terpilih -  Non-Aktif</option>
                                                                    @endif

                                                                @endif
                                                                <option value="1">Aktif</option>
                                                                <option value="0">Non-Aktif</option>
                                                            </select>
                                                            @error('reward_status')
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
                                                                <input id="reward_image"
                                                                       class="custom-file-input @error('reward_image') is-invalid @enderror"
                                                                       type="file" name="reward_image"
                                                                       accept="image/*"
                                                                       onchange="previewImg('reward_image')">
                                                                <label class="custom-file-label"
                                                                       for="reward_image">PILIH</label>
                                                            </div>


                                                            @if($mode=='edit')
                                                                @if($reward_image)
                                                                    @component('mycomponents.checkboxValue')
                                                                        @slot('variabel')
                                                                            gambar
                                                                        @endslot
                                                                        @slot('value')
                                                                            {{$reward_image}}
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
    <script src="{{asset('backtemplate/plugins/summernote/summernote.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //changeTextFile('gambar');
            $("#my-summernote").summernote();
        });
    </script>

@endpush
