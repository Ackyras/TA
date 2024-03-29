<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <img src="{{ asset('adminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NICK_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
            <div class="info">
                <a href="{{ route('dashboard.index') }}" class="d-block">
                    {{ getCurrentPeriod() ? 'Periode ' . getCurrentPeriod()->name : '' }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                @canany(['users', 'divisions', 'programs'])
                    <li class="nav-header">Settings</li>
                    <li class="nav-item {{ request()->routeIs('dashboard.setting.*') ? 'active menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        @can('periods')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.setting.period.index') }}"
                                        class="nav-link {{ request()->routeIs('dashboard.setting.period.*') ? 'active' : '' }}">
                                        <i class="fas fa-clock nav-icon"></i>
                                        <p>List Periode</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.setting.seeding.index') }}"
                                    class="nav-link {{ request()->routeIs('dashboard.setting.seeding.*') ? 'active' : '' }}">
                                    <i class="fas fa-upload nav-icon"></i>
                                    <p>Mass Upload</p>
                                </a>
                            </li>
                        </ul>
                        @can('users')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.setting.user.index') }}"
                                        class="nav-link {{ request()->routeIs('dashboard.setting.user.*') ? 'active' : '' }}">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>List User</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can('divisions')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.setting.division.index') }}"
                                        class="nav-link {{ request()->routeIs('dashboard.setting.division.*') ? 'active' : '' }}">
                                        <i class="fas fa-user-tie nav-icon"></i>
                                        <p>Bidang</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can('programs')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.setting.program.index') }}"
                                        class="nav-link {{ request()->routeIs('dashboard.setting.program.*') ? 'active' : '' }}">
                                        <i class="fas fa-scroll nav-icon"></i>
                                        <p>Kamus Usulan</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                    </li>
                @endcanany
                @canany(['districts', 'villages', 'farmers'])
                    <li class="nav-header">Daerah</li>
                    @can('districts')
                        <li class="nav-item">
                            <a href="{{ route('dashboard.district.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.district.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-city"></i>
                                <p>
                                    Kecamatan
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('villages')
                        <li class="nav-item">
                            <a href="{{ route('dashboard.village.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.village.*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-home"></i>
                                <p>
                                    Desa
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('farmers')
                        <li class="nav-item">
                            <a href="{{ route('dashboard.farmer.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.farmer.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    Kelompok Tani
                                </p>
                            </a>
                        </li>
                    @endcan
                @endcanany
                @if (activePeriodIsExists())
                    <li class="nav-header">Pengajuan</li>
                    @can('requests.read')
                        <li class="nav-item">
                            <a href="{{ route('dashboard.request.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.request.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Proposal Bantuan
                                </p>
                            </a>
                        </li>
                        {{-- @hasanyrole(['kadis', 'kabid'])
                        <li class="nav-item">
                            <a href="{{ route('dashboard.request.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.request.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-stream"></i>
                                <p>
                                    Pelaksanaan bantuan
                                </p>
                            </a>
                        </li>
                    @endhasanyrole --}}
                    @endcan
                    @if (archivePeriodIsExists())
                        @can('archives.*')
                            <li class="nav-header">Arsip</li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.archive.index') }}"
                                    class="nav-link {{ request()->routeIs('dashboard.archive.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box"></i>
                                    <p>
                                        Arsip
                                    </p>
                                </a>
                            </li>
                            @if (request()->routeIs('dashboard.archive.period.*'))
                                <li
                                    class="nav-item {{ request()->routeIs('dashboard.archive.*') ? 'active menu-open' : '' }}">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-box-open"></i>
                                        <p>
                                            Data Arsip
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    @can('archives.requests')
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('dashboard.archive.period.request.index', ['period' => request()->route()->parameter('period')]) }}"
                                                    class="nav-link {{ request()->routeIs('dashboard.archive.period.request.*') ? 'active' : '' }}">
                                                    <i class="fas fa-file-archive nav-icon"></i>
                                                    <p>Pengajuan</p>
                                                </a>
                                            </li>
                                        </ul>
                                    @endcan
                                </li>
                            @else
                            @endif
                        @endcan
                    @endif
                @endif
                {{-- <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.district.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.district.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Beranda
                        </p>
                    </a>
                </li> --}}
                {{-- <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Level 1</p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Level 1
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Level 2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Level 2
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Level 2</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Level 1</p>
                    </a>
                </li>
                <li class="nav-header">LABELS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p class="text">Important</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle text-warning"></i>
                        <p>Warning</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Informational</p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
