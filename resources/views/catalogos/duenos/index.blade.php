@extends('layouts.app')

@section('title', 'Gestión de Propietarios')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/duenos/duenos.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-lg-4 col-md-12">
            @include('catalogos.duenos.partials.form_registro')
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0" style="color: #1e293b;">Listado de Propietarios</h5>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Sincronizado</span>
                </div>

                <div class="datatable-container">
                    <table id="tablaDuenos" class="table table-hover align-middle w-100">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" style="min-width: 100px;">ACCIONES</th>
                                <th>NOMBRE COMPLETO</th>
                                <th>CURP / RFC</th>
                                <th>TELÉFONO</th>
                                <th>CALLE</th>
                                <th>COLONIA</th>
                                <th>NÚMERO</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/duenos/duenos.js') }}"></script>
@endpush
