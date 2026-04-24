/**
 * Lógica de interfaz para el Login
 * Cumple con el requerimiento de separación de archivos .js [cite: 13]
 */
document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");

    if (loginForm) {
        loginForm.addEventListener("submit", function () {
            const btn = this.querySelector('button[type="submit"]');
            // Efecto visual de carga
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validando...';
            btn.disabled = true;
        });
    }
});
