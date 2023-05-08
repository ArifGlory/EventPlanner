@extends('mylayouts.layout_panel')
<?php
$titlePage = 'konfigurasi aplikasi';
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
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Konfigurasi App</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row mb-2">
                <div class="col-sm-12">
                    <p>isi form sesuai kebutuhan dari aplikasi</p>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <!-- DataTable with Buttons -->
                    <div class="card">
                        <form method="post" action="{{ url('main/update-settings') }}"
                              enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="card-body">
                                @include('mycomponents.alert')
                                <div class="row">
                                    <div class="col-lg-9">
                                        @foreach($data as $st)
                                            <div class="form-group mb-3 row">
                                                <label
                                                    class="form-label col-lg-3 col-form-label">{{ $st->setting_name }}</label>
                                                <div class="col">

                                                    @if($st->setting_type != 'textarea')
                                                        <input type="{{ $st->setting_type }}"
                                                               name="{{ $st->setting_var }}"
                                                               id="{{ $st->setting_var }}"
                                                               value="{{ $st->setting_val }}"
                                                               class="@error($st->setting_var) is-invalid @enderror form-control"
                                                               placeholder="{{$st->setting_description}}"
                                                               @if($st->setting_type=='file') accept="image/*"
                                                               @endif
                                                               @if($st->setting_type == 'file') onchange="previewImg('{{$st->setting_var}}')" @endif>
                                                        @if($st->setting_type == 'file')
                                                            <div class="mt-3 d-flex justify-content-center gap-4">
                                                                <a class="avatar avatar-xl image-popup-no-margins"
                                                                   href="{{getImageOri($st->setting_val)}}">
                                                                    <img src="{{getImageThumb($st->setting_val)}}"
                                                                         alt="image {{$st->setting_val}}"
                                                                         class="d-block rounded img-preview_{{$st->setting_var}}"
                                                                         height="100" width="100">
                                                                </a>
                                                            </div>
                                                        @endif

                                                    @else
                                                        <textarea class="form-control" name="{{ $st->setting_var }}"
                                                                  id="{{ $st->setting_var }}">{{ $st->setting_val }}</textarea>
                                                    @endif
                                                    @error($st->setting_var)
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col d-flex justify-content-center align-self-center">
                                        <lottie-player
                                            src="{{asset('assets/illustrations/64123-loading-or-settings.json')}}"
                                            background="transparent" speed="1" style="width: 100%; height: 100%;"
                                            loop
                                            autoplay></lottie-player>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                @component('mycomponents.btnsubmit')
                                    @slot('variabel')
                                        Simpan
                                    @endslot
                                @endcomponent
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')

@endpush
