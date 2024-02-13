<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/login_style.css') }}">


</head>

<body>

  <main class="container">
    <div class="card">
      <div class="card-header">
        <img
          src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fassets.stickpng.com%2Fimages%2F585e4bcdcb11b227491c3396.png&f=1&nofb=1&ipt=2c2512f5cead5c583d0025c3ae0174ec0d7223c447256834afb2b2108d29081e&ipo=images"
          alt="Logo" width="120" />
        <h1 class="text-center mb-4">Iniciar sesión</h1>
      </div>
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Escriba su email"
              value="{{ old('email') }}" required />
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group position-relative">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control"
              placeholder="Escriba su contraseña" required />
            <button type="button" id="toggle-password" class="form-control-icon" onclick="togglePassword()">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <button type="submit" class="btn btn-primary">Iniciar sesión</button>
          <div class="text-center mt-3">
            <p>¿No tienes una cuenta?</p>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Crea una</a>
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