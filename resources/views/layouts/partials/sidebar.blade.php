<div class="sidebar d-flex flex-column">
        <div class="sidebar-brand">
            <span class="fw-bold"><i class="bi bi-car-front-fill me-2"></i>Seguimiento Vehicular</span>
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
                <a href="{{ route('consulta.index') }}" class="nav-link {{ request()->is('consultar*') ? 'active' : '' }}">
                    <i class="bi bi-search me-3"></i> Consultar Unidad
                </a>
            </li>
        </ul>

        <div class="p-4">
            <a href="{{ route('logout') }}" class="btn btn-salir w-100 d-flex align-items-center justify-content-center">
                 Salir
            </a>
        </div>
    </div>
