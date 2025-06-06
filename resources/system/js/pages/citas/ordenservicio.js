var table = $('#example').DataTable({
  language: languageSpanish,
  destroy: true,
  data: [],
  columns: [
    { 'data': 'num' },
    { 'data': 'opciones' },
    { 'data': 'codigo' },
    { 'data': 'total' },
    { 'data': 'gastos' },
    { 'data': 'ganancia' },
    { 'data': 'id_cronograma' },
    { 'data': 'nombre_fundo' },
    { 'data': 'nombre_cliente' },
    { 'data': 'nombre_servicio' },
    { 'data': 'cant_medida' },
    { 'data': 'nombre_operador' },
    { 'data': 'nombre_maquinaria' },
    { 'data': 'fecha_ingreso' },
    { 'data': 'fecha_salida' },
    { 'data': 'estado_trabajo' }
  ],
  columnDefs: [
    {
      "targets": [6],
      "visible": false,
      "searchable": true
    }
  ],
  order: [[1, 'asc']]
});

// PUNTO ANTES DEL GRAN CAMBIO

// Variables globales para almacenar las opciones originales de los filtros
let usuariosOriginales = [];
let tablasOriginales = [];

$(document).ready(function () {
  // Inicializar filtros
  initializeFilters();

  setDefaultDates();

  // Eventos de cambio para los filtros
  $("#txtFechaInicio").change(showLista);
  $("#txtFechaFin").change(showLista);
  $("#filterUser").change(showLista);
  $("#filterTable").change(showLista);
  $("#cboClienteBuscar").change(showLista);
  $("#cboFundoBuscar").change(showLista);
  $("#cboMaquinariaBuscar").change(showLista);
  $("#cboMedicoBuscar").change(showLista);
  $("#cboUnidadBuscar").change(showLista);


  $("#btnNuevoOperadorMaquinaria").click(function () {
    $("#nuevoOperadorMaquinariaContainer").show();
    $("#btnNuevoOperadorMaquinaria").hide();
  });

  $("#nuevoOperadorMaquinariaContainer .btn-danger").click(function () {
    $("#nuevoOperadorMaquinariaContainer").hide();
    $("#btnNuevoOperadorMaquinaria").show();
    limpiarCamposNuevoOperadorMaquinaria();
  });

  $("#cboClienteBuscar").on("change", function () {
    const selectedValue = $(this).val();
    $("#id_cliente").val(selectedValue);
  });

  $("#cboClienteBuscar").select2({
    placeholder: "Seleccione un cliente",
    allowClear: true,
  });

  $("#btnNuevoPago").click(function () {
    $("#nuevoPagoContainer").show();
    $("#btnNuevoPago").hide();
  });

  $("#nuevoPagoContainer .btn-danger").click(function () {
    $("#nuevoPagoContainer").hide();
    $("#btnNuevoPago").show();
    limpiarCamposNuevoPago();
  });

  $(".btnCancelarOperadorMaquinaria").click(function () {
    const idCronograma = $("#id_cronograma").val();

    if (!idCronograma || idCronograma === "0") {
      console.error("ID de cronograma no válido al cancelar.");
      return;
    }

    $("#nuevoOperadorMaquinariaContainer").hide();
    $("#btnNuevoOperadorMaquinaria").show();

    cargarOperadoresMaquinariasExistentes(idCronograma)
      .then(() => {
        console.log("Datos recargados correctamente tras cancelar.");
      })
      .catch((error) => {
        console.error("Error al recargar los datos tras cancelar:", error);
      });
  });


  $("#frmOperadorMaquinaria").submit(function (e) {
    e.preventDefault();

    const idUnidadMedida = $("#id_cronograma").data("unidad_medida"); // Obtener la unidad de medida
    if (idUnidadMedida == 4) {
      saveOperadorMaquinariaC();
      return;
    }

    const nuevasHectareas = parseFloat($("#horas_trabajadas").val()) || 0;

    if (!validateCantidadHectareas(nuevasHectareas)) {
      return; // Detén el guardado si la validación falla
    }

    saveOperadorMaquinariaC(); // Proceder con el guardado
  });

  $("#frmPago").submit(function (e) {
    e.preventDefault();
    savePago();
  });

  $("#horas_trabajadas, #pago_por_hora").on("input", function () {
    const horas_trabajadas = parseFloat($("#horas_trabajadas").val()) || 0;
    const pago_por_hora = parseFloat($("#pago_por_hora").val()) || 0;
    const total = horas_trabajadas * pago_por_hora;
    $("#total_pago").val(total.toFixed(2)); // Mostrar el total con 2 decimales
  });

  $("#petroleo_entrada, #petroleo_salida, #precio_petroleo").on("input", function () {
    const petroleoEntrada = parseFloat($("#petroleo_entrada").val()) || 0;
    const petroleoSalida = parseFloat($("#petroleo_salida").val()) || 0;
    const precioPetroleo = parseFloat($("#precio_petroleo").val()) || 0;

    const consumoPetroleo = petroleoEntrada - petroleoSalida;
    const pagoPetroleo = consumoPetroleo * precioPetroleo;

    $("#consumo_petroleo").val(consumoPetroleo.toFixed(2));
    $("#pago_petroleo").val(pagoPetroleo.toFixed(2));
  });

  // Mostrar la lista inicial
  showLista();
});

