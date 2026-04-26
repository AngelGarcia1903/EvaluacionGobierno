@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vehiculos/vehiculos.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Catálogo de Vehículos</h2>
            <p class="text-muted small">Gestión y control de unidades registradas en el sistema.</p>
        </div>
        <button class="btn btn-dark px-4 py-2 shadow-sm" style="border-radius: 12px; background: #0f172a;"
                data-bs-toggle="modal" data-bs-target="#modalVehiculo">
            <i class="bi bi-plus-circle me-2"></i>NUEVO VEHÍCULO
        </button>
    </div>

    <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
        <div class="table-responsive">
            <table id="tablaDinamicaVehiculos" class="table table-hover align-middle w-100">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" style="min-width: 100px;">ACCIONES</th>
                        <th>VIN</th>
                        <th>PLACAS</th>
                        <th>MARCA</th>
                        <th>MODELO</th>
                        <th>AÑO</th>
                        <th>PROPIETARIO ACTUAL</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>
    </div>
</div>

@include('catalogos.vehiculos.partials.modal_registro')
@endsection

@push('scripts')
    <script src="{{ asset('js/vehiculos/vehiculos.js') }}"></script>
@endpush
