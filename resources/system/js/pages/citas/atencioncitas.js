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

$('#fecha_salida_edit').on('change', function () {
  const fechaSalida = $(this).val();
  if (fechaSalida) {
    const fechaPago = moment(fechaSalida).add(10, 'days').format('YYYY-MM-DD');
    $('#fecha_pago_edit').val(fechaPago);
  }
});

$(document).ready(function () {
  $("#btnExportarPDF").on("click", function () {
      var id_cronograma = $("#id_cronograma").val();
      if (id_cronograma) {
          generarResumenCompras(id_cronograma);
      } else {
          alert("No se encontró el ID del cronograma.");
      }
  });
});

function generarResumenCompras(id_cronograma) {
  try {
    if (!id_cronograma) {
      console.error("El ID del cronograma es requerido para generar el resumen de compras.");
      return;
    }

    const link = "?view=resumencomprasserviciopdf&id_cronograma=" + id_cronograma;
    window.open(link, "_blank");
  } catch (e) {
    console.error("Error al generar el resumen de compras en PDF:", e);
  }
}


$("#monto_unitario_edit, #cantidad_edit, #descuento_edit, #adelanto_edit").on("input", function () {
  recalcularMontos();
});

$(document).on('click', '#btnGuardarCambios', function () {
  const idCronograma = $('#id_cronograma').val();
  const fechaIngreso = $('#fecha_ingreso_edit').val();
  const horaIngreso = $('#hora_ingreso_edit').val();
  const fechaSalida = $('#fecha_salida_edit').val();
  const horaSalida = $('#hora_salida_edit').val();
  const fechaPago = $('#fecha_pago_edit').val();
  const horaPago = $('#hora_pago_edit').val();

  const cantidad = $('#cantidad_edit').val();
  const montoUnitario = $('#monto_unitario_edit').val();
  const descuento = $('#descuento_edit').val();
  const adelanto = $('#adelanto_edit').val();
  const montoTotal = $('#monto_total_edit').val();
  const saldoPorPagar = $('#saldo_por_pagar_edit').val();

  if (!idCronograma || !fechaIngreso || !horaIngreso || !fechaSalida || !horaSalida || !fechaPago || !horaPago ||
    !cantidad || !montoUnitario || !montoTotal || !saldoPorPagar) {
    Swal.fire('Error', 'Todos los campos son obligatorios.', 'error');
    return;
  }

  Swal.fire({
    title: '¿Actualizar fechas y/o montos del cronograma?',
    text: 'Esta acción no se puede deshacer.',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#22c63b',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, actualizar ahora',
  }).then((result) => {
    if (result.value) {

      $.ajax({
        url: "ajax.php?accion=actualizarFechasHoras", // Ruta al archivo PHP de backend
        type: 'POST',
        data: {
          action: 'updateFechasHoras',
          id_cronograma: idCronograma,
          fecha_ingreso: fechaIngreso,
          hora_ingreso: horaIngreso,
          fecha_salida: fechaSalida,
          hora_salida: horaSalida,
          fecha_pago: fechaPago,
          hora_pago: horaPago,
          cantidad: cantidad,
          monto_unitario: montoUnitario,
          descuento: descuento,
          adelanto: adelanto,
          monto_total: montoTotal,
          saldo_por_pagar: saldoPorPagar,
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
      right: "month,basicWeek,agendaDay",
    },
    views: {
      month: {
        displayEventTime: false,
        tittleFormat: 'MMMM YYYY',
      },
      basicWeek: {
        displayEventTime: false,
        tittleFormat: '[Semana] W - YYYY',
      },
    },
    select: function (start, end) {
      var fecha_ingreso = moment(start).format("YYYY-MM-DD");
      var hora_ingreso = moment(start).format("HH:mm");
      var fecha_salida = moment(end).format("YYYY-MM-DD");
      var hora_salida = moment(end).format("HH:mm");
      var fecha_pago = moment(end).add(10, 'days').format("YYYY-MM-DD");

      $("#fecha_ingreso").val(fecha_ingreso);
      $("#hora_ingreso").val(hora_ingreso);
      $("#fecha_salida").val(fecha_salida);
      $("#hora_salida").val(hora_salida);
      $("#fecha_pago").val(fecha_pago);
      $("#hora_pago").val("00:00");

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
      console.log("mostrar eventos",event);
      let description = `
      <br/>C: ${event.nombre_cliente}   
      <br/>O: ${event.nombre_operador} 
      <br/>S: ${event.nombre_servicio}
      <br/>${event.description}
      <br/>F: ${event.nombre_fundo}
      `;
      element.find(".fc-title").append(description);

      if (event.estado === "EN PROCESO") {
        element.css("color", "black");
        element.find(".fc-title").css("color", "black");
        element.find(".fc-content").css("color", "black");
        element.find(".fc-event").css("color", "black");
        element.find(".fc-time").css("color", "black");
    }
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

function actualizarVistaFechas(estadoTrabajo) {
  if (estadoTrabajo === "TERMINADO") {
    // Mostrar campos 'show' y ocultar campos 'edit'
    $('#fecha_ingreso_show').closest('.form-group').show();
    $('#fecha_salida_show').closest('.form-group').show();
    $('#fecha_pago_show').closest('.form-group').show();

    $('#fecha_ingreso_edit').closest('.form-group').hide();
    $('#hora_ingreso_edit').closest('.form-group').hide();
    $('#fecha_salida_edit').closest('.form-group').hide();
    $('#hora_salida_edit').closest('.form-group').hide();
    $('#fecha_pago_edit').closest('.form-group').hide();
    $('#hora_pago_edit').closest('.form-group').hide();

    $('#cantidad_edit').closest('.form-group').hide();
    $('#monto_unitario_edit').closest('.form-group').hide();
    $('#descuento_edit').closest('.form-group').hide();
    $('#adelanto_edit').closest('.form-group').hide();

    $("#btnGuardarCambios").hide();
  } else {
    // Ocultar campos 'show' y mostrar campos 'edit'
    $('#fecha_ingreso_show').closest('.form-group').hide();
    $('#fecha_salida_show').closest('.form-group').hide();
    $('#fecha_pago_show').closest('.form-group').hide();

    $('#fecha_ingreso_edit').closest('.form-group').show();
    $('#hora_ingreso_edit').closest('.form-group').show();
    $('#fecha_salida_edit').closest('.form-group').show();
    $('#hora_salida_edit').closest('.form-group').show();
    $('#fecha_pago_edit').closest('.form-group').show();
    $('#hora_pago_edit').closest('.form-group').show();

    $("#btnGuardarCambios").show();
  }
}

function cargarDatosCronograma(info) {
  // Llenar los campos con los datos del cronograma
  $("#fecha_ingreso_show").val(moment(info.fecha_ingreso).format("YYYY-MM-DD HH:mm"));
  $("#fecha_salida_show").val(moment(info.fecha_salida).format("YYYY-MM-DD HH:mm"));
  $("#fecha_pago_show").val(
    info.fecha_pago
      ? moment(info.fecha_pago).format("YYYY-MM-DD HH:mm")
      : moment(info.fecha_salida).add(10, "days").format("YYYY-MM-DD HH:mm")
  ).closest(".form-group").show();

  $("#fecha_ingreso_edit").val(moment(info.fecha_ingreso).format("YYYY-MM-DD"));
  $("#hora_ingreso_edit").val(moment(info.fecha_ingreso).format("HH:mm"));
  $("#fecha_salida_edit").val(moment(info.fecha_salida).format("YYYY-MM-DD"));
  $("#hora_salida_edit").val(moment(info.fecha_salida).format("HH:mm"));
  $("#fecha_pago_edit").val(
    info.fecha_pago
      ? moment(info.fecha_pago).format("YYYY-MM-DD")
      : moment(info.fecha_salida).add(10, "days").format("YYYY-MM-DD")
  );
  $("#hora_pago_edit").val(
    info.fecha_pago
      ? moment(info.fecha_pago).format("HH:mm")
      : "00:00"
  );

  $("#label_precio_vista").html("Precio por " + info.unidad_servicio);
  $("#label_total_vista").html("Total de " + info.unidad_servicio);


  $("#cantidad_edit").val(info.cantidad);
    $("#monto_unitario_edit").val(info.monto_unitario);
    $("#descuento_edit").val(info.descuento);
    $("#adelanto_edit").val(info.adelanto);
    $("#monto_total_edit").val(info.monto_total);
    $("#saldo_por_pagar_edit").val(info.saldo_por_pagar);

  actualizarVistaFechas(info.estado_trabajo);
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
          $("#estado_trabajo_show").val(info.estado_trabajo);

          obtenerCantidadDisponible(info.id_cronograma);

          cargarDatosCronograma(info);

          if (info.estado_trabajo === "REGISTRADO") {
            $("#btnAprobarCronograma").show();
            $("#btnAnularCronograma").hide();
          } else if (info.estado_trabajo === "TERMINADO") {
            $("#btnAprobarCronograma").hide();
            $("#btnAnularCronograma").hide();
          } else {
            $("#btnAprobarCronograma").hide();
            $("#btnAnularCronograma").show();
          }


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

function obtenerCantidadDisponible(id_cronograma) {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=getCantidadDisponible",
    data: { id_cronograma: id_cronograma },
    success: function (response) {
      try {
        const data = JSON.parse(response);
        if (data.error === "NO") {
          let cantidadDisponible = parseFloat(data.cantidad);
          if (isNaN(cantidadDisponible)) {
            cantidadDisponible = 0;
          }
          console.log(`Cantidad disponible del cronograma (${id_cronograma}):`, cantidadDisponible);

          $("#id_cronograma").data("cantidad_disponible", cantidadDisponible);
        } else {
          console.error("Error al obtener la cantidad disponible:", data.message);
        }
      } catch (e) {
        console.error("Error al procesar la respuesta de cantidad disponible:", e);
      }
    },
    error: function () {
      console.error("No se pudo conectar con el servidor para obtener la cantidad disponible.");
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

  const montoUnitario = parseFloat($("#monto_unitario_edit").val()) || 0;
    const cantidadEdit = parseFloat($("#cantidad_edit").val()) || 0;
    const descuentoEdit = parseFloat($("#descuento_edit").val()) || 0;
    const adelantoEdit = parseFloat($("#adelanto_edit").val()) || 0;

    const subTotal = montoUnitario * cantidadEdit;
    const montoTotal = subTotal - descuentoEdit;
    const saldoPorPagar = montoTotal - adelantoEdit;

  var subtotal = precio * hectareas;
  var monto_total = subtotal - descuento;
  var saldo_por_pagar = monto_total - adelanto;

  $("#monto_total").val(monto_total.toFixed(2));
  $("#saldo_por_pagar").val(saldo_por_pagar.toFixed(2));

  $("#monto_total_edit").val(montoTotal.toFixed(2));
    $("#saldo_por_pagar_edit").val(saldoPorPagar.toFixed(2));
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

  if (nuevoEstado === "EN PROCESO"){
    var estadoActual = $("#estado_trabajo").val();

    if (estadoActual === "TERMINADO"){
      mensajeConfirmacion = "¿Está seguro de revertir el estado de TERMINADO a EN PROCESO?";
    } else {
      mensajeConfirmacion = "¿Iniciar el trabajo de este cronograma?";
    }
  } else {
  switch (nuevoEstado) {
    case "ANULADO":
      mensajeConfirmacion = "¿Está seguro de anular este cronograma?";
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
  $("#accionesAprobacion").empty();

  if (info.estado_trabajo === "APROBADO") {
    $("#accionesAprobacion").append(`
      <button type="button" class="btn btn-warning" id="btnAnularCronograma"><i class="fa fa-ban"></i> Anular</button>
      <button type="button" class="btn btn-success" id="btnIniciarTrabajo"><i class="fa fa-check"></i> Iniciar Trabajo</button>
    `);

    $("#btnAnularCronograma").click(function () {
      cambiarEstadoCronograma("ANULADO");
    });

    $("#btnIniciarTrabajo").click(function () {
      cambiarEstadoCronograma("EN PROCESO");
    });
  }

  if (info.estado_trabajo === "EN PROCESO") {
    $("#accionesAprobacion").append(`
      <button type="button" class="btn btn-warning" id="btnAnularCronograma"><i class="fa fa-ban"></i> Anular</button>
      <button type="button" class="btn btn-primary" id="btnFinalizarTrabajo"><i class="fa fa-check"></i> Finalizar Trabajo</button>
    `);

    $("#btnAnularCronograma").click(function () {
      cambiarEstadoCronograma("ANULADO");
    });

    $("#btnFinalizarTrabajo").click(function () {
      cambiarEstadoCronograma("TERMINADO");
    });
    
  }

  if (info.estado_trabajo === "TERMINADO") {
    $("#accionesAprobacion").append(`
      <button type="button" class="btn btn-primary" id="btnRevertirProceso"><i class="fa fa-refresh"></i> Revertir Proceso</button>
    `);

    $("#btnRevertirProceso").click(function () {
      cambiarEstadoCronograma("EN PROCESO");
    });
    
  }

}



