@extends('layouts.app')

@section('title', 'Gestión de Propietarios')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/duenos/duenos.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-title-dark">Catálogo de Propietarios</h2>
                    <p class="text-muted mb-0">Gestión y control de dueños registrados en el sistema.</p>
                </div>
                <button type="button" class="btn btn-dark px-4 py-2 fw-bold shadow-sm btn-dark-custom" onclick="abrirModalNuevo()">
                    <i class="bi bi-person-plus me-2"></i>NUEVO PROPIETARIO
                </button>
            </div>

            <div class="card shadow-sm border-0 p-4 card-table-custom">
                <div class="datatable-container">
                    <table id="tablaDuenos" class="table table-hover align-middle w-100">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center col-acciones">ACCIONES</th>
                                <th>NOMBRE COMPLETO</th>
                                <th>CURP / RFC</th>
                                <th>TELÉFONO</th>
                                <th>CALLE</th>
                                <th>COLONIA</th>
                                <th>NÚMERO</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('catalogos.duenos.partials.modal_registro')

@endsection

@push('scripts')
    <script src="{{ asset('js/duenos/duenos.js') }}"></script>
@endpush
