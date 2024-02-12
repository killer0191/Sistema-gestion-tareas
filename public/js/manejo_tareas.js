$(document).ready(function () {
    // Crear nueva tarea
    $("#editarTareaForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: crearTareaURL,
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                console.log("Tarea creada exitosamente");
                // Actualizar la interfaz de usuario o realizar cualquier otra acción necesaria
            },
            error: function (xhr, status, error) {
                console.error("Error al crear la tarea");
                // Manejar errores de validación u otros errores
            },
        });
    });

    // Editar tarea existente
    $("#editarTareaForm").submit(function (event) {
        event.preventDefault();
        var id = $(this).data("id"); // Obtener el ID de la tarea
        $.ajax({
            url: editarTareaURL(id),
            method: "PUT",
            data: $(this).serialize(),
            success: function (response) {
                console.log("Tarea editada exitosamente");
                // Actualizar la interfaz de usuario o realizar cualquier otra acción necesaria
            },
            error: function (xhr, status, error) {
                console.error("Error al editar la tarea");
                // Manejar errores de validación u otros errores
            },
        });
    });

    // Eliminar tarea
    $(".btn-danger").click(function (event) {
        event.preventDefault();
        var id = $(this).data("id");
        $.ajax({
            url: "/tarea/" + id,
            method: "DELETE",
            success: function (response) {
                console.log("Tarea eliminada exitosamente");
                // Actualizar la interfaz de usuario o realizar cualquier otra acción necesaria
            },
            error: function (xhr, status, error) {
                console.error("Error al eliminar la tarea");
                // Manejar errores u otros errores
            },
        });
    });
});
