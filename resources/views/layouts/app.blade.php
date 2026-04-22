<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Seguridad - Irapuato</title>
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Seguridad Pública</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Vehículos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Dueños</a></li>
                </ul>
                <div class="d-flex">
                    <span class="navbar-text me-3">Bienvenido, {{ session('user_name') }}</span>
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">Salir</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
