$(document).ready(function () {
    // Buscar al dar clic
    $("#btnBuscar").on("click", function () {
        ejecutarBusqueda();
    });

    // Buscar al presionar ENTER
    $("#inputBusqueda").on("keypress", function (e) {
        if (e.which === 13) {
            ejecutarBusqueda();
        }
    });

    function ejecutarBusqueda() {
        // Obtenemos el valor y lo pasamos a mayúsculas
        const termino = $("#inputBusqueda").val().trim().toUpperCase();
        $("#inputBusqueda").val(termino);

        if (!termino) {
            return Swal.fire(
                "Atención",
                "Ingresa Placa o VIN vehicular para continuar.",
                "warning",
            );
        }

        $.ajax({
            url: "/consultas/buscar", // <-- Asegúrate de que esta URL coincide con tus rutas en web.php
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
                llenarDatosPartial(res);
                $("#contenedorResultado").removeClass("d-none").hide().fadeIn(); // Efecto suave
            },
            error: function (xhr) {
                let mensaje =
                    "El vehículo no está en la base de datos municipal.";
                if (xhr.status === 404) mensaje = xhr.responseJSON.error;
                Swal.fire("Sin registros", mensaje, "info");
                $("#contenedorResultado").addClass("d-none");
            },
            complete: function () {
                $("#btnBuscar").prop("disabled", false).text("CONSULTAR");
            },
        });
    }

    function llenarDatosPartial(res) {
        // 1. Datos Generales
        $("#resModelo").text(`${res.vehiculo.marca} ${res.vehiculo.modelo}`);
        $("#resAnio").text(res.vehiculo.anio);
        $("#resVIN").text(res.vehiculo.vin);
        $("#resPlacas").text(res.vehiculo.placa);

        // 2. Estatus de Robo
        const statusAlert = $("#statusAlert");
        if (res.reporte) {
            statusAlert.html(`
                <div class="alert alert-danger d-flex align-items-center shadow-sm" style="border-radius: 12px;">
                    <i class="bi bi-exclamation-octagon-fill fs-1 me-3"></i>
                    <div>
                        <strong class="text-uppercase fs-5">Reporte de Robo Activo</strong>
                        <p class="mb-0"><strong>Detalles:</strong> ${res.reporte.description} | <strong>Fecha:</strong> ${res.reporte.report_date}</p>
                    </div>
                </div>
            `);
        } else {
            statusAlert.html(`
                <div class="alert alert-success d-flex align-items-center shadow-sm" style="border-radius: 12px;">
                    <i class="bi bi-check-circle-fill fs-2 me-3"></i>
                    <div><strong class="fs-5">VEHÍCULO SIN REPORTE DE ROBO</strong></div>
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
                    <td><code class="text-primary fw-bold">${d.identificacion}</code></td>
                    <td>${d.fecha_asociacion}</td>
                    <td class="text-center">
                        ${
                            d.es_actual == 1 || d.es_actual === true
                                ? '<span class="badge bg-primary px-3 py-2">Dueño Actual</span>'
                                : '<span class="badge bg-secondary px-3 py-2">Anterior</span>'
                        }
                    </td>
                </tr>
            `;
        });
        $("#tablaHistorial tbody").html(filasDuenos);

        // 5. Activación de DataTable con Exportación Avanzada a Excel
        $("#tablaHistorial").DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
            },
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="bi bi-file-earmark-excel"></i> Exportar Historial',
                    className: "btn btn-success btn-sm mt-2 mb-2 border-0",
                    title: `Reporte_Estatus_Vehicular_${res.vehiculo.placa}`,

                    // Aquí construimos las columnas y filas personalizadas
                    customizeData: function (data) {
                        let statusRobo = res.reporte
                            ? `⚠️ REPORTE ACTIVO - ${res.reporte.description} (Fecha: ${res.reporte.report_date})`
                            : "✅ VEHÍCULO SIN REPORTE DE ROBO";

                        let fechaHoy = new Date().toLocaleDateString("es-MX");

                        // Creamos una matriz que simula las 4 columnas de Excel
                        let customTopRows = [
                            [
                                "ESPECIFICACIONES DE LA UNIDAD",
                                "",
                                "INFORMACIÓN DEL SISTEMA",
                                "",
                            ],
                            [
                                "Marca/Modelo:",
                                `${res.vehiculo.marca} ${res.vehiculo.modelo} (${res.vehiculo.anio})`,
                                "Fecha de consulta:",
                                fechaHoy,
                            ],
                            ["VIN:", res.vehiculo.vin, "", ""],
                            ["Placas:", res.vehiculo.placa, "", ""],
                            ["", "", "", ""], // Fila vacía
                            ["ESTATUS DE ROBO:", statusRobo, "", ""],
                            ["", "", "", ""], // Fila vacía
                            ["HISTORIAL DE PROPIETARIOS", "", "", ""],
                            data.header, // Empujamos los encabezados de la tabla original aquí
                        ];

                        // Unimos nuestras filas personalizadas con las filas de dueños
                        data.body = customTopRows.concat(data.body);

                        // Vaciamos el encabezado original para que no se imprima doble
                        data.header = ["", "", "", ""];
                    },
                    // Le damos formato de "Negritas" a nuestras celdas para que se vea profesional
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets["sheet1.xml"];
                        // El estilo '2' en DataTables Excel significa Negrita (Bold)
                        $("row:eq(2) c", sheet).attr("s", "2"); // ESPECIFICACIONES DE LA UNIDAD
                        $("row:eq(7) c", sheet).attr("s", "2"); // ESTATUS DE ROBO
                        $("row:eq(9) c", sheet).attr("s", "2"); // HISTORIAL DE PROPIETARIOS
                        $("row:eq(10) c", sheet).attr("s", "2"); // Encabezados originales de la tabla
                    },
                },
            ],
            responsive: true,
            bSort: false, // Desactiva el ordenado automático para mantener la cronología real
        });
    }
});
