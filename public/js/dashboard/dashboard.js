$(document).ready(function () {
    // 1. Extraemos los datos que Laravel nos dejó en la variable global window.chartData
    const datosMarcas = window.chartData.marcas;
    const datosEstatus = window.chartData.estatus;

    // 2. GRÁFICA DE BARRAS (Vehículos por Marca)
    const ctxMarcas = document.getElementById("graficaMarcas").getContext("2d");
    new Chart(ctxMarcas, {
        type: "bar",
        data: {
            labels: Object.keys(datosMarcas), // Nombres de las marcas
            datasets: [
                {
                    label: "Unidades Registradas",
                    data: Object.values(datosMarcas), // Cantidades
                    backgroundColor: "#4f46e5",
                    borderRadius: 8,
                    barPercentage: 0.5,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }, // Ocultamos la leyenda para que se vea más limpio
            },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
                x: { grid: { display: false } },
            },
        },
    });

    // 3. GRÁFICA DE DONA (Estatus de Robo)
    const ctxEstatus = document
        .getElementById("graficaEstatus")
        .getContext("2d");
    new Chart(ctxEstatus, {
        type: "doughnut",
        data: {
            labels: Object.keys(datosEstatus),
            datasets: [
                {
                    data: Object.values(datosEstatus),
                    backgroundColor: ["#10b981", "#e11d48"], // Verde para Sanos, Rojo para Robados
                    borderWidth: 0,
                    hoverOffset: 4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "70%", // Qué tan gruesa es la dona
            plugins: {
                legend: { position: "bottom" },
            },
        },
    });
});
