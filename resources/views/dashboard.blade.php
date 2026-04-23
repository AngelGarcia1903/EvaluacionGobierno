@extends('layouts.app')

@section('content')
<style>
    /* Efecto de iluminación para las tarjetas */
    .card-glow {
        border: none;
        border-radius: 24px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .card-glow:hover {
        transform: translateY(-5px);
    }
    /* Iconos flotantes con efecto glass */
    .icon-box {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
        border-radius: 15px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
    }
    /* Estilo para los porcentajes (más legibles) */
    .stat-label {
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    /* Reducción de la tarjeta de acción */
.card-quick-action {
    border-radius: 30px;
    background: white;
    max-width: 500px; /* Tamaño controlado */
    margin: 0 auto;   /* Centrado */
    transition: all 0.3s ease;
}

/* Efecto Hover para el Botón de Registro */
.btn-register {
    background: #1e293b;
    border: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-register:hover {
    background: #334155;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(30, 41, 59, 0.3);
    color: #6366f1; /* Un ligero toque de color al texto en hover */
}
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold text-dark" style="letter-spacing: -1px;">Dashboard Principal</h1>
            <p class="text-muted">Sistema de seguimiento vehicular</p>
        </div>
        <div class="d-flex align-items-center shadow-sm p-2 bg-white rounded-pill">
            <div class="text-end me-3 ps-3">
                <small class="text-muted d-block" style="font-size: 0.7rem; text-transform: uppercase;">Usuario</small>
                <span class="fw-bold">Admin</span>
            </div>
            <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold"
                 style="width: 45px; height: 45px; background: linear-gradient(45deg, #a855f7, #ec4899); box-shadow: 0 4px 10px rgba(168, 85, 247, 0.4);">
                A
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-glow p-4 text-white" style="background: linear-gradient(135deg, #4f46e5, #9333ea); box-shadow: 0 15px 30px rgba(79, 70, 229, 0.3);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label mb-1 opacity-75">Total de Vehículos</p>
                        <h2 class="display-5 fw-bold mb-3" id="countVehiculos">{{ $totalVehiculos }}</h2>
                        <div class="stat-label">
                            <i class="bi bi-arrow-up-short"></i> 12% <span class="opacity-75 fw-normal">vs mes anterior</span>
                        </div>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-car-front-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-glow p-4 text-white" style="background: linear-gradient(135deg, #f43f5e, #e11d48); box-shadow: 0 15px 30px rgba(244, 63, 94, 0.3);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label mb-1 opacity-75">Reportes de Robo</p>
                        <h2 class="display-5 fw-bold mb-3" id="countRobos">{{ $totalReportes ?? 0 }}</h2>
                        <div class="stat-label">
                            <i class="bi bi-arrow-down-short"></i> 5% <span class="opacity-75 fw-normal">vs mes anterior</span>
                        </div>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-glow p-4 text-white" style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label mb-1 opacity-75">Propietarios</p>
                        <h2 class="display-5 fw-bold mb-3" id="countPropietarios">{{ $totalDuenos }}</h2>
                        <div class="stat-label">
                            <i class="bi bi-arrow-up-short"></i> 8% <span class="opacity-75 fw-normal">vs mes anterior</span>
                        </div>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card-quick-action border-0 shadow-lg p-4 text-center">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-plus-circle-fill fs-2 text-primary"></i>
                </div>
                <h4 class="fw-bold mb-2">Gestión de Unidades</h4>
                <p class="text-muted small mb-4 px-3">Registra un nuevo vehículo vinculándolo a un propietario existente.</p>

                <button class="btn btn-register w-100 py-3 fw-bold rounded-pill text-white"
                        onclick="abrirModalVehiculo()">
                    REGISTRAR VEHÍCULO
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalVehiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 p-4 text-white" style="background: linear-gradient(135deg, #1e293b, #334155);">
                <h5 class="modal-title fw-bold"><i class="bi bi-car-front-fill me-2"></i>Registrar Nuevo Vehículo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formNuevoVehiculo">
                @csrf
                <div class="modal-body p-4 bg-white">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NÚMERO DE SERIE (VIN) *</label>
                            <input type="text" name="vin" class="form-control border-0 bg-light p-3" style="border-radius: 12px;" placeholder="Ej: 1HGBH..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NÚMERO DE PLACAS *</label>
                            <input type="text" name="placas" class="form-control border-0 bg-light p-3" style="border-radius: 12px;" placeholder="Ej: ABC-123" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">PROPIETARIO *</label>
                            <select name="dueno_id" id="selectDueno" class="form-select border-0 bg-light p-3" style="border-radius: 12px;" required>
                                <option value="">Cargando propietarios...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">MODELO DEL AUTO *</label>
                            <input type="text" name="modelo" class="form-control border-0 bg-light p-3" style="border-radius: 12px;" placeholder="Ej: Honda Civic 2020" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 bg-light">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark px-5 py-3 fw-bold shadow-sm" style="border-radius: 15px; background: #1e293b;">GUARDAR UNIDAD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // La declaramos global para que el onclick la vea
    function abrirModalVehiculo() {
        // Verificación de seguridad: ¿jQuery ya cargó?
        if (typeof $ === 'undefined') {
            console.error("jQuery no ha cargado aún.");
            return;
        }

        const select = $('#selectDueno');
        select.empty().append('<option value="">Cargando propietarios...</option>');

        // Abrir modal
       var modalElement = document.getElementById('modalVehiculo');
        var myModal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        myModal.show();

        $.get("{{ route('duenos.data') }}", function(res) {
            select.empty().append('<option value="">Seleccionar propietario...</option>');
            res.data.forEach(dueno => {
                select.append(`<option value="${dueno.id}">${dueno.full_name}</option>`);
            });
        }).fail(function() {
            Swal.fire('Error', 'No se pudieron cargar los propietarios', 'error');
        });
    }

    $(document).ready(function() {
        // Carga inicial de datos
        if (typeof cargarEstadisticas === "function") {
            cargarEstadisticas();
        }

        function cargarEstadisticas() {
            $.get("{{ route('vehiculos.data') }}", function(res) { $('#countVehiculos').text(res.data.length); });
            $.get("{{ route('duenos.data') }}", function(res) { $('#countPropietarios').text(res.data.length); });
            $.get("{{ route('reportes.data') }}", function(res) { $('#countRobos').text(res.data.length); });
        }

        $('#formNuevoVehiculo').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('vehiculos.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    const modalEl = document.getElementById('modalVehiculo');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                    $('#formNuevoVehiculo')[0].reset();

                    // Actualizamos las estadísticas inmediatamente ANTES o durante el mensaje de éxito
                    cargarEstadisticas();

                    Swal.fire({
                        title: '¡Registro Exitoso!',
                        text: 'El conteo se ha actualizado automáticamente.',
                        icon: 'success',
                        confirmButtonColor: '#1e293b'
                    });
                }
            });
        });
    });
</script>

@endsection
