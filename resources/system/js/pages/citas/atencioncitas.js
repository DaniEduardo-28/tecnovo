var fundosData = [];

$(document).ready(function () {

  crearCalendario();

  $("#cboFundoBuscar, #cboMaquinariaBuscar, #cboMedicoBuscar, #cboClienteBuscar").change(function () {
    crearCalendario();
  });

  $("#frmCronograma").submit(function (e) {
    e.preventDefault();
    registrarCronograma();
  });

  // Botón anular cronograma en el modal de vista
  $("#btnAnularCronograma").click(function () {
    cambiarEstadoCronograma('ANULADO');
  });

  // Botón aprobar cronograma en el modal de vista
  $("#btnAprobarCronograma").click(function () {
    cambiarEstadoCronograma('APROBADO');
  });

  // Recalcular montos al cambiar valores
  $("#precio_hectarea, #total_hectareas, #descuento, #adelanto").on("input", function () {
    recalcularMontos();
  });

  $("#modal-calendario").on("shown.bs.modal", function () {
    recalcularMontos();
  });

  $("#id_cliente").on("change", function () {
    var id_cliente = $(this).val();
    cargarFundosPorCliente(id_cliente);
  });

  $("#id_fundo").on("change", function () {
    var id_fundo_seleccionado = $(this).val();
    if (id_fundo_seleccionado !== "all" && fundosData.length > 0) {
      var fundoSeleccionado = fundosData.find(function (fundo) {
        return fundo.id_fundo == id_fundo_seleccionado;
      });

      if (fundoSeleccionado) {
        $("#total_hectareas").val(fundoSeleccionado.cantidad_hc);
        recalcularMontos();
      }
    } else {
      $("#total_hectareas").val(0);
      recalcularMontos();
    }
  });

  $("#cboMaquinariaBuscar").on("change", function () {
    const selectedValue = $(this).val();
    $("#id_maquinaria").val(selectedValue);
  });

  $("#cboClienteBuscar").on("change", function () {
    const selectedValue = $(this).val();
    $("#id_cliente").val(selectedValue);
    cargarFundosPorCliente(selectedValue);
  });

  $("#id_servicio").on("change", function () {
    if ($("#id_servicio").val() == "") {
      return false;
    }
    const json_servicio = $("#json_servicio").val();
    var data = JSON.parse(json_servicio);
    if (data && Array.isArray(data) && data.length > 0) {
      const service_selected = data.find((x) => x.id_servicio == $("#id_servicio").val());
      $("#label_precio").html("Precio por " + service_selected.unidad);
      $("#label_total").html("Total de " + service_selected.unidad);
      $("#precio_hectarea").val(service_selected.precio);
    }
  });

  $("#id_maquinaria").on("change", function () {
    if ($("#id_maquinaria").val() == "") {
      return false;
    }
    const json_maquinaria = $("#json_maquinaria").val();
    var data = JSON.parse(json_maquinaria);
    if (data && Array.isArray(data) && data.length > 0) {
      const maquinaria_selected = data.find((x) => x.id_maquinaria == $("#id_maquinaria").val());
      $("#id_operador").val(maquinaria_selected.id_trabajador);
    }
  });

  $("#id_unidad").on("change", function () {
    const servicioData = JSON.parse($("#json_servicio").val());
    const selectedUnidadId = $(this).val();
    const filteredServices = servicioData.filter((service) => service.id_tipo_servicio == selectedUnidadId);

    $("#id_servicio").empty().append('<option value="">Seleccione...</option>');

    filteredServices.forEach((service) => {
      $("#id_servicio").append(`<option value="${service.id_servicio}">${service.name_servicio} (${service.precio} x ${service.unidad})</option>`);
    });
  });

  $("#cboClienteBuscar").select2({
    placeholder: "Seleccione un cliente",
    allowClear: true,
  });

  $("#id_cliente").select2({
    placeholder: "Seleccione un cliente",
    allowClear: true,
    dropdownParent: $("#modal-calendario"),
  });
});


