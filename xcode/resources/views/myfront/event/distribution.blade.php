@extends('mylayouts.layout_front_sb')
@section('title', 'Persebaran Event')
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
    <section class="wrapper bg-soft-primary" id="#beranda">
        <div class="container pt-5 pb-5 pt-md-5 pb-md-10">
            <div class="row gx-lg-8 gx-xl-12 gy-10 mb-5 align-items-center">
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start order-2 order-lg-0"
                     data-cues="slideInDown" data-group="page-title" data-delay="600">
                    <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0">Persebarang Event</h1>
                    <p class="lead fs-lg mb-7">Persebaran event yang ada di Bandar Lampung</p>
                </div>
                <!-- /column -->
                <div class="col-lg-7" data-cue="slideInDown">
                    <lottie-player
                        src="{{asset('statis/illustrations/maps.json')}}"
                        background="transparent" speed="1" style="width: 100%; height: 400px;"
                        loop
                        autoplay></lottie-player>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->

    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h3> Event </h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Lokasi Persebaran Event</label>
                    </div>
                </div>
            </div>
            <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mt-4">
                <div class="col-lg-9 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-8 text-center">
                                    <div style="height: 400px;" id="mapgue"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Informasi Event</h5>
                            <a href="#" class="btn btn-soft-primary rounded-pill">Lihat Info Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- /section -->
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
        let lok_lat = {{$event_latitude}};
        let lok_lng = {{$event_longitude}};
        let data_event = @json($event);

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
        for(let i = 0; i < data_event.length; i++){
            let lat = data_event[i]['event_latitude'];
            let lon = data_event[i]['event_longitude'];
            let event_name = data_event[i]['event_name'];
            let event_lokasi = data_event[i]['event_lokasi'];

            var marker = L.marker([lat, lon], {
                draggable: false ,
                clickable : true,
                title : event_name
            }).addTo(results).bindPopup(event_name+'<br>'+event_lokasi)
                .openPopup();
        }

        marker.on('click', function (e) {

            console.log("data marker  : "+e);
            //var latdrag = (e.target._latlng.lat);
            //var lngdrag = (e.target._latlng.lng);
            // popup
            //     .setLatLng(e.target._latlng)
            //     .setContent("koordinatnya adalah " + e.target._latlng
            //         .toString()
            //     )
            //     .openOn(mymap);
        });
    </script>
@endpush