$('#btnReportePdf').click(function () {
  try {
    // Obtener los filtros seleccionados
    const cliente = $("#cboClienteBuscar").val();
    const fundo = $("#cboFundoBuscar").val();
    const maquinaria = $("#cboMaquinariaBuscar").val();
    const operador = $("#cboMedicoBuscar").val();
    const unidadNegocio = $("#cboUnidadBuscar").val();

    // Generar link para el reporte PDF
    const link = "?view=reporteordenserviciopdf&cliente=" + cliente + "&fundo=" + fundo + "&maquinaria=" + maquinaria + "&operador=" + operador + "&unidadNegocio=" + unidadNegocio;
    window.open(link);
  } catch (e) {
    console.error("Error al generar el reporte PDF:", e);
  }
});

$('#btnReporteExcel').click(function () {
  try {
    // Obtener los filtros seleccionados
    const fecha_inicio = $("#txtFechaInicio").val();
    const fecha_fin = $("#txtFechaFin").val();
    const cliente = $("#cboClienteBuscar").val();
    const fundo = $("#cboFundoBuscar").val();
    const maquinaria = $("#cboMaquinariaBuscar").val();
    const operador = $("#cboMedicoBuscar").val();
    const unidadNegocio = $("#cboUnidadBuscar").val();

    // Generar link para el reporte Excel
    const link = "?view=reporteordenservicioexcel&cliente=" + cliente + "&fundo=" + fundo + "&maquinaria=" + maquinaria + "&operador=" + operador + "&unidadNegocio=" + unidadNegocio;
    window.open(link, '_blank');
  } catch (e) {
    console.error("Error al generar el reporte Excel:", e);
  }
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

function generarInformeCliente(id_cronograma) {
  try {
    if (!id_cronograma) {
      console.error("El ID del cronograma es requerido para generar el informe al cliente.");
      return;
    }

    const link = "?view=informeclienteserviciopdf&id_cronograma=" + id_cronograma;
    window.open(link, "_blank");
  } catch (e) {
    console.error("Error al generar el informe al cliente en PDF:", e);
  }
}


// Función para configurar las fechas predeterminadas
function setDefaultDates() {
  const today = new Date();
  const lastMonth = new Date();
  lastMonth.setDate(today.getDate() - 30);

  $("#txtFechaInicio").val(lastMonth.toISOString().split("T")[0]);
  $("#txtFechaFin").val(today.toISOString().split("T")[0]);
}

/* showLista(); */

// Inicializar filtros al cargar la página
function initializeFilters() {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=showOrdenServicio",
    data: {}
  })
    .done(function (data) {
      try {
        var data1 = JSON.parse(data);
        console.log("Datos recibidos:", data1);
        if (data1["error"] === "NO") {
          console.log("Datos de filtros no requeridos eliminados");

        } else {
          console.error("Error al cargar filtros:", data1["message"]);
        }
      } catch (err) {
        console.error("Error al procesar los filtros:", err, data);
      }
    })
    .fail(function (jqXHR, textStatus, textError) {
      console.error("Error en la petición AJAX para filtros:", textError);
    });
}

$(document).on('click', '.btnEliminarCronograma', function () {
  const idCronograma = $(this).data('id');
  deleteCronograma(idCronograma);
});


// Función para mostrar la lista
function showLista() {
  table.clear().draw();
  $("#divPaginador").addClass("d-none");

  // Obtener valores de fecha
  const fechaInicio = $("#txtFechaInicio").val();
  const fechaFin = $("#txtFechaFin").val();
  const cliente = $("#cboClienteBuscar").val();
  const fundo = $("#cboFundoBuscar").val();
  const maquinaria = $("#cboMaquinariaBuscar").val();
  const operador = $("#cboMedicoBuscar").val();
  const unidadNegocio = $("#cboUnidadBuscar").val();

  $.ajax({
    data: {
      fecha_inicio: fechaInicio,
      fecha_fin: fechaFin,
      id_cliente: cliente,
      id_fundo: fundo,
      id_maquinaria: maquinaria,
      id_trabajador: operador,
      id_tipo_servicio: unidadNegocio
    },
    type: "POST",
    url: "ajax.php?accion=showOrdenServicio"
  })
    .done(function (data) {
      try {
        const data1 = JSON.parse(data);
        console.log("Datos recibidos:", data1);
        if (data1["error"] === "NO") {
          const registros = data1["data"];
          registros.forEach(function (item) {
            table.row.add({
              num: item.num,
              opciones: item.options,
              codigo: item.codigo,
              total: item.total,
              gastos: item.gastos,
              ganancia: item.ganancia,
              id_cronograma: item.id_cronograma,
              nombre_fundo: item.nombre_fundo,
              nombre_cliente: item.nombre_cliente,
              nombre_servicio: item.nombre_servicio,
              cant_medida: item.cant_medida,
              nombre_operador: item.nombre_operador,
              nombre_maquinaria: item.nombre_maquinaria,
              fecha_ingreso: item.fecha_ingreso,
              fecha_salida: item.fecha_salida,
              estado_trabajo: item.estado_trabajo
            }).draw();
          });
          $("#divPaginador").removeClass("d-none");
        } else {
          console.log(data1["message"]);
          $("#divPaginador").addClass("d-none");
        }
      } catch (err) {
        console.error("Error al analizar el JSON:", err, data);
      }
    })
    .fail(function (jqXHR, textStatus, textError) {
      console.error("Error al realizar la petición:", textError);
    });
}
// Función para llenar los filtros
function fillFilterOptions(data, selector) {
  var selectElement = $(selector);
  var currentValue = selectElement.val();
  selectElement.empty();
  selectElement.append(`<option value="">Todos</option>`);

  if (data.length > 0) {
    data.forEach(value => {
      selectElement.append(`<option value="${value}">${value}</option>`);
    });
  } else {
    console.warn(`No hay datos para llenar el filtro ${selector}`);
  }

  // Restaurar el valor seleccionado 
  if (data.includes(currentValue) || currentValue === "") {
    selectElement.val(currentValue);
  } else {
    selectElement.val("");
  }
}




