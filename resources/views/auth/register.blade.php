<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - KiddoSpace</title>
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
        .bubble-pink { background-color: #ffeef4; color: #ff5c93; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                
                <div class="card shadow-sm border-0 rounded-4 bg-white">
                    <div class="card-body p-4">
                        
                        <div class="text-center mb-4">
                            <div class="bubble-pink rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="fa-solid fa-user-plus fa-xl"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Crear Cuenta</h4>
                            <small class="text-muted">Registra un nuevo usuario administrativo</small>
                        </div>
                        
                        <form action="{{ route('register.store') }}" method="POST" id="formRegister">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark opacity-75 small">Nombre Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="name" id="name" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px;" value="{{ old('name') }}">
                                </div>
                                @error('name') <small class="text-danger mt-1 d-block" style="font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark opacity-75 small">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px;" value="{{ old('email') }}">
                                </div>
                                @error('email') <small class="text-danger mt-1 d-block" style="font-size: 12px;">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark opacity-75 small">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px;">
                                </div>
                                @error('password') <small class="text-danger mt-1 d-block" style="font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark opacity-75 small">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-shield-halved"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px;">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 py-2.5 fw-bold rounded-3 shadow-sm border-0 mb-3" style="background-color: #10b981; font-size: 14px;">
                                Registrar Usuario
                            </button>
                        </form>

                        <div class="text-center mt-2 border-top border-light pt-3">
                            <span class="text-muted small">¿Ya tienes una cuenta registrada?</span>
                            <a href="{{ route('login') }}" class="d-block small fw-bold text-decoration-none mt-1" style="color: #ff5c93;">
                                Volver al inicio de sesión
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('formRegister').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const passwordConf = document.getElementById('password_confirmation').value;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // 1. Campos vacíos
            if (!name || !email || !password || !passwordConf) {
                swalWithBootstrapButtons.fire({
                    title: "Datos Incompletos",
                    text: "Por favor, completa todos los campos del registro.",
                    icon: "warning",
                    confirmButtonText: "Ok"
                });
                return;
            }

            // 2. Coherencia: El nombre de una persona no lleva números
            if (/\d/.test(name)) {
                swalWithBootstrapButtons.fire({
                    title: "Nombre Inválido",
                    text: "El nombre completo de un usuario no puede contener números.",
                    icon: "error",
                    confirmButtonText: "Corregir"
                });
                return;
            }

            // 3. Seguridad: Contraseña corta
            if (password.length < 6) {
                swalWithBootstrapButtons.fire({
                    title: "Contraseña Débil",
                    text: "La contraseña debe tener un mínimo de 6 caracteres por seguridad.",
                    icon: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            // 4. Integridad: Verificar coincidencia
            if (password !== passwordConf) {
                swalWithBootstrapButtons.fire({
                    title: "Error de Coincidencia",
                    text: "Las contraseñas ingresadas no coinciden. Por favor, revísalas.",
                    icon: "error",
                    confirmButtonText: "Verificar"
                });
                return;
            }

            // Si todo pasa con éxito, se envía el formulario
            this.submit();
        });
    </script>
</body>
</html>