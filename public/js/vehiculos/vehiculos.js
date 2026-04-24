/* public/js/vehiculos/vehiculos.js */
$(document).ready(function () {
    // 1. Inicialización de Tabla Dinámica (Parte 3, Punto 17)
    const table = $("#tablaDinamicaVehiculos").DataTable({
        ajax: "/vehiculos/data", // Ruta que devuelve JSON
        columns: [
            {
                data: "vin",
                render: (data) =>
                    `<code class="text-primary fw-bold">${data}</code>`,
            },
            {
                data: "license_plate",
                render: (data) => `<span class="badge bg-dark">${data}</span>`,
            },
            { data: "model" },
            { data: "brand" },
            {
                data: null,
                render: function () {
                    return `
                        <div class="text-center">
                            <button class="btn btn-sm btn-outline-primary border-0"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                        </div>`;
                },
            },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excelHtml5", // Deseable Exportar a Excel [cite: 20, 27]
                text: '<i class="bi bi-file-earmark-excel me-2"></i>Excel',
                className: "btn btn-success btn-sm border-0 mb-3",
                exportOptions: { columns: [0, 1, 2, 3] },
            },
        ],
        responsive: true, // Responsivo (Parte 3, Punto 16) [cite: 10, 16]
    });

    // 2. Lógica para cargar propietarios al abrir el modal (AJAX/JSON)
    $("#modalVehiculo").on("show.bs.modal", function () {
        $.get("/duenos/data", function (res) {
            let options =
                '<option value="">Seleccionar propietario...</option>';
            res.data.forEach((dueno) => {
                // Ajusta 'nombre_completo' según lo que envíe tu DuenoController
                options += `<option value="${dueno.id}">${dueno.nombre_completo || dueno.full_name}</option>`;
            });
            $("#selectDueno").html(options);
        });
    });

    // 3. Envío del formulario por AJAX (Requisito Parte 3)
    $("#formNuevoVehiculo").on("submit", function (e) {
        e.preventDefault();
        const $form = $(this);
        const $btn = $form.find('button[type="submit"]');

        $btn.prop("disabled", true).html(
            '<span class="spinner-border spinner-border-sm"></span> Guardando...',
        );

        $.ajax({
            url: "/vehiculos/store",
            method: "POST",
            data: $form.serialize(),
            success: function (response) {
                bootstrap.Modal.getInstance(
                    document.getElementById("modalVehiculo"),
                ).hide();
                $form[0].reset();
                table.ajax.reload(); // Recarga la tabla dinámica en tiempo real
                Swal.fire(
                    "¡Éxito!",
                    "Vehículo guardado en el catálogo.",
                    "success",
                );
            },
            error: function () {
                Swal.fire(
                    "Error",
                    "No se pudo registrar. Verifique VIN/Placas únicos.",
                    "error",
                );
            },
            complete: function () {
                $btn.prop("disabled", false).text("GUARDAR UNIDAD");
            },
        });
    });
});
