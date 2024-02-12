import "./bootstrap";
/*
// Crear nueva tarea
$("#crearTareaForm").submit(function (event) {
    event.preventDefault();
    var datos = $(this).serialize();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: "{{ route('tarea.store') }}",
        method: "POST",
        data: datos,
        success: function (response) {
            console.log("Tarea creada exitosamente");
            // Cerrar el modal de crear tarea
            $("#crearTareaModal").modal("hide");
            // Limpiar los campos del formulario
            $("#crearTareaForm")[0].reset();

            var imagen = "";
            if (response.idEstadoF == 1) {
                imagen = "finalizada.png";
            } else {
                var fechaActual = new Date();
                var fechaVencimiento = new Date(response.fechaVenc);
                if (fechaActual > fechaVencimiento) {
                    imagen = "vencida.png";
                } else {
                    imagen = "pendiente.png";
                }
            }

            // Agregar la nueva tarea a la lista
            var nuevaTarea = `
        <div class="card mb-3">
        <img src="{{ asset('assets/') }}/${imagen}" class="estado-imagen" alt="Estado" width="50px">
          <div class="card-body">
            <h5 class="card-title">${response.titulo}</h5>
            <p class="card-text">${response.descripcion}</p>
            ${
                response.fechaVenc
                    ? `<p class="card-text">Fecha de vencimiento: ${response.fechaVenc}</p>`
                    : ""
            }
            <form method="POST" class="eliminar-tarea-form" action="/tarea/${
                response.idTarea
            }">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" data-id="${
                  response.idTarea
              }">Eliminar</button>
            </form>
            <button class="btn btn-primary mt-2 editar-tarea-btn" data-toggle="modal" data-target="#editarTareaModal"
              data-tarea='${JSON.stringify(response)}' data-id="${
                response.idTarea
            }">Editar</button>
          </div>
        </div>
      `;
            $(".row").append(nuevaTarea);
        },
        error: function (xhr, status, error) {
            console.error("Error al crear la tarea");
        },
    });
});*/
