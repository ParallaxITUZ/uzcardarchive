<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" src="/assets/brand/logo.svg" width="118" height="46">
                <svg class="sidebar-brand-full" width="118" height="46">
                    <use xlink:href="/assets/brand/logo.svg"></use>
                </svg>
                <svg class="sidebar-brand-narrow" width="46" height="46">
                    <use xlink:href="/assets/brand/logo.svg"></use>
                </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="/">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
                </svg>
                {{ __('common.dashboard') }}
                <span class="badge badge-sm bg-info ms-auto">{{ __('common.new') }}</span>
            </a>
        </li>
        <li class="nav-title">{{ __('common.user_settings') }}</li>
        @permission('users_read')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-users nav-icon"></i>
                {{ __('common.users') }}
            </a>
        </li>
        @endpermission
        @permission('roles_read')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="fas fa-users-cog nav-icon"></i>
                {{ __('common.roles') }}
            </a>
        </li>
        @endpermission
        @permission('permissions_read')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('permissions.index') }}">
                <i class="fas fa-tasks nav-icon"></i>
                {{ __('common.permissions') }}
            </a>
        </li>
        @endpermission
        <li class="nav-title">{{ __('common.dictionaries') }}</li>
        @permission('dictionaries_read')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dictionaries.index') }}">
                <i class="far fa-folder-open nav-icon"></i>
                {{ __('common.dictionaries') }}
            </a>
        </li>
        @endpermission
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="javascript:void(0)">
                <i class="fas fa-sitemap nav-icon"></i>
                {{ __('common.organizational_structures') }}
            </a>
            <ul class="nav-group-items">
                @permission('companies_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('companies.index') }}" target="_top">
                        <i class="far fa-building nav-icon"></i>
                        {{ __('common.companies') }}
                    </a>
                </li>
                @endpermission
                @permission('filials_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('filials.index') }}" target="_top">
                        <i class="far fa-building nav-icon"></i>
                        {{ __('common.filials') }}
                    </a>
                </li>
                @endpermission
                @permission('centres_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('centres.index') }}" target="_top">
                        <i class="far fa-building nav-icon"></i>
                        {{ __('common.centres') }}
                    </a>
                </li>
                @endpermission
                @permission('departments_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('departments.index') }}" target="_top">
                        <i class="far fa-building nav-icon"></i>
                        {{ __('common.departments') }}
                    </a>
                </li>
                @endpermission
                @permission('agents_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agents.index') }}" target="_top">
                        <i class="fas fa-user-tie nav-icon"></i>
                        {{ __('common.agents') }}
                    </a>
                </li>
                @endpermission
                @permission('agent_workers_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agent-workers.index') }}" target="_top">
                        <i class="fas fa-user-tie nav-icon"></i>
                        {{ __('common.agent_workers') }}
                    </a>
                </li>
                @endpermission
            </ul>
        </li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="javascript:void(0)">
                <i class="fas fa-warehouse nav-icon"></i>
                {{ __('common.warehouse') }}
            </a>
            <ul class="nav-group-items">
                @permission('policies_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('policies.index') }}" target="_top">
                        <i class="fas fa-boxes nav-icon"></i>
                        {{ __('common.policies') }}
                    </a>
                </li>
                @endpermission
                @permission('policies_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('policies.index') }}" target="_top">
                        <i class="far fa-file-alt nav-icon"></i>
                        {{ __('common.applications') }}
                    </a>
                </li>
                @endpermission
                @permission('policies_read')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('policies.index') }}" target="_top">
                        <i class="far fa-list-alt nav-icon"></i>
                        {{ __('common.logs') }}
                    </a>
                </li>
                @endpermission
            </ul>
        </li>
        <li class="nav-divider"></li>
        <li class="nav-title">Extras</li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-star"></use>
                </svg>
                Pages
            </a>
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="login.html" target="_top">
                        <svg class="nav-icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                        </svg>
                        Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.html" target="_top">
                        <svg class="nav-icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                        </svg>
                        Register
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="404.html" target="_top">
                        <svg class="nav-icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bug"></use>
                        </svg>
                        Error 404
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="500.html" target="_top">
                        <svg class="nav-icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bug"></use>
                        </svg>
                        Error 500
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mt-auto"><a class="nav-link" href="docs.html">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-description"></use>
                </svg>
                Docs</a></li>
        <li class="nav-item"><a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-layers"></use>
                </svg>
                Try CoreUI
                <div class="fw-semibold">PRO</div>
            </a></li>
    </ul>
    {{--    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>--}}
</div>
