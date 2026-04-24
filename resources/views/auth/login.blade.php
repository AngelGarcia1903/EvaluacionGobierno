<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Seguridad Pública Irapuato</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>
<body class="d-flex align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-10"> <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">Acceso al Sistema</h3>
                        <p class="text-muted small">Consulta de Vehículos Robados</p>
                    </div>

                    <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Usuario</label>
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Ej: oficial_admin" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Contraseña</label>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
                        </div>

                        @if($errors->has('login_error'))
                            <div class="alert alert-danger p-2 small border-0 mb-3">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first('login_error') }}
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            INGRESAR
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/auth/login.js') }}"></script>
</body>
</html>
