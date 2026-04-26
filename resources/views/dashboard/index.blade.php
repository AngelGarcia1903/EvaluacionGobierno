@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endpush

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard Principal</h2>
            <p class="text-muted mb-0">Sistema de Seguridad Pública Irapuato</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card-glow p-4 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4f46e5, #818cf8);">
                <div>
                    <p class="stat-label mb-1">Total Vehículos</p>
                    <h2 class="display-5 fw-bold mb-0">{{ $totalVehiculos }}</h2>
                </div>
                <i class="bi bi-car-front-fill opacity-50" style="font-size: 4rem;"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-glow p-4 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #e11d48, #fb7185);">
                <div>
                    <p class="stat-label mb-1">Reportes Activos</p>
                    <h2 class="display-5 fw-bold mb-0">{{ $totalReportes }}</h2>
                </div>
                <i class="bi bi-shield-exclamation opacity-50" style="font-size: 4rem;"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-glow p-4 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #059669, #34d399);">
                <div>
                    <p class="stat-label mb-1">Propietarios</p>
                    <h2 class="display-5 fw-bold mb-0">{{ $totalDuenos }}</h2>
                </div>
                <i class="bi bi-people-fill opacity-50" style="font-size: 4rem;"></i>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-dashboard p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Distribución por Marca</h5>
                <div class="chart-container">
                    <canvas id="graficaMarcas"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-dashboard p-4 mb-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pie-chart-fill me-2 text-danger"></i>Estatus de la Flota</h5>
                <div class="chart-container" style="height: 200px;">
                    <canvas id="graficaEstatus"></canvas>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <div class="card-dashboard p-3 text-center">
                        <p class="kpi-title mb-1">Índice de Robo</p>
                        <p class="kpi-value text-danger mb-0">{{ $porcentajeRobos }}%</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-dashboard p-3 text-center">
                        <p class="kpi-title mb-1">Vehs / Dueño</p>
                        <p class="kpi-value text-success mb-0">{{ $promedioPorDueno }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.chartData = {
        marcas: @json($vehiculosPorMarca),
        estatus: @json($estatusFlota)
    };
</script>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endpush
