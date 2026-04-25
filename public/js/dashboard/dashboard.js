function abrirModalVehiculo() {
    const select = $("#selectDueno");
    select.empty().append('<option value="">Cargando propietarios...</option>');

    var modalElement = document.getElementById("modalVehiculo");
    var myModal = bootstrap.Modal.getOrCreateInstance(modalElement);
    myModal.show();

    // AJAX para cargar dueños (JSON)
    $.get("/duenos-data", function (res) {
        select
            .empty()
            .append('<option value="">Seleccionar propietario...</option>');
        res.data.forEach((dueno) => {
            select.append(
                `<option value="${dueno.id}">${dueno.full_name}</option>`,
            );
        });
    });
}

$(document).ready(function () {
    cargarEstadisticas();

    function cargarEstadisticas() {
        $.when(
            $.get("/vehiculos-count"),
            $.get("/duenos-count"),
            $.get("/reportes-count"),
        ).done(function (v, d, r) {
            $("#countVehiculos").text(v[0].total);
            $("#countPropietarios").text(d[0].total);
            $("#countRobos").text(r[0].total);
        });
    }

    $("#formNuevoVehiculo").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "/vehiculos/store",
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                bootstrap.Modal.getInstance(
                    document.getElementById("modalVehiculo"),
                ).hide();
                cargarEstadisticas();
                Swal.fire("¡Éxito!", "Vehículo registrado", "success");
            },
        });
    });
});
