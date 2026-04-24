/* public/js/reportes/reportes.js */
$(document).ready(function () {
    // 1. Inicialización de DataTable (Parte 3, Punto 17) [cite: 17]
    const table = $("#tablaReportes").DataTable({
        ajax: "/reportes/data", // Consulta vía AJAX/JSON [cite: 18]
        columns: [
            {
                data: "license_plate",
                render: function (data) {
                    return `<span class="badge bg-danger text-uppercase p-2">${data}</span>`;
                },
            },
            { data: "model" },
            { data: "report_date" },
            {
                data: "description",
                render: function (data) {
                    return `<small class="text-muted">${data}</small>`;
                },
            },
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excelHtml5", // Deseable Exportar a Excel [cite: 20, 27]
                text: '<i class="bi bi-file-earmark-excel"></i> Exportar a Excel',
                className: "btn btn-success btn-sm border-0 mb-3",
                exportOptions: { columns: [0, 1, 2, 3] },
            },
        ],
        order: [[2, "desc"]],
        responsive: true, // Requisito Responsivo [cite: 16, 23]
    });

    // 2. Envío de formulario vía AJAX [cite: 18, 25]
    $("#formReporte").on("submit", function (e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        $btn.prop("disabled", true).html(
            '<span class="spinner-border spinner-border-sm"></span> PROCESANDO...',
        );

        $.ajax({
            url: "/reportes/store",
            method: "POST",
            data: $(this).serialize(),
            success: function (res) {
                Swal.fire({
                    title: "¡Registrado!",
                    text: res.success,
                    icon: "success",
                    confirmButtonColor: "#dc3545",
                });
                $("#formReporte")[0].reset();
                table.ajax.reload();
            },
            error: function (xhr) {
                Swal.fire(
                    "Error",
                    "No se pudo guardar: " + xhr.responseJSON.error,
                    "error",
                );
            },
            complete: function () {
                $btn.prop("disabled", false).html(
                    '<i class="bi bi-shield-lock-fill me-2"></i>REGISTRAR EN DB',
                );
            },
        });
    });
});
