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
        <div class="card mb-3" id="tarea-{{ $tarea->idTarea }}">
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

            <div id="editarTareaContainer-{{ $tarea->idTarea }}"></div>

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
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="estadoCheckbox" name="idEstadoF">
              <label class="form-check-label" for="estadoCheckbox">
                Tarea finalizada
              </label>
            </div>
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
    $(".editar-tarea-btn").click(function(event) {
      event.preventDefault();
      var tareaData = $(this).data("tarea");
      $("#titulo_editar").val(tareaData.titulo);
      $("#descripcion_editar").val(tareaData.descripcion);
      $("#fechaVenc_editar").val(tareaData.fechaVenc);
      $("#editarTareaForm").data("id", tareaData.idTarea);
    });

    // Actualizar tarea
    $("#editarTareaForm").submit(function(event) {
      event.preventDefault();
      var datos = $(this).serialize();
      var id = $(this).data("id");
      var estado = $("#estadoCheckbox").is(":checked") ? 1 : 2; // Get the checkbox value
      datos += "&idEstadoF=" + estado; // Add the checkbox value to the data string
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('tarea.update', '') }}/" + id,
        method: "PUT",
        data: datos,
        success: function(response) {
          console.log("Tarea editada exitosamente");
          // Actualizar los datos de la tarea en el DOM
          var tarea = response.tarea;
          var tareaElement = $("#tarea-" + id);
          tareaElement.find(".card-title").text(tarea.titulo);
          tareaElement.find(".card-text").remove(); // Remove existing task description
          tareaElement.find(".fecha-vencimiento").remove(); // Remove existing due date
          tareaElement.append("<p class='card-text'>" + tarea.descripcion +
          "</p>"); // Add new task description
          if (tarea.fechaVenc) {
            tareaElement.append("<p class='card-text fecha-vencimiento'>Fecha de vencimiento: " + tarea
              .fechaVenc + "</p>"); // Add new due date
          }
          tareaElement.find(".eliminar-tarea-btn").data("id", tarea.idTarea);
          tareaElement.find(".editar-tarea-btn").data("tarea", JSON.stringify(tarea));
          tareaElement.find(".editar-tarea-btn").data("id", tarea.idTarea);
          // Close the edit task modal
          $("#editarTareaModal").modal("hide");
        },
        error: function(xhr, status, error) {
          console.error("Error al editar la tarea");
          console.error(xhr.responseText);
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