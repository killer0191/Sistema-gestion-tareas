$("#editarTareaModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var tarea = button.data("tarea");
    var modal = $(this);
    var action = button.data("action");

    // Cambiar el título del modal según si se está creando o editando una tarea
    modal
        .find(".modal-title")
        .text(action === "crear" ? "Crear Tarea" : "Editar Tarea");

    // Cambiar el texto del botón según si se está creando o editando una tarea
    modal
        .find("#editarTareaForm button[type='submit']")
        .text(action === "crear" ? "Crear Tarea" : "Actualizar Tarea");

    // Llenar los campos del formulario con la información de la tarea
    modal.find("#titulo").val(tarea ? tarea.titulo : "");
    modal.find("#descripcion").val(tarea ? tarea.descripcion : "");
    modal.find("#fecha_vencimiento").val(tarea ? tarea.fecha_vencimiento : "");

    // Cambiar la acción del formulario según si se está editando o creando una nueva tarea
    var formAction =
        action === "crear"
            ? "/tarea/crear"
            : "/tarea/editar/" + (tarea ? tarea.id : "");
    modal.find("#editarTareaForm").attr("action", formAction);
});

/*Lo que si funciona*/
// Datos de la tarea a actualizar
var tarea = {
    idTarea: 10, // ID de la tarea que deseas actualizar
    titulo: "Nuevo título",
    descripcion: "Nueva descripción",
    //fechaVenc: "2024-12-31", // Fecha de vencimiento en formato YYYY-MM-DD
    //idEstadoF: 1, // ID del estado de la tarea
    //idUsuarioF: 2 // ID del usuario asignado a la tarea
};

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
// Enviar la solicitud AJAX para actualizar la tarea
$.ajax({
    url: "{{ route('tarea.update', '') }}/" + tarea.idTarea,
    method: "PUT",
    data: tarea,
    dataType: "json",
    success: function (response) {
        console.log("Tarea editada exitosamente");
        // Aquí puedes manejar la respuesta si es necesario
    },
    error: function (xhr, status, error) {
        console.error("Error al editar la tarea:", error);
        console.error("Respuesta del servidor:", xhr.responseText);
    },
});

/*// Editar tarea
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
        method: "PUT", // Usar POST para Laravel
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
    });*/
