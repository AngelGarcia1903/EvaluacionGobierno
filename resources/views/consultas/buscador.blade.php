@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/consultas/consultas.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-title-dark">Consulta de Estatus Vehicular</h1>
        <p class="text-muted">Plataforma de Verificación de Seguridad Pública</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="input-group input-group-lg shadow-sm mb-5 search-container-custom">
                <span class="input-group-text bg-white border-0 ps-4"><i class="bi bi-search text-muted"></i></span>
                <input type="text" id="inputBusqueda" class="form-control border-0" placeholder="Ingrese Número de Placa o VIN..." style="text-transform: uppercase;">
                <button class="btn btn-dark-custom px-5 fw-bold" id="btnBuscar">CONSULTAR</button>
            </div>

            <div id="contenedorResultado" class="d-none">
                @include('consultas.partials.resultado')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/consultas/consultas.js') }}"></script>
@endpush
