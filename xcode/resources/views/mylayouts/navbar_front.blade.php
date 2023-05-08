<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid">
        <a href="{{url('')}}" class="navbar-brand">
            @if(getSetting('app_logo'))
                <img src="{{getImageThumb(getSetting('app_logo'))}}" alt="{{getSetting('app_name')}}"
                     class="brand-image">
            @else
                @include('mylayouts.default_logo')
            @endif
            <span class="brand-text font-weight-bold" style="color: black!important;">{{getSetting('app_name')}}</span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">


            <ul class="navbar-nav">

                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       class="nav-link dropdown-toggle font-weight-bold" style="color: black!important;">Homepage</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item">2022 </a></li>
                        <li><a href="#" class="dropdown-item">2021</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

            <li class="nav-item">
                @if(\Auth::check())
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-dashboard mr-2"></i> Panel User
                    </a>
                @else
                    <a class="nav-link" data-slide="true" href="{{url('login')}}" role="button">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login App
                    </a>
                @endif
            </li>
        </ul>
    </div>
</nav>
