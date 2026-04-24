@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            @include('catalogos.reportes.partials.form_reporte')
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                <h5 class="fw-bold mb-4">Catálogo de Reportes (Tabla Dinámica)</h5>
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
                        <tbody>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inicialización de DataTable (Parte 3, Punto 17)
    const table = $('#tablaReportes').DataTable({
        ajax: "{{ route('reportes.data') }}", // Punto 18: AJAX y JSON
        columns: [
            {
                data: 'license_plate',
                render: function(data) {
                    return `<span class="badge bg-danger text-uppercase p-2">${data}</span>`;
                }
            },
            { data: 'model' },
            { data: 'report_date' },
            {
                data: 'description',
                render: function(data) {
                    return `<small class="text-muted">${data}</small>`;
                }
            }
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
        dom: 'Bfrtip', // Habilita botones de exportación
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel"></i> Exportar a Excel',
                className: 'btn btn-success btn-sm border-0 mb-3',
                exportOptions: { columns: [0, 1, 2, 3] }
            }
        ],
        order: [[2, 'desc']] // Ordenar por fecha por defecto
    });

    // Envío de formulario vía AJAX
    $('#formReporte').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('reportes.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire({
                    title: '¡Registrado!',
                    text: res.success,
                    icon: 'success',
                    confirmButtonColor: '#dc3545'
                });
                $('#formReporte')[0].reset();
                table.ajax.reload(); // Recarga la tabla dinámica sin refrescar la página
            },
            error: function(xhr) {
                Swal.fire('Error', 'No se pudo guardar: ' + xhr.responseJSON.error, 'error');
            }
        });
    });
});
</script>
@endsection
