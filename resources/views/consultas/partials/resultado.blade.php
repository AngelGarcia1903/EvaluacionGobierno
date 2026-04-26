<div class="card border-0 shadow-lg p-4 mb-4 card-resultado">
    <div id="statusAlert"></div>

    <div class="row mt-4 mb-4">
        <div class="col-md-6 especificaciones-unidad mb-3 mb-md-0">
            <h6 class="text-muted small fw-bold text-uppercase mb-3">Especificaciones de la Unidad</h6>
            <p class="mb-1"><strong>Marca/Modelo:</strong> <span id="resModelo"></span> (<span id="resAnio"></span>)</p>
            <p class="mb-1"><strong>VIN:</strong> <code class="text-dark fw-bold" id="resVIN"></code></p>
            <p class="mb-0"><strong>Placas:</strong> <span class="badge bg-dark fs-6" id="resPlacas"></span></p>
        </div>
        <div class="col-md-6 ps-md-4 d-flex flex-column justify-content-center">
            <h6 class="text-muted small fw-bold text-uppercase mb-3">Información del Sistema</h6>
            <p class="mb-1"><strong>Fecha de consulta:</strong> {{ date('d/m/Y') }}</p>
            <p class="mb-0 text-muted small"><i class="bi bi-info-circle me-1"></i> Información generada por el Catálogo de Unidades Registradas.</p>
        </div>
    </div>

    <h5 class="fw-bold mb-3 mt-2"><i class="bi bi-people-fill me-2"></i>Historial de Propietarios</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle w-100" id="tablaHistorial">
            <thead class="table-light">
                <tr>
                    <th>NOMBRE DEL PROPIETARIO</th>
                    <th>IDENTIFICACIÓN (CURP)</th>
                    <th>FECHA DE REGISTRO</th>
                    <th class="text-center">ESTADO</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>
</div>
