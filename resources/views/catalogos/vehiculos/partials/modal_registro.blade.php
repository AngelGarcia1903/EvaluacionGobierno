<div class="modal fade" id="modalVehiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 p-4 text-white" style="background: linear-gradient(135deg, #0f172a, #1e293b);">
                <h5 class="modal-title fw-bold"><i class="bi bi-car-front-fill me-2"></i>Registrar Unidad</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formNuevoVehiculo">
                @csrf
                <div class="modal-body p-4 bg-white">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NÚMERO DE SERIE (VIN) *</label>
                            <input type="text" name="vin" class="form-control border-0 bg-light p-3" style="border-radius: 12px;" placeholder="VIN único" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NÚMERO DE PLACAS *</label>
                            <input type="text" name="placas" class="form-control border-0 bg-light p-3" style="border-radius: 12px;" placeholder="Placas actuales" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">PROPIETARIO *</label>
                            <select name="dueno_id" id="selectDueno" class="form-select border-0 bg-light p-3" style="border-radius: 12px;" required>
                                <option value="">Seleccionar propietario...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">MODELO DEL AUTO *</label>
                            <input type="text" name="modelo" class="form-control border-0 bg-light p-3" style="border-radius: 12px;" placeholder="Ej: Honda Civic 2024" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 bg-light">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark px-5 py-3 fw-bold shadow-sm" style="border-radius: 15px; background: #0f172a;">GUARDAR UNIDAD</button>
                </div>
            </form>
        </div>
    </div>
</div>
