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
    anularCronograma();
  });

  // Recalcular montos al cambiar valores
  $("#precio_hectarea, #total_hectareas, #descuento, #adelanto").on("input", function () {
    recalcularMontos();
  });

  // Recalcular montos al mostrar el modal
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
});

function crearCalendario() {
  $('#calendario').fullCalendar('destroy');
  var fundo = $("#cboFundoBuscar").val();
  var maquinaria = $("#cboMaquinariaBuscar").val();
  var operador = $("#cboMedicoBuscar").val();
  var cliente = $("#cboClienteBuscar").val();

  $("#calendario").fullCalendar({
    defaultView: "agendaWeek",
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
      var hoy = moment().startOf("day");
      var seleccion = moment(start);
      if (seleccion.isBefore(hoy)) {
        Swal.fire("Advertencia", "No puedes crear cronogramas en fechas pasadas.", "warning");
        $("#calendario").fullCalendar("unselect");
        return;
      }

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
        },
        error: function(e) {
          console.log(e);
        },
        color: "yellow",
        textColor: "black",
      },
    ],
    eventRender: function(event, element) {
      element.find('.fc-title').append("<br/>" + event.description);
    },
    loading: function( isLoading, view ) {
      if(isLoading) {
        showHideLoader('block');
      } else {
        showHideLoader('none');
      }
    }
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
            if (data.error === "NO") {
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
      try {
        var data = JSON.parse(response);
        if (data.error === "NO") {
          var info = data.data[0];
          $("#id_cronograma").val(info.id_cronograma);
          $("#fundo_show").val(info.fundo);
          $("#cliente_show").val(info.cliente);
          $("#operador_show").val(info.operador);
          $("#maquinaria_show").val(info.maquinaria);
          $("#fecha_ingreso_show").val(info.fecha_ingreso);
          $("#fecha_salida_show").val(info.fecha_salida);
          $("#estado_trabajo_show").val(info.estado_trabajo);

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
            if (data.error === "NO") {
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
  var id_cronograma = event.id;
  var fecha_ingreso = moment(event.start).format("YYYY-MM-DD");
  var fecha_salida = event.end ? moment(event.end).format("YYYY-MM-DD") : fecha_ingreso;
  var hora_ingreso = moment(event.start).format("HH:mm");
  var hora_salida = event.end ? moment(event.end).format("HH:mm") : hora_ingreso;

  var hoy = moment().startOf("day");
  var seleccion = moment(event.start);
  if (seleccion.isBefore(hoy)) {
    Swal.fire("Advertencia", "No puedes establecer cronogramas en fechas pasadas.", "warning");
    revertFunc();
    return;
  }

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
        url: "ajax.php?accion=actualizarCronograma",
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
            if (data.error === "NO") {
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
  if (id_cliente === "all") {
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
        if (data.error === "NO") {
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
