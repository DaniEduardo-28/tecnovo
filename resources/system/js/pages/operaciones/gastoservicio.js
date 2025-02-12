var tableForm = $('#table_form').DataTable({
  language: languageSpanish,
  searching: false,
  ordering: false,
  lengthChange: false,
  paging: false,
  destroy: true,
  info: false,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_detalle_gastoserv' },
    { 'data': 'descripcion_gasto' },
    { 'data': 'monto_gastado' },
    { 'data': 'opcion' }
  ],
  columnDefs: [
    {
      "targets": [1],
      "visible": false,
      "searchable": false
    }
  ]
});


var tableListado = $('#tabla_listado').DataTable({
  language: languageSpanish,
  searching: false,
  ordering: false,
  lengthChange: false,
  paging: false,
  destroy: true,
  info: false,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_gasto_servicio' },
    { 'data': 'name_proveedor' },
    { 'data': 'name_usuario' },
    { 'data': 'fecha_emision' },
    { 'data': 'numero_documento' },
    { 'data': 'total' },
    { 'data': 'estado' },
    { 'data': 'opciones' }
  ],
  columnDefs: [
    {
      "targets": [1, 3],
      "visible": false,
      "searchable": false
    }
  ]
});

$(document).ready(function () {

  $("#contenedor_formulario").addClass("d-none");
  $("#contenedor_proveedor").addClass("d-none");

  $("#btnAdd").click(function () {
    $("#contenedor_formulario").removeClass("d-none");
    $("#contenedor_listado").addClass("d-none");
    $("#panelOptions").addClass("d-none");
    $("#accion").val("add");
    $("#txtEstadoForm").val("En proceso ...");
  });

  $("#btnCancelForm").click(function () {
    cancelarForm();
    $("#btnSaveForm").removeClass("d-none");
    $("#btnSeleccionarProveedor").removeClass("d-none");
  });

  $("#btnSeleccionarProveedor").click(function () {
    $("#contenedor_formulario").addClass("d-none");
    $("#contenedor_proveedor").removeClass("d-none");
    showDataProveedor();
  });

  $('#btnSearchProveedor').click(function () {
    showDataProveedor();
  });

  $("#txtBuscarProveedor").keypress(function (e) {
    if (e.which == 13) {
      showDataProveedor();
    }
  });


  $("#btnCancelarProveedor").click(function () {
    $("#contenedor_formulario").removeClass("d-none");
    $("#contenedor_proveedor").addClass("d-none");
    $("#id_proveedor").val("0");
    $('#img_proveedor').attr('src', "resources/global/images/sin_imagen.png");
    $("#name_proveedor").html("No Seleccionado");
  });


  $('#table_form tbody').on('click', '#btnDeleteProducto', function (e) {
    try {
      e.preventDefault();
      tableForm.row($(this).parents('tr')).remove().draw();
      actualizarnumeracion();
      calcularTotal();
    } catch (e) {
      runAlert("Error", "Error en TryCatch: " + e, "error");
    }
  });

  $('#table_form tbody').on('change', 'input', function (e) {
    try {
      calcularTotal();
    } catch (e) {
      runAlert("Error", "Error en TryCatch: " + e, "error");
    }
  });

  showData();

  $("#btnSaveForm").click(function (e) {
    try {
      var id_gasto_servicio = $("#id_gasto_servicio").val();
      var id_documento_venta = $("#id_documento_venta").val();
      var id_tipo_gasto = $("#id_tipo_gasto").val();  // <-- Agregar captura
      var accion = $('#accion').val();
      var id_proveedor = $("#id_proveedor").val();
      console.log("ID Proveedor antes de enviar:", id_proveedor);
      var fecha_emision = $("#txtFechaOrdenForm").val();
      var serie = $("#txtSerieForm").val();
      var correlativo = $("#txtCorrelativoForm").val();
      var total = $("#txtTotalForm").val();
      var codigo_moneda = $("#codigo_moneda").val();

      var countRows = tableForm.data().count();
      console.log("ID Tipo Gasto:", id_tipo_gasto); // <-- Verificar en consola
      console.log("ID Documento Venta:", id_documento_venta); // <-- Verificar en consola

      if (!id_tipo_gasto || id_tipo_gasto == "0") {
        runAlert("Error", "Debe seleccionar un motivo de gasto.", "warning");
        return;
      }

      if (!id_documento_venta || id_documento_venta == "0") {
        runAlert("Error", "Debe seleccionar un tipo de comprobante.", "warning");
        return;
      }

      if (id_proveedor == "0" || id_proveedor == "") {
        runAlert("Faltan Datos", "Debe seleccionar un proveedor.", "warning");
        return;
      }

      if (codigo_moneda == "" || codigo_moneda == "0") { // Verifica si el campo de moneda está vacío
        runAlert("Error", "Campo obligatorio: Moneda.", "warning");
        return;
      }

      if (countRows == 0) {
        runAlert("Faltan Datos", "Debe agregar al menos un gasto.", "warning");
        return;
      }

      var detalles = [];
      var objeto = {};

      $('#table_form > tbody  > tr').each(function () {
        var descripcion_gasto = $(this).find("td").eq(1).text().trim();
        var inputElement = $(this).find("td").eq(2).find("input");
        var monto_gastado = inputElement.length > 0 ? inputElement.val().trim() : "0";

        if (descripcion_gasto !== "" && !isNaN(parseFloat(monto_gastado))) {
          detalles.push({
            "descripcion_gasto": descripcion_gasto,
            "monto_gastado": monto_gastado
          });
        } else {
          console.warn("Registro ignorado por valores inválidos:", { descripcion_gasto, monto_gastado });
        }
      });

      objeto.datos = detalles;

      var form = 'id_proveedor=' + id_proveedor + '&fecha_emision=' + fecha_emision +
      '&accion=' + accion + '&serie=' + serie + '&correlativo=' + correlativo +
      "&total=" + total + "&codigo_moneda=" + codigo_moneda + "&id_tipo_gasto=" + id_tipo_gasto +
      "&id_documento_venta=" + id_documento_venta + "&array_detalle=" + JSON.stringify(objeto);

      Swal.fire({
        title: '¿Seguro de confirmar la operación?',
        text: "No podrás revertir esta operación.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22c63b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, realizar ahora!'
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "ajax.php?accion=goGastoServicio",
            datatype: "json",
            data: form,
            success: function (data) {
              try {
                var response = JSON.parse(data);
                if (response['error'] == "SI") {
                  runAlert("Error", response['message'], "warning");
                } else {
                  cancelarForm();
                  runAlert("Éxito", response['message'], "success");
                }
              } catch (e) {
                runAlert("Error", data + e, "error");
              }
            },
            error: function (data) {
              runAlert("Error", data, "error");
            },
            beforeSend: function (xhr) {
              showHideLoader('block');
            },
            complete: function (jqXHR, textStatus) {
              showHideLoader('none');
              showData();
            }
          });
        }
      });

    } catch (e) {
      runAlert("Error", "Error en Try Catch: " + e, "error");
    }
  });


  $('#btnBuscarListado').click(function () {
    showData();
  });

  $("#txtBuscarListado").keypress(function (e) {
    if (e.which == 13) {
      showData();
    }
  });

});

