@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reportes/reportes.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-title-dark">Historial de Reportes de Robo</h2>
                    <p class="text-muted mb-0">Gestión y control de incidentes registrados en el sistema.</p>
                </div>
                <button type="button" class="btn btn-danger px-4 py-2 fw-bold shadow-sm btn-danger-custom" onclick="abrirModalNuevoReporte()">
                    <i class="bi bi-shield-plus me-2"></i>NUEVO REPORTE
                </button>
            </div>

            <div class="card shadow-sm border-0 p-4 card-table-custom">
                <div class="table-responsive">
                    <table class="table table-hover align-middle w-100" id="tablaReportes">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center col-acciones">ACCIONES</th>
                                <th>PLACAS</th>
                                <th>MODELO</th>
                                <th>FECHA DE ROBO</th>
                                <th>DESCRIPCIÓN</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('catalogos.reportes.partials.modal_registro')

@endsection

@push('scripts')
    <script src="{{ asset('js/reportes/reportes.js') }}"></script>
@endpush
