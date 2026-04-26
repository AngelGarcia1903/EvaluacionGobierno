/* public/js/vehiculos/vehiculos.js */
$(document).ready(function () {
    // 1. Inicialización de Tabla Dinámica (Parte 3, Punto 17)
    const table = $("#tablaDinamicaVehiculos").DataTable({
        ajax: "/vehiculos/data",
        scrollX: true, // Scroll horizontal
        scrollY: "250px", // Scroll vertical (aprox 5 registros)
        scrollCollapse: true,
        pageLength: 10,
        autoWidth: false,
        dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        columns: [
            {
                data: null, // Columna de Acciones
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                <div class="text-center action-buttons">
                    <button class="btn btn-sm btn-outline-primary border-0" onclick="editarVehiculo(${data.id})">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger border-0" onclick="eliminarVehiculo(${data.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>`;
                },
            },
            {
                data: "vin",
                render: (data) =>
                    `<code class="text-primary fw-bold">${data}</code>`,
            },
            {
                data: "license_plate",
                render: (data) => `<span class="badge bg-dark">${data}</span>`,
            },
            { data: "brand" },
            { data: "model" },
            { data: "year_model" },
            {
                data: "duenos",
                render: function (data) {
                    if (data && data.length > 0) {
                        const actual = data.find(
                            (d) => d.pivot.is_current == 1,
                        );
                        return actual
                            ? actual.full_name
                            : '<span class="text-muted">Sin dueño</span>';
                    }
                    return '<span class="text-muted">Sin dueño</span>';
                },
            },
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="bi bi-file-earmark-excel"></i>Exportar a Excel',
                className: "btn btn-success btn-sm mb-3",
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] },
            },
        ],
    });

    // 2. Lógica para cargar propietarios al abrir el modal (AJAX/JSON)
    // 2. Lógica para cargar propietarios al abrir el modal (AJAX/JSON)
    $("#modalVehiculo").on("show.bs.modal", function () {
        // SOLUCIÓN: Solo hacemos esta petición si es un vehículo NUEVO
        // (es decir, si el formulario no tiene el atributo data-edit-id)
        if (!$("#formNuevoVehiculo").attr("data-edit-id")) {
            $.get("/duenos/data", function (res) {
                let options =
                    '<option value="">Seleccionar propietario...</option>';
                res.data.forEach((dueno) => {
                    options += `<option value="${dueno.id}">${dueno.full_name}</option>`;
                });
                $("#selectDueno").html(options);
            });
        }
    });

    // 3. Envío del formulario por AJAX (Requisito Parte 3)
    $("#formNuevoVehiculo").on("submit", function (e) {
        e.preventDefault();
        const editId = $(this).attr("data-edit-id");
        const $form = $(this);
        const $btn = $form.find('button[type="submit"]');

        const url = editId ? `/vehiculos/${editId}` : "/vehiculos";
        const method = editId ? "PUT" : "POST";

        $btn.prop("disabled", true).html(
            '<span class="spinner-border spinner-border-sm"></span>',
        );

        $.ajax({
            url: url,
            method: method,
            data: $form.serialize() + (editId ? "&_method=PUT" : ""),
            success: function (response) {
                bootstrap.Modal.getInstance(
                    document.getElementById("modalVehiculo"),
                ).hide();
                $form[0].reset();
                $form.removeAttr("data-edit-id");
                $("#tablaDinamicaVehiculos")
                    .DataTable()
                    .ajax.reload(null, false);
                Swal.fire(
                    "¡Éxito!",
                    editId ? "Vehículo actualizado." : "Vehículo registrado.",
                    "success",
                );
            },
            error: function () {
                Swal.fire(
                    "Error",
                    "Verifique que el VIN/Placas no estén duplicados.",
                    "error",
                );
            },
            complete: function () {
                $btn.prop("disabled", false)
                    .text("GUARDAR UNIDAD")
                    .removeClass("btn-primary")
                    .addClass("btn-dark");
                $("#modalVehiculoLabel").text("Registrar Nuevo Vehículo");
            },
        });
    });
});
// Función para eliminar
function eliminarVehiculo(id) {
    Swal.fire({
        title: "¿Eliminar vehículo?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/vehiculos/${id}`,
                method: "DELETE",
                data: { _token: $('meta[name="csrf-token"]').attr("content") },
                success: function () {
                    Swal.fire(
                        "Eliminado",
                        "El vehículo ha sido borrado.",
                        "success",
                    );
                    $("#tablaDinamicaVehiculos")
                        .DataTable()
                        .ajax.reload(null, false);
                },
            });
        }
    });
}

// Función para editar (Cargar datos en el modal)
function editarVehiculo(id) {
    // 1. Primero cargamos los propietarios para asegurar que el select tenga opciones
    $.get("/duenos/data", function (res) {
        let options = '<option value="">Seleccionar propietario...</option>';
        res.data.forEach((dueno) => {
            options += `<option value="${dueno.id}">${dueno.full_name}</option>`;
        });
        $("#selectDueno").html(options);

        // 2. Una vez llenos los dueños, pedimos los datos del vehículo
        $.get(`/vehiculos/${id}/edit`, function (data) {
            $("#vin").val(data.vin);
            $("#license_plate").val(data.license_plate);
            $("#brand").val(data.brand);
            $("#model").val(data.model);
            $("#year_model").val(data.year_model);

            // 3. Seleccionar el dueño actual (Soporta booleanos 'true' y números '1')
            if (data.duenos && data.duenos.length > 0) {
                const actual = data.duenos.find(
                    (d) =>
                        d.pivot.is_current == 1 || d.pivot.is_current === true,
                );
                if (actual) {
                    $("#selectDueno").val(actual.id);
                } else {
                    // Fallback: Si no hay dueño "actual" marcado, pone el último de la lista
                    $("#selectDueno").val(
                        data.duenos[data.duenos.length - 1].id,
                    );
                }
            }

            // 4. Cambiamos el título del modal y el texto del botón
            $("#modalVehiculo .modal-title").html(
                '<i class="bi bi-pencil-square me-2"></i>Editar Vehículo',
            );
            $("#formNuevoVehiculo").attr("data-edit-id", id);
            $("#formNuevoVehiculo button[type='submit']")
                .text("ACTUALIZAR UNIDAD")
                .removeClass("btn-dark")
                .addClass("btn-primary");

            // 5. Mostrar el modal con opciones de bloqueo
            const modal = new bootstrap.Modal(
                document.getElementById("modalVehiculo"),
                {
                    backdrop: "static",
                    keyboard: false,
                },
            );
            modal.show();
        });
    });
}

$("#modalVehiculo").on("hidden.bs.modal", function () {
    $("#formNuevoVehiculo")[0].reset();
    $("#formNuevoVehiculo").removeAttr("data-edit-id");

    // Regresar el título y el botón a su estado original
    $("#modalVehiculo .modal-title").html(
        '<i class="bi bi-car-front-fill me-2"></i>Registrar Unidad',
    );
    $("#formNuevoVehiculo button[type='submit']")
        .text("GUARDAR UNIDAD")
        .removeClass("btn-primary")
        .addClass("btn-dark");

    $("body").removeClass("modal-open").css("padding-right", "");
    $(".modal-backdrop").remove();
});