$(document).ready(function () {


  $('#btnAgregarDetalle').click(function () {
    $('#modalAgregarGasto').modal('show');
  });


  $('#btnGuardarGasto').click(function () {
    var descripcion = $('#descripcion_gasto').val().trim();
    var monto = parseFloat($('#monto_gastado').val().trim());

    if (descripcion === '' || isNaN(monto) || monto <= 0) {
      Swal.fire('Error', 'Ingrese una descripción y un monto válido.', 'warning');
      return;
    }

    var num = tableForm.data().count() + 1;
    tableForm.row.add({
      "num": num,
      "id_detalle_gastoserv": "",
      "descripcion_gasto": descripcion,
      "monto_gastado": `<input class="form-control" value="${monto.toFixed(2)}" type="number" min="0" step="0.01">`,
      "opcion": '<button type="button" class="btn btn-danger btn-sm" id="btnDeleteProducto"><i class="fa fa-trash"></i></button>'
    }).draw();

    $('#modalAgregarGasto').modal('hide');
    $('#descripcion_gasto').val('');
    $('#monto_gastado').val('');
    actualizarnumeracion();
    console.log("Llamando a calcularTotal()");
    calcularTotal();
  });

  $('#table_form tbody').on('click', '#btnDeleteProducto', function () {
    var fila = $(this).parents('tr');
    var montoEliminado = fila.find("td").eq(3).find("input").val();

    console.log("Eliminando fila con monto:", montoEliminado);

    tableForm.row(fila).remove().draw();
    actualizarnumeracion();

    console.log("Llamando a calcularTotal() después de eliminar");
    setTimeout(calcularTotal, 100);
  });

});

