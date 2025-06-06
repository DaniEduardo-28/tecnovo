$(document).ready(function () {
  $("#panelForm").addClass("d-none");
  $("#divSinDatos").addClass("d-none");

  $('#btnSearch').click(function () {
    showData();
  });

  $("#txtBuscar").keypress(function (e) {
    if (e.which == 13) {
      showData();
    }
  });

  $("#cboTipoBuscar").change(function () {
    showData();
  });

  $('#btnAdd').click(function () {
    $('#frmDatos')[0].reset();
    $('#img_destino').attr('src', "resources/global/images/sin_imagen.png");
    $("#flag_imagen").val("0");
    $("#accion").val("add");
    addClassDiv();
  });

  $("#frmDatos").submit(function (e) {
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function () {
    removeClassDiv();
  });

  showData();

  $("#precio").change(function () {
    var element = $("#precio");
    element.val(dosDecimales(element));
  });

  $("#pago_operador").change(function () {
    var element = $("#pago_operador");
    element.val(dosDecimales(element));
  });
});

function showData() {
  paginador = $(".pagination");
  var items = 10, numeros = 6;
  init_paginator(paginador, items, numeros);
  set_callback(get_data_callback);
  cargaPagina(0);
}

var innerdivHtml1 = '<table class="table clients-contant-table mb-0">';
innerdivHtml1 += '<thead>';
innerdivHtml1 += '<tr>';
innerdivHtml1 += '<th scope="col">Servicio</th>';
innerdivHtml1 += '<th scope="col">Unidad de Negocio</th>';
innerdivHtml1 += '<th scope="col">Maquinaria</th>';
innerdivHtml1 += '<th scope="col">Medida</th>';
innerdivHtml1 += '<th scope="col">Precio</th>';
innerdivHtml1 += '<th scope="col">Pago al Operador</th>';
innerdivHtml1 += '<th scope="col">Estado</th>';
innerdivHtml1 += '<th scope="col">Editar &amp; Eliminar</th>';
innerdivHtml1 += '</tr>';
innerdivHtml1 += '</thead>';
innerdivHtml1 += '<tbody></tbody></table>';

function get_data_callback() {
  $("#divPaginador").addClass("d-none");
  $("#divDatos").html(innerdivHtml1);

  // Captura de filtros
  var valor = $("#txtBuscar").val();
  var id_tipo_servicio = $("#cboTipoBuscar").val();
  var id_maquinaria = $("#id_maquinaria").val() || ""; // Filtro maquinaria
  var id_unidad_medida = $("#id_unidad_medida").val() || "";
  $.ajax({
    data: {
      limit: itemsPorPagina,
      offset: desde,
      valor: valor,
      id_tipo_servicio: id_tipo_servicio,
      id_maquinaria: id_maquinaria,
      id_unidad_medida: id_unidad_medida
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
    url: 'ajax.php?accion=showServicio'
  }).done(function (data, textStatus, jqXHR) {
    try {
      var data1 = JSON.parse(data);
      console.log(data1); // Depuración para verificar datos

      if (data1["error"] == "NO") {
        if (pagina == 0) {
          creaPaginador(data1["cantidad"]);
        }

        // Genera el cuerpo de la tabla
        var innerdivHtml = '<table class="table clients-contant-table mb-0">';
        innerdivHtml += '<thead>';
        innerdivHtml += '<tr>';
        innerdivHtml += '<th scope="col">Servicio</th>';
        innerdivHtml += '<th scope="col">Unidad de Negocio</th>';
        innerdivHtml += '<th scope="col">Maquinaria</th>';
        innerdivHtml += '<th scope="col">Medida</th>';
        innerdivHtml += '<th scope="col">Precio</th>';
        innerdivHtml += '<th scope="col">Pago al Operador</th>';
        innerdivHtml += '<th scope="col">Estado</th>';
        innerdivHtml += '<th scope="col">Editar &amp; Eliminar</th>';
        innerdivHtml += '</tr>';
        innerdivHtml += '</thead><tbody>';

        var o = data1["data"];

        for (var i = 0; i < o.length; i++) {
          innerdivHtml += '<tr>';
          innerdivHtml += '<td>';
          innerdivHtml += '<div class="d-flex align-items-center">';
          innerdivHtml += '<div class="bg-img mr-4">';
          innerdivHtml += '<img src="' + o[i].src_imagen + '" class="img-fluid" alt="Clients-01">';
          innerdivHtml += '</div>';
          innerdivHtml += '<p class="font-weight-bold">' + o[i].name_servicio + '</p>';
          innerdivHtml += '</div>';
          innerdivHtml += '</td>';
          innerdivHtml += '<td>' + o[i].name_tipo + '</td>';
          innerdivHtml += '<td>' + o[i].maquinaria_descripcion + '</td>'; // Cambio aplicado
          innerdivHtml += '<td>' + o[i].unidad + '</td>'; // Cambio aplicado
          innerdivHtml += '<td>' + o[i].signo_moneda + ' ' + o[i].precio + '</td>';
          innerdivHtml += '<td>' + o[i].signo_moneda + ' ' + o[i].pago_operador + '</td>';
          innerdivHtml += o[i].estado;
          innerdivHtml += '    <td>';
          innerdivHtml += o[i].flag_editar;
          innerdivHtml += o[i].flag_eliminar;
          innerdivHtml += '    </td>';
          innerdivHtml += '</tr>';
        }

        innerdivHtml += '</tbody></table>';

        $("#divDatos").html(innerdivHtml);
        $("#divSinDatos").addClass("d-none");
        $("#divPaginador").removeClass("d-none");
        console.log(data1.data);

      } else {
        console.log(data1["message"]);
        $("#divSinDatos").removeClass("d-none");
        $("#divPaginador").addClass("d-none");
        $("#divDatos").html("");
      }
    } catch (err) {
      runAlert("Message", err + data, "warning");
      $("#divSinDatos").removeClass("d-none");
      $("#divPaginador").addClass("d-none");
      $("#divDatos").html("");
    }

  }).fail(function (jqXHR, textStatus, textError) {
    runAlert("Oh No...!!!", "Error al realizar la petición " + textError, "warning");
  });
}

function addClassDiv() {
  $("#panelForm").removeClass("d-none");
  $("#panelTabla").addClass("d-none");
  $("#panelOptions").addClass("d-none");
}

function removeClassDiv() {
  $("#panelForm").addClass("d-none");
  $("#panelTabla").removeClass("d-none");
  $("#panelOptions").removeClass("d-none");
  $("#frmDatos")[0].reset();
}

function mostrarImagen(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#img_destino').attr('src', e.target.result);
      $("#flag_imagen").val("1");
    }
    reader.readAsDataURL(input.files[0]);
  }else {
    $('#img_destino').attr('src', "resources/global/images/sin_imagen.png");
    $("#flag_imagen").val("0");
  }
}