// Restaurar las opciones originales de los filtros
function restoreOriginalFilterOptions() {
  fillFilterOptions(usuariosOriginales, "#filterUser");
  fillFilterOptions(tablasOriginales, "#filterTable");
}

function get_data_callback() {
  table.clear().draw();
  var fecha_inicio = $("#txtFechaInicio").val();
  var fecha_fin = $("#txtFechaFin").val();
  var cliente = $("#cboClienteBuscar").val();
  var fundo = $("#cboFundoBuscar").val();
  var maquinaria = $("#cboMaquinariaBuscar").val();
  var operador = $("#cboMedicoBuscar").val();
  var unidadNegocio = $("#cboUnidadBuscar").val();
  $("#divPaginador").addClass("d-none");

  $.ajax({
    data: {
      limit: itemsPorPagina,
      offset: desde,
      fecha_inicio: fecha_inicio,
      fecha_fin: fecha_fin,
      cliente: cliente,
      fundo: fundo,
      maquinaria: maquinaria,
      operador: operador,
      unidadNegocio: unidadNegocio
    },
    type: "POST",
    url: 'ajax.php?accion=showOrdenServicio'
  }).done(function (data) {
    try {
      var data1 = JSON.parse(data);
      if (data1["error"] == "NO") {
        var o = data1["data"];
        o.forEach(function (item) {
          table.row.add({
            "num": item.num,
            "opciones": item.options,
            "codigo": item.codigo,
            "total": item.total,
            "gastos": item.gastos,
            "ganancia": item.ganancia,
            "id_cronograma": item.id_cronograma,
            "nombre_fundo": item.nombre_fundo,
            "nombre_cliente": item.nombre_cliente,
            "nombre_servicio": item.nombre_servicio,
            "cant_medida": item.cant_medida,
            "nombre_operador": item.nombre_operador,
            "nombre_maquinaria": item.nombre_maquinaria,
            "fecha_ingreso": item.fecha_ingreso,
            "fecha_salida": item.fecha_salida,
            "estado_trabajo": item.estado_trabajo
          }).draw();
        });
        $("#divPaginador").removeClass("d-none");
      } else {
        console.log(data1["message"]);
        $("#divPaginador").addClass("d-none");
      }
    } catch (err) {
      console.error("Error al analizar el JSON:", err, data);
    }
  }).fail(function (jqXHR, textStatus, textError) {
    console.error("Error al realizar la petición:", textError);
  });
}

/******************************************* */
/********* MODAL DE OPERADORES y MAQUINARIAS ************* */
/******************************************* */

function showModalOperadorMaquinaria(id_cronograma) {
  if (!id_cronograma || id_cronograma === 0) {
    runAlert("Error", "El ID del cronograma es inválido.", "warning");
    return;
  }

  limpiarCamposNuevoOperadorMaquinaria();
  $("#nuevoOperadorMaquinariaContainer").hide();
  $("#btnNuevoOperadorMaquinaria").show();

  $("#id_cronograma").val(id_cronograma);

  cargarOperadoresMaquinariasExistentes(id_cronograma)
    .then(() => {
      $("#modalOperadorMaquinaria").modal("show");
    })
    .catch((error) => {
      console.error("Error al cargar datos de operadores y maquinarias:", error);
      runAlert("Error", "No se pudieron cargar los datos del cronograma.", "error");
    });
}

$("#modalOperadorMaquinaria").on("hidden.bs.modal", function () {
  limpiarCamposNuevoOperadorMaquinaria();
  $("#nuevoOperadorMaquinariaContainer").hide();
  $("#btnNuevoOperadorMaquinaria").show();
});