function actualizarnumeracion() {
  var rows = tableForm.rows().data();
  for (var i = 0; i < rows.length; i++) {
    tableForm.cell(i, 0).data(i + 1).draw();
  }
}

function cancelarForm() {
  $("#contenedor_formulario").addClass("d-none");
  $("#contenedor_listado").removeClass("d-none");
  $("#panelOptions").removeClass("d-none");
  $("#accion").val("");
  $("#txtTotalForm").val("S/ 0.00");
  $("#txtObservacionesForm").val("");
  $("#id_proveedor").val("0");
  $("#id_gasto_servicio").val("0");
  $('#img_proveedor').attr('src', "resources/global/images/sin_imagen.png");
  $("#name_proveedor").html("No Seleccionado");
  $("#form_datos")[0].reset();
  tableForm.rows().remove().draw();
  console.log("Llamando a calcularTotal()");
  calcularTotal();
}


function calcularTotal() {
  var suma_total = 0.00;

  console.log("Ejecutando calcularTotal()...");

  $('#table_form tbody tr').each(function () {
    var inputElement = $(this).find("td").eq(2).find("input");

    if (inputElement.length > 0) {
      var monto_gastado = inputElement.val();
      monto_gastado = monto_gastado ? monto_gastado.replace(/,/g, '') : '0';
      var monto = parseFloat(monto_gastado);

      console.log("Fila procesada - Monto capturado:", monto_gastado, "Monto convertido:", monto);

      if (!isNaN(monto)) {
        suma_total += monto;
      }
    } else {
      console.warn("No se encontró el input en esta fila:", $(this));
    }
  });

  console.log("Suma total calculada antes de mostrar:", suma_total);

  suma_total = suma_total.toFixed(2);
  $("#txtTotalForm").val(`S/ ${suma_total}`);
}



function showDataProveedor() {
  $("#tbody_proveedor").html("");
  $("#paginador_proveedor").addClass("d-none");
  paginador = $("#paginador_proveedor");
  var items = 9, numeros = 6;
  init_paginator(paginador, items, numeros);
  set_callback(get_data_callback);
  cargaPagina(0);
}

