<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
  }

  .register-container {
    max-width: 400px;
    margin: 50px auto;
  }

  .card {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  }

  .card-header {
    text-align: center;
  }

  .card-header img {
    margin-bottom: 20px;
  }

  .form-group {
    margin-bottom: 20px;
    position: relative;
  }

  .form-label {
    font-weight: bold;
    font-size: 1rem;
    display: block;
    margin-bottom: 5px;
  }

  .form-control {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    font-size: 1rem;
    width: calc(100% - 42px);
  }

  .form-control-icon {
    position: absolute;
    right: 30px;
    top: 70%;
    transform: translateY(-50%);
    cursor: pointer;
  }

  .btn {
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
  }

  .btn-primary {
    background-color: #007bff;
    color: #fff;
  }

  .btn-outline-primary {
    border: 1px solid #007bff;
    background-color: transparent;
    color: #007bff;
  }

  .btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
  }

  .text-center {
    text-align: center;
  }

  .mt-3 {
    margin-top: 30px;
  }

  a {
    text-decoration: none;
  }
  </style>
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