$(document).ready(function () {
    const table = $("#tablaReportes").DataTable({
        ajax: "/reportes/data",
        scrollX: true,
        scrollY: "350px",
        scrollCollapse: true,
        pageLength: 10,
        autoWidth: false,
        dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                    <div class="text-center action-buttons">
                        <button class="btn btn-sm btn-outline-primary border-0" onclick="editarReporte(${data.id})">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger border-0" onclick="eliminarReporte(${data.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>`;
                },
            },
            {
                data: "license_plate",
                render: (data) =>
                    `<span class="badge bg-danger text-uppercase p-2">${data}</span>`,
            },
            { data: "model" },
            { data: "report_date" },
            {
                data: "description",
                render: (data) => `<small class="text-muted">${data}</small>`,
            },
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="bi bi-file-earmark-excel"></i> Exportar a Excel',
                className: "btn btn-success btn-sm border-0 mb-3",
                exportOptions: { columns: [1, 2, 3, 4] },
            },
        ],
        order: [[3, "desc"]],
    });

    // Envío del Formulario Unificado (Crear y Editar)
    $("#formReporte").on("submit", function (e) {
        e.preventDefault();
        const editId = $(this).attr("data-edit-id");
        const $form = $(this);
        const $btn = $("#btnSubmitReporte");

        const url = editId ? `/reportes/${editId}` : "/reportes";
        const method = editId ? "PUT" : "POST";

        $btn.prop("disabled", true).html(
            '<span class="spinner-border spinner-border-sm"></span> PROCESANDO...',
        );

        $.ajax({
            url: url,
            method: method,
            data: $form.serialize() + (editId ? "&_method=PUT" : ""),
            success: function (res) {
                bootstrap.Modal.getInstance(
                    document.getElementById("modalReporte"),
                ).hide();
                table.ajax.reload(null, false);

                Swal.fire({
                    title: "¡Éxito!",
                    text:
                        res.success ||
                        (editId
                            ? "El reporte ha sido actualizado."
                            : "Reporte registrado correctamente."),
                    icon: "success",
                    confirmButtonColor: "#dc3545",
                });
            },
            error: function (xhr) {
                Swal.fire({
                    title: "Error",
                    text: "No se pudo procesar la solicitud.",
                    icon: "error",
                    confirmButtonColor: "#dc3545",
                });
            },
            complete: function () {
                $btn.prop("disabled", false).html(
                    editId ? "ACTUALIZAR REPORTE" : "GUARDAR REPORTE",
                );
            },
        });
    });

    // Limpieza al cerrar modal
    $("#modalReporte").on("hidden.bs.modal", function () {
        $("#formReporte")[0].reset();
        $("#formReporte").removeAttr("data-edit-id");
        $("#tituloModalReporte").html(
            '<i class="bi bi-megaphone me-2"></i>Registrar Reporte de Robo',
        );
        $("#btnSubmitReporte")
            .html("GUARDAR REPORTE")
            .removeClass("btn-primary")
            .addClass("btn-danger");

        $("body").removeClass("modal-open").css("padding-right", "");
        $(".modal-backdrop").remove();
    });
});

// --- FUNCIONES GLOBALES ---
function abrirModalNuevoReporte() {
    const modal = new bootstrap.Modal(document.getElementById("modalReporte"), {
        backdrop: "static",
        keyboard: false,
    });
    modal.show();
}

function eliminarReporte(id) {
    Swal.fire({
        title: "¿Eliminar reporte?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/reportes/${id}`,
                method: "DELETE",
                data: { _token: $('meta[name="csrf-token"]').attr("content") },
                success: function () {
                    Swal.fire(
                        "Eliminado",
                        "El reporte ha sido borrado.",
                        "success",
                    );
                    $("#tablaReportes").DataTable().ajax.reload(null, false);
                },
            });
        }
    });
}

function editarReporte(id) {
    $.get(`/reportes/${id}/edit`, function (data) {
        $("#vehiculo_id").val(data.vehicle_id);
        $("#fecha_reporte").val(data.report_date);
        $("#descripcion").val(data.description);

        $("#formReporte").attr("data-edit-id", id);
        $("#tituloModalReporte").html(
            '<i class="bi bi-pencil-square me-2"></i>Editar Reporte',
        );
        $("#btnSubmitReporte")
            .html("ACTUALIZAR REPORTE")
            .removeClass("btn-danger")
            .addClass("btn-primary");

        const modal = new bootstrap.Modal(
            document.getElementById("modalReporte"),
            {
                backdrop: "static",
                keyboard: false,
            },
        );
        modal.show();
    });
}
