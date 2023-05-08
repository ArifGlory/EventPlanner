@extends('mylayouts.layout_panel')
<?php

$titlePage = "Tambah Transaksi Point Manual";
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
                        <li class="breadcrumb-item"><a href="{{url('main/transaksi-point')}}">List</a></li>
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
                                                    @endif
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="user_id">Pilih Pengguna</label>
                                                                <br>
                                                                <small>pengguna harus terdaftar dahulu di sistem</small>
                                                                <select style="width:100%"
                                                                        class="form-control  @error('user_id') is-invalid @enderror"
                                                                        name="user_id" required id="user_id">
                                                                </select>
                                                                @error('user_id')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="category_name">Jumlah Top-up Point</label>
                                                            <input
                                                                class="form-control @error('log_saldo_nominal') is-invalid @enderror"
                                                                name="log_saldo_nominal" id="log_saldo_nominal" type="number"
                                                                value="{{ $log_saldo_nominal }}"
                                                                autofocus/>
                                                            @error('log_saldo_nominal')
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
                                                                    class="form-control @error('log_saldo_description') is-invalid @enderror"
                                                                    id="exampleFormControlTextarea1" rows="3"
                                                                    name="log_saldo_description">{{$log_saldo_description}}</textarea>
                                                                @error('log_saldo_description')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="is_active">Bukti Pembayaran</label>
                                                            <br>
                                                            <small>dapat diisi dengan bukti transfer dll.</small>
                                                            <div class="custom-file">
                                                                <input id="log_saldo_bukti"
                                                                       class="custom-file-input @error('log_saldo_bukti') is-invalid @enderror"
                                                                       type="file" name="log_saldo_bukti"
                                                                       accept="image/*"
                                                                       onchange="previewImg('log_saldo_bukti')">
                                                                <label class="custom-file-label"
                                                                       for="log_saldo_bukti">PILIH</label>
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
                                        <!--end::Card-->
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
        function remoteMember() {
            $("#user_id").select2({
                placeholder: 'Cari nama pengguna dimulai dengan 3 karakter',
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
