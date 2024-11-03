$(document).ready(function () {
  // Inicialización de la interfaz
  $("#panelForm").addClass("d-none");
  $("#divSinDatos").addClass("d-none");
  showData();

  // Eventos de búsqueda y filtrado
  $("#btnSearch").click(function () {
      showData();
  });

  $("#txtBuscar").keypress(function (e) {
      if (e.which == 13) {
          showData();
      }
  });

  // Evento para mostrar el formulario de nueva orden de gasto
  $("#btnAdd").click(function () {
      $("#frmDatos")[0].reset();
      $("#accion").val("add");
      addClassDiv();
  });

  // Evento para cancelar y ocultar el formulario
  $("#btnCancel").click(function () {
      removeClassDiv();
  });

  // Evento de envío del formulario
  $("#frmDatos").submit(function (e) {
      e.preventDefault();
      saveOperation();
  });

  // Detectar cuando el usuario sale del campo "N° Documento"
  $("#numero_documento_cliente").on("blur", function () {
    buscarProveedorPorDocumento();
  });
});

// Función para mostrar datos con paginación
function showData() {
  paginador = $(".pagination");
  var items = 6, numeros = 6;
  init_paginator(paginador, items, numeros);
  set_callback(get_data_callback);
  cargaPagina(0);
}

// Callback para cargar los datos de órdenes de gasto
function get_data_callback() {
  var valor = $("#txtBuscar").val();
  var id_documento = $("#cboDocumentoBuscar").val();
  $.ajax({
      data: {
          limit: itemsPorPagina,
          offset: desde,
          valor: valor,
          id_documento: id_documento
      },
      beforeSend: function () {
          showHideLoader("block");
      },
      complete: function () {
          showHideLoader("none");
          if (totalPaginas == 1 && pagina == 0) {
              paginador.find(".next_link").hide();
          }
      },
      type: "POST",
      url: "ajax.php?accion=showOrdenGasto",
  })
  .done(function (data) {
      try {
          var data1 = JSON.parse(data);
          if (data1["error"] == "NO") {
              if (pagina == 0) {
                  creaPaginador(data1["cantidad"]);
              }
              
              // Genera el cuerpo de la tabla
              var innerdivHtml = "";
              var o = data1["data"];
              for (var i = 0; i < o.length; i++) {
                  innerdivHtml += '<div class="col-xxl-3 col-xl-4 col-sm-6">';
                  innerdivHtml += '<div class="card card-statistics">';
                  innerdivHtml += '<div class="card-body py-4">';
                  innerdivHtml += '<h5 class="mb-0">' + o[i].nombre_proveedor + '</h5>';
                  innerdivHtml += '<p>' + o[i].estado + o[i].options + '</p>';
                  innerdivHtml += "<p><strong>Documento:</strong> " + o[i].name_documento + " " + o[i].serie + "-" + o[i].correlativo + "</p>";
                  innerdivHtml += "<p><strong>Fecha:</strong> " + o[i].fecha_gasto + "</p>";
                  innerdivHtml += "</div>";
                  innerdivHtml += "</div>";
                  innerdivHtml += "</div>";
              }

              $("#divDatos").html(innerdivHtml);
              $("#divSinDatos").addClass("d-none");
              $("#divPaginador").removeClass("d-none");
          } else {
              console.log(data1["message"]);
              $("#divSinDatos").removeClass("d-none");
              $("#divPaginador").addClass("d-none");
              $("#divDatos").html("");
          }
      } catch (err) {
          console.log("Error: " + err);
          $("#divSinDatos").removeClass("d-none");
          $("#divPaginador").addClass("d-none");
          $("#divDatos").html("");
      }
  })
  .fail(function (jqXHR, textStatus) {
      console.log("Error en la petición: " + textStatus);
  });
}

// Función para mostrar el formulario de agregar/editar
function addClassDiv() {
  $("#panelForm").removeClass("d-none");
  $("#panelTabla").addClass("d-none");
  $("#panelOptions").addClass("d-none");
}

// Función para ocultar el formulario y volver a la tabla
function removeClassDiv() {
  $("#panelForm").addClass("d-none");
  $("#panelTabla").removeClass("d-none");
  $("#panelOptions").removeClass("d-none");
  $("#frmDatos")[0].reset();
}

