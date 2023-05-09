<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <a href="{{getImageThumb($row->foto)}}">
                <img class="profile-user-img img-fluid img-circle img-preview_avatar"
                     src="{{getImageThumb($row->foto)}}"
                     alt="user image {{$row->name}}">
            </a>
        </div>
        <br>
        <h3 class="profile-username text-center">{{$row->name}}</h3>
        <p class="text-muted text-center">{{ $row->alamat }}</p>

    </div>
    <div class="card-body">
        <hr>
        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
        <p class="text-muted">
            {{$row->email}}
        </p>
    </div>

</div>