$(document).on('click', '#btnGuardarCambios', function () {
  const idCronograma = $('#id_cronograma').val();
  const fechaIngreso = $('#fecha_ingreso_edit').val();
  const horaIngreso = $('#hora_ingreso_edit').val();
  const fechaSalida = $('#fecha_salida_edit').val();
  const horaSalida = $('#hora_salida_edit').val();

  if (!fechaIngreso || !horaIngreso || !fechaSalida || !horaSalida) {
    Swal.fire('Error', 'Todos los campos de fecha y hora son obligatorios.', 'error');
    return;
  }

  $.ajax({
    url: "ajax.php?accion=actualizarFechasHoras", // Ruta al archivo PHP de backend
    type: 'POST',
    data: {
      action: 'updateFechasHoras',
      id_cronograma: idCronograma,
      fecha_ingreso: fechaIngreso,
      hora_ingreso: horaIngreso,
      fecha_salida: fechaSalida,
      hora_salida: horaSalida
    },
    success: function (response) {
      const res = JSON.parse(response);
      if (res.success) {
        Swal.fire('Éxito', res.message, 'success');
        $('#modal-calendario-show').modal('hide'); // Cierra el modal
        crearCalendario(); // Recargar calendario
      } else {
        Swal.fire('Error', res.message || 'No se pudo actualizar las fechas.', 'error');
      }
    },
    error: function () {
      Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
    }
  });
});

function crearCalendario() {
  $("#calendario").fullCalendar("destroy");
  var fundo = $("#cboFundoBuscar").val();
  var maquinaria = $("#cboMaquinariaBuscar").val();
  var operador = $("#cboMedicoBuscar").val();
  var cliente = $("#cboClienteBuscar").val();

  $("#calendario").fullCalendar({
    defaultView: "month",
    editable: true,
    selectable: true,
    locale: "es",
    header: {
      left: "prev,next today",
      center: "title",
      right: "month,agendaWeek,agendaDay",
    },
    select: function (start, end) {
      var fecha_ingreso = moment(start).format("YYYY-MM-DD");
      var hora_ingreso = moment(start).format("HH:mm");
      var fecha_salida = moment(end).format("YYYY-MM-DD");
      var hora_salida = moment(end).format("HH:mm");
      $("#fecha_ingreso").val(fecha_ingreso);
      $("#hora_ingreso").val(hora_ingreso);
      $("#fecha_salida").val(fecha_salida);
      $("#hora_salida").val(hora_salida);

      $("#modal-calendario").modal("show");
    },
    eventClick: function (event) {
      getCronograma(event.id);
    },
    eventDrop: function (event, delta, revertFunc) {
      actualizarFechaCronograma(event, revertFunc);
    },
    eventResize: function (event, delta, revertFunc) {
      actualizarFechaCronograma(event, revertFunc);
    },
    eventSources: [
      {
        url: "ajax.php?accion=showCronograma",
        type: "POST",
        data: {
          fundo: fundo,
          maquinaria: maquinaria,
          operador: operador,
          cliente: cliente,
          tipo_vista: "aprobacion"
        },
        success: function (events) {
          console.log(events);
          events.forEach(function (event) {
            event.estado_trabajo = event.estado_trabajo;
          });
        },

        error: function (e) {
          console.log(e.responseText);
        },
        color: "yellow",
        textColor: "black",
      },
    ],
    eventRender: function (event, element) {
      console.log(event);
      let description = `
          <br/>${event.description}
          <br/>Servicio: ${event.nombre_servicio}
          <br/>Cliente: ${event.nombre_cliente}
          <br/>Operador: ${event.nombre_operador}
          <br/>Maquinaria: ${event.nombre_maquinaria}
          <br/>Fundo: ${event.nombre_fundo}
      `;
      element.find(".fc-title").append(description);
    },
    loading: function (isLoading, view) {
      if (isLoading) {
        showHideLoader("block");
      } else {
        showHideLoader("none");
      }
    },
  });
}

function registrarCronograma() {
  Swal.fire({
    title: "¿Desea guardar este cronograma?",
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#22c63b",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, guardar",
  }).then(function (result) {
    if (result.value) {
      var form = $("#frmCronograma")[0];
      var formData = new FormData(form);

      $.ajax({
        type: "POST",
        url: "ajax.php?accion=registrarCronograma",
        contentType: false,
        processData: false,
        data: formData,
        beforeSend: function () {
          showHideLoader("block");
        },
        success: function (response) {
          try {
            console.log(response);
            var data = JSON.parse(response);
            if (data.error == "NO") {
              Swal.fire("Éxito", data.message, "success");
              $("#frmCronograma")[0].reset();
              $("#modal-calendario").modal("hide");
              crearCalendario();
            } else {
              Swal.fire("Error", data.message, "error");
            }
          } catch (e) {
            Swal.fire("Error", "Error en la respuesta del servidor: " + e, "error");
          }
        },
        error: function (xhr) {
          Swal.fire("Error", xhr.responseText, "error");
        },
        complete: function () {
          showHideLoader("none");
        },
      });
    }
  });
}