$("#src_imagen").change(function(){
  mostrarImagen(this);
});

function saveOperation() {
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
      var form = $("#frmDatos");
      var formdata = false;
      if (window.FormData) {
        formdata = new FormData(form[0]);
      }
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goServicio",
        contentType: false,
        processData: false,
        data: formdata,
        success: function (data) {
          try {
            var response = JSON.parse(data);
            if (response['error'] == "SI") {
              runAlert("Oh No...!!!", response['message'], "warning");
            } else {
              removeClassDiv();
              showData();
              runAlert("Bien hecho...!!!", response['message'], "success");
            }
          } catch (e) {
            runAlert("Oh No...!!!", e + data, "error");
          }
        },
    		error: function (data) {
          runAlert("Oh No...!!!", data, "error");
        },
        beforeSend: function (xhr) {
          showHideLoader('block');
        },
        complete: function (jqXHR, textStatus) {
          showHideLoader('none');
        }
      });
    }
  });
}

function getDataEdit(id_servicio){
  $.ajax({
    type: "POST",
    data:{
  		id_servicio: id_servicio
		},

    url: "ajax.php?accion=getDataEditServicio",
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          $("#id_servicio").val(o[0].id_servicio);
          $("#id_tipo_servicio").val(o[0].id_tipo_servicio);
          $("#id_maquinaria").val(o[0].id_maquinaria);
          $("#id_unidad_medida").val(o[0].id_unidad_medida);
          $("#name_servicio").val(o[0].name_servicio);
          $("#descripcion_breve").val(o[0].descripcion_breve);
          $("#descripcion_larga").val(o[0].descripcion_larga);
          $("#precio").val(o[0].precio);
          $("#pago_operador").val(o[0].pago_operador);
          $("#id_moneda").val(o[0].id_moneda);
          var estado = o[0].estado;
          var flag_igv = o[0].flag_igv;
          $('#img_destino').attr('src', o[0].src_imagen);
          $("#accion").val("edit");
          $("#flag_imagen").val("0");
          estado=="activo" ? $("#estado").prop('checked', true) : $("#estado").prop('checked', false);
          flag_igv=="1" ? $("#flag_igv").prop('checked', true) : $("#flag_igv").prop('checked', false);
          var name_tipo = o[0].name_tipo;
          var id_tipo_servicio = o[0].id_tipo_servicio;
          var maquinaria_descripcion = o[0].maquinaria_descripcion;
          var id_maquinaria = o[0].id_maquinaria;
          var unidad = o[0].unidad;
          var id_unidad_medida = o[0].id_unidad_medida;
          var flag_encontro = false;
          $("#id_tipo_servicio option").each(function(){
            if ($(this).val() == id_tipo_servicio ){
              flag_encontro = true;
            }
          });
          if (!flag_encontro) {
            $('#id_tipo_servicio').append('<option value="' + id_tipo_servicio + '" selected>' + name_tipo + '</option>');
          }
          if (!flag_encontro) {
            $('#id_maquinaria').append('<option value="' + id_maquinaria + '" selected>' + maquinaria_descripcion + '</option>');
          }
          if (!flag_encontro) {
            $('#id_unidad_medida').append('<option value="' + id_unidad_medida + '" selected>' + unidad + '</option>');
          }
          addClassDiv();
        }else {
          runAlert("Message",data1["message"],"warning");
        }
      } catch (e) {
        runAlert("Oh No...!!!","Error en TryCatch: " + e + data,"error");
        showHideLoader('none');
      }
    },
    beforeSend: function (xhr) {
      showHideLoader('block');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      runAlert("Oh No...!!!","Error de petición: " + jqXHR,"warning");
    },
    complete: function (jqXHR, textStatus) {
      showHideLoader('none');
    }
  });
}

function deleteRegistro(id_servicio,servicio){

  try {

    var parametros = {
      "id_servicio" : id_servicio
    };

    Swal.fire({
      title: '¿Seguro de eliminar el servicio : ' + servicio + '?',
      text: "No podrás revertir esta operación.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar ahora!'
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=deleteServicio",
          datatype: "json",
          data: parametros,
          success: function(data){
            try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              }else {
                removeClassDiv();
                showData();
                runAlert("Bien hecho...!!!",response['message'],"success");
              }
            } catch (e) {
              runAlert("Oh No...!!!",e,"error");
            }
          },
          error: function(data){
            runAlert("Oh No...!!!",data,"error");
          },
          beforeSend: function (xhr) {
            showHideLoader('block');
          },
          complete: function (jqXHR, textStatus) {
            showHideLoader('none');
          }
        });
      }
    });

  } catch (e) {
    runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
  }
}
