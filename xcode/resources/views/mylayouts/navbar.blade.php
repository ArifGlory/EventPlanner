<nav class="main-header navbar navbar-expand navbar-success navbar-light" style="background-color: #E668B3!important;">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <div class="btn-group">
            <button type="button" class="btn btn-default">
                @if(Auth::user()->foto)
                    <img src="{{getImageThumb(Auth::user()->foto)}}" class="img-circle elevation-2" alt="User Image" width="25px" height="25px"> {{Auth::user()->name}}
                @else
                    <img src="{{asset('statis/user_logo.png')}}" class="img-circle elevation-2" alt="User Image" width="25px" height="25px"> {{Auth::user()->name}}
                @endif
            </button>
            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"
                    aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
                <a href="{{url('main/profil')}}" class="dropdown-item has-icon">
                    <i class="far fa-sm fa-user"></i> Profil
                </a>
                <a href="{{url('main/log-saya')}}" class="dropdown-item has-icon">
                    <i class="fas fa-sm fa-bolt"></i> Log Aktivitas
                </a>
                <a href="{{url('main/ubah-password')}}" class="dropdown-item has-icon">
                    <i class="fas fa-sm fa-cog"></i> Ubah Password
                </a>
                <div class="dropdown-divider"></div>


                    <a href="{{ route('auth-logout') }}"
                       class="dropdown-item"><i
                            class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>

            </div>
        </div>

    </ul>
</nav>
