<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/home_style.css') }}">
</head>

<body>

  <header class="header dark-theme d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="header-content text-center">
      <h1 class="display-4">Sistema de Gestión de Tareas</h1>
      <p class="lead">Bienvenido, {{ Auth::user()->nombre }}</p>
      <a id="scroll-button" class="btn btn-success btn-lg mt-3">Ver lista de tareas</a>
      <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" class="logout-button">Cerrar sesión</button>
      </form>
    </div>
  </header>

  <main class="container mt-5" id="main-content">
    <div class="row">
      <div class="col">
        <h2>Lista de tareas</h2>
        <!-- Botón para abrir el modal de crear nueva tarea -->
        <button class="btn btn-success mt-2" data-toggle="modal" data-target="#crearTareaModal" data-tarea="{}"
          data-action="crear" data-url="{{ route('tarea.create') }}">Crear nueva tarea</button>
        @php
        $tarea = (object) [
        'idTarea' => 1,
        'titulo' => '',
        'descripcion' => '',
        'fechaVenc' => '',
        'idEstadoF' => 2,
        ];
        @endphp
        <div class="card-container">
          @foreach($tareas as $tarea)
          @php
          // Determinar el nombre de la imagen según el estado de la tarea y si está vencida
          $imagen = '';
          if ($tarea->idEstadoF == 1) {
          $imagen = 'finalizada.png';
          } else {
          $fechaActual = now();
          $fechaVencimiento = \Carbon\Carbon::parse($tarea->fechaVenc);
          if ($fechaActual->gt($fechaVencimiento)) {
          $imagen = 'vencida.png';
          } else {
          $imagen = 'pendiente.png';
          }
          }
          @endphp
          <div class="card mb-3" id="tarea-{{ $tarea->idTarea }}">
            <img src="{{ asset('assets/' . $imagen) }}" class="estado-imagen" alt="Estado" width="50px">
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
    </div>
  </main>

  <!-- Modal para crear tarea -->
  <div class="modal fade" id="crearTareaModal" tabindex="-1" role="dialog" aria-labelledby="crearTareaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearTareaModalLabel">Crear tarea</h5>
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
            <center><button type="submit" class="btn btn-primary">Crear tarea</button></center>
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
          <h5 class="modal-title" id="editarTareaModalLabel">Editar tarea</h5>
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
            <input type="hidden" id="estadoOriginal" name="estadoOriginal" value="{{ $tarea->idEstadoF }}">
            <input type="hidden" name="idUsuarioF" value="{{ Auth::id() }}"><br />
            <center><button type="submit" class="btn btn-primary">Actualizar tarea</button></center>
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
    $("#scroll-button").click(function(e) {
      e.preventDefault();
      $('html, body').animate({
        scrollTop: $("#main-content").offset().top
      }, 500);
    });
  });
  </script>
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

          var imagen = '';
          if (response.idEstadoF == 1) {
            imagen = 'finalizada.png';
          } else {
            var fechaActual = new Date();
            var fechaVencimiento = new Date(response.fechaVenc);
            if (fechaActual > fechaVencimiento) {
              imagen = 'vencida.png';
            } else {
              imagen = 'pendiente.png';
            }
          }

          // Agregar la nueva tarea a la lista
          var nuevaTarea = `
        <div class="card mb-3">
        <img src="{{ asset('assets/') }}/${imagen}" class="estado-imagen" alt="Estado" width="50px">
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

      // Formatear la fecha de vencimiento para mostrarla en el input de tipo date
      const fechaVencString = tareaData.fechaVenc;
      const fechaVenc = new Date(fechaVencString);
      const formattedFechaVenc = fechaVenc.toISOString().split('T')[0]; // Formato YYYY-MM-DD
      $("#fechaVenc_editar").val(formattedFechaVenc);

      // Marcar la casilla "Tarea finalizada" si la tarea está finalizada
      if (tareaData.idEstadoF == 1) {
        $("#estadoCheckbox").prop("checked", true);
      } else {
        $("#estadoCheckbox").prop("checked", false);
      }

      $("#editarTareaForm").data("id", tareaData.idTarea);
    });


    // Actualizar tarea
    $("#editarTareaForm").submit(function(event) {
      event.preventDefault();
      var datos = $(this).serialize();
      var id = $(this).data("id");
      var estadoOriginal = $("#estadoOriginal").val(); // Obtener el estado original
      var estado = $("#estadoCheckbox").is(":checked") ? 1 : 2; // Obtener el nuevo estado
      datos += "&idEstadoF=" + estado;
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
          tareaElement.find(".card-text").text(tarea.descripcion);
          if (tarea.fechaVenc) {
            tareaElement.find(".fecha-vencimiento").text("Fecha de vencimiento: " + tarea
              .fechaVenc); // Actualizar la fecha de vencimiento existente
          } else {
            tareaElement.find(".fecha-vencimiento")
              .remove(); // Eliminar la fecha de vencimiento si no existe en la tarea actualizada
          }
          // Actualizar el estado de la tarea en la imagen
          var nuevaImagen = tarea.idEstadoF == 1 ? 'finalizada.png' : (tarea.idEstadoF == 2 ?
            'pendiente.png' : 'vencida.png');
          tareaElement.find('.estado-imagen').attr('src', '{{ asset("assets/") }}/' + nuevaImagen);
          // Actualizar los datos del botón de editar tarea
          tareaElement.find(".editar-tarea-btn").data("tarea", JSON.stringify(tarea));
          tareaElement.find(".editar-tarea-btn").data("id", tarea.idTarea);
          // Cerrar el modal de edición de tarea
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