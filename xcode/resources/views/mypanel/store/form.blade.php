@extends('mylayouts.layout_panel')
<?php
$modenya = $mode == 'add' ? 'tambah store' : 'ubah store';
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
                        <li class="breadcrumb-item"><a href="{{url('main/stores')}}">List</a></li>
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
                                                                       href="{{getImageOri($store_logo)}}">
                                                                        <img
                                                                            class="img-fluid rounded my-4 img-preview_gambar"
                                                                            src="{{getImageOri($store_logo)}}" height="110"
                                                                            width="110"
                                                                            alt="User picture">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(cekRoleAkses('superadmin') || cekRoleAkses('admin'))
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="store_pemilik">Pemilik Toko/UMKM</label>
                                                                    <br>
                                                                    <small>Pemilik Toko harus terdaftar dahulu di sistem</small>
                                                                    <select style="width:100%"
                                                                            class="form-control  @error('store_pemilik') is-invalid @enderror"
                                                                            name="store_pemilik" required id="store_pemilik">
                                                                    </select>
                                                                    @error('store_pemilik')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                    @endif
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="mm_nama">Nama
                                                                Toko/UMKM</label>
                                                            <input
                                                                class="form-control @error('store_name') is-invalid @enderror"
                                                                name="store_name" id="store_name" type="text"
                                                                value="{{ $store_name }}"
                                                                autofocus/>
                                                            @error('store_name')
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
                                                                class="form-control @error('store_tags') is-invalid @enderror"
                                                                name="store_tags" id="store_tags" type="text"
                                                                value="{{ $store_tags }}"/>
                                                            @error('store_tags')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> No. Telepon <small>Serbaiknya yang dapat dihubungi lewat whatsapp</small> </label>

                                                            <input
                                                                class="form-control @error('store_phone') is-invalid @enderror"
                                                                name="store_phone" id="store_phone" type="text"
                                                                value="{{ $store_phone }}"/>
                                                            @error('store_phone')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> URL Web Toko </label>
                                                            <input
                                                                class="form-control @error('store_url') is-invalid @enderror"
                                                                name="store_url" id="store_url" type="text"
                                                                value="{{ $store_url }}"/>
                                                            @error('store_url')
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
                                                                class="form-control @error('store_description') is-invalid @enderror"
                                                                id="exampleFormControlTextarea1" rows="3"
                                                                name="store_description">{{$store_description}}</textarea>
                                                            @error('store_description')
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
                                                            <label class="form-label" for="status">Jenis
                                                                Toko/UMKM</label>
                                                            <select style="width:100%"
                                                                    class="select2 form-control  @error('store_type') is-invalid @enderror"
                                                                    name="store_type" id="jenis_id">
                                                                <option value="online"> Online</option>
                                                                <option value="offline"> Offline</option>
                                                            </select>
                                                            @error('store_type')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="is_active">Gambar Toko</label>
                                                            <div class="custom-file">
                                                                <input id="store_logo"
                                                                       class="custom-file-input @error('store_logo') is-invalid @enderror"
                                                                       type="file" name="store_logo"
                                                                       accept="image/*"
                                                                       onchange="previewImg('store_logo')">
                                                                <label class="custom-file-label"
                                                                       for="store_logo">PILIH</label>
                                                            </div>


                                                            @if($mode=='edit')
                                                                @if($store_logo)
                                                                    @component('mycomponents.checkboxValue')
                                                                        @slot('variabel')
                                                                            gambar
                                                                        @endslot
                                                                        @slot('value')
                                                                            {{$store_logo}}
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
        @if($mode=='edit')
            var selectedPemilik = new Option('{{$pemilik->name}}', '{{$pemilik->id}}', true, true);
            $("#store_pemilik").append(selectedPemilik).trigger('change');
        @endif

        function remoteMember() {
            $("#store_pemilik").select2({
                placeholder: 'Cari nama pemilik dimulai dengan 3 karakter',
                //minimumInputLength: 3,
                ajax: {
                    url: "{{url('main/member')}}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term, // search term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: `${item.name} - ${item.email}`,
                                    id: `${item.id}`
                                }
                            })
                        };
                    },
                    cache: true
                },
                // dropdownParent: "#modal_form",
                templateResult: formatRepo,
                templateSelection: formatRepoSelection

            });
        }

        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }
            return repo.text;
        }

        function formatRepoSelection(repo) {
            return repo.text;
        }

        $(document).ready(function () {
            //changeTextFile('gambar');
            remoteMember();
        });
    </script>

@endpush
