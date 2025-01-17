var table = $('#example').DataTable({
    language: languageSpanish,
    destroy: true,
    data: [],
    columns: [
      { 'data': 'num' },
      { 'data': 'opciones'},
      { 'data': 'codigo' },
      { 'data': 'total' },
      { 'data': 'gastos' },
      { 'data': 'ganancia' },
      { 'data': 'id_cronograma' },
      { 'data': 'nombre_fundo' },
      { 'data': 'nombre_cliente' },
      { 'data': 'nombre_servicio' },
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

    $("#btnNuevoOperador").click(function () {
      $("#nuevoOperadorContainer").show();
      $("#btnNuevoOperador").hide();
    });

    $("#btnNuevaMaquina").click(function () {
      $("#nuevaMaquinariaContainer").show();
      $("#btnNuevaMaquina").hide();
    });
  
    $("#nuevoOperadorContainer .btn-danger").click(function () {
      $("#nuevoOperadorContainer").hide();
      $("#btnNuevoOperador").show();
      limpiarCamposNuevoOperador();
    });

    $("#nuevaMaquinariaContainer .btn-danger").click(function () {
      $("#nuevaMaquinariaContainer").hide();
      $("#btnNuevaMaquina").show();
      limpiarCamposNuevaMaquinaria();
    });

    $("#frmOperador").submit(function (e) {
      e.preventDefault();
      saveOperadorC();
    });

    $("#frmMaquinaria").submit(function (e) {
      e.preventDefault();
      saveMaquinariaC();
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
        window.open(link);
    } catch (e) {
        console.error("Error al generar el reporte Excel:", e);
    }
});

  
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
                // Si no necesitas filtros, elimina esta sección
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
  const idCronograma = $(this).data('id'); // Obtener el ID del cronograma
  deleteCronograma(idCronograma); // Llamar a la función de eliminación
});

  $('#btnReporteExcel').click(function () {
    try {
        const fecha_inicio = $("#txtFechaInicio").val();
        const fecha_fin = $("#txtFechaFin").val();
        const filterUser = $("#filterUser").val();
        const filterTable = $("#filterTable").val();
  
        // Generar link con parámetros
        const link = `?view=ordenservicio&fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&filterUser=${filterUser}&filterTable=${filterTable}`;
        window.open(link, '_blank');
    } catch (e) {
        console.error("Error al generar el reporte Excel:", e);
    }
  });
  
  $('#btnReportePdf').click(function () {
    try {
        const fecha_inicio = $("#txtFechaInicio").val();
        const fecha_fin = $("#txtFechaFin").val();
        const filterUser = $("#filterUser").val();
        const filterTable = $("#filterTable").val();
  
        // Generar link con parámetros
        const link = `?view=ordenservicio&fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&filterUser=${filterUser}&filterTable=${filterTable}`;
        window.open(link, '_blank');
    } catch (e) {
        console.error("Error al generar el reporte PDF:", e);
    }
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
/********* MODAL DE OPERADORES ************* */
/******************************************* */

function showModalOperador(id_cronograma) {
  $("#id_cronograma").val(id_cronograma);
  cargarOperadoresExistentes(id_cronograma);
  $("#modalOperador").modal("show");
}


function cargarOperadoresExistentes(id_cronograma) {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=getOperadoresByCronograma",
    data: { id_cronograma: id_cronograma },
    success: function (response) {
      try {
        var data1 = JSON.parse(response);
        var o = data1["data"];
        llenarTablaOperadores(o);
      } catch (err) {
        console.log(err);
      }
    },
    error: function () {
      runAlert("Error", "No se pudo conectar con el servidor para cargar los operadores.", "error");
    },
  });
}

