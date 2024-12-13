var table = $('#example').DataTable({
    language: languageSpanish,
    destroy: true,
    dom: 'tip',
    columns: [
      { 'data': 'num' },
      { 'data': 'id_cliente' },
      { 'data': 'numero_documento' },
      { 'data': 'nombre_cliente' },
      { 'data': 'apodo'},
      { 'data': 'direccion' },
      { 'data': 'telefono' },
      { 'data': 'cant_fundos' },
      { 'data': 'estado'}
    ],
    columnDefs: [
      {
        "targets": [1],
        "visible": false,
        "searchable": false
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

    // Mostrar la lista inicial
    showLista();
  });

  // Función para buscar datos personalizados
$('#btnBuscarOrden').on('click', function () {
  const tipoBusqueda = $('#cboTipoBuscarOrden').val(); // Tipo de búsqueda (1: Nombres/Apellidos, 2: Apodo)
  const valorBusqueda = $('#txtBuscarOrden').val(); // Valor ingresado en el input de búsqueda

  // Limpiar y buscar en la tabla con lógica personalizada
  table.clear().draw(); // Limpia la tabla antes de cargar nuevos datos

  $.ajax({
      type: "POST",
      url: "ajax.php?accion=showClienteReporte", // Ruta a tu backend
      data: {
          tipo_busqueda: tipoBusqueda, // Envía el tipo de búsqueda seleccionado
          valor_busqueda: valorBusqueda, // Envía el valor ingresado
          estado: "all"
      },
      success: function (response) {
          try {
              const data = JSON.parse(response);
              if (data.error === "NO") {
                  data.data.forEach(function (item) {
                      table.row.add({
                          num: item.num,
                          id_cliente: item.id_cliente,
                          numero_documento: item.numero_documento,
                          nombre_cliente: item.nombre_cliente,
                          apodo: item.apodo,
                          direccion: item.direccion,
                          telefono: item.telefono,
                          cant_fundos: item.cant_fundos,
                          estado: item.estado
                      }).draw();
                  });
              } else {
                  alert(data.message || "No se encontraron resultados.");
              }
          } catch (err) {
              console.error("Error procesando los datos:", err);
              alert("Ocurrió un error al procesar la respuesta del servidor.");
          }
      },
      error: function (xhr, status, error) {
          console.error("Error en la solicitud AJAX:", error);
          alert("Ocurrió un error al realizar la búsqueda.");
      }
  });
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
        url: "ajax.php?accion=showClienteReporte",
        data: {}
    })
    .done(function (data) {
        try {
            var data1 = JSON.parse(data);
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
        const link = `?view=reporteclienteexcel&fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&filterUser=${filterUser}&filterTable=${filterTable}`;
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
        const link = `?view=reporteclientepdf&fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&filterUser=${filterUser}&filterTable=${filterTable}`;
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
  
    $.ajax({
        data: {
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin
        },
        type: "POST",
        url: "ajax.php?accion=showClienteReporte"
    })
    .done(function (data) {
        try {
            const data1 = JSON.parse(data);
            if (data1["error"] === "NO") {
                const registros = data1["data"];
                registros.forEach(function (item) {
                    table.row.add({
                        num: item.num,
                        id_cliente: item.id_cliente,
                        numero_documento: item.numero_documento,
                        nombre_cliente: item.nombre_cliente,
                        apodo: item.apodo,
                        direccion: item.direccion,
                        telefono: item.telefono,
                        cant_fundos: item.cant_fundos,
                        estado: item.estado
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
    var currentValue = selectElement.val(); // Guardar el valor actual seleccionado
    selectElement.empty(); // Limpiar opciones previas
    selectElement.append(`<option value="">Todos</option>`); // Añadir opción "Todos"
  
    if (data.length > 0) {
      data.forEach(value => {
        selectElement.append(`<option value="${value}">${value}</option>`);
      });
    } else {
      console.warn(`No hay datos para llenar el filtro ${selector}`);
    }
  
    // Restaurar el valor seleccionado o establecer "Todos" si no coincide con las opciones actuales
    if (data.includes(currentValue) || currentValue === "") {
      selectElement.val(currentValue);
    } else {
      selectElement.val(""); // Volver a "Todos" si el valor seleccionado ya no es válido
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
    var tipo_busqueda = $("#cboTipoBuscarOrden").val();
    $("#divPaginador").addClass("d-none");
  
    $.ajax({
      data: {
        limit: itemsPorPagina,
        offset: desde,
        fecha_inicio: fecha_inicio,
        fecha_fin: fecha_fin,
      },
      type: "POST",
      url: 'ajax.php?accion=showClienteReporte'
    }).done(function (data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"] == "NO") {
          var o = data1["data"];
          o.forEach(function (item) {
            table.row.add({
              "num": item.num,
              "id_cliente": item.id_cliente,
              "numero_documento": item.numero_documento,
              "nombre_cliente": item.nombre_cliente,
              "apodo": item.apodo,
              "direccion": item.direccion,
              "telefono": item.telefono,
              "cant_fundos": item.cant_fundos,
              "estado": item.estado
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
  
  