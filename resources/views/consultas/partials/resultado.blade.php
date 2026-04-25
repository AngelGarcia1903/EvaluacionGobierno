<div class="card border-0 shadow-lg p-4 mb-4 card-resultado">
    <div id="statusAlert"></div>

    <div class="row mt-4 mb-4">
        <div class="col-md-6 border-end especificaciones-unidad">
            <h6 class="text-muted small fw-bold text-uppercase mb-3">Especificaciones de la Unidad [cite: 2]</h6>
            <p class="mb-1"><strong>Marca/Modelo:</strong> <span id="resModelo"></span></p>
            <p class="mb-1"><strong>VIN:</strong> <code class="text-dark" id="resVIN"></code></p>
            <p class="mb-0"><strong>Placas:</strong> <span class="badge bg-dark fs-6" id="resPlacas"></span></p>
        </div>
        <div class="col-md-6 ps-4">
            <h6 class="text-muted small fw-bold text-uppercase mb-3">Información del Sistema</h6>
            <p class="mb-1"><strong>Fecha de consulta:</strong> {{ date('d/m/Y') }}</p>
            <p class="mb-0 text-muted small"><i class="bi bi-info-circle me-1"></i> Información generada por Seguridad Pública[cite: 2].</p>
        </div>
    </div>

    <h5 class="fw-bold mb-3 mt-2"><i class="bi bi-people-fill me-2"></i>Historial de Propietarios [cite: 2, 21]</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="tablaHistorial">
            <thead class="table-light">
                <tr>
                    <th>Nombre del Propietario [cite: 2]</th>
                    <th>Identificación (CURP)</th>
                    <th>Fecha de Registro</th>
                    <th class="text-center">Estado</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>
</div>
