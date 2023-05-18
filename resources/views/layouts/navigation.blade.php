<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
            </svg>
        </button>
        <a class="header-brand d-md-none" href="javascript:void(0)">
            <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="assets/brand/coreui.svg#full"></use>
            </svg>
        </a>
        <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">{{ __('common.dashboard') }}</a></li>
        </ul>
        <ul class="header-nav ms-auto">
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="javascript:void(0)">--}}
{{--                    <svg class="icon icon-lg">--}}
{{--                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>--}}
{{--                    </svg>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="false">
                    {{Auth::user()->profile->name}}
                    <div class="avatar avatar-md ml-1">
                        <img class="avatar-img" src="/assets/img/avatars/8.jpg" alt="user@email.com">
                        <span class="avatar-status bg-success"></span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">{{ __('common.settings') }}</div>
                    </div>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg>
                        {{ __('common.profile') }}
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg>
                        {{ __('common.settings') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link class="dropdown-item" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg class="icon me-2">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                            </svg>
                            {{ __('auth.logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single--><span>{{ __('common.home') }}</span>
                </li>
                <li class="breadcrumb-item active"><span>{{ __('common.dashboard') }}</span></li>
            </ol>
        </nav>
    </div>
</header>
