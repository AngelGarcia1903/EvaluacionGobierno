<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VehicleTrack - Sistema de Rastreo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
/* Tipografía y Base */
body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }

/* Sidebar Estilo Figma Premium */
.sidebar {
    height: 100vh;
    width: 260px;
    position: fixed;
    background: #0f172a; /* Azul casi negro muy elegante */
    color: white;
    z-index: 1000;
    border-right: 1px solid rgba(255,255,255,0.05);
}

/* Marca/Logo */
.sidebar-brand {
    padding: 30px 20px;
    font-size: 1.5rem;
}
.sidebar-brand i {
    /* El icono de carro con un ligero degradado */
    background: linear-gradient(45deg, #a855f7, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Links del Menú */
.sidebar .nav-link {
    color: #94a3b8;
    margin: 8px 18px;
    padding: 12px 15px;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-weight: 500;
    display: flex;
    align-items: center;
}

/* HOVER: El efecto de azul iluminado que pediste */
.sidebar .nav-link:hover {
    color: white;
    background: linear-gradient(90deg, #6366f1, #8b5cf6); /* Degradado azul/morado */
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.6); /* Iluminación (Glow) */
    transform: translateX(5px);
}

/* Link Activo */
.sidebar .nav-link.active {
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    color: white;
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
}

/* BOTÓN SALIR: Rojo intenso con sombra de color */
.btn-salir {
    background: #ef4444; /* Rojo intenso */
    color: white;
    border: none;
    padding: 14px;
    border-radius: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4); /* Sombra roja de iluminación */
}

.btn-salir:hover {
    background: #dc2626;
    color: white;
    box-shadow: 0 10px 25px rgba(239, 68, 68, 0.6); /* Brillo más fuerte al pasar el mouse */
    transform: translateY(-2px);
}

/* Ajuste del Main Content */
.main-content {
    margin-left: 260px;
    padding: 40px;
}
    </style>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="sidebar d-flex flex-column">
    <div class="sidebar-brand">
        <span class="fw-bold"><i class="bi bi-car-front-fill me-2"></i>VehicleTrack</span>
        <div class="text-muted small fw-normal mt-1" style="font-size: 0.7rem;">Sistema de Seguimiento</div>
    </div>

    <ul class="nav nav-pills flex-column mb-auto mt-2">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('vehiculos.index') }}" class="nav-link {{ request()->is('vehiculos*') ? 'active' : '' }}">
                <i class="bi bi-truck me-3"></i> Vehículos
            </a>
        </li>
        <li>
            <a href="{{ route('duenos.index') }}" class="nav-link {{ request()->is('duenos*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill me-3"></i> Propietarios
            </a>
        </li>
        <li>
            <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->is('reportes*') ? 'active' : '' }}">
                <i class="bi bi-shield-fill-exclamation me-3"></i> Reportes de Robo
            </a>
        </li>
        <li>
            <a href="#" class="nav-link">
                <i class="bi bi-clock-history me-3"></i> Historial
            </a>
        </li>
    </ul>

    <div class="p-4">
        <a href="{{ route('logout') }}" class="btn btn-salir w-100 d-flex align-items-center justify-content-center">
             Salir
        </a>
    </div>
</div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