function cargarOperadoresMaquinariasExistentes(id_cronograma) {
  return new Promise((resolve, reject) => {
    console.log("ID Cronograma recibido:", id_cronograma);

    $.ajax({
      type: "POST",
      url: "ajax.php?accion=getOperadoresMaquinariasByCronograma",
      data: { id_cronograma: id_cronograma },
      success: function (response) {
        try {
          const data = JSON.parse(response);
          if (data.error === "NO") {
            const totalDisponibles = parseFloat(data.data.cantidad) || 0;
            const operadores = data.data.operadores || [];
            const unidadMedida = data.data.unidad_medida;

            const asignadas = operadores.reduce((sum, op) => sum + parseFloat(op.horas_trabajadas || 0), 0);
            const disponibles = totalDisponibles - asignadas;
            const pagoOperador = parseFloat(data.data.pago_operador) || 0;

            console.log("Unidad de Medida obtenida y guardada en `data()`:", unidadMedida);

            $("#id_cronograma").data("unidad_medida", unidadMedida);
            $("#id_cronograma").attr("data-unidad_medida", unidadMedida);

            actualizarColumnas(unidadMedida);
            $("#pago_por_hora").val(pagoOperador.toFixed(2));


            llenarTablaOperadoresMaquinarias(data.data);
            resolve();
          } else {
            console.error(data.message);
            $("#tablaOperadorMaquinaria tbody").empty();
            resolve();
          }
        } catch (err) {
          console.error("Error al procesar la respuesta:", err);
          reject(err);
        }
      },
      error: function () {
        runAlert("Error", "No se pudo conectar con el servidor para cargar los operadores.", "error");
        reject();
      },
    });
  });
}


function llenarTablaOperadoresMaquinarias(datos) {
  const tabla = $("#tablaOperadorMaquinaria tbody");
  tabla.empty();

  const operadores = datos.operadores || [];
  const maquinarias = datos.maquinarias || [];
  const unidadMedida = datos.unidad_medida;

  console.log("Unidad recibida:", unidadMedida);
  console.log("Operadores recibidos:", operadores);
  console.log("Maquinarias recibidas:", maquinarias);

  const totalHectareas = parseFloat(datos.cantidad) || 0;
  let hectareasAsignadas = 0;

  const maxLength = Math.max(operadores.length, maquinarias.length);
  for (let i = 0; i < maxLength; i++) {
    const operador = operadores[i] || {};
    const maquinaria = maquinarias[i] || {};

    const horasTrabajadas = parseFloat(operador.horas_trabajadas) || 0;
    hectareasAsignadas += horasTrabajadas; // Acumular las hectáreas asignadas

    const pagoPorHora = parseFloat(operador.pago_por_hora) || 0;
    const totalPago = parseFloat(operador.total_pago) || horasTrabajadas * pagoPorHora;

    const petroleoEntrada = parseFloat(maquinaria.petroleo_entrada) || 0;
    const petroleoSalida = parseFloat(maquinaria.petroleo_salida) || 0;
    const consumoPetroleo = petroleoEntrada - petroleoSalida;
    const precioPetroleo = parseFloat(maquinaria.precio_petroleo) || 0;
    const pagoPetroleo = consumoPetroleo * precioPetroleo;

    const fila = `
          <tr>
              <td>${i + 1}</td>
              <td>${operador.nombre_operador || ""}</td>
              <td>${horasTrabajadas.toFixed(2)}</td>
              <td>${pagoPorHora.toFixed(2)}</td>
              <td>${totalPago.toFixed(2)}</td>
              <td>${maquinaria.nombre_maquinaria || ""}</td>
              <td>${petroleoEntrada.toFixed(2)}</td>
              <td>${petroleoSalida.toFixed(2)}</td>
              <td>${consumoPetroleo.toFixed(2)}</td>
              <td>${precioPetroleo.toFixed(2)}</td>
              <td>${pagoPetroleo.toFixed(2)}</td>
              <td>
                  <button class="btn btn-warning btn-sm btnEditarOperadorMaquinaria" data-id-operador="${operador.id_cronograma_operador || ""}" data-id-maquinaria="${maquinaria.id_cronograma_maquinaria || ""}">
                      <i class="fa fa-edit"></i>
                  </button>
                  <button class="btn btn-danger btn-sm btnEliminarOperadorMaquinaria" data-id-operador="${operador.id_cronograma_operador || ""}" data-id-maquinaria="${maquinaria.id_cronograma_maquinaria || ""}">
                      <i class="fa fa-trash"></i>
                  </button>
              </td>
          </tr>`;
    tabla.append(fila);
  }

  const hectareasDisponibles = totalHectareas - hectareasAsignadas;
  let labelText = "";

  if (unidadMedida == "4") {
    labelText = "Horas disponibles:";
  } else if (unidadMedida == "5") {
    labelText = "Hectáreas disponibles:";
  } else {
    labelText = "Unidades disponibles:";
  }

  console.log("Unidad recibida:", unidadMedida);
  console.log("Label seleccionado:", labelText);

  $("#labelHectareasDisponibles")
    .text(`${labelText} ${hectareasDisponibles.toFixed(2)}`)
    .data("total", hectareasDisponibles);



  $(".btnEditarOperadorMaquinaria").click(function () {
    const idOperador = $(this).data("id-operador");
    const idMaquinaria = $(this).data("id-maquinaria");
    editarOperadorMaquinaria(idOperador, idMaquinaria);
  });

  $(".btnEliminarOperadorMaquinaria").click(function () {
    const idOperador = $(this).data("id-operador");
    const idMaquinaria = $(this).data("id-maquinaria");
    if (idOperador || idMaquinaria) {
      deleteRegistroOperadorMaquinaria(idOperador, idMaquinaria);
    }
  });
}

