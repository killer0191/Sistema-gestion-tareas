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

/*
    // !--Editar tarea existente-- >
    $(".editar-tarea-btn").click(function() {
      var tarea = $(this).data("tarea");
      $("#editarTareaForm input[name='titulo']").val(tarea.titulo);
      $("#editarTareaForm textarea[name='descripcion']").val(tarea.descripcion);
      $("#editarTareaForm input[name='fechaVenc']").val(tarea.fechaVenc);
      var id = $(this).data("id");

      console.log("el id de editar es: " + id);
    });

    //   !--Actualizar tarea-- >
    $("#editarTareaForm").submit(function(event) {
      event.preventDefault();
      var datos = $(this).serialize();
      var id = $("#editarTareaForm").data("id");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('tarea.update') }}/" + id, // Utiliza url() para construir la URL
        method: "PUT",
        data: datos,
        success: function(response) {
          console.log("Tarea editada exitosamente");
          // Actualizar la interfaz de usuario o realizar cualquier otra acción necesaria
        },
        error: function(xhr, status, error) {
          console.error("Error al editar la tarea");
          // Manejar errores de validación u otros errores
        },
      });
    });*/
