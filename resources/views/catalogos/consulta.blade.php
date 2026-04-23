@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Consulta de Estatus Vehicular</h1>
        <p class="text-muted">Ingrese el VIN o las Placas para verificar la legalidad de la unidad.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="input-group input-group-lg shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <input type="text" id="inputBusqueda" class="form-control border-0 px-4" placeholder="Ej: 1HGBH... o ABC-123">
                <button class="btn btn-dark px-5" id="btnBuscar" style="background: #1e293b;">Consultar</button>
            </div>

            <div id="resultadoBusqueda" class="mt-5 d-none">
                </div>
        </div>
    </div>
</div>

<script>
$('#btnBuscar').on('click', function() {
    const termino = $('#inputBusqueda').val();
    if(!termino) return Swal.fire('Atención', 'Ingresa un dato para buscar', 'warning');

    $.ajax({
        url: "{{ route('consulta.buscar') }}",
        method: "POST",
        data: { _token: "{{ csrf_token() }}", termino: termino },
        success: function(res) {
            let statusCard = res.tiene_reporte
                ? `<div class="alert alert-danger p-4 border-0" style="border-radius: 20px;">
                     <h4 class="fw-bold"><i class="bi bi-x-octagon-fill"></i> ¡ALERTA DE ROBO!</h4>
                     <p>Este vehículo cuenta con un reporte de robo activo en el sistema.</p>
                   </div>`
                : `<div class="alert alert-success p-4 border-0" style="border-radius: 20px;">
                     <h4 class="fw-bold"><i class="bi bi-check-circle-fill"></i> VEHÍCULO LIMPIO</h4>
                     <p>No se encontraron reportes de robo vigentes.</p>
                   </div>`;

            $('#resultadoBusqueda').html(`
                <div class="card border-0 shadow-lg p-4" style="border-radius: 25px;">
                    ${statusCard}
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold">DATOS DEL VEHÍCULO</h6>
                            <p class="mb-1"><strong>Modelo:</strong> ${res.vehiculo.modelo}</p>
                            <p class="mb-1"><strong>VIN:</strong> ${res.vehiculo.vin}</p>
                            <p><strong>Placas:</strong> ${res.vehiculo.placas}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold">PROPIETARIO REGISTRADO</h6>
                            <p class="mb-1"><strong>Nombre:</strong> ${res.dueno.nombre} ${res.dueno.apellido_paterno}</p>
                            <p><strong>CURP:</strong> ${res.dueno.curp}</p>
                        </div>
                    </div>
                </div>
            `).removeClass('d-none');
        },
        error: function() {
            Swal.fire('No encontrado', 'El vehículo no existe en nuestra base de datos.', 'info');
            $('#resultadoBusqueda').addClass('d-none');
        }
    });
});
</script>
@endsection
