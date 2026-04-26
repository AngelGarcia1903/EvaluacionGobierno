<div class="modal fade" id="modalVehiculo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 p-3 text-white" style="background: linear-gradient(135deg, #0f172a, #1e293b);">
                <h5 class="modal-title fw-bold"><i class="bi bi-car-front-fill me-2"></i>Registrar Unidad</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formNuevoVehiculo">
                @csrf
                <div class="modal-body p-4 bg-white">
                   <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NÚMERO DE SERIE (VIN) *</label>
                            <input type="text" name="vin" id="vin" maxlength="17" class="form-control border-0 bg-light p-2" style="border-radius: 12px;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NÚMERO DE PLACAS *</label>
                            <input type="text" name="license_plate" id="license_plate" class="form-control border-0 bg-light p-2" style="border-radius: 12px;" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted">PROPIETARIO *</label>
                            <select name="owner_id" id="selectDueno" class="form-select border-0 bg-light p-2" style="border-radius: 12px;" required>
                                <option value="">Seleccionar propietario...</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">MARCA *</label>
                            <input type="text" name="brand" id="brand" class="form-control border-0 bg-light p-2" style="border-radius: 12px;" placeholder="Ej: Honda" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-muted">MODELO *</label>
                            <input type="text" name="model" id="model" class="form-control border-0 bg-light p-2" style="border-radius: 12px;" placeholder="Ej: Civic" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">AÑO *</label>
                            <input type="number" name="year_model" id="year_model" min="1900" max="2027" class="form-control border-0 bg-light p-2" style="border-radius: 12px;" placeholder="2024" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark px-5 py-3 fw-bold shadow-sm" style="border-radius: 15px; background: #0f172a;">GUARDAR UNIDAD</button>
                </div>
            </form>
        </div>
    </div>
</div>
