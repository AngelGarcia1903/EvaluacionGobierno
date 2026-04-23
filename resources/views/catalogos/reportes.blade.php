@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                <h5 class="fw-bold mb-4"><i class="bi bi-megaphone text-danger me-2"></i>Nuevo Reporte de Robo</h5>
                <form id="formReporte">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Vehículo a Reportar</label>
                        <select name="vehiculo_id" class="form-select bg-light border-0" required>
                            <option value="">Seleccione por VIN o Placa...</option>
                            @foreach($vehiculos as $v)
                                <option value="{{ $v->id }}">{{ $v->placas }} - {{ $v->modelo }} ({{ $v->vin }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha del Incidente</label>
                        <input type="date" name="fecha_reporte" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción / Detalles</label>
                        <textarea name="descripcion" class="form-control bg-light border-0" rows="3" placeholder="Lugar, hora y detalles del robo..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 py-3 fw-bold shadow-sm" style="border-radius: 12px;">
                        Generar Reporte de Robo
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                <h5 class="fw-bold mb-4">Reportes Activos en el Sistema</h5>
                <div id="contenedorReportes">
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    cargarReportes();

    function cargarReportes() {
        $.get("{{ route('reportes.data') }}", function(res) {
            let html = '';
            res.data.forEach(r => {
                html += `
                <div class="alert border-0 mb-3 d-flex align-items-start" style="background: #fff5f5; border-left: 5px solid #f43f5e !important; border-radius: 15px;">
                    <div class="rounded-circle bg-danger text-white p-2 me-3 mt-1">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-bold mb-0 text-danger">${r.vehiculo.modelo} (${r.vehiculo.placas})</h6>
                            <small class="text-muted">${r.fecha_reporte}</small>
                        </div>
                        <p class="mb-1 small text-dark mt-2">${r.descripcion}</p>
                        <hr class="my-2 opacity-10">
                        <small class="text-muted">Propietario: <strong>${r.vehiculo.dueno.nombre}</strong></small>
                    </div>
                </div>`;
            });
            $('#contenedorReportes').html(html || '<p class="text-center text-muted">No hay reportes activos.</p>');
        });
    }

    $('#formReporte').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('reportes.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire('Reporte Creado', res.success, 'success');
                $('#formReporte')[0].reset();
                cargarReportes();
            }
        });
    });
});
</script>
@endsection
