<div class="card mt-4">
    <div class="card-body">
        <table id="tablaVehiculos" class="table table-striped table-bordered display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>VIN</th>
                    <th>Placas</th>
                    <th>Modelo</th>
                    <th>Dueño Actual</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script type="module">
    document.addEventListener('DOMContentLoaded', function () {
        $('#tablaVehiculos').DataTable({
            ajax: '/api/vehiculos', // Esta ruta la definiremos en routes/api.php o web.php
            columns: [
                { data: 'id' },
                { data: 'vin' },
                { data: 'placas' },
                { data: 'modelo' },
                { data: 'dueno' },
                { data: 'acciones' }
            ],
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
        });
    });
</script>
