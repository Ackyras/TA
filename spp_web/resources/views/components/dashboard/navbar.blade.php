<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
        @impersonating($guard = null)
        <a class="dropdown-item" href="{{ route('impersonate.leave') }}">
            <i class="far fa-user-circle"></i>
            Return ({{ auth()->id() }})
        </a>
        @endImpersonating
        @canImpersonate()
        <li class="nav-item dropdown">
            <button type="button" class="btn dropdown-toggle" id="navbarDropdown4" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Dev-Tool ({{ auth()->id() }})
            </button>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown4">
                <div class="dropdown-item">
                    <strong>
                        Easy Switch
                    </strong>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('impersonate', 2) }}">
                    <i class="far fa-eye"></i>
                    Kadis
                </a>
                <a class="dropdown-item" href="{{ route('impersonate', 3) }}">
                    <i class="far fa-eye"></i>
                    Kabid
                </a>
                <a class="dropdown-item" href="{{ route('impersonate', 7) }}">
                    <i class="far fa-eye"></i>
                    Koor
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>
        @endCanImpersonate
        <li class="nav-item dropdown">
            <button type="button" class="btn dropdown-toggle" id="navbarDropdown4" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {{ auth()->user()->name }}
            </button>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown4">
                <a class="dropdown-item" href="">
                    <i class="far fa-user-circle"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-danger dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>