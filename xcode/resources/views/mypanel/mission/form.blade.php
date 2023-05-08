@extends('mylayouts.layout_panel')
<?php
$modenya = $mode == 'add' ? 'tambah mission' : 'ubah mission';
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
                    <h6 class="m-1 font-weight-bolder">Total Point Saya : {{ format_angka_indo(Auth::user()->saldo_point) }} </h6>
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
                                                <h6>Pastikan total Mission Reward tidak melebihi kredit point yang anda miliki
                                                <br>
                                                    <small>Point anda akan langsung dikurangi sejumlah total reward yang diberikan</small>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if($mode=='edit')
                                                        <div class="col-lg-12">
                                                            <div class="user-picture-section mb-3">
                                                                <div class=" d-flex align-items-center flex-column">
                                                                    <a class="image-popup-no-margins"
                                                                       href="{{getImageOri($mission_image)}}">
                                                                        <img
                                                                            class="img-fluid rounded my-4 img-preview_gambar"
                                                                            src="{{getImageOri($mission_image)}}" height="110"
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
                                                                class="form-control @error('mission_name') is-invalid @enderror"
                                                                name="mission_name" id="mission_name" type="text"
                                                                value="{{ $mission_name }}"
                                                                autofocus/>
                                                            @error('mission_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="mission_total_reward">Total Reward Mission</label>
                                                                <input
                                                                    class="form-control numbersOnly @error('mission_total_reward') is-invalid @enderror"
                                                                    @if($isAlreadyJoined > 0) disabled @endif
                                                                    name="mission_total_reward" id="mission_total_reward" type="number"
                                                                    value="{{ $mission_total_reward }}"
                                                                    autofocus/>
                                                                @error('mission_total_reward')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="mission_reward_peserta">Reward per Peserta
                                                                <br>
                                                                    <small>Reward minimal 1000 Point</small>
                                                                </label>
                                                                <input
                                                                    class="form-control numbersOnly @error('mission_reward_peserta') is-invalid @enderror"
                                                                    @if($isAlreadyJoined > 0) disabled @endif
                                                                    name="mission_reward_peserta" id="mission_reward_peserta" type="number"
                                                                    value="{{ $mission_reward_peserta }}"
                                                                    autofocus/>
                                                                @error('mission_total_reward')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="mission_max_participant">Max Participant</label>
                                                                <input
                                                                    class="form-control numbersOnly @error('mission_max_participant') is-invalid @enderror"
                                                                    name="" id="mission_max_participant" type="number"
                                                                    @if($mode=='edit') value="{{ $mission_max_participant }}" @endif
                                                                    disabled
                                                                    autofocus/>
                                                                @error('mission_max_participant')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="bobot">Deskripsi</label>
                                                            <textarea class="form-control @error('mission_description') is-invalid @enderror"
                                                                id="my-summernote"
                                                                name="mission_description">{{$mission_description}}</textarea>
                                                            @error('mission_description')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="status">Tanggal Akhir mission</label>
                                                                <input
                                                                    class="form-control @error('mission_end_date') is-invalid @enderror"
                                                                    name="mission_end_date" id="mission_end_date" type="date"
                                                                    value="{{ $mission_end_date }}"/>
                                                                @error('mission_end_date')
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
                                                                    <input id="mission_image"
                                                                           class="custom-file-input @error('mission_image') is-invalid @enderror"
                                                                           type="file" name="mission_image"
                                                                           accept="image/*"
                                                                           onchange="previewImg('mission_image')">
                                                                    <label class="custom-file-label"
                                                                           for="mission_image">PILIH</label>
                                                                </div>


                                                                @if($mode=='edit')
                                                                    @if($mission_image)
                                                                        @component('mycomponents.checkboxValue')
                                                                            @slot('variabel')
                                                                                gambar
                                                                            @endslot
                                                                            @slot('value')
                                                                                {{$mission_image}}
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
                                    <div class="col-lg-4 mt-3">
                                        <div class="card">
                                            <div class="card-header bg-success">
                                                <h6>Budget Calculator
                                                    <br>
                                                    <small>Yuk coba hitung kebutuhan campaign mission anda</small>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="mission_max_participant">Peserta ingin dijangkau</label>
                                                            <input
                                                                class="form-control numbersOnly" id="estimatedPerson" type="number"
                                                                value=""/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="mission_max_participant">Reward Point per Peserta</label>
                                                            <br>
                                                            <p> <strong>Minimal 1000 Point</strong> </p>
                                                            <input
                                                                class="form-control numbersOnly" id="rewardPointPeserta" type="number" min="1000"
                                                                value="1000"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Budget Dibutuhkan (point)</label>
                                                            <input
                                                                class="form-control" id="estimatedBudget" type="text" disabled
                                                                value=""/>
                                                        </div>
                                                        <div class="form-group">
                                                            <input value="0" type="range" min="0" max="{{Auth::user()->saldo_point}}" class="custom-range" id="budgetRange">
                                                        </div>
                                                    </div>
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

            $("#estimatedPerson").keyup(function (){
                if($(this).val() != null && $(this).val() !== ""){
                    var person = parseInt($(this).val());
                    var reward = parseInt($("#rewardPointPeserta").val());
                    var budgets = person * reward;
                    var text = budgets.toLocaleString('de-DE');
                    console.log(budgets);

                    $("#estimatedBudget").val(text);
                }else{
                    $("#estimatedBudget").val(0)
                }
            });
            $("#mission_reward_peserta").keyup(function () {
                if($("#mission_total_reward").val() !== "" && $(this).val() !== ""){
                    var totalReward = parseInt($("#mission_total_reward").val());
                    var rewardPeserta = parseInt($(this).val());
                    var partisipanMax = parseInt(totalReward / rewardPeserta);

                    $("#mission_max_participant").val(partisipanMax);
                }
            });

            $("#budgetRange").change(function (){
                var budget = parseInt($(this).val());
                var reward = parseInt($("#rewardPointPeserta").val());

                var person = parseInt(budget / reward);
                $("#estimatedPerson").val(person);

                var text = budget.toLocaleString('de-DE');
                $("#estimatedBudget").val(text+" Point");
            });
        });

        jQuery('.numbersOnly').keyup(function () {
            this.value = this.value.replace(/[^0-9\.]/g,'');
        });


    </script>

@endpush
