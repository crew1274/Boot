<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta name="author" content="黃偉鑫">
    <meta name="description" content="客戶端網頁">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Icon -->
    <link rel="icon" href="{{ asset("favicon.ico") }}" type="image/x-icon" />

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    @stack('css')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

{{ csrf_field() }}
</head>
<body>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <a class="navbar-brand" href="{{ url('/version') }}">
                    <small>Version:{{ config('app.version', '1.0.0') }}</small>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">

                    <!-- Server -->
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-server fa-fw"></i> @lang('home.server') <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu ">
                        <li>
                            <a href="{{ url('#') }}">
                                <div data-toggle="modal" data-target="#link" data-whatever="@link">
                                 <i class="fa fa-link" aria-hidden="true"></i> @lang('server.link')
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('#') }}">
                                <div data-toggle="modal" data-target="#time" data-whatever="@time">
                                <i class="fa fa-clock-o" aria-hidden="true"></i> @lang('server.time')
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>


                    <!-- Network -->
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wifi fa-fw"></i> @lang('home.network') <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu ">
                        <li>
                            <a href="{{ url('#') }}">
                                <div data-toggle="modal" data-target="#wifi" data-whatever="@wifi">
                                 @lang('network.wifi')
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('#') }}">
                                <div data-toggle="modal" data-target="#staticip" data-whatever="@staticip">
                                @lang('network.staticip')
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('#') }}" >
                                <div data-toggle="modal" data-target="#dhcp" data-whatever="@dhcp">
                                @lang('network.dhcp')
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                    <!-- Language -->
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-globe fa-fw"></i> @lang('home.language') <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu ">
                        <li>
                            <a href="{{ url('/lang/zh') }}">
                                <div>
                                    <i class="fa fa-language"></i> 中文
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('/lang/en') }}">
                                <div>
                               <i class="fa fa-language"></i> English
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">@lang('home.login')</a></li>
                            <li><a href="{{ url('/register') }}">@lang('home.register')</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa fa-user" fa-fw></i> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i> @lang('home.logout')
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
        @include('layouts.network')
        @include('layouts.server')
    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    @stack('javascript')
</body>
</html>