function getCronograma(id_cronograma) {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=getCronograma",
    data: { id_cronograma: id_cronograma },
    beforeSend: function () {
      showHideLoader("block");
    },
    success: function (response) {
      console.log(response);
      try {
        var data = typeof response === "string" ? JSON.parse(response) : response;
        if (data.error === "NO") {
          var info = data.data;
          console.log("Datos del cronograma:", info);

          $("#id_cronograma").val(info.id_cronograma);
          $("#fundo_show").val(info.nombre_fundo);
          $("#cliente_show").val(info.nombre_cliente);
          $("#operador_show").val(info.nombre_operador);
          $("#maquinaria_show").val(info.nombre_maquinaria);
          const fechaIngreso = moment(info.fecha_ingreso).format("YYYY-MM-DD");
          const horaIngreso = moment(info.fecha_ingreso).format("HH:mm");
          const fechaSalida = moment(info.fecha_salida).format("YYYY-MM-DD");
          const horaSalida = moment(info.fecha_salida).format("HH:mm");
          
          $("#fecha_ingreso_edit").val(fechaIngreso);
          $("#hora_ingreso_edit").val(horaIngreso);
          $("#fecha_salida_edit").val(fechaSalida);
          $("#hora_salida_edit").val(horaSalida);
          $("#estado_trabajo_show").val(info.estado_trabajo);


          mostrarOpcionesAprobacion(info);

          $("#modal-calendario-show").modal("show");
        } else {
          Swal.fire("Error", data.message, "error");
        }
      } catch (e) {
        Swal.fire("Error", "Error en la respuesta del servidor: " + e, "error");
      }
    },
    error: function (xhr) {
      Swal.fire("Error", xhr.responseText, "error");
    },
    complete: function () {
      showHideLoader("none");
    },
  });
}

function anularCronograma() {
  var id_cronograma = $("#id_cronograma").val();
  Swal.fire({
    title: "¿Seguro de anular este cronograma?",
    text: "No podrás revertir esta acción.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#22c63b",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, anular ahora",
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=eliminarCronograma",
        data: { id_cronograma: id_cronograma },
        beforeSend: function () {
          showHideLoader("block");
        },
        success: function (response) {
          try {
            var data = JSON.parse(response);
            if (data.error == "NO") {
              Swal.fire("Éxito", data.message, "success");
              $("#modal-calendario-show").modal("hide");
              crearCalendario();
            } else {
              Swal.fire("Error", data.message, "error");
            }
          } catch (e) {
            Swal.fire("Error", "Error en la respuesta del servidor: " + e, "error");
          }
        },
        error: function (xhr) {
          Swal.fire("Error", xhr.responseText, "error");
        },
        complete: function () {
          showHideLoader("none");
        },
      });
    }
  });
}

function actualizarFechaCronograma(event, revertFunc) {
  if (event.estado_trabajo === "EN PROCESO") {
    Swal.fire("Advertencia", "No se puede mover un cronograma en estado 'EN PROCESO'.", "warning");
    revertFunc();
    return;
  }

  var id_cronograma = event.id;
  var fecha_ingreso = moment(event.start).format("YYYY-MM-DD");
  var fecha_salida = event.end ? moment(event.end).format("YYYY-MM-DD") : fecha_ingreso;
  var hora_ingreso = moment(event.start).format("HH:mm");
  var hora_salida = event.end ? moment(event.end).format("HH:mm") : hora_ingreso;

  Swal.fire({
    title: "¿Actualizar fechas del cronograma?",
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#22c63b",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, actualizar ahora",
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=actualizarFechaCita",
        data: {
          id_cronograma: id_cronograma,
          fecha_ingreso: fecha_ingreso,
          hora_ingreso: hora_ingreso,
          fecha_salida: fecha_salida,
          hora_salida: hora_salida,
        },
        beforeSend: function () {
          showHideLoader("block");
        },
        success: function (response) {
          try {
            var data = JSON.parse(response);
            if (data.error == "NO") {
              Swal.fire("Éxito", data.message, "success");
              crearCalendario();
            } else {
              Swal.fire("Error", data.message, "error");
              revertFunc();
            }
          } catch (e) {
            Swal.fire("Error", "Error en la respuesta del servidor: " + e, "error");
            revertFunc();
          }
        },
        error: function (xhr) {
          Swal.fire("Error", xhr.responseText, "error");
          revertFunc();
        },
        complete: function () {
          showHideLoader("none");
        },
      });
    } else {
      revertFunc();
    }
  });
}

