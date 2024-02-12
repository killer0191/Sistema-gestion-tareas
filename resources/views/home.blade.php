<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
  /* Estilos para centrar vertical y horizontalmente el formulario */
  .modal-dialog {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
  }

  .modal-content {
    width: 80%;
  }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
      <img src="{{ asset('assets/logo.png') }}" width="70" height="70" class="d-inline-block align-top" alt="Logo">
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      @auth
      <div class="navbar-text">
        <span>Bienvenido, {{ Auth::user()->nombre }}</span>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-link ml-3"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
        </form>
      </div>
      @endauth
    </div>
  </nav>

  <main class="container mt-4">
    <h1>Sistema de Gestión de Tareas</h1>
    <div class="row">
      <div class="col-md-6">
        <h2>Lista de Tareas</h2>

        <!-- Botón para abrir el modal de crear nueva tarea -->
        <button class="btn btn-success mt-2" data-toggle="modal" data-target="#crearTareaModal" data-tarea="{}"
          data-action="crear" data-url="{{ route('tarea.create') }}">Crear Nueva Tarea</button>


        @foreach($tareas as $tarea)
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">{{ $tarea->titulo }}</h5>
            <p class="card-text">{{ $tarea->descripcion }}</p>
            @if($tarea->fechaVenc)
            <p class="card-text">Fecha de vencimiento: {{ $tarea->fechaVenc }}</p>
            @endif
            <form method="POST" class="eliminar-tarea-form" action="/tarea/{{ $tarea->idTarea }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger eliminar-tarea-btn" data-action="eliminar"
                data-id="{{ $tarea->idTarea }}">Eliminar</button>
            </form>
            <button class="btn btn-primary mt-2 editar-tarea-btn" data-toggle="modal" data-target="#editarTareaModal"
              data-tarea="{{ json_encode($tarea) }}" data-id="{{ $tarea->idTarea }}">Editar</button>

          </div>
        </div>
        @endforeach




      </div>
    </div>
  </main>

  <!-- Modal para crear tarea -->
  <div class="modal fade" id="crearTareaModal" tabindex="-1" role="dialog" aria-labelledby="crearTareaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearTareaModalLabel">Crear Tarea</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="crearTareaForm" action="{{ route('tarea.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="titulo">Título de la tarea:</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
              <label for="descripcion">Descripción:</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="fechaVenc">Fecha de vencimiento:</label>
              <input type="date" class="form-control" id="fechaVenc" name="fechaVenc" required>
            </div>
            <input type="hidden" name="idEstadoF" value="2">
            <input type="hidden" name="idUsuarioF" value="{{ Auth::id() }}">
            <button type="submit" class="btn btn-primary">Crear Tarea</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para editar tarea -->
  <div class="modal fade" id="editarTareaModal" tabindex="-1" role="dialog" aria-labelledby="editarTareaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarTareaModalLabel">Editar Tarea</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editarTareaForm" action="{{ route('tarea.update', ['tarea' => $tarea->idTarea]) }}" method="PUT"
            data-id="{{ $tarea->idTarea }}">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="titulo_editar">Título de la tarea:</label>
              <input type="text" class="form-control" id="titulo_editar" name="titulo" required>
            </div>
            <div class="form-group">
              <label for="descripcion_editar">Descripción:</label>
              <textarea class="form-control" id="descripcion_editar" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="fechaVenc_editar">Fecha de vencimiento:</label>
              <input type="date" class="form-control" id="fechaVenc_editar" name="fechaVenc" required>
            </div>
            <input type="hidden" name="idEstadoF" value="2">
            <input type="hidden" name="idUsuarioF" value="{{ Auth::id() }}">
            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
  $(document).ready(function() {
    // Crear nueva tarea
    $("#crearTareaForm").submit(function(event) {
      event.preventDefault();
      var datos = $(this).serialize();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('tarea.store') }}",
        method: "POST",
        data: datos,
        success: function(response) {
          console.log("Tarea creada exitosamente");
          // Cerrar el modal de crear tarea
          $('#crearTareaModal').modal('hide');
          // Limpiar los campos del formulario
          $("#crearTareaForm")[0].reset();
          // Agregar la nueva tarea a la lista
          var nuevaTarea = `
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">${response.titulo}</h5>
            <p class="card-text">${response.descripcion}</p>
            ${response.fechaVenc ? `<p class="card-text">Fecha de vencimiento: ${response.fechaVenc}</p>` : ''}
            <form method="POST" class="eliminar-tarea-form" action="/tarea/${response.idTarea}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" data-id="${response.idTarea}">Eliminar</button>
            </form>
            <button class="btn btn-primary mt-2 editar-tarea-btn" data-toggle="modal" data-target="#editarTareaModal"
              data-tarea='${JSON.stringify(response)}' data-id="${response.idTarea}">Editar</button>
          </div>
        </div>
      `;
          $(".row").append(nuevaTarea);
        },
        error: function(xhr, status, error) {
          console.error("Error al crear la tarea");
        },
      });
    });

    // Editar tarea
    // Editar tarea
    $(".editar-tarea-btn").click(function() {
      var tarea = $(this).data("tarea");
      console.log('el id es: ' + tarea.idTarea);
      $("#editarTareaForm").attr("action", "{{ route('tarea.update', '') }}/" + tarea
      .idTarea); // Actualizar la URL del formulario
      $("#titulo_editar").val(tarea.titulo);
      $("#descripcion_editar").val(tarea.descripcion);
      $("#fechaVenc_editar").val(tarea.fechaVenc);

      // Abrir el modal de edición
      $('#editarTareaModal').modal('show');
    });

    $("#editarTareaForm").submit(function(event) {
      event.preventDefault();
      var datos = $(this).serialize();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: $(this).attr('action'), // Obtener la URL del formulario
        method: "POST", // Usar POST para Laravel
        data: datos + '&_method=PUT', // Agregar el campo _method con el valor PUT
        success: function(response) {
          console.log("Tarea editada exitosamente");
          $('#editarTareaModal').modal('hide');
          // Actualizar la tarea en la lista (puedes hacerlo más eficiente, recargando solo la tarea modificada)
          location.reload();
        },
        error: function(xhr, status, error) {
          console.error("Error al editar la tarea");
        },
      });
    });


    // Eliminar tarea
    $(".eliminar-tarea-btn").click(function(event) {
      event.preventDefault();
      var id = $(this).data("id");
      var botonEliminar = $(this); // Guardar una referencia al botón de eliminar
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('tarea.destroy', '') }}/" + id,
        method: "DELETE",
        success: function(response) {
          console.log("Tarea eliminada exitosamente");
          // Eliminar la tarea del DOM
          botonEliminar.closest('.card').remove(); // Usar la referencia al botón de eliminar
        },
        error: function(xhr, status, error) {
          console.error("Error al eliminar la tarea");
          console.log(error);
        },
      });
    });



  });
  </script>

</body>

</html>