@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reportes/reportes.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-lg-4 col-md-12">
            @include('catalogos.reportes.partials.form_reporte')
        </div>

        <div class="col-lg-8 col-md-12">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                <h5 class="fw-bold mb-4">Historial de Reportes de Robo</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle w-100" id="tablaReportes">
                        <thead class="table-light">
                            <tr>
                                <th>Placa</th>
                                <th>Vehículo</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/reportes/reportes.js') }}"></script>
@endpush
