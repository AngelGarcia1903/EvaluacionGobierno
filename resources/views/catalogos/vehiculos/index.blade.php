@extends('layouts.app')

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
            <table class="table table-hover align-middle w-100" id="tablaDinamicaVehiculos">
                <thead class="table-light">
                    <tr>
                        <th>VIN</th>
                        <th>Placas</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@include('catalogos.vehiculos.partials.modal_registro')

<script>
$(document).ready(function() {
    // Inicialización de Tabla Dinámica (Requisito Parte 3, Punto 17)
    const table = $('#tablaDinamicaVehiculos').DataTable({
        ajax: "{{ route('vehiculos.data') }}", // Consulta vía AJAX/JSON [cite: 18]
        columns: [
            { data: 'vin', render: function(data) { return `<code class="text-primary fw-bold">${data}</code>`; } },
            { data: 'license_plate', render: function(data) { return `<span class="badge bg-dark">${data}</span>`; } },
            { data: 'model' },
            { data: 'brand' },
            {
                data: null,
                render: function(data) {
                    return `
                        <div class="text-center">
                            <button class="btn btn-sm btn-outline-primary border-0 me-1"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                        </div>`;
                }
            }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }, // Idioma español [cite: 16]
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel me-2"></i>Exportar a Excel',
                className: 'btn btn-success btn-sm border-0 mb-3',
                exportOptions: { columns: [0, 1, 2, 3] } // Exportar solo datos relevantes [cite: 20]
            }
        ],
        responsive: true
    });

    // Escuchar el evento de éxito del modal para recargar la tabla
    $(document).on('vehiculoRegistrado', function() {
        table.ajax.reload();
    });
});
</script>
@endsection