function recalcularMontos() {
  var precio = parseFloat($("#precio_hectarea").val()) || 0;
  var hectareas = parseFloat($("#total_hectareas").val()) || 0;
  var descuento = parseFloat($("#descuento").val()) || 0;
  var adelanto = parseFloat($("#adelanto").val()) || 0;

  var subtotal = precio * hectareas;
  var monto_total = subtotal - descuento;
  var saldo_por_pagar = monto_total - adelanto;

  $("#monto_total").val(monto_total.toFixed(2));
  $("#saldo_por_pagar").val(saldo_por_pagar.toFixed(2));
}

function cargarFundosPorCliente(id_cliente) {
  if (id_cliente == "all") {
    $("#id_fundo").html('<option value="all">Seleccione un cliente primero</option>');
    return;
  }

  $.ajax({
    type: "POST",
    url: "ajax.php?accion=showFundoCliente",
    data: { id_cliente: id_cliente },
    beforeSend: function () {
      showHideLoader("block");
    },
    success: function (response) {
      try {
        var data = JSON.parse(response);
        $("#id_fundo").empty();
        if (data.error == "NO") {
          fundosData = data.data;
          $("#id_fundo").append('<option value="all">Seleccione...</option>');
          data.data.forEach(function (fundo) {
            $("#id_fundo").append('<option value="' + fundo.id_fundo + '">' + fundo.nombre_fundo + " (" + fundo.cantidad_hc + " ha)</option>");
          });
        } else {
          fundosData = [];
          $("#id_fundo").append('<option value="all">' + data.message + "</option>");
        }
      } catch (e) {
        Swal.fire("Error", "Error en la respuesta del servidor: " + e, "error");
      }
    },
    error: function (xhr) {
      Swal.fire("Error", xhr.responseText, "error");
    },
    complete: function () {
      showHideLoader("none");
    },
  });
}

function cambiarEstadoCronograma(nuevoEstado) {
  var id_cronograma = $("#id_cronograma").val();
  var mensajeConfirmacion = "";

  switch (nuevoEstado) {
    case "ANULADO":
      mensajeConfirmacion = "¿Está seguro de anular este cronograma?";
      break;
    case "EN PROCESO":
      mensajeConfirmacion = "¿Iniciar el trabajo de este cronograma?";
      break;
    case "TERMINADO":
      mensajeConfirmacion = "¿Finalizar el trabajo de este cronograma?";
      break;
    case "APROBADO":
      mensajeConfirmacion = "¿Aprobar este cronograma?";
      break;
    default:
      console.error("Estado no válido");
      return;
  }

  Swal.fire({
    title: mensajeConfirmacion,
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#22c63b",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, confirmar",
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=cambiarEstadoCronograma",
        data: JSON.stringify({ id_cronograma: id_cronograma, estado: nuevoEstado }),
        contentType: "application/json",
        beforeSend: function () {
          showHideLoader("block");
        },
        success: function (response) {
          try {
            var data = typeof response === "object" ? response : JSON.parse(response);
            if (data.error == "NO") {
              Swal.fire("Éxito", data.message, "success");
              $("#modal-calendario-show").modal("hide");
              crearCalendario();
            } else {
              Swal.fire("Error", data.message, "error");
            }
          } catch (e) {
            Swal.fire("Error", "Error en la respuesta del servidor: " + e, "error");
          }
        },
        error: function (xhr) {
          Swal.fire("Error", xhr.responseText, "error");
        },
        complete: function () {
          showHideLoader("none");
        },
      });
    }
  });
}


function mostrarOpcionesAprobacion(info) {
  // Limpiar el contenedor de botones antes de agregar las nuevas opciones
  $("#accionesAprobacion").empty();

  if (info.estado_trabajo === "APROBADO") {
    // Botón para Anular el cronograma
    $("#accionesAprobacion").append(`
      <button type="button" class="btn btn-danger" id="btnAnularCronograma">Anular Cronograma</button>
      <button type="button" class="btn btn-success" id="btnIniciarTrabajo">Iniciar Trabajo</button>
    `);

    // Evento para Anular el cronograma
    $("#btnAnularCronograma").click(function () {
      cambiarEstadoCronograma("ANULADO");
    });

    // Evento para Iniciar Trabajo
    $("#btnIniciarTrabajo").click(function () {
      cambiarEstadoCronograma("EN PROCESO");
    });
  }

  if (info.estado_trabajo === "EN PROCESO") {
    $("#accionesAprobacion").append(`
      <button type="button" class="btn btn-primary" id="btnFinalizarTrabajo">Finalizar Trabajo</button>
    `);

    $("#btnFinalizarTrabajo").click(function () {
      cambiarEstadoCronograma("TERMINADO");
    });
  }

}



