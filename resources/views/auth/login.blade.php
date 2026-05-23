<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - KiddoSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f0f4fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .bubble-blue { background-color: #e8eeff; color: #2e5bff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                
                <div class="card shadow-sm border-0 rounded-4 bg-white">
                    <div class="card-body p-4">
                        
                        <div class="text-center mb-4">
                            <div class="bubble-blue rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="fa-solid fa-shapes fa-xl"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">¡Hola de nuevo!</h4>
                            <small class="text-muted">Ingresa tus credenciales para acceder</small>
                        </div>
                        
                        <form action="{{ route('login.store') }}" method="POST" id="formLogin">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark opacity-75 small">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" id="loginEmail" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px;" value="{{ old('email') }}">
                                </div>
                                @error('email') <small class="text-danger mt-1 d-block" style="font-size: 12px;">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark opacity-75 small">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password" id="loginPassword" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px;">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold rounded-3 shadow-sm border-0 mb-3" style="background-color: #2e5bff; font-size: 14px;">
                                Entrar al Sistema
                            </button>
                        </form>

                        <div class="text-center mt-2 border-top border-light pt-3">
                            <span class="text-muted small">¿No tienes una cuenta administrativa?</span>
                            <a href="{{ route('register') }}" class="d-block small fw-bold text-decoration-none mt-1" style="color: #2e5bff;">
                                Registrar nuevo usuario
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('formLogin').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // 1. Campos vacíos
            if (!email || !password) {
                swalWithBootstrapButtons.fire({
                    title: "Campos Vacíos",
                    text: "Por favor, ingresa tu correo y contraseña para acceder.",
                    icon: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            // Si pasa la validación local, mandamos el inicio de sesión a Laravel
            this.submit();
        });
    </script>
</body>
</html>