function llenarTablaOperadores(operadores) {
  const tablaOperador = $("#tablaOperador tbody");
  tablaOperador.empty();
  if (operadores && operadores.length > 0) {
    operadores.forEach((operador, index) => {
      const fila = `
        <tr>
          <td>${index + 1}</td>
          <td>${operador.nombre_operador}</td>
          <td>${parseFloat(operador.horas_trabajadas).toFixed(2)}</td>
          <td>${parseFloat(operador.pago_por_hora).toFixed(2)}</td>
          <td>${(operador.horas_trabajadas * operador.pago_por_hora).toFixed(2)}</td>
          <td>
            <button class="btn btn-warning btn-sm btnEditarOperador" data-id="${operador.id_cronograma_operador}">
              <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-danger btn-sm btnEliminarOperador" data-id="${operador.id_cronograma_operador}">
              <i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>
      `;
      tablaOperador.append(fila);
    });

    $(".btnEditarOperador").click(function () {
      const id_cronograma_operador = $(this).data("id");
      editarOperador(id_cronograma_operador);
    });

    $(".btnEliminarOperador").click(function () {
      const id_cronograma = $(this).data("id");
      if (id_cronograma) {
        deleteRegistroOperador(id_cronograma);
      }
    });
  }
}

function deleteRegistroOperador(id_cronograma) {
  try {
    var parametros = {
      id_cronograma_operador: id_cronograma,
    };

    Swal.fire({
      title: "¿Seguro de anular el operador seleccionado?",
      text: "No podrás revertir esta operación.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#22c63b",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Anular ahora!",
    }).then(function (result) {
      if (result.value) {
        console.log(parametros);
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=deleteOperadorCronograma",
          datatype: "json",
          data: parametros,
          success: function (data) {
            try {
              var response = JSON.parse(data);
              if (response["error"] == "SI") {
                runAlert("Oh No...!!!", response["message"], "warning");
              } else {
                cargarOperadoresExistentes($("#id_cronograma").val());
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

function saveOperadorC() {

  Swal.fire({
    title: "¿Seguro de registrar el operador?",
    text: "No podrás revertir esta operación.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#22c63b",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Realizar ahora!",
  }).then(function (result) {
    if (result.value) {
      const form = $("#frmOperador");
      const formData = new FormData(form[0]);

      const horas = parseFloat($("#horas_trabajadas").val()) || 0;
      const pagoHora = parseFloat($("#pago_por_hora").val()) || 0;
      const total = horas * pagoHora;
      formData.append("total_pago", total.toFixed(2));

      for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
      }

      // Verificar si es una edición o un nuevo registro
      const idEdicion = form.data("editing");
      const accion = idEdicion ? "actualizarOperadorCronograma" : "goOperadorCronograma";
      
      if (idEdicion) {
        formData.append("id_cronograma_operador", idEdicion); // Agregar el ID para la edición
      }


      $.ajax({
        type: "POST",
        url: `ajax.php?accion=${accion}`,
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
              $("#nuevoOperadorContainer").hide();
              $("#btnNuevoOperador").show();
              limpiarCamposNuevoOperador();
              cargarOperadoresExistentes($("#id_cronograma").val());
              runAlert("Bien hecho...!!!", response["message"], "success");
            }

            // Limpiar estado de edición
            form.removeData("editing");
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

function cancelarFormOperador() {}

function limpiarCamposNuevoOperador() {
  $("#nombre_operador").prop("selectedIndex", 0);
  $("#horas_trabajadas").val("");
  $("#pago_por_hora").val("");
  $("#total_pago").val("");
}

function editarOperador(id_cronograma_operador) {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=getOperadorById",
    data: { id_cronograma_operador: id_cronograma_operador },
    success: function (response) {
      try {
        const data = JSON.parse(response);
        if (data.error === "NO") {
          const operador = data.data;
          $("#nombre_operador").val(operador.id_trabajador);
          $("#horas_trabajadas").val(operador.horas_trabajadas);
          $("#pago_por_hora").val(operador.pago_por_hora);
          $("#total_pago").val((operador.horas_trabajadas * operador.pago_por_hora).toFixed(2));

          // Cambiar el texto del botón de guardar y mostrar el contenedor de edición
          $("#btnNuevoOperador").hide();
          $("#nuevoOperadorContainer").show();
          $("#frmOperador").data("editing", id_cronograma_operador); // Guardar el ID para la edición
        } else {
          runAlert("Error", data.message, "error");
        }
      } catch (e) {
        console.error("Error al procesar la respuesta:", e);
        runAlert("Error", "No se pudo procesar la respuesta del servidor", "error");
      }
    },
    error: function () {
      runAlert("Error", "No se pudo conectar con el servidor", "error");
    }
  });
}

/******************************************** */
/********* MODAL DE MAQUINARIAS ************* */
/******************************************** */

function showModalMaquinaria(id_cronograma) {
  if (!id_cronograma || id_cronograma === 0) {
    runAlert("Error", "El ID del cronograma es inválido.", "warning");
    return;
  }

  $("#id_cronograma").val(id_cronograma); 
  cargarMaquinariasExistentes(id_cronograma);
  $("#modalMaquinaria").modal("show");
}

function cargarMaquinariasExistentes(id_cronograma) {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=getMaquinariasByCronograma",
    data: { id_cronograma: id_cronograma },
    success: function (response) {
      try {
        var data1 = JSON.parse(response);
        var o = data1["data"];
        llenarTablaMaquinarias(o);
      } catch (err) {
        console.log(err);
      }
    },
    error: function () {
      runAlert("Error", "No se pudo conectar con el servidor para cargar las maquinarias.", "error");
    },
  });
}

function llenarTablaMaquinarias(maquinarias) {
  const tablaMaquinaria = $("#tablaMaquinaria tbody");
  tablaMaquinaria.empty();
  if (maquinarias && maquinarias.length > 0) {
    maquinarias.forEach((maquinaria, index) => {
      const petroleoEntrada = parseFloat(maquinaria.petroleo_entrada) || 0;
      const petroleoSalida = parseFloat(maquinaria.petroleo_salida) || 0;
      const precioPetroleo = parseFloat(maquinaria.precio_petroleo) || 0;

      const consumoPetroleo = petroleoEntrada - petroleoSalida;
      const pagoPetroleo = consumoPetroleo * precioPetroleo;

      const fila = `
        <tr>
          <td>${index + 1}</td>
          <td>${maquinaria.nombre_maquinaria}</td>
          <td>${petroleoEntrada.toFixed(2)}</td>
          <td>${petroleoSalida.toFixed(2)}</td>
          <td>${consumoPetroleo.toFixed(2)}</td>
          <td>${precioPetroleo.toFixed(2)}</td>
          <td>${pagoPetroleo.toFixed(2)}</td>
          <td>
            <button class="btn btn-warning btn-sm btnEditarMaquinaria" data-id="${maquinaria.id_cronograma_maquinaria}">
              <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-danger btn-sm btnEliminarMaquinaria" data-id="${maquinaria.id_cronograma_maquinaria}">
              <i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>
      `;
      tablaMaquinaria.append(fila);
    });

    // Asignar eventos a los botones de editar y eliminar
    $(".btnEditarMaquinaria").click(function () {
      const id_cronograma_maquinaria = $(this).data("id");
      editarMaquinaria(id_cronograma_maquinaria);
    });

    $(".btnEliminarMaquinaria").click(function () {
      const id_cronograma = $(this).data("id");
      if (id_cronograma) {
        deleteRegistroMaquinaria(id_cronograma);
      }
    });
  }
}


function deleteRegistroMaquinaria(id_cronograma_maquinaria) {
  try {
    var parametros = {
      id_cronograma_maquinaria: id_cronograma_maquinaria,
    };

    Swal.fire({
      title: "¿Seguro de anular la maquinaria seleccionada?",
      text: "No podrás revertir esta operación.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#22c63b",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Anular ahora!",
    }).then(function (result) {
      if (result.value) {
        console.log(parametros);
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=deleteMaquinariaCronograma",
          datatype: "json",
          data: parametros,
          success: function (data) {
            try {
              var response = JSON.parse(data);
              if (response["error"] == "SI") {
                runAlert("Oh No...!!!", response["message"], "warning");
              } else {
                cargarOperadoresExistentes($("#id_cronograma").val());
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


function saveMaquinariaC() {
  const idCronograma = $("#id_cronograma").val();
  console.log("ID Cronograma:", idCronograma);

  Swal.fire({
    title: "¿Seguro de registrar la maquinaria?",
    text: "No podrás revertir esta operación.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#22c63b",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Realizar ahora!",
  }).then(function (result) {
    if (result.value) {
      const form = $("#frmMaquinaria");
      const formData = new FormData(form[0]);

      const idCronograma = $("#id_cronograma").val();
      console.log("ID Cronograma antes de enviar:", idCronograma); // Log para depuración
      formData.append("id_cronograma", idCronograma);

      const petroleoEntrada = parseFloat($("#petroleo_entrada").val()) || 0;
      const petroleoSalida = parseFloat($("#petroleo_salida").val()) || 0;
      const precioPetroleo = parseFloat($("#precio_petroleo").val()) || 0;

      const consumoPetroleo = petroleoEntrada - petroleoSalida;
      const pagoPetroleo = consumoPetroleo * precioPetroleo;

      formData.append("consumo_petroleo", consumoPetroleo.toFixed(2));
      formData.append("pago_petroleo", pagoPetroleo.toFixed(2));

      for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
      }

      // Verificar si es una edición o un nuevo registro
      const idEdicion = form.data("editing");
      const accion = idEdicion ? "actualizarMaquinariaCronograma" : "goMaquinariaCronograma";
      
      if (idEdicion) {
        formData.append("id_cronograma_maquinaria", idEdicion); // Agregar el ID para la edición
      }


      $.ajax({
        type: "POST",
        url: `ajax.php?accion=${accion}`,
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
              $("#nuevaMaquinariaContainer").hide();
              $("#btnNuevaMaquina").show();
              limpiarCamposNuevaMaquinaria();
              cargarMaquinariasExistentes($("#id_cronograma").val());
              runAlert("Bien hecho...!!!", response["message"], "success");
            }

            // Limpiar estado de edición
            form.removeData("editing");
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

function cancelarFormMaquinaria() {}

function limpiarCamposNuevaMaquinaria() {
  $("#nombre_maquinaria").prop("selectedIndex", 0);
  $("#petroleo_entrada").val("");
  $("#petroleo_salida").val("");
  $("#consumo_petroleo").val("");
  $("#precio_petroleo").val("");
  $("#pago_petroleo").val("");
}

function editarMaquinaria(id_cronograma_maquinaria) {
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=getMaquinariaById",
    data: { id_cronograma_maquinaria: id_cronograma_maquinaria },
    success: function (response) {
      try {
        const data = JSON.parse(response);
        if (data.error === "NO") {
          const maquinaria = data.data;
          $("#nombre_maquinaria").val(maquinaria.id_maquinaria);
          $("#petroleo_entrada").val(maquinaria.petroleo_entrada);
          $("#petroleo_salida").val(maquinaria.petroleo_salida);
          $("#consumo_petroleo").val(parseFloat(maquinaria.consumo_petroleo).toFixed(2));         
          $("#precio_petroleo").val(parseFloat(maquinaria.precio_petroleo).toFixed(2));
          $("#pago_petroleo").val(parseFloat(maquinaria.pago_petroleo).toFixed(2));


          // Cambiar el texto del botón de guardar y mostrar el contenedor de edición
          $("#btnNuevaMaquina").hide();
          $("#nuevaMaquinariaContainer").show();
          $("#frmMaquinaria").data("editing", id_cronograma_maquinaria); // Guardar el ID para la edición
        } else {
          runAlert("Error", data.message, "error");
        }
      } catch (e) {
        console.error("Error al procesar la respuesta:", e);
        runAlert("Error", "No se pudo procesar la respuesta del servidor", "error");
      }
    },
    error: function () {
      runAlert("Error", "No se pudo conectar con el servidor", "error");
    }
  });
}