function deleteRegistroOperadorMaquinaria(id_operador, id_maquinaria) {
  try {
    var parametros = {
      id_cronograma_operador: id_operador,
      id_cronograma_maquinaria: id_maquinaria,
    };
    Swal.fire({
      title: "¿Seguro de eliminar este registro?",
      text: "No podrás revertir esta operación.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#22c63b",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar",
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=deleteOperadorMaquinariaCronograma",
          datatype: "json",
          data: parametros,
          success: function (data) {
            try {
              var response = JSON.parse(data);
              if (response["error"] == "SI") {
                runAlert("Oh No...!!!", response["message"], "warning");
              } else {
                let idCronograma = $("#id_cronograma").val();
                cargarOperadoresMaquinariasExistentes(idCronograma).then(() => {
                  actualizarCantidadRestante(idCronograma);
                });
                runAlert("Bien hecho...!!!", response["message"], "success");
              }
            } catch (e) {
                console.log(e);
              }
            },
            error: function (data) {
              runAlert("Oh No...!!!", data, "error");
            },
            beforeSend: function (xhr) {
              showHideLoader("block");
            },
            complete: function (jqXHR, textStatus) {
              showHideLoader("none");
            },
          });
      }
    });
  } catch (e) {
    runAlert("Oh No...!!!", "Error en TryCatch: " + e, "error");
  }
}

function calcularValoresFormulario() {
  const horas_trabajadas = parseFloat($("#horas_trabajadas").val()) || 0;
  const pago_por_hora = parseFloat($("#precio_por_unidad").val()) || 0;
  const petroleoEntrada = parseFloat($("#petroleo_entrada").val()) || 0;
  const petroleoSalida = parseFloat($("#petroleo_salida").val()) || 0;
  const precioPetroleo = parseFloat($("#precio_petroleo").val()) || 0;

  const total = horas_trabajadas * pago_por_hora;
  const consumoPetroleo = petroleoEntrada - petroleoSalida;
  const pagoPetroleo = consumoPetroleo * precioPetroleo;

  // Asigna valores predeterminados
  $("#total_pago").val(total.toFixed(2));
  $("#consumo_petroleo").val(consumoPetroleo);
  $("#pago_petroleo").val(pagoPetroleo);
}

$("#horas_trabajadas, #pago_por_hora, #petroleo_entrada, #petroleo_salida, #precio_petroleo").on("input", calcularValoresFormulario);

function saveOperadorMaquinariaC() {
  Swal.fire({
    title: "¿Seguro de guardar los cambios?",
    text: "No podrás revertir esta operación.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#22c63b",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, guardar",
  }).then(function (result) {
    if (result.value) {
      const formData = new FormData($("#frmOperadorMaquinaria")[0]);
      console.log("id_cronograma_operador:", formData.get("id_cronograma_operador"));
      console.log("id_cronograma_maquinaria:", formData.get("id_cronograma_maquinaria"));

      const idCronograma = $("#id_cronograma").val();

      if (!idCronograma) {
        console.error("ID de cronograma faltante.");
        runAlert("Error", "ID de cronograma es requerido.", "error");
        return;
      }

      formData.append("id_cronograma", idCronograma);
      // Rellenar valores vacíos con 0 para evitar errores en el backend
      ["horas_trabajadas", "pago_por_hora", "petroleo_entrada", "petroleo_salida", "precio_petroleo"].forEach((campo) => {
        if (!formData.get(campo) || isNaN(formData.get(campo))) {
          formData.set(campo, "0");
        }
      });

      const idEdicion = $("#frmOperadorMaquinaria").data("editing");
      let cantidadNueva = parseFloat($("#horas_trabajadas").val()) || 0;
      let totalDisponible = parseFloat($("#labelHectareasDisponibles").data("total")) || 0;
      let cantidadAnterior = 0;

      if (idEdicion) {
        cantidadAnterior = obtenerCantidadActualEnEdicion(idEdicion);
      }

      let nuevaDisponibilidad = totalDisponible + cantidadAnterior - cantidadNueva;

      if (nuevaDisponibilidad < 0) {
        Swal.fire("Error", "La cantidad ingresada supera el límite disponible.", "error");
        return;
      }

      let unidadMedida = $("#id_cronograma").data("unidad_medida");
      let labelTexto = unidadMedida === '5' ? "Hectáreas disponibles:" : "Horas disponibles:";

      $("#labelHectareasDisponibles").data("total", nuevaDisponibilidad.toFixed(2));
      $("#labelHectareasDisponibles").text(`${labelTexto} ${nuevaDisponibilidad.toFixed(2)}`);

      const accion = idEdicion ? "actualizarOperadorMaquinariaCronograma" : "goOperadorMaquinariaCronograma";
      if (idEdicion) {
        formData.append("id_cronograma", idEdicion);
      }

      $.ajax({
        type: "POST",
        url: `ajax.php?accion=${accion}`,
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          const data = JSON.parse(response);
          if (data.error === "NO") {
            runAlert("Éxito", data.message, "success");
            console.log(data);

            $("#nuevoOperadorMaquinariaContainer").hide();
            $("#btnNuevoOperadorMaquinaria").show();
            limpiarCamposNuevoOperadorMaquinaria();
            cargarOperadoresMaquinariasExistentes($("#id_cronograma").val());
          } else {
            runAlert("Error", data.message, "error");
          }
        },
        error: function () {
          runAlert("Error", "No se pudo conectar con el servidor", "error");
        },
      });
    }
  });
}

