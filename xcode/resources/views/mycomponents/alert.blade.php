@if (session('status'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{session('status')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
@endif



@if (session('feedback'))
    @if (session('feedback.tipe')=='error')
        @php $respon = 'GAGAL'; $tipe_alert = 'danger'; $icon = 'fas fa-ban';
        @endphp
    @else
        @php $respon = 'SUKSES'; $tipe_alert = 'success'; $icon = 'fas fa-check'; @endphp
    @endif
    <div class="alert alert-{{$tipe_alert}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon {{$icon}}"></i> {{$respon}}</h5>
        {{session('feedback.message')}}
    </div>
@endif

