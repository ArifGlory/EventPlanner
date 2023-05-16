@extends('mylayouts.layout_panel')
<?php
$modenya = $mode == 'add' ? 'tambah event' : 'ubah event';
$titlePage = $modenya;
?>
@section('title', ucwords($titlePage))
@push('css')
    <!-- leaflet css  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@3.1.3/dist/esri-leaflet-geocoder.css"
          integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
          crossorigin="">
    <style>
        /* ukuran peta */
        #mapgue {
            height: 100%;
        }
    </style>
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
                                    <div class="col-lg-12 mt-3">
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
                                                    <div class="col-lg-12 mb-8 text-center">
                                                        <h3>Peta Lokasi Event</h3>
                                                        <div style="height: 400px;" id="mapgue"></div>
                                                    </div>
                                                    <div class="col-lg-6 mt-4">
                                                        <div class="form-group mb-2">
                                                            <label for="lok_lat">Latitude</label>
                                                            <input type="text"
                                                                   class="form-control  @error('event_latitude') is-invalid @enderror"
                                                                   id="event_latitude" name="event_latitude" readonly
                                                                   value="{{$event_latitude}}"/>
                                                            @error('event_latitude')
                                                            <div class="invalid-feedback" id="error_event_latitude">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mt-4">
                                                        <div class="form-group mb-2">
                                                            <label for="lok_lng">
                                                                Longitude</label>
                                                            <input type="text"
                                                                   class="form-control  @error('event_longitude') is-invalid @enderror"
                                                                   id="event_longitude" name="event_longitude" readonly
                                                                   value="{{$event_longitude}}">
                                                            @error('event_longitude')
                                                            <div class="invalid-feedback" id="error_event_longitude">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-1">
                                                        <div class="mb-3 mt-4">
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
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 mt-3">
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
    <!-- leaflet js  -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet@3.0.8/dist/esri-leaflet.js"
            integrity="sha512-E0DKVahIg0p1UHR2Kf9NX7x7TUewJb30mxkxEm2qOYTVJObgsAGpEol9F6iK6oefCbkJiA4/i6fnTHzM6H1kEA=="
            crossorigin=""></script>

    <script src="https://unpkg.com/esri-leaflet-geocoder@3.1.3/dist/esri-leaflet-geocoder.js"
            integrity="sha512-mwRt9Y/qhSlNH3VWCNNHrCwquLLU+dTbmMxVud/GcnbXfOKJ35sznUmt3yM39cMlHR2sHbV9ymIpIMDpKg4kKw=="
            crossorigin=""></script>
    <script>
        var lok_lat = {{$event_latitude}};
        var lok_lng = {{$event_longitude}};
        var mymap = L.map('mapgue').setView([lok_lat, lok_lng], 13);
        //setting maps menggunakan api mapbox bukan google maps, daftar dan dapatkan token

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        // buat variabel berisi fugnsi L.popup
        var popup = L.popup();

        var searchControl = L.esri.Geocoding.geosearch({
            position: 'topright',
            placeholder: 'Cari Lokasi',
            useMapBounds: false,
            providers: [L.esri.Geocoding.arcgisOnlineProvider({
                apikey: 'AAPK2e97da1510ea44cda7d15d90f4c5a6012SBpdH2i6kuElOVl6wuvVOqTOCqfRItUfj52KH0xKMXKgISf3ZvMeyzcKHd1B0z-', // replace with your api key - https://developers.arcgis.com
                nearby: {
                    lat: -5.441073410393852,
                    lng: 105.25861960614812
                }
            })]
        }).addTo(mymap);

        var results = L.layerGroup().addTo(mymap);
        // create markers
        var marker = L.marker([lok_lat, lok_lng], {
            draggable: true
        }).addTo(results).bindPopup('Tandai Lokasi<br> Secara Manual.')
            .openPopup();

        searchControl.on('results', function (e) {
            results.clearLayers();
            for (var i = e.results.length - 1; i >= 0; i--) {
                var searchMarker = L.marker(e.results[i].latlng, {
                    draggable: true
                });
                document.getElementById('event_latitude').value = searchMarker.getLatLng().lat;
                document.getElementById('event_longitude').value = searchMarker.getLatLng().lng;

                searchMarker.on('dragend', function (e) {
                    console.log(e);
                    var _marker = e.target;
                    console.log(_marker.getLatLng())
                    document.getElementById('event_latitude').value = _marker.getLatLng().lat;
                    document.getElementById('event_longitude').value = _marker.getLatLng().lng;
                })
                results.addLayer(searchMarker);
            }
        });


        setTimeout(function () {
            $('.pointer').fadeOut('slow');
        }, 3400);


        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("koordinatnya adalah " + e.latlng
                    .toString()
                )
                .openOn(mymap);
        }

        mymap.on('click', onMapClick);
        marker.on('dragend', function (e) {
            var latdrag = (e.target._latlng.lat);
            var lngdrag = (e.target._latlng.lng);
            // popup
            //     .setLatLng(e.target._latlng)
            //     .setContent("koordinatnya adalah " + e.target._latlng
            //         .toString()
            //     )
            //     .openOn(mymap);
            document.getElementById('event_latitude').value = latdrag;
            document.getElementById('event_longitude').value = lngdrag;
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            //changeTextFile('event_poster');
        });
    </script>

@endpush
