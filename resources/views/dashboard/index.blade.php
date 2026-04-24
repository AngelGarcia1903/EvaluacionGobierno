@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold text-dark">Dashboard Principal</h1>
            <p class="text-muted">Sistema de Seguridad Pública Irapuato</p>
        </div>
        </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-glow p-4 text-white" style="background: linear-gradient(135deg, #4f46e5, #9333ea);">
                <p class="stat-label mb-1">Total de Vehículos</p>
                <h2 id="countVehiculos" class="display-5 fw-bold">{{ $totalVehiculos }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-glow p-4 text-white" style="background: linear-gradient(135deg, #f43f5e, #e11d48);">
                <p class="stat-label mb-1">Reportes de Robo</p>
                <h2 id="countRobos" class="display-5 fw-bold">{{ $totalReportes }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-glow p-4 text-white" style="background: linear-gradient(135deg, #10b981, #059669);">
                <p class="stat-label mb-1">Propietarios</p>
                <h2 id="countPropietarios" class="display-5 fw-bold">{{ $totalDuenos }}</h2>
            </div>
        </div>
    </div>

    <div class="card-quick-action shadow-lg p-4 text-center">
        <button class="btn btn-register w-100 py-3 text-white rounded-pill" onclick="abrirModalVehiculo()">
            REGISTRAR VEHÍCULO
        </button>
    </div>
</div>

@include('catalogos.vehiculos.partials._modal_create')

@endsection

@push('scripts')
<script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endpush
