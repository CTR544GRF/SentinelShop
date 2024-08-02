<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plantilla.css') }}">
    <link rel="stylesheet" href="@yield('estilos')">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/swetalerts.js')}}"></script>
</head>
<body>
    <header class="sidebar">
    <div class="user">
        <div class="user">
            <div class="circle">
                {{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}
            </div>
            <h3>{{ auth()->user()->nombre }}</h3>
            <h5>{{ ucfirst(auth()->user()->tipo_usuario) }}</h5>
            <span class="form_line"></span>
        </div>
        <ul>
            <li><a href="{{ route('ver_finanzas')}}">Panel</a></li>
            <li><a href="{{ route('ver_usuarios')}}">Usuarios</a></li>
            <li><a href="{{ route('ver_productos')}}">Productos</a></li>
            <li><a href="{{ route('ver_facturas')}}">Facturas</a></li>
        </ul>
    </header>

    <main>
        <div class="top-right">
            <a href="{{ route('ver_finanzas')}}"><h3 class="logotipo">SentinelShop</h3></a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <h3>Cerrar sesión</h3>
                </button>
            </form>
        </div>

        <div class="menu-panel">
            <div class="info_panel">
                <h2>@yield ('tittle')</h2>
                <h4>@yield ('descripcion')</h4>
            </div>

            <div class="botones">
                <ul>
                    <!-- verifica si los botones se llamaron el la lista o no -->
                    @if (View::hasSection('link_1') && View::hasSection('button_one'))
                        <li><a href="@yield('link_1')">@yield('button_one')</a></li>
                    @endif
                    @if (View::hasSection('link_2') && View::hasSection('button_two'))
                        <li><a href="@yield('link_2')">@yield('button_two')</a></li>
                    @endif
                    @if (View::hasSection('link_3') && View::hasSection('button_three'))
                        <li><a href="@yield('link_3')">@yield('button_three')</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="slider_bar"></div>

        <!-- seccion -->
        @yield('seccion')
        <!-- fin seccion -->  
    </main>

</body>
</html>