@extends('layouts.app')

@section('title', 'Gestión de Propietarios')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            @include('catalogos.duenos.partials.form_registro')
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0" style="color: #1e293b;">Listado de Propietarios</h5>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Sincronizado</span>
                </div>

                <div class="table-responsive">
                    <table id="tablaDuenos" class="table table-hover align-middle w-100">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-muted small">ID</th>
                                <th class="text-muted small">NOMBRE COMPLETO</th>
                                <th class="text-muted small">CURP / RFC</th>
                                <th class="text-muted small text-center">ACCIONES</th>
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
        // Inicializar DataTable (Parte 3, Punto 17 )
        const table = $('#tablaDuenos').DataTable({
            ajax: "{{ route('duenos.data') }}",
            columns: [
                { data: 'id' },
                { data: 'full_name' },
                { data: 'curp_rfc' },
                {
                    data: null,
                    render: function() {
                        return `
                            <div class="text-center">
                                <button class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                            </div>`;
                    }
                }
            ],
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
            dom: 'Bfrtip', // Habilita botones [cite: 17, 20]
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel"></i> Exportar a Excel',
                    className: 'btn btn-success btn-sm mb-3 border-0',
                    exportOptions: { columns: [0, 1, 2] }
                }
            ]
        });

        // Manejo del formulario vía AJAX
        $('#formDueno').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('duenos.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Propietario registrado correctamente',
                        icon: 'success',
                        confirmButtonColor: '#1e293b'
                    });
                    $('#formDueno')[0].reset();
                    table.ajax.reload(); // Recarga sin refrescar página
                },
                error: function(xhr) {
                    Swal.fire('Error', 'No se pudo guardar. Verifique los datos duplicados.', 'error');
                }
            });
        });
    });
</script>
@endsection
