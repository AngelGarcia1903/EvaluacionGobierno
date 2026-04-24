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
                <input type="text" name="full_name" class="form-control bg-light border-0 py-2" style="border-radius: 10px;" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">CURP / RFC</label>
                <input type="text" name="curp_rfc" class="form-control bg-light border-0 py-2" style="border-radius: 10px;" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Teléfono</label>
                <input type="text" name="phone" class="form-control bg-light border-0 py-2" style="border-radius: 10px;">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Dirección</label>
                <textarea name="address" class="form-control bg-light border-0 py-2" style="border-radius: 10px;" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-dark w-100 py-3 fw-bold shadow-sm" style="border-radius: 12px; background: #1e293b;">
                <i class="bi bi-person-plus-fill me-2"></i>GUARDAR PROPIETARIO
            </button>
        </form>
    </div>
</div>
