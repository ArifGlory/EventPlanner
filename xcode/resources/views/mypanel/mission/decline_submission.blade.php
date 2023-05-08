@extends('mylayouts.layout_panel')
<?php
$titlePage = "Tolak Submission";
?>
@section('title', ucwords($titlePage))
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
                        <li class="breadcrumb-item"><a href="{{url('main/mission')}}">List</a></li>
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
                                                <h6>Berikan Alasan penolakan submission yang jelas kepada pengguna</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="text-center">
                                                            <label>Bukti Pengerjaan</label>
                                                            <br>
                                                            <a href="{{getImageOri($submission->submission_image)}}" class="image-popup-no-margins">
                                                                <img onerror="imgError(this)" class="profile-user-img img-fluid"
                                                                     src="{{ getImageThumb($submission->submission_image) }}" alt="mission">
                                                            </a>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <table class="table">
                                                                <tr>
                                                                    <td style="width:30%">Nama Pengguna</td>
                                                                    <th style="width:70%">{{$submission->name}}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:30%">Akun Social media</td>
                                                                    <th style="width:70%">{{$submission->submission_user_socmed_account}}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:30%">Nama Mission</td>
                                                                    <th style="width:70%">{{$submission->mission_name}}</th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <input type="hidden" name="submission_id" value="{{ encodeId($submission->submission_id)  }}">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="bobot">Alasan Penolakan</label>
                                                            <textarea class="form-control @error('submission_decline_reason') is-invalid @enderror"
                                                                id=""
                                                                name="submission_decline_reason">{{$submission_decline_reason}}</textarea>
                                                            @error('submission_decline_reason')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
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
        $(document).ready(function () {
            //changeTextFile('gambar');
        });
    </script>

@endpush
