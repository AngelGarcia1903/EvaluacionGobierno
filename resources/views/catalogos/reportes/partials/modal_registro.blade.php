<div class="modal fade" id="modalReporte" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg modal-content-custom">
            <div class="modal-header border-0 p-4 text-white modal-header-danger">
                <h5 class="modal-title fw-bold m-0" id="tituloModalReporte">
                    <i class="bi bi-megaphone me-2"></i>Registrar Reporte de Robo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-white">
                <form id="formReporte">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Vehículo robado *</label>
                            <select name="vehiculo_id" id="vehiculo_id" class="form-select bg-light border-0 py-2 input-radius-custom" required>
                                <option value="">Seleccionar vehículo...</option>
                                @foreach($vehiculos as $v)
                                    <option value="{{ $v->id }}">PLACAS: {{ $v->license_plate }} - {{ $v->brand }} {{ $v->model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Fecha del robo *</label>
                            <input type="date" name="fecha_reporte" id="fecha_reporte" class="form-control bg-light border-0 py-2 input-radius-custom" required max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Descripción de los hechos *</label>
                            <textarea name="descripcion" id="descripcion" class="form-control bg-light border-0 py-2 input-radius-custom" rows="4" placeholder="Detalle cómo y dónde ocurrió el robo..." style="resize: none;" required></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-0 p-3 bg-light">
                <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formReporte" id="btnSubmitReporte" class="btn btn-danger px-4 py-2 fw-bold shadow-sm btn-danger-custom">GUARDAR REPORTE</button>
            </div>
        </div>
    </div>
</div>
