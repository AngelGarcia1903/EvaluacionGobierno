@extends('layouts.app')

@section('title', 'Gestión de Propietarios')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold" style="color: #1e293b;">Registrar Propietario</h5>
                    <p class="text-muted small">Ingrese la información legal del dueño.</p>
                </div>
                <div class="card-body">
                    <form id="formDueno">
    @csrf
    <div class="mb-3">
        <label class="form-label small fw-bold">Nombre Completo</label>
        <input type="text" name="full_name" class="form-control bg-light border-0" required>
    </div>
    <div class="mb-3">
        <label class="form-label small fw-bold">CURP / RFC</label>
        <input type="text" name="curp_rfc" class="form-control bg-light border-0" required>
    </div>
    <div class="mb-3">
        <label class="form-label small fw-bold">Teléfono</label>
        <input type="text" name="phone" class="form-control bg-light border-0">
    </div>
    <div class="mb-3">
        <label class="form-label small fw-bold">Dirección</label>
        <textarea name="address" class="form-control bg-light border-0"></textarea>
    </div>
    <button type="submit" class="btn btn-dark w-100">Guardar Propietario</button>
</form>
                </div>
            </div>
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
                                <th class="text-muted small">CURP</th>
                                <th class="text-muted small">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Inicializar DataTable con los nombres de tu SQL (owners)
        const table = $('#tablaDuenos').DataTable({
            ajax: "{{ route('duenos.data') }}",
            columns: [
                { data: 'id' },
                { data: 'full_name' }, // Coincide con tu SQL
                { data: 'curp_rfc' },  // Coincide con tu SQL
                {
                    data: null,
                    render: function() {
                        return '<button class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-pencil-square"></i></button>';
                    }
                }
            ],
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
            dom: '<"d-flex justify-content-between"f>rtip'
        });

        // Manejo del formulario
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
                    table.ajax.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'No se pudo guardar. Revisa que el CURP/RFC no sea duplicado.', 'error');
                }
            });
        });
    });
</script>
@endsection