function cancelarFormOperadorMaquinaria() { }

function limpiarCamposNuevoOperadorMaquinaria(pagoOperador = "0") {
  $("#nombre_operador").prop("selectedIndex", 0);
  $("#horas_trabajadas").val("0");
  $("#pago_por_hora").val(pagoOperador);
  $("#total_pago").val("0");
  $("#nombre_maquinaria").prop("selectedIndex", 0);
  $("#petroleo_entrada").val("0");
  $("#petroleo_salida").val("0");
  $("#consumo_petroleo").val("0");
  $("#precio_petroleo").val("0");
  $("#pago_petroleo").val("0");
  $("#frmOperadorMaquinaria").removeData("editing");
}


function editarOperadorMaquinaria(id_cronograma_operador, id_cronograma_maquinaria) {
  $("#frmOperadorMaquinaria").data("editing", id_cronograma_operador);
  $("#id_cronograma_operador").val(id_cronograma_operador || "");
  $("#id_cronograma_maquinaria").val(id_cronograma_maquinaria || "");

  let cantidadAnteriorEdicion = parseFloat($("#frmOperadorMaquinaria").data("cantidad_editando")) || 0;
  let totalDisponible = parseFloat($("#labelHectareasDisponibles").data("total")) || 0;

  if (cantidadAnteriorEdicion) {
    console.log(`Restaurando disponibilidad antes de edición: +${cantidadAnteriorEdicion}`);
    totalDisponible += cantidadAnteriorEdicion;
    $("#frmOperadorMaquinaria").data("cantidad_editando", 0);
  }
  console.log(`✅ Total disponible restaurado antes de editar: ${totalDisponible}`);

  $.ajax({
    type: "POST",
    url: "ajax.php?accion=getOperadorMaquinariaById",
    data: { id_cronograma_operador, id_cronograma_maquinaria },
    success: function (response) {
      try {
        const data = JSON.parse(response);

        if (data.error === "NO") {
          const operador = data.data.operador || {};
          const maquinaria = data.data.maquinaria || {};

          let cantidadNueva = parseFloat(operador.horas_trabajadas || 0);
          let unidadMedida = $("#id_cronograma").data("unidad_medida") || 0;

          console.log(`Nueva cantidad a editar: ${cantidadNueva}`);

          let labelTexto = unidadMedida === "5" ? "Hectáreas disponibles: " : "Horas disponibles: ";
          let nuevaDisponibilidad = totalDisponible + cantidadNueva;


          console.log(`Nueva disponibilidad calculada: ${nuevaDisponibilidad}`);

          $("#labelHectareasDisponibles")
            .text(`${labelTexto} ${nuevaDisponibilidad.toFixed(2)}`)
            .data("total", nuevaDisponibilidad);

          $("#frmOperadorMaquinaria").data("cantidad_editando", cantidadNueva);

          $("#nombre_operador").val(operador.id_trabajador || "");
          $("#horas_trabajadas").val(parseFloat(operador.horas_trabajadas || 0).toFixed(2));
          $("#pago_por_hora").val(parseFloat(operador.pago_por_hora || 0).toFixed(2));
          $("#total_pago").val(parseFloat(operador.total_pago || 0).toFixed(2));

          $("#nombre_maquinaria").val(maquinaria.id_maquinaria || "");
          $("#petroleo_entrada").val(parseFloat(maquinaria.petroleo_entrada || 0).toFixed(2));
          $("#petroleo_salida").val(parseFloat(maquinaria.petroleo_salida || 0).toFixed(2));
          $("#consumo_petroleo").val(parseFloat(maquinaria.consumo_petroleo || 0).toFixed(2));
          $("#precio_petroleo").val(parseFloat(maquinaria.precio_petroleo || 0).toFixed(2));
          $("#pago_petroleo").val(parseFloat(maquinaria.pago_petroleo || 0).toFixed(2));

          $("#btnNuevoOperadorMaquinaria").hide();
          $("#nuevoOperadorMaquinariaContainer").show();
          $("#frmOperadorMaquinaria").data("editing", { id_cronograma_operador, id_cronograma_maquinaria });

        } else {
          console.error("Error al cargar los datos: " + data.message);
          runAlert("Error", data.message, "warning");
        }
      } catch (e) {
        console.error("Error al procesar la respuesta:", e);
      }
    },
    error: function () {
      runAlert("Error", "No se pudo conectar con el servidor para obtener los datos", "error");
    },
  });
}

function actualizarColumnas(id_unidad_medida) {
  console.log("ID Unidad Medida recibido:", id_unidad_medida);
  if (id_unidad_medida == 5) { // HECTÁREAS
    console.log("Modificando a Cantidad Hectáreas y Pago / Hectárea");
    $("#colCantidad").text("Cantidad Hectáreas");
    $("#colPrecio").text("Pago / Hectárea");

    $("#labelCantidad").text("Cantidad de Hectáreas");
    $("#labelPrecio").text("Pago / Hectárea");

  } else if (id_unidad_medida == 4) { // HORAS
    console.log("Modificando a Cantidad Horas y Pago / Hora");
    $("#colCantidad").text("Cantidad Horas");
    $("#colPrecio").text("Pago / Hora");

    $("#labelCantidad").text("Cantidad de Horas");
    $("#labelPrecio").text("Pago / Hora");

  } else {
    console.log("Restaurando valores predeterminados");
    $("#colCantidad").text("Cantidad");
    $("#colPrecio").text("Pago / Unidad");

    $("#labelCantidad").text("Cantidad");
    $("#labelPrecio").text("Pago / Unidad");
  }
}


