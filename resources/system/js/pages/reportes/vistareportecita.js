var table = $('#example').DataTable({
    language: languageSpanish,
    destroy: true,
    columns: [
      { 'data': 'num' },
      { 'data': 'id_cita' },
      { 'data': 'fecha_cita' },
      { 'data': 'estado' },
      { 'data': 'name_servicio' },
      { 'data': 'nombre_trabajador' },
      { 'data': 'name_maquinaria' }
    ],
    columnDefs: [
      {
        "targets": [1],
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
        url: "ajax.php?accion=showCitaReporte",
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
        const link = `?view=reportecitaexcel&fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&filterUser=${filterUser}&filterTable=${filterTable}`;
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
        const link = `?view=reportecitapdf&fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&filterUser=${filterUser}&filterTable=${filterTable}`;
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
        url: "ajax.php?accion=showCitaReporte"
    })
    .done(function (data) {
        try {
            const data1 = JSON.parse(data);
            if (data1["error"] === "NO") {
                const registros = data1["data"];
                registros.forEach(function (item) {
                    table.row.add({
                        num: item.num,
                        id_cita: item.id_cita,
                        fecha_cita: item.fecha_cita,
                        estado: item.estado,
                        name_servicio: item.name_servicio,
                        nombre_trabajador: item.nombre_trabajador,
                        name_maquinaria: item.name_maquinaria
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
    $("#divPaginador").addClass("d-none");
  
    $.ajax({
      data: {
        limit: itemsPorPagina,
        offset: desde,
        fecha_inicio: fecha_inicio,
        fecha_fin: fecha_fin,
      },
      type: "POST",
      url: 'ajax.php?accion=showCitaReporte'
    }).done(function (data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"] == "NO") {
          var o = data1["data"];
          o.forEach(function (item) {
            table.row.add({
              "num": item.num,
              "id_cita": item.id_cita,
              "fecha_cita": item.fecha_cita,
              "estado": item.estado,
              "name_servicio": item.name_servicio,
              "nombre_trabajador": item.nombre_trabajador,
              "name_maquinaria": item.name_maquinaria
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
  
  