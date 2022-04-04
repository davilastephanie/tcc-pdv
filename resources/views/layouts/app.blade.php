@extends('layouts.html')

@section('bodyClass', 'c-app')

@section('body')
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <img src="{{ url('/img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="46" class="c-sidebar-brand-full">
            <img src="{{ url('/img/logo-icon.png') }}" alt="{{ env('APP_NAME') }}" height="46" class="c-sidebar-brand-minimized">
        </div>
        <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-item">
                <a href="{{ url('/') }}" class="c-sidebar-nav-link {{ $menuActive == 'home' ? 'c-active' : '' }}">
                    <i class="c-sidebar-nav-icon c-icon cil-home"></i> Home
                </a>
            </li>

            @foreach (getAppMenu($menuActive) as $group => $modules)
                @if (!empty($group))
                    <li class="c-sidebar-nav-title">{{ $group }}</li>
                @endif

                @foreach ($modules as $props)
                    <li class="c-sidebar-nav-item">
                        @if ($props['url'] != '#')
                            <a href="{{ $props['url'] }}" class="c-sidebar-nav-link {{ $props['active'] ? 'c-active' : '' }}">
                                <i class="c-sidebar-nav-icon c-icon {{ $props['icon'] }}"></i> {{ $props['title'] }}
                            </a>
                        @else
                            <a href="#" class="c-sidebar-nav-link text-muted">
                                <i class="c-sidebar-nav-icon c-icon {{ $props['icon'] }} text-muted"></i> {{ $props['title'] }}
                            </a>
                        @endif
                    </li>
                @endforeach
            @endforeach

        </ul>
        <button type="button"
                class="c-sidebar-minimizer c-class-toggler"
                data-target="_parent"
                data-class="c-sidebar-minimized"
        ></button>
    </div>
    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <button type="button"
                    class="c-header-toggler c-class-toggler d-lg-none mfe-auto"
                    data-target="#sidebar"
                    data-class="c-sidebar-show"
            >
                <i class="c-icon c-icon-lg cil-menu"></i>
            </button>

            <a href="{{ url('/') }}" class="c-header-brand d-lg-none">
                <img src="{{ url('/img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="46">
            </a>

            <button type="button"
                    class="c-header-toggler c-class-toggler mfs-3 d-md-down-none"
                    data-target="#sidebar"
                    data-class="c-sidebar-lg-show"
                    responsive="true"
            >
                <i class="c-icon c-icon-lg cil-menu"></i>
            </button>

            <ul class="c-header-nav ml-auto mr-4">
                <li class="c-header-nav-item">
                    <span class="badge badge-primary badge-username">
                        <i class="c-icon cil-user"></i> {{ auth()->user()->name }}
                    </span>
                </li>
                <li class="c-header-nav-item">
                    <a href="#"
                       class="c-header-nav-link js-submit-confirm"
                       title="Sair"
                       data-toggle="tooltip"
                       data-target="#formLogout"
                       data-message="Deseja realmente sair?"
                    >
                        <i class="c-icon c-icon-lg cil-account-logout"></i>
                    </a>
                </li>
            </ul>
            @hasSection('breadcrumb')
                <div class="c-subheader px-3">
                    <ol class="breadcrumb border-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        @yield('breadcrumb')
                    </ol>
                </div>
            @endif
        </header>
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        @yield('content')
                    </div>
                </div>
            </main>
            <footer class="c-footer">
                <div><a href="#">{{ env('APP_NAME') }}</a> © {{ date('Y') }}</div>
                <div class="ml-auto">Desenvolvido por <a href="maito:stephanie_oliver2009@hotmail.com">Stéphanie</a></div>
            </footer>
        </div>
    </div>

    <form method="post" action="{{ route('logout') }}" id="formLogout">
        @csrf
    </form>
@endsection