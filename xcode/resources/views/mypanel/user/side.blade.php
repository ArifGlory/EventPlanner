<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <a href="{{getImageThumb($row->avatar)}}">
                <img class="profile-user-img img-fluid img-circle img-preview_avatar"
                     src="{{getImageThumb($row->member->avatar)}}"
                     alt="user image {{$row->member->ktp->nama}}">
            </a>
        </div>
        <h3 class="profile-username text-center">{{$row->member->ktp->nama}}</h3>
        <p class="text-muted text-center">{{getRoleNameForUser($row)}}</p>

    </div>
    <div class="card-body">
        <?php
        $active = getActiveLabel($row->status);
        ?>
        <strong><i class="{{$active['icon'].' '.$active['color']}}"></i> Status</strong>
        <p class="text-muted">{{$active['teks']}}</p>
        <hr>
        <strong><i class="fas fa-user-check mr-1"></i> NIK</strong>
        <p class="text-muted">
            {{$row->nik}}
        </p>
        <hr>
        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
        <p class="text-muted">
            {{$row->email}}
        </p>
    </div>

</div>
