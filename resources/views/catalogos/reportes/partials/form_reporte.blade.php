<div class="card border-0 shadow-sm p-4 card-reporte">
    <h5 class="fw-bold mb-4">
        <i class="bi bi-megaphone text-danger me-2"></i>Nuevo Reporte
    </h5>
    <form id="formReporte">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase label-reporte">Vehículo a reportar</label>
            <select name="vehiculo_id" class="form-select bg-light border-0 py-2 form-reporte-input" required>
                <option value="">Seleccione por VIN o Placa...</option>
                @foreach($vehiculos as $v)
                    <option value="{{ $v->id }}">{{ $v->license_plate }} - {{ $v->model }} ({{ $v->vin }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase label-reporte">Fecha del Incidente</label>
            <input type="date" name="fecha_reporte" class="form-control bg-light border-0 py-2 form-reporte-input" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase label-reporte">Descripción / Detalles</label>
            <textarea name="descripcion" class="form-control bg-light border-0 py-2 form-reporte-input" rows="4"
                      placeholder="Indique lugar, hora y circunstancias del robo..." required></textarea>
        </div>

        <button type="submit" class="btn btn-danger w-100 py-3 fw-bold shadow-sm btn-reporte-submit">
            <i class="bi bi-shield-lock-fill me-2"></i>REGISTRAR EN DB
        </button>
    </form>
</div>