function obtenerUnidadMedida(id_cronograma) {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=getUnidadMedida",
    data: { id_cronograma: id_cronograma },
    success: function (response) {
      try {
        const data = JSON.parse(response);
        console.log("Respuesta del backend:", data);
        if (data.error === "NO") {
          const { id_unidad_medida, precio } = data.data;
          console.log("Unidad de Medida:", id_unidad_medida, "Precio:", precio);
          actualizarColumnas(id_unidad_medida);

          $("#pago_por_hora").val(precio.toFixed(2));

          $("#precio_por_unidad").val(precio);
          recalcularPagoTotal();
        } else {
          console.error("Error al obtener la unidad de medida:", data.message);
        }
      } catch (e) {
        console.error("Error al procesar la respuesta:", e);
      }
    },
    error: function () {
      console.error("No se pudo conectar con el servidor para obtener la unidad de medida.");
    },
  });
}

function recalcularPagoTotal() {
  const cantidad = parseFloat($("#horas_trabajadas").val()) || 0;
  const precioPorUnidad = parseFloat($("#precio_por_unidad").val()) || 0;

  // Calcula el total y actualiza el campo
  const total = cantidad * precioPorUnidad;
  $("#total_pago").val(total.toFixed(2));
}

$("#horas_trabajadas, #pago_por_hora").on("input", function () {
  recalcularPagoTotal();
});

function validateCantidadHectareas(inputCantidad) {
  const cantidadTotalPermitida = parseFloat($("#labelHectareasDisponibles").data("total")) || 0;
  const totalRegistrado = calcularTotalHectareasRegistradas();
  const idEdicion = $("#frmOperadorMaquinaria").data("editing");
  let cantidadEdicionAnterior = 0;

  const unidadMedida = $("#id_cronograma").data("unidad_medida");
  if (unidadMedida === 4) {
    return true;
  }

  if (idEdicion) {
    cantidadEdicionAnterior = obtenerCantidadActualEnEdicion(idEdicion);
  }

  const hectareasDisponibles = cantidadTotalPermitida + cantidadEdicionAnterior - inputCantidad;

  console.log(`Validando: Total permitido: ${cantidadTotalPermitida}, Total registrado: ${totalRegistrado}, 
    Cantidad anterior: ${cantidadEdicionAnterior}, Nueva cantidad: ${inputCantidad}, 
    Disponibles después de validación: ${hectareasDisponibles}`);

  if (hectareasDisponibles < 0) {
    Swal.fire("Error", "La cantidad de hectáreas excede el límite disponible.", "error");
    return false;
  }
  return true;
}

function calcularTotalHectareasRegistradas() {
  let total = 0;
  $("#tablaOperadorMaquinaria tbody tr").each(function () {
    const cantidad = parseFloat($(this).find("td:nth-child(3)").text()) || 0;
    total += cantidad;
  });
  return total;
}

function obtenerCantidadActualEnEdicion(idEdicion) {
  let cantidad = 0;
  $("#tablaOperadorMaquinaria tbody tr").each(function () {
    const operadorId = $(this).find("button.btnEditarOperadorMaquinaria").data("id-operador");
    if (operadorId === idEdicion) {
      cantidad = parseFloat($(this).find("td:nth-child(3)").text()) || 0; // La columna 3 es la cantidad registrada
    }
  });
  return cantidad;
}

function actualizarCantidadRestante(id_cronograma) {
  let cantidadRestante = parseFloat($('#labelHectareasDisponibles').data("total")) || 0;

  console.log("Actualizando cantidad restante:", cantidadRestante);

  $.ajax({
    url: "ajax.php?accion=getCantidadDisponible",
    type: 'POST',
    data: {
      id_cronograma: id_cronograma,
      cantidad_restante: cantidadRestante
    },
    success: function (response) {
      let res = JSON.parse(response);
      if (res.error === "NO") {
        console.log("Cantidad restante actualizada correctamente:", res.message);
      } else {
        console.error("Error al actualizar cantidad restante:", res.message);
      }
    },
    error: function () {
      console.error("No se pudo conectar con el servidor para actualizar cantidad restante.");
    }
  });
}

$(document).on("DOMSubtreeModified", "#labelHectareasDisponibles", function () {
  let idCronograma = $("#id_cronograma").val();
  if (idCronograma) {
    actualizarCantidadRestante(idCronograma);
  }
});


function cancelarFormPago() {}

function limpiarCamposNuevoPago() {
  const today = new Date().toISOString().split("T")[0];
  $("#fecha_pago").val(today);
  $("#metodo_pago").prop("selectedIndex", 0);
  $("#monto").val("");
}

