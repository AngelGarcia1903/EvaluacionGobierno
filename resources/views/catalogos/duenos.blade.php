@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Registrar Dueño</div>
            <div class="card-body">
                <form id="formDueno">
                    @csrf
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>CURP</label>
                        <input type="text" name="curp" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Guardar Dueño</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm p-3">
            <table id="tablaDuenos" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>CURP</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script type="module">
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        const table = $('#tablaDuenos').DataTable({
            ajax: "{{ route('duenos.data') }}",
            columns: [
                { data: 'id' },
                {
                    data: null,
                    render: (data) => `${data.nombre} ${data.apellido_paterno}`
                },
                { data: 'curp' }
            ],
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
        });

        // Envío por AJAX (Requerimiento examen)
        $('#formDueno').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('duenos.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response.success);
                    $('#formDueno')[0].reset();
                    table.ajax.reload();
                }
            });
        });
    });
</script>
@endsection
