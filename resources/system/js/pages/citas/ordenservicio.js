var table = $('#example').DataTable({
    language: languageSpanish,
    destroy: true,
    data: [],
    columns: [
      { 'data': 'opciones'},
      { 'data': 'num' },
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
        "targets": [2],
        "visible": false,
        "searchable": true
      }
    ]
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

    $("#btnNuevoOperador").click(function () {
      $("#nuevoOperadorContainer").show();
      $("#btnNuevoOperador").hide();
    });
  
    $("#nuevoOperadorContainer .btn-danger").click(function () {
      $("#nuevoOperadorContainer").hide();
      $("#btnNuevoOperador").show();
      limpiarCamposNuevoOperador();
    });

    $("#frmPOperador").submit(function (e) {
      e.preventDefault();
      saveOperadorC();
    });
  
    // Mostrar la lista inicial
    showLista();
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
  
    $.ajax({
        data: {
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin,
            id_cliente: cliente,
            id_fundo: fundo,
            id_maquinaria: maquinaria,
            id_trabajador: operador
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
                        opciones: item.options,
                        num: item.num,
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
        operador: operador
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
              "opciones": item.options,
              "num": item.num,
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
    operadores.forEach((operadores) => {
      const fila = `
        <tr>
          <td>${operadores.num}</td>
          <td>${operadores.nombre_operador}</td>
          <td>${parseFloat(operadores.horas_trabajadas).toFixed(2)}</td>
          <td>${parseFloat(operadores.pago_por_hora).toFixed(2)}</td>
          <td>${parseFloat(operadores.total_pago).toFixed(2)}</td>
          <td>
            ${operadores.flag_eliminar}
          </td>
        </tr>
      `;
      tablaOperador.append(fila);
    });
  }
}

function deleteRegistro(id_cronograma) {
  try {
    var parametros = {
      id_cronograma: id_cronograma,
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
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goOperadorCronograma",
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
              showData();
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

function cancelarFormOperador() {}

function limpiarCamposNuevoOperador() {
  $("#nombre_operador").prop("selectedIndex", 0);
  $("#horas_trabajadas").val("");
  $("#pago_por_hora").val("");
  $("#total_pago").val("");
}