function savePago() {
  console.log($("#total_pendiente").val());
  console.log($("#monto").val());
  if (parseFloat($("#total_pendiente").val()) < parseFloat($("#monto").val())) {
    runAlert("Oh No...!!!", "El monto a pagar no puede ser mayor al pendiente.", "warning");
    return;
  }

  Swal.fire({
    title: "¿Seguro de registrar el pago?",
    text: "No podrás revertir esta operación.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#22c63b",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Realizar ahora!",
  }).then(function (result) {
    if (result.value) {
      const form = $("#frmPago");
      const formData = new FormData(form[0]);
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goPagoCliente",
        datatype: "json",
        processData: false,
        contentType: false,
        data: formData,
        success: function (data) {
          try {
            const response = JSON.parse(data);
            if (response["error"] == "SI") {
              runAlert("Oh No...!!!", response["message"], "warning");
            } else {
              $("#nuevoPagoContainer").hide();
              $("#btnNuevoPago").show();
              limpiarCamposNuevoPago();
              cargarPagosExistentes($("#id_cronograma_pago").val());
              runAlert("Bien hecho...!!!", response["message"], "success");
              showLista();
            }
          } catch (e) {
            runAlert("Oh No...!!!", e, "error");
          }
        },
        error: function (data) {
          runAlert("Oh No...!!!", data, "error");
        },
        beforeSend: function (xhr) {
          showHideLoader("block");
        },
        complete: function (jqXHR, textStatus) {
          showHideLoader("none");
        },
      });
    }
  });
}


function showModalPagos(id_cronograma_pago, monto_total, signo) {
  if (!monto_total || isNaN(monto_total)) {
    console.warn("monto_total es inválido, buscando en el input oculto...");
    monto_total = parseFloat($("#total_ingreso").val()) || 0;
}

  $("#id_cronograma_pago").val(id_cronograma_pago);
  $("#total_ingreso").val(monto_total);
  $("#moneda_ingreso").val(signo);
  $("#lblTotalPagar").html(`<strong>Total a Pagar:</strong> ${signo} ${monto_total.toFixed(2)}`);
  cargarPagosExistentes(id_cronograma_pago);
  $("#modalPagos").modal("show");
}


function deleteRegistro(id_cronograma_pago) {
  try {
    var parametros = {
      id_cronograma_pago: id_cronograma_pago,
    };

    Swal.fire({
      title: "¿Seguro de anular el pago seleccionado?",
      text: "No podrás revertir esta operación.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#22c63b",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Anular ahora!",
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=deletePagoCliente",
          datatype: "json",
          data: parametros,
          success: function (data) {
            try {
              var response = JSON.parse(data);
              if (response["error"] == "SI") {
                runAlert("Oh No...!!!", response["message"], "warning");
              } else {
                cargarPagosExistentes($("#id_cronograma_pago").val());
                runAlert("Bien hecho...!!!", response["message"], "success");
              }
            } catch (e) {
              console.log(e);
            }
          },
          error: function (data) {
            runAlert("Oh No...!!!", data, "error");
          },
          beforeSend: function (xhr) {
            showHideLoader("block");
          },
          complete: function (jqXHR, textStatus) {
            showHideLoader("none");
          },
        });
      }
    });
  } catch (e) {
    runAlert("Oh No...!!!", "Error en TryCatch: " + e, "error");
  }
}

function cargarPagosExistentes(id_cronograma_pago) {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=showPagoCliente",
    data: { id_cronograma_pago: id_cronograma_pago },
    success: function (response) {
      try {
        var data1 = JSON.parse(response);
        console.log(data1);
        var o = data1["data"];
        llenarTablaPagos(o);
      } catch (err) {
        console.log(err);
      }
    },
    error: function () {
      runAlert("Error", "No se pudo conectar con el servidor para cargar los pagos.", "error");
    },
  });
}

function llenarTablaPagos(pagos) {
  const tablaPagos = $("#tablaPagos tbody");
  tablaPagos.empty();
  let total_pagado = 0;
  let monto_total = parseFloat($("#total_ingreso").val());
  console.log("new total mont", monto_total);
  let signo = $("#moneda_ingreso").val();
  console.log("new signo", signo);
  if (pagos && pagos.length > 0) {
    pagos.forEach((pago) => {
      const fila = `
        <tr>
          <td>${pago.num}</td>
          <td>${pago.fecha_pago}</td>
          <td>${pago.name_forma_pago}</td>
          <td>${parseFloat(pago.monto).toFixed(2)}</td>
          <td>
            ${pago.flag_eliminar}
          </td>
        </tr>
      `;
      total_pagado += parseFloat(pago.monto);
      tablaPagos.append(fila);
    });
  }
  let pendiente = monto_total - total_pagado;
  $("#lblTotalPagado").html(`<strong>Total Pagado:</strong> ${signo} ${total_pagado.toFixed(2)}`);
  $("#lblPendientePago").html(`<strong>Pendiente de Pago:</strong> ${signo} ${pendiente.toFixed(2)}`);
  $("#total_pendiente").val(pendiente);
  if (pendiente <= 0) {
    $("#nuevoPagoContainer").hide();
    $("#btnNuevoPago").hide();
  } else {
    $("#btnNuevoPago").show();
  }
}