function get_data_callback() {
  var valor = $("#txtBuscarProveedor").val();
  var id_documento = $("#cboDocuProveedor").val();
  $.ajax({
    data: {
      limit: itemsPorPagina,
      offset: desde,
      valor: valor,
      id_documento: id_documento,
      estado: 1
    },
    beforeSend: function (xhr) {
      showHideLoader('block');
    },
    complete: function (jqXHR, textStatus) {
      showHideLoader('none');
      if (totalPaginas == 1 && pagina == 0) {
        paginador.find(".next_link").hide();
      }
    },
    type: "POST",
    url: "ajax.php?accion=showProveedor"
  }).done(function (data, textStatus, jqXHR) {
    try {
      var data1 = JSON.parse(data);
      if (data1["error"] == "NO") {
        if (pagina == 0) {
          creaPaginador(data1["cantidad"]);
        }

        // Generar la tabla de proveedores
        var innerdivHtml = "";
        var o = data1["data"];

        for (var i = 0; i < o.length; i++) {
          innerdivHtml += '<tr>';
          innerdivHtml += '<td>';
          innerdivHtml += '<div class="d-flex align-items-center">';
          innerdivHtml += '<div class="bg-img mr-4">';
          innerdivHtml += '<img src="' + o[i].src_imagen + '" class="img-fluid" alt="Proveedor">';
          innerdivHtml += '</div>';
          innerdivHtml += '<p class="font-weight-bold">' + o[i].apellidos + ' ' + o[i].nombres + '</p>';
          innerdivHtml += '</div>';
          innerdivHtml += '</td>';
          innerdivHtml += '<td>' + o[i].name_documento + '</td>';
          innerdivHtml += '<td>' + o[i].num_documento + '</td>';
          innerdivHtml += '<td>' + o[i].direccion_completa + '</td>';
          innerdivHtml += '<td>' + o[i].telefono + '</td>';
          innerdivHtml += '<td><button class="btn btn-sm btn-primary" onclick="seleccionarProveedor(' + o[i].id_proveedor + ', \'' + o[i].apellidos + ' ' + o[i].nombres + '\', \'' + o[i].src_imagen + '\')">Seleccionar</button></td>';
          innerdivHtml += '</tr>';
        }

        $("#paginador_proveedor").removeClass("d-none");
        $("#tbody_proveedor").html(innerdivHtml);
      } else {
        console.log(data1["message"]);
        $("#paginador_proveedor").addClass("d-none");
        $("#tbody_proveedor").html("");
      }
    }
    catch (err) {
      runAlert("Message", err + data, "warning");
      $("#paginador_proveedor").addClass("d-none");
      $("#tbody_proveedor").html("");
    }
  }).fail(function (jqXHR, textStatus, textError) {
    runAlert("Error", "Error al realizar la petición " + textError, "warning");
  });
}

function seleccionarProveedor(id_proveedor, proveedor, src_imagen) {
  $("#contenedor_formulario").removeClass("d-none");
  $("#contenedor_proveedor").addClass("d-none");
  $("#id_proveedor").val(id_proveedor);
  $('#img_proveedor').attr('src', src_imagen);
  $("#name_proveedor").html(proveedor);
}

function showData() {
  tableListado.clear().draw();
  $("#paginador_listado").addClass("d-none");
  paginador = $("#paginador_listado");
  var items = 10, numeros = 6;
  init_paginator(paginador, items, numeros);
  set_callback(get_data_callback2);
  cargaPagina(0);
}
function get_data_callback2() {
  tableListado.clear().draw();
  var fecha_inicio = $("#txtFechaInicioBuscarListado").val();
  var fecha_fin = $("#txtFechaFinBuscarListado").val();
  var tipo_busqueda = $("#cboTipoBuscarListado").val();
  var valor = $("#txtBuscarListado").val();

  $.ajax({
    type: "POST",
    url: "ajax.php?accion=showGastoServicio",
    data: {
      limit: itemsPorPagina,
      offset: desde,
      valor: valor,
      tipo_busqueda: tipo_busqueda,
      fecha_fin: fecha_fin,
      fecha_inicio: fecha_inicio
    },
    dataType: "json",  // Asegura que la respuesta se interprete directamente como JSON
    beforeSend: function () {
      showHideLoader('block');
    },
    complete: function () {
      showHideLoader('none');
      if (totalPaginas === 1 && pagina === 0) {
        paginador.find(".next_link").hide();
      }
    }
  }).done(function (data) {
    try {
      if (typeof data !== "object") {
        console.warn("La respuesta no es un objeto JSON válido, intentando parsear...");
        data = JSON.parse(data);
      }

      console.log("Respuesta del servidor:", data);

      if (data.error === "NO") {
        if (pagina === 0) {
          creaPaginador(data.cantidad);
        }

        var o = data.data;
        if (!Array.isArray(o)) {
          console.warn("La respuesta no contiene un array válido en 'data'.");
          return;
        }

        for (var i = 0; i < o.length; i++) {
          tableListado.row.add({
            "num": o[i].num || "-",
            "id_gasto_servicio": o[i].id_gasto_servicio || "-",
            "name_proveedor": o[i].name_proveedor || "Desconocido",
            "name_usuario": o[i].name_usuario || "Desconocido",
            "fecha_emision": o[i].fecha_emision || "-",
            "numero_documento": o[i].numero_documento || "-",
            "total": o[i].total || "0.00",
            "estado": o[i].estado || "-",
            "opciones": o[i].options || ""
          }).draw();
        }

        $("#paginador_listado").removeClass("d-none");
      } else {
        console.warn("Error en la respuesta del servidor:", data.message);
        runAlert("Error", data.message, "warning");
      }
    }
    catch (err) {
      console.error("Error al procesar la respuesta JSON:", err);
      runAlert("Error", "Ocurrió un error al procesar la respuesta del servidor.", "error");
    }
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("Error en la petición AJAX:", jqXHR.responseText);
    runAlert("Oh No...!!!", "Error al realizar la petición: " + textStatus, "warning");
  });
}

