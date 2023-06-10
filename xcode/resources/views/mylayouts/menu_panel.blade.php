<aside class="main-sidebar sidebar-light-success elevation-4">
    <a href="javascript:void(0);" class="brand-link text-sm text-white">
        @if(getSetting('app_logo'))
            <img src="{{getImageThumb(getSetting('app_logo'))}}" alt="{{getSetting('app_name')}}"
                 class="brand-image">
        @else
            @include('mylayouts.default_logo')
        @endif
        <span class="brand-text font-weight-bolder text-success">{{getSetting('app_name')}}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{url('main')}}" class="nav-link {{ activeMenuSeg1('main') }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-header">Master Data</li>

                @if(cekRoleAkses('superadmin') || cekRoleAkses('admin') || cekRoleAkses('store'))

                    <li class="nav-item">
                        <a href="{{url('main/event')}}" class="nav-link {{ activeMenu('main/event') }}">
                            <i class="nav-icon fas fa-star"></i>
                            <p>
                                Event
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('main/berita')}}" class="nav-link {{ activeMenu('main/berita') }}">
                            <i class="nav-icon fas fa-file-contract"></i>
                            <p>
                                Berita
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('main/category')}}" class="nav-link {{ activeMenu('main/category') }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Kategori
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('main/report')}}" class="nav-link {{ activeMenu('main/report') }}">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Report Event
                            </p>
                        </a>
                    </li>
                @endif


                @if(cekRoleAkses('superadmin'))
                    <li class="nav-header">Konfigurasi</li>
                    <li class="nav-item">
                        <a href="{{url('main/category')}}" class="nav-link {{ activeMenu('main/category') }}">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>
                                Kategori
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('main/subcategory')}}" class="nav-link {{ activeMenu('main/subcategory') }}">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>
                                Sub Kategori
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('main/settings')}}" class="nav-link {{ activeMenu('main/settings') }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Pengaturan Aplikasi
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('main/pengguna')}}" class="nav-link {{ activeMenu('main/pengguna') }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Pengguna
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">Ekstra</li>
                    <li class="nav-item">
                        <a href="{{url('main/transaksi-point')}}" class="nav-link {{ activeMenu('main/transaksi-point') }}">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>
                                 Transaksi Point
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('main/aktivitas')}}" class="nav-link {{ activeMenu('main/aktivitas') }}">
                            <i class="nav-icon fas fa-clock"></i>
                            <p>
                                Catatan Aktivitas
                            </p>
                        </a>
                    </li>
                @endif


            </ul>
        </nav>
    </div>
</aside>
