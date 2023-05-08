<?php
$segment = Request::segment(1).'/'.Request::segment(2);
?>
<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-pills flex-column flex-sm-row mb-4">
            <li class="nav-item"><a class="nav-link {{ $segment=='main/profil' ? 'active' : '' }}" href="{{url('main/profil')}}"><i
                        class='fa fa-user'></i> Profil</a></li>
            <li class="nav-item"><a class="nav-link {{ $segment=='main/log-saya' ? 'active' : '' }}" href="{{url('main/log-saya')}}"><i class='fa fa-time'></i>
                    Aktivitas</a></li>
            <li class="nav-item"><a class="nav-link {{ $segment=='main/ubah-password' ? 'active' : '' }}" href="{{url('main/ubah-password')}}"><i
                        class='fa fa-key'></i> Ubah Password</a></li>
        </ul>
    </div>
</div>
