<div class="modal fade" id="modalDueno" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg modal-content-custom">
            <div class="modal-header border-0 p-4 text-white modal-header-custom">
                <h5 class="modal-title fw-bold m-0" id="tituloModalDueno">
                    <i class="bi bi-person-plus-fill me-2"></i>Registrar Propietario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-white">
                <form id="formDueno">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nombre Completo *</label>
                        <input type="text" name="full_name" id="full_name" class="form-control bg-light border-0 py-2 input-dueno-custom input-radius-custom" required placeholder="Ej. Juan Pérez García">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">CURP / RFC *</label>
                            <input type="text" name="curp_rfc" id="curp_rfc" maxlength="18" minlength="13" class="form-control bg-light border-0 py-2 input-curp-custom" required placeholder="13 a 18 caracteres">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Teléfono *</label>
                            <input type="text" name="phone" id="phone" maxlength="10" minlength="10" class="form-control bg-light border-0 py-2 input-radius-custom" required placeholder="10 dígitos">
                        </div>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Calle *</label>
                            <input type="text" name="calle" id="calle" class="form-control bg-light border-0 py-2 input-dueno-custom input-radius-custom" required placeholder="Nombre de la calle">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Colonia *</label>
                            <input type="text" name="colonia" id="colonia" class="form-control bg-light border-0 py-2 input-dueno-custom input-radius-custom" required placeholder="Nombre de la colonia">
                        </div>
                    </div>

                    <div class="row align-items-end mt-1">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">Núm. Exterior *</label>
                            <input type="text" name="num_ext" id="num_ext" maxlength="10" class="form-control bg-light border-0 py-2 input-dueno-custom input-radius-custom" required placeholder="Ej. 123">
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="checkInterior">
                                <label class="form-check-label small fw-bold text-muted" for="checkInterior">
                                    ¿Núm. Interior?
                                </label>
                            </div>
                            <div id="campoInterior" class="campo-interior-oculto">
                                <input type="text" name="num_int" id="num_int" maxlength="10" class="form-control bg-light border-0 py-2 input-dueno-custom input-radius-custom" placeholder="Ej. B-2" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-0 p-3 bg-light">
                <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formDueno" id="btnSubmitDueno" class="btn btn-dark px-4 py-2 fw-bold shadow-sm btn-dark-custom">GUARDAR PROPIETARIO</button>
            </div>
        </div>
    </div>
</div>
