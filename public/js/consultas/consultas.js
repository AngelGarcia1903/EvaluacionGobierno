$(document).ready(function () {
    $("#btnBuscar").on("click", function () {
        const termino = $("#inputBusqueda").val();

        if (!termino) {
            return Swal.fire(
                "Atención",
                "Ingresa Placa o VIN vehicular para continuar.",
                "warning",
            );
        }

        $.ajax({
            url: "/consultar/buscar",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                termino: termino,
            },
            beforeSend: function () {
                $("#btnBuscar")
                    .prop("disabled", true)
                    .html(
                        '<span class="spinner-border spinner-border-sm"></span> Consultando...',
                    );
                $("#contenedorResultado").addClass("d-none");
            },
            success: function (res) {
                // Inyecta los datos en el partial resultado.blade.php
                llenarDatosPartial(res);
                $("#contenedorResultado").removeClass("d-none");
            },
            error: function (xhr) {
                let mensaje =
                    "El vehículo no está en la base de datos municipal.";
                if (xhr.status === 404) mensaje = xhr.responseJSON.error;

                Swal.fire("Sin registros", mensaje, "info");
                $("#contenedorResultado").addClass("d-none");
            },
            complete: function () {
                $("#btnBuscar").prop("disabled", false).text("Consultar");
            },
        });
    });

    function llenarDatosPartial(res) {
        // 1. Datos Generales
        $("#resModelo").text(`${res.vehiculo.marca} ${res.vehiculo.modelo}`);
        $("#resVIN").text(res.vehiculo.vin);
        $("#resPlacas").text(res.vehiculo.placa);

        // 2. Estatus de Robo
        const statusAlert = $("#statusAlert");
        if (res.reporte) {
            statusAlert.html(`
                <div class="alert alert-danger d-flex align-items-center shadow-sm">
                    <i class="bi bi-exclamation-octagon-fill fs-3 me-3"></i>
                    <div>
                        <strong class="text-uppercase">Reporte de Robo Activo</strong>
                        <p class="mb-0 small">Detalles: ${res.reporte.description} | Fecha: ${res.reporte.report_date}</p>
                    </div>
                </div>
            `);
        } else {
            statusAlert.html(`
                <div class="alert alert-success d-flex align-items-center shadow-sm">
                    <i class="bi bi-check-circle-fill fs-3 me-3"></i>
                    <div><strong>VEHÍCULO SIN REPORTE DE ROBO</strong></div>
                </div>
            `);
        }

        // 3. Reinicialización de DataTable
        if ($.fn.DataTable.isDataTable("#tablaHistorial")) {
            $("#tablaHistorial").DataTable().destroy();
        }

        // 4. Historial de Propietarios
        let filasDuenos = "";
        res.duenos.forEach((d) => {
            filasDuenos += `
                <tr>
                    <td class="fw-bold">${d.nombre}</td>
                    <td><code>${d.identificacion}</code></td>
                    <td>${d.fecha_asociacion}</td>
                    <td class="text-center">
                        ${
                            d.es_actual
                                ? '<span class="badge bg-primary">Dueño Actual</span>'
                                : '<span class="text-muted small">Anterior</span>'
                        }
                    </td>
                </tr>
            `;
        });
        $("#tablaHistorial tbody").html(filasDuenos);

        // 5. Activación de DataTable
        $("#tablaHistorial").DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
            },
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excel",
                    text: '<i class="bi bi-file-earmark-excel"></i> Exportar Historial',
                    className: "btn btn-outline-success btn-sm mt-2 mb-2",
                    title: `Historial_Vehiculo_${res.vehiculo.placa}`,
                },
            ],
            responsive: true,
        });
    }
});
