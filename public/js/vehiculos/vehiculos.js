/* public/js/vehiculos/vehiculos.js */
$(document).ready(function () {
    // 1. Inicialización de Tabla Dinámica (Parte 3, Punto 17)
    const table = $("#tablaDinamicaVehiculos").DataTable({
        ajax: "/vehiculos/data", // Ruta que devuelve JSON
        columns: [
            {
                data: null,
                render: function (data) {
                    /* botones editar/borrar */
                },
            },
            { data: "vin" },
            { data: "license_plate" },
            { data: "brand" },
            { data: "model" },
            { data: "year_model" },
            // Esta columna asume que tu controlador envía el nombre del dueño en la respuesta JSON
            {
                data: "duenos",
                render: function (data) {
                    // Buscamos en el array de dueños el que tenga is_current en el pivot
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
    $.get(`/vehiculos/${id}/edit`, function (data) {
        const modal = new bootstrap.Modal(
            document.getElementById("modalVehiculo"),
        );
        modal.show();

        $("#vin").val(data.vin);
        $("#license_plate").val(data.license_plate);
        $("#brand").val(data.brand);
        $("#model").val(data.model);
        $("#year_model").val(data.year_model);
        $("#selectDueno").val(data.owner_id); // Asumiendo que el modelo tiene owner_id o lo sacas del dueno_actual

        $("#modalVehiculoLabel").text("Editar Vehículo");
        $("#formNuevoVehiculo").attr("data-edit-id", id);
    });
}