function getDataEdit(id_gasto_servicio) {
  try {
    cancelarForm();

    $.ajax({
      type: "POST",
      data: {
        id_gasto_servicio: id_gasto_servicio
      },
      url: "ajax.php?accion=getDataEditGastoServicio",
      success: function (data) {
        try {
          var data1 = JSON.parse(data);
          if (data1["error"] == "NO") {
            var o = data1["data"];
            $("#id_gasto_servicio").val(o[0].id_gasto_servicio);
            $("#id_proveedor").val(o[0].id_proveedor);
            $("#name_proveedor").html(o[0].name_proveedor);
            $('#img_proveedor').attr('src', o[0].src_imagen_proveedor);
            $("#txtFechaOrdenForm").val(o[0].fecha_emision);
            $("#txtSerieForm").val(o[0].serie);
            $("#txtCorrelativoForm").val(o[0].correlativo);
            $("#txtObservacionesForm").val(o[0].observaciones);
            $("#txtEstadoForm").val(o[0].estado);
            $("#codigo_moneda").val(o[0].id_moneda);

            for (var i = 0; i < o.length; i++) {
              tableForm.row.add({
                "num": i + 1,
                "id_detalle_gastoserv": o[i].id_detalle_gastoserv,
                "descripcion_gasto": o[i].descripcion_gasto,
                "monto_gastado": '<input class="form-control" value="' + o[i].monto_gastado + '" step="0.10" type="number" min="0">',
                "opcion": '<button type="button" class="btn btn-danger" id="btnDeleteProducto"><span class="fa fa-close"></span></button>',
              }).draw();
            }

            $("#contenedor_formulario").removeClass("d-none");
            $("#contenedor_listado").addClass("d-none");
            $("#panelOptions").addClass("d-none");
            $("#accion").val("edit");
            $("#txtEstadoForm").val("En proceso ...");
          } else {
            runAlert("Message", data1["message"], "warning");
          }
        } catch (e) {
          runAlert("Oh No...!!!", "Error en TryCatch: " + e + data, "error");
          showHideLoader('none');
        }
      },
      beforeSend: function (xhr) {
        showHideLoader('block');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        runAlert("Oh No...!!!", "Error de petición: " + jqXHR, "warning");
      },
      complete: function (jqXHR, textStatus) {
        showHideLoader('none');
      }
    });

  } catch (e) {
    runAlert("Oh No...!!!", "Error Try Catch " + e, "warning");
  }
}
function verRegistro(id_gasto_servicio) {
  try {
    cancelarForm();

    $.ajax({
      type: "POST",
      data: {
        id_gasto_servicio: id_gasto_servicio
      },
      url: "ajax.php?accion=getDataVerGastoServicio",
      success: function (data) {
        try {
          var data1 = JSON.parse(data);
          if (data1["error"] == "NO") {
            var o = data1["data"];
            $("#id_gasto_servicio").val(o[0].id_gasto_servicio);
            $("#id_proveedor").val(o[0].id_proveedor);
            $("#name_proveedor").html(o[0].name_proveedor);
            $('#img_proveedor').attr('src', o[0].src_imagen_proveedor);
            $("#txtFechaOrdenForm").val(o[0].fecha_emision);
            $("#txtSerieForm").val(o[0].serie);
            $("#txtCorrelativoForm").val(o[0].correlativo);
            $("#txtObservacionesForm").val(o[0].observaciones);
            $("#txtEstadoForm").val(o[0].estado);
            $("#codigo_moneda").val(o[0].id_moneda);

            for (var i = 0; i < o.length; i++) {
              tableForm.row.add({
                "num": i + 1,
                "id_detalle_gastoserv": o[i].id_detalle_gastoserv,
                "descripcion_gasto": o[i].descripcion_gasto,
                "monto_gastado": '<input class="form-control" value="' + o[i].monto_gastado + '" step="0.10" type="number" min="0" disabled>',
                "opcion": '',
              }).draw();
            }

            $("#contenedor_formulario").removeClass("d-none");
            $("#contenedor_listado").addClass("d-none");
            $("#panelOptions").addClass("d-none");
            $("#accion").val("ver");

            $("#btnSaveForm").addClass("d-none");
            $("#btnSeleccionarProveedor").addClass("d-none");

          } else {
            runAlert("Message", data1["message"], "warning");
          }
        } catch (e) {
          runAlert("Oh No...!!!", "Error en TryCatch: " + e + data, "error");
          showHideLoader('none');
        }
      },
      beforeSend: function (xhr) {
        showHideLoader('block');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        runAlert("Oh No...!!!", "Error de petición: " + jqXHR, "warning");
      },
      complete: function (jqXHR, textStatus) {
        showHideLoader('none');
      }
    });

  } catch (e) {
    runAlert("Oh No...!!!", "Error Try Catch " + e, "warning");
  }
}
function deleteRegistro(id_gasto_servicio) {
  try {
    var parametros = {
      "id_gasto_servicio": id_gasto_servicio
    };

    Swal.fire({
      title: '¿Seguro de anular el gasto de servicio seleccionado?',
      text: "No podrás revertir esta operación.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, Anular ahora!'
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=deleteGastoServicio",
          datatype: "json",
          data: parametros,
          success: function (data) {
            try {
              var response = JSON.parse(data);
              if (response['error'] == "SI") {
                runAlert("Oh No...!!!", response['message'], "warning");
              } else {
                showData();
                runAlert("Bien hecho...!!!", response['message'], "success");
              }
            } catch (e) {
              runAlert("Oh No...!!!", e, "error");
            }
          },
          error: function (data) {
            runAlert("Oh No...!!!", "Error al procesar la solicitud.", "error");
          },
          beforeSend: function () {
            showHideLoader('block');
          },
          complete: function () {
            showHideLoader('none');
          }
        });
      }
    });

  } catch (e) {
    runAlert("Oh No...!!!", "Error en TryCatch: " + e, "error");
  }
}
function eliminarRegistro(id_gasto_servicio) {
  try {
    var parametros = {
      "id_gasto_servicio": id_gasto_servicio
    };

    Swal.fire({
      title: '¿Seguro de eliminar el gasto de servicio de forma definitiva?',
      text: "Esta operación no podrá ser revertida.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar ahora!'
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=eliminarGastoServicio",
          datatype: "json",
          data: parametros,
          success: function (data) {
            try {
              var response = JSON.parse(data);
              if (response['error'] === "SI") {
                runAlert("Error", response['message'], "warning");
              } else {
                showData();
                runAlert("Éxito", response['message'], "success");
              }
            } catch (e) {
              runAlert("Error de Sistema", e, "error");
            }
          },
          error: function (data) {
            runAlert("Error", "Ocurrió un error al procesar la solicitud.", "error");
          },
          beforeSend: function () {
            showHideLoader('block');
          },
          complete: function () {
            showHideLoader('none');
          }
        });
      }
    });
  } catch (e) {
    runAlert("Error de Sistema", "Ocurrió un error inesperado: " + e, "error");
  }
}

