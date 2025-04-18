<div class="header">

    <!-- Logo -->
    <div class="header-left active">
        <a href="{{ route('dashboard') }}" class="logo logo-normal">
            <img src="{{ photo_url(setting('site_logo')) }}" alt="">
        </a>
        <a href="{{ route('dashboard') }}" class="logo logo-white">
            <img src="{{ photo_url(setting('site_logo')) }}" alt="">
        </a>
        <a href="{{ route('dashboard') }}" class="logo-small">
            <img src="{{ photo_url(setting('favicon')) }}" alt="">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- Search -->
        <li class="nav-item nav-searchinputs">
            <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i data-feather="search"></i>
                </a>
                <form action="#" class="dropdown">
                    <div class="searchinputs dropdown-toggle" id="dropdownMenuClickable" data-bs-toggle="dropdown"
                        data-bs-auto-close="false">
                        <input type="text" placeholder="Search">
                        <div class="search-addon">
                            <span><i data-feather="x-circle" class="feather-14"></i></span>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <!-- /Search -->
        @if (route('pos.index') == request()->url())
            <li class="nav-item nav-item-box" title="Dashboard">
                <a href="{{ route('dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Dashboard">
                    <i data-feather="grid"></i>
                </a>
            </li>
            <li class="nav-item nav-item-box">
                <a href="javascript:void(0);" onclick="showKeyboardShortcutModal()" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="Keyboard Shortcuts">
                    <i data-feather="command"></i>
                </a>
            </li>
        @else
            <li class="nav-item nav-item-box" title="POS">
                <a href="{{ route('pos.index') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="POS">
                    <i data-feather="shopping-cart"></i>
                </a>
            </li>
        @endif

        <!-- Flag -->
        <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
                <img src="{{ asset('assets/img/flags/' . get_language_flag(get_current_user_language()) . '.png') }}"
                    alt="Language" class="img-fluid">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @foreach (get_all_languages() as $language)
                    <a href="{{ route('change.lang', ['lang' => $language]) }}"
                        class="dropdown-item {{ get_current_user_language() == $language ? 'active' : '' }}">
                        <img src="{{ asset('assets/img/flags/' . get_language_flag($language) . '.png') }}"
                            alt="" height="16"> {{ get_language_full_name($language) }}
                    </a>
                @endforeach
            </div>
        </li>
        <!-- /Flag -->

        <li class="nav-item nav-item-box">
            <a href="javascript:void(0);" id="btnFullscreen">
                <i data-feather="maximize"></i>
            </a>
        </li>

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-info">
                    <span class="user-letter">
                        <img src="{{ auth()->user()->avatar }}" alt="" class="img-fluid">
                    </span>
                    <span class="user-detail">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->role_name }}</span>
                    </span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img"><img src="{{ auth()->user()->avatar }}" alt="">
                            <span class="status online"></span></span>
                        <div class="profilesets">
                            <h6>{{ auth()->user()->name }}</h6>
                            <h5>{{ auth()->user()->role_name }}</h5>
                        </div>
                    </div>
                    <hr class="m-0">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"> <i class="me-2"
                            data-feather="user"></i> My
                        Profile</a>
                    <a class="dropdown-item" href="{{ route('settings.site') }}"><i class="me-2"
                            data-feather="settings"></i>Settings</a>
                    <hr class="m-0">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item logout pb-0" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <img src="{{ asset('assets/img/icons/log-out.svg') }}" class="me-2"
                                alt="img">Logout
                        </a>
                    </form>
                </div>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
            <a class="dropdown-item" href="{{ route('settings.site') }}">Settings</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
            </form>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>
