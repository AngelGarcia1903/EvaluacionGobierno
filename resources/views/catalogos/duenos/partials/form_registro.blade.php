<div class="card shadow-sm border-0 mb-4 card-registro-dueno">
    <div class="card-header bg-white border-0 card-registro-header">
        <h5 class="fw-bold title-dueno">Registrar Propietario</h5>
        <p class="text-muted small">Ingrese la información legal del dueño.</p>
    </div>
    <div class="card-body">
        <form id="formDueno">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Nombre Completo</label>
                <input type="text" name="full_name" class="form-control bg-light border-0 py-2 input-dueno-custom" required placeholder="Ej. Juan Pérez García">
            </div>

            <div class="row g-3"> <div class="col-md-12">
                    <label class="form-label small fw-bold">CURP / RFC</label>
                    <input type="text" name="curp_rfc" id="curp_rfc"
                        maxlength="18" minlength="13"
                        class="form-control bg-light border-0 py-2"
                        required placeholder="13 a 18 caracteres"
                        style="text-transform: uppercase; letter-spacing: 1px;">
                </div>
                <div class="col-md-12"> <label class="form-label small fw-bold">Teléfono</label>
                    <input type="text" name="phone" id="phone"
                        maxlength="10" minlength="10"
                        class="form-control bg-light border-0 py-2"
                        required placeholder="10 dígitos">
                </div>
            </div>

            <hr class="text-muted opacity-25">

            <div class="mb-3">
                <label class="form-label small fw-bold">Calle</label>
                <input type="text" name="calle" class="form-control bg-light border-0 py-2 input-dueno-custom" required placeholder="Nombre de la calle">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Colonia</label>
                <input type="text" name="colonia" class="form-control bg-light border-0 py-2 input-dueno-custom" required placeholder="Nombre de la colonia">
            </div>

            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label class="form-label small fw-bold">Núm. Exterior</label>
                    <input type="text" name="num_ext" maxlength="10" class="form-control bg-light border-0 py-2 input-dueno-custom" required placeholder="Ej. 123">
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="checkInterior">
                        <label class="form-check-label small fw-bold" for="checkInterior">
                            ¿Núm. Interior?
                        </label>
                    </div>
                    <div id="campoInterior" style="display: none;">
                        <input type="text" name="num_int" maxlength="10" class="form-control bg-light border-0 py-2 input-dueno-custom" placeholder="Ej. B-2" disabled>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-dark w-100 py-3 fw-bold shadow-sm btn-dueno-submit">
                    <i class="bi bi-person-plus-fill me-2"></i><span>GUARDAR PROPIETARIO</span>
                </button>
                <button type="button" id="btnCancelarEdicion" class="btn btn-outline-secondary w-100 py-2 fw-bold mt-2 border-0" style="display: none;">
                    <i class="bi bi-x-circle me-2"></i>CANCELAR EDICIÓN
                </button>
            </div>
        </form>
    </div>
</div>
