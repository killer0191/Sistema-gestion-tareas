<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/login_style.css') }}">

</head>

<body>

  <main class="register-container">
    <div class="card">
      <div class="card-header">
        <img src="{{ asset('assets/person.png') }}" alt="Logo" width="120" />
        <h2 class="text-center mb-4">Crear cuenta</h2>
      </div>
      <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escriba su nombre" required>
          </div>

          <div class="form-group">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Escriba su email" required>
            @error('email')
            <span class="text-danger"><br /> El email ya ha sido registrado</span>
            @enderror
          </div>
          <div class="form-group position-relative">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control"
              placeholder="Escriba su contraseña" required>
            <!-- Botón con icono de Font Awesome -->
            <button type="button" id="toggle-password" class="form-control-icon" onclick="togglePassword()">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirmar contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
              placeholder="Confirme su contraseña" required>
            @error('password_confirmation')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <button class="btn btn-primary">
            Crear cuenta
          </button>
          <div class="text-center mt-3">
            <p>¿Ya tienes una cuenta?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Inicia sesión</a>
          </div>
        </div>
      </form>
    </div>
  </main>
  <script>
  function togglePassword() {
    var passwordField = document.getElementById("password");
    var toggleButton = document.getElementById("toggle-password");
    if (passwordField.type === "password") {
      passwordField.type = "text";
      toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
      passwordField.type = "password";
      toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
    }
  }
  </script>

</body>

</html>