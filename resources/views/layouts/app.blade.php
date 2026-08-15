<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'La Buena Mesa · Gestión de Menú')
    </title>

    <link rel="stylesheet"
          href="{{ asset('css/app.css') }}">
</head>

<body>

    {{-- MENÚ PRINCIPAL --}}
    <nav class="navbar">

        <div class="navbar__brand">
            🍽️ La Buena Mesa
        </div>

        <div class="navbar__menu">

            <a href="{{ url('/') }}"
               class="navbar__link">
                🏠 Principal
            </a>

            <a href="{{ url('/docs') }}"
               class="navbar__link">
                📚 Documentación API
            </a>

        </div>

    </nav>


    {{-- CABECERA --}}
    <header class="topbar">

        <div class="topbar__brand">

            <span class="topbar__logo">
                🍽️
            </span>

            <div>

                <h1>
                    La Buena Mesa
                </h1>

                <p>
                    Panel de gestión del menú — consume la API RESTful interna
                </p>

            </div>

        </div>

    </header>


    {{-- CONTENIDO --}}
    <main class="container">

        @yield('content')

    </main>


    {{-- FOOTER --}}
    <footer class="footer">

        <p>
            API base:
            <code>/api/menu-items</code>
            · Proyecto académico — Laravel 12 + Eloquent
        </p>

    </footer>


    {{-- Scripts de las vistas --}}
    @stack('scripts')

</body>

</html>