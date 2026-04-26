$(document).ready(function () {
    // 1. Inicializar DataTable
    const table = $("#tablaDuenos").DataTable({
        ajax: "/duenos/data",
        scrollX: true,
        scrollY: "350px", // Aumentamos un poco para aprovechar el ancho completo
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
                        <button class="btn btn-sm btn-outline-primary border-0" onclick="editarDueno(${data.id})">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger border-0" onclick="eliminarDueno(${data.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>`;
                },
            },
            { data: "full_name" },
            {
                data: "curp_rfc",
                render: (data) =>
                    `<code class="text-primary fw-bold">${data.toUpperCase()}</code>`,
            },
            { data: "phone" },
            { data: "calle" },
            { data: "colonia" },
            {
                data: null,
                render: (data) =>
                    `${data.num_ext}${data.num_int ? " int. " + data.num_int : ""}`,
            },
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="bi bi-file-earmark-excel"></i>Exportar a Excel',
                className: "btn btn-success btn-sm mb-3 border-0",
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] },
            },
        ],
    });

    // 2. Validaciones de Input (CURP y Números)
    $("#curp_rfc").on("input", function () {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, "");
        const len = this.value.length;
        $(this).removeClass("is-invalid is-valid"); // Uso clases estándar de bootstrap
        if (len === 13 || len === 18) $(this).addClass("is-valid");
        else if (len > 0) $(this).addClass("is-invalid");
    });

    // Teléfono: ESTRICTAMENTE solo números
    $("#phone").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    // Números Exterior e Interior: Letras, números, guiones y espacios
    $("#num_ext, #num_int").on("input", function () {
        // La expresión regular permite mayúsculas, minúsculas, números, guiones (-) y espacios
        this.value = this.value.replace(/[^A-Za-z0-9\-\s]/g, "").toUpperCase();
    });
    // 3. Lógica del Checkbox (Habilitar/Deshabilitar Num Interior)
    $("#checkInterior").on("change", function () {
        const isChecked = $(this).is(":checked");
        const $campo = $("#campoInterior");
        if (isChecked) {
            $campo.fadeIn();
            $campo.find("input").prop("disabled", false);
        } else {
            $campo.fadeOut();
            $campo.find("input").prop("disabled", true).val("");
        }
    });

    // 4. Manejo del formulario (Guardar / Actualizar) en el Modal
    $("#formDueno").on("submit", function (e) {
        e.preventDefault();
        const curpLen = $("#curp_rfc").val().length;

        if (curpLen !== 13 && curpLen !== 18) {
            Swal.fire(
                "CURP/RFC Inválido",
                "Debe tener 13 o 18 caracteres.",
                "error",
            );
            $("#curp_rfc").addClass("is-invalid").focus();
            return false;
        }

        const editId = $(this).attr("data-edit-id");
        const $btn = $("#btnSubmitDueno"); // ID del botón en el modal
        const url = editId ? `/duenos/${editId}` : "/duenos";
        const method = editId ? "PUT" : "POST";

        $btn.prop("disabled", true).html(
            '<span class="spinner-border spinner-border-sm"></span>',
        );

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize() + (editId ? "&_method=PUT" : ""),
            success: function (res) {
                // Cerrar modal y recargar
                bootstrap.Modal.getInstance(
                    document.getElementById("modalDueno"),
                ).hide();
                table.ajax.reload(null, false);

                Swal.fire(
                    "¡Éxito!",
                    editId ? "Registro actualizado" : "Propietario registrado",
                    "success",
                );
            },
            error: function () {
                Swal.fire(
                    "Error",
                    "No se pudo procesar la solicitud o el CURP ya existe.",
                    "error",
                );
            },
            complete: function () {
                $btn.prop("disabled", false).html(
                    editId ? "ACTUALIZAR PROPIETARIO" : "GUARDAR PROPIETARIO",
                );
            },
        });
    });

    // 5. Limpieza al cerrar el modal (Reemplaza al antiguo btnCancelarEdicion)
    $("#modalDueno").on("hidden.bs.modal", function () {
        $("#formDueno")[0].reset();
        $("#formDueno").removeAttr("data-edit-id");
        $("#curp_rfc").removeClass("is-invalid is-valid");
        $("#checkInterior").prop("checked", false).trigger("change");

        // Restaurar estado de Creación
        $("#tituloModalDueno").html(
            '<i class="bi bi-person-plus-fill me-2"></i>Registrar Propietario',
        );
        $("#btnSubmitDueno")
            .html("GUARDAR PROPIETARIO")
            .removeClass("btn-primary")
            .addClass("btn-dark");

        $("body").removeClass("modal-open").css("padding-right", "");
        $(".modal-backdrop").remove();
    });
});

// --- FUNCIONES GLOBALES ---

// Función para abrir el modal limpio (NUEVO PROPIETARIO)
function abrirModalNuevo() {
    const modal = new bootstrap.Modal(document.getElementById("modalDueno"), {
        backdrop: "static",
        keyboard: false,
    });
    modal.show();
}

// Función para eliminar
function eliminarDueno(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Se borrará permanentemente",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        confirmButtonText: "Sí, eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/duenos/${id}`,
                method: "DELETE",
                data: { _token: $("meta[name='csrf-token']").attr("content") },
                success: function () {
                    Swal.fire("Eliminado", "Registro borrado", "success");
                    $("#tablaDuenos").DataTable().ajax.reload(null, false);
                },
            });
        }
    });
}

// Función para editar (Abre modal y carga datos)
function editarDueno(id) {
    $.get(`/duenos/${id}/edit`, function (data) {
        // Cargar inputs
        $("#full_name").val(data.full_name);
        $("#curp_rfc").val(data.curp_rfc).trigger("input");
        $("#phone").val(data.phone);
        $("#calle").val(data.calle);
        $("#colonia").val(data.colonia);
        $("#num_ext").val(data.num_ext);

        if (data.num_int) {
            $("#checkInterior").prop("checked", true).trigger("change");
            $("#num_int").val(data.num_int);
        } else {
            $("#checkInterior").prop("checked", false).trigger("change");
        }

        // Cambiar estado a Edición
        $("#formDueno").attr("data-edit-id", id);
        $("#tituloModalDueno").html(
            '<i class="bi bi-pencil-square me-2"></i>Editar Propietario',
        );
        $("#btnSubmitDueno")
            .html("ACTUALIZAR PROPIETARIO")
            .removeClass("btn-dark")
            .addClass("btn-primary");

        // Mostrar Modal
        const modal = new bootstrap.Modal(
            document.getElementById("modalDueno"),
            {
                backdrop: "static",
                keyboard: false,
            },
        );
        modal.show();
    });
}