// Función para guardar una nueva orden de gasto o actualizar una existente
function saveOperation() {
  Swal.fire({
      title: "¿Seguro de confirmar la operación?",
      text: "No podrás revertir esta operación.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#22c63b",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, realizar ahora!"
  }).then(function (result) {
      if (result.value) {
          var form = $("#frmDatos");
          var formdata = new FormData(form[0]);

          $.ajax({
              type: "POST",
              url: "ajax.php?accion=goOrdenGasto",
              contentType: false,
              processData: false,
              data: formdata,
              success: function (data) {
                  try {
                      var response = JSON.parse(data);
                      if (response["error"] == "SI") {
                          Swal.fire("Error", response["message"], "warning");
                      } else {
                          removeClassDiv();
                          showData();
                          Swal.fire("Éxito", response["message"], "success");
                      }
                  } catch (e) {
                      console.log("Error en JSON: " + e);
                  }
              },
              error: function () {
                  Swal.fire("Error", "Error en la petición", "error");
              }
          });
      }
  });
}

// Función para obtener datos de una orden de gasto para edición
function getDataEdit(id_orden_gasto) {
  $.ajax({
      type: "POST",
      data: {
          id_orden_gasto: id_orden_gasto
      },
      url: "ajax.php?accion=getDataEditOrdenGasto",
      success: function (data) {
          try {
              var data1 = JSON.parse(data);
              if (data1["error"] == "NO") {
                  var o = data1["data"][0];
                  $("#id_orden_gasto").val(o.id_orden_gasto);
                  $("#id_documento").val(o.id_documento);
                  $("#id_documento_venta").val(o.id_documento_venta);
                  $("#id_moneda").val(o.id_moneda);
                  $("#id_proveedor").val(o.id_proveedor);
                  $("#id_gasto").val(o.id_gasto);
                  $("#id_servicio").val(o.id_servicio);
                  $("#serie").val(o.serie);
                  $("#correlativo").val(o.correlativo);
                  $("#fecha_gasto").val(o.fecha_gasto);
                  $("#accion").val("edit");
                  addClassDiv();
              } else {
                  Swal.fire("Error", data1["message"], "warning");
              }
          } catch (e) {
              console.log("Error en JSON: " + e);
          }
      },
      error: function () {
          Swal.fire("Error", "Error en la petición", "error");
      }
  });
}

// Función para eliminar una orden de gasto
function deleteRegistro(id_orden_gasto, orden_info) {
  Swal.fire({
      title: "¿Seguro de eliminar la orden de gasto: " + orden_info + "?",
      text: "No podrás revertir esta operación.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#22c63b",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar ahora!"
  }).then(function (result) {
      if (result.value) {
          $.ajax({
              type: "POST",
              url: "ajax.php?accion=deleteOrdenGasto",
              data: { id_orden_gasto: id_orden_gasto },
              success: function (data) {
                  try {
                      var response = JSON.parse(data);
                      if (response["error"] == "SI") {
                          Swal.fire("Error", response["message"], "warning");
                      } else {
                          showData();
                          Swal.fire("Éxito", response["message"], "success");
                      }
                  } catch (e) {
                      console.log("Error en JSON: " + e);
                  }
              },
              error: function () {
                  Swal.fire("Error", "Error en la petición", "error");
              }
          });
      }
  });
}

function buscarProveedorPorDocumento() {
  const numeroDocumento = $("#numero_documento_cliente").val().trim();

  if (numeroDocumento === "") {
    return;
  }

  $.ajax({
    url: "ajax.php?accion=getDataProveedor",
    type: "POST",
    data: {
      numero_documento: numeroDocumento,
    },
    dataType: "json",
    success: function (response) {
      if (response.error === "NO") {
        // Autocompletar los campos con la información obtenida
        const proveedor = response.data;
        $("#nombres").val(proveedor.nombre_proveedor);
        $("#apellidos").val(proveedor.apellidos_proveedor);
        $("#direccion").val(proveedor.direccion_proveedor);
        $("#telefono").val(proveedor.telefono_proveedor);
        $("#correo").val(proveedor.correo_proveedor);
      } else {
        // Limpia los campos si no se encuentra el proveedor
        $("#nombres").val("");
        $("#apellidos").val("");
        $("#direccion").val("");
        $("#telefono").val("");
        $("#correo").val("");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error al buscar proveedor:", error);
    },
  });
}
