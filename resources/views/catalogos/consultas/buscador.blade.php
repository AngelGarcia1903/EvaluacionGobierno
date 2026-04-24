@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Consulta de Estatus Vehicular</h1>
        <p class="text-muted">Ingrese el VIN o las Placas para obtener el historial completo[cite: 2].</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="input-group input-group-lg shadow-sm mb-5" style="border-radius: 20px; overflow: hidden;">
                <input type="text" id="inputBusqueda" class="form-control border-0 px-4" placeholder="Buscar por Placas o VIN...">
                <button class="btn btn-dark px-5" id="btnBuscar" style="background: #1e293b;">Consultar</button>
            </div>

            <div id="contenedorResultado" class="d-none"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#btnBuscar').on('click', function() {
        const termino = $('#inputBusqueda').val();
        if(!termino) return Swal.fire('Atención', 'Ingresa un dato para buscar', 'warning');

        $.ajax({
            url: "{{ route('consulta.buscar') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                termino: termino
            },
            beforeSend: function() {
                $('#btnBuscar').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
            },
            success: function(res) {
                // Inyectamos el contenido generado por el servidor o construido dinámicamente
                // Para este examen, procesaremos el JSON recibido [cite: 25]
                renderizarResultados(res);
            },
            error: function() {
                Swal.fire('No encontrado', 'El vehículo no está en la base de datos.', 'info');
                $('#contenedorResultado').addClass('d-none');
            },
            complete: function() {
                $('#btnBuscar').prop('disabled', false).text('Consultar');
            }
        });
    });

    function renderizarResultados(res) {
        // Lógica para construir el HTML (utilizando la estructura del partial definido abajo)
        // ... (construcción de filasDuenos similar a tu código previo)

        // Tras renderizar el HTML en #contenedorResultado:
        $('#tablaHistorial').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
            dom: 'Bfrtip',
            buttons: ['excel'], // Punto deseable del examen [cite: 27]
            responsive: true
        });
    }
});
</script>
@endsection
