$(document).ready(function(){

  $("#panelForm").addClass("d-none");
  $("#divSinDatos").addClass("d-none");

  $('#btnSearch').click(function(){
    showData();
  });

  $("#txtBuscar").keypress(function(e) {
    if (e.which == 13 ) {
      showData();
    }
  });

  $("#cboTipoBuscar").change(function(){
    showData();
	});

  $('#btnAdd').click(function(){
    $('#frmDatos')[0].reset();
    $('#img_destino').attr('src', "resources/global/images/sin_imagen.png");
    $("#flag_imagen").val("0");
    $("#accion").val("add");
    addClassDiv();
  });

  $("#frmDatos").submit(function(e) {
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
  });

  showData();

  $("#precio_venta").change(function(){
    var element = $("#precio_venta");
    element.val(dosDecimales(element));
  });

  $("#precio_compra").change(function(){
    var element = $("#precio_compra");
    element.val(dosDecimales(element));
  });

});

function showData(){

  paginador = $(".pagination");
  var items = 10, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback);
  cargaPagina(0);

}

var innerdivHtml1 = '<table class="table clients-contant-table mb-0">';
innerdivHtml1 += '<thead>';
innerdivHtml1 += '<tr>';
innerdivHtml1 += '<th scope="col">Producto</th>';
innerdivHtml1 += '<th scope="col">Categoria</th>';
innerdivHtml1 += '<th scope="col">Descripción</th>';
innerdivHtml1 += '<th scope="col">Stock</th>';
innerdivHtml1 += '<th scope="col">Stock Mínimo</th>';
innerdivHtml1 += '<th scope="col">Precio Compra</th>';
innerdivHtml1 += '<th scope="col">Precio Venta</th>';
innerdivHtml1 += '<th scope="col">Estado</th>';
innerdivHtml1 += '<th scope="col">Editar &amp; Eliminar</th>';
innerdivHtml1 += '</tr>';
innerdivHtml1 += '</thead>';
innerdivHtml1 += '<tbody></tbody></table>';

function get_data_callback(){
  $("#divPaginador").addClass("d-none");
  $("#divDatos").html(innerdivHtml1);
  var valor = $("#txtBuscar").val();
  var id_categoria = $("#cboCategoriaBuscar").val();
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      valor: valor,
      id_categoria: id_categoria
		},
    beforeSend: function (xhr) {
      showHideLoader('block');
    },
    complete: function (jqXHR, textStatus) {
      showHideLoader('none');
      if (totalPaginas==1 && pagina==0) {
        paginador.find(".next_link").hide();
      }
    },
		type:"POST",
		url:'ajax.php?accion=showAccesorio'
	}).done(function(data,textStatus,jqXHR){
    try {
      var data1 = JSON.parse(data);
      if (data1["error"]=="NO") {

        if(pagina==0){
          creaPaginador(data1["cantidad"]);
        }

        // genera el cuerpo de la tabla
        var innerdivHtml = '<table class="table clients-contant-table mb-0">';
        innerdivHtml += '<thead>';
        innerdivHtml += '<tr>';
        innerdivHtml += '<th scope="col">Producto</th>';
        innerdivHtml += '<th scope="col">Categoria</th>';
        innerdivHtml += '<th scope="col">Descripción</th>';
        innerdivHtml += '<th scope="col">Stock</th>';
        innerdivHtml += '<th scope="col">Stock Mínimo</th>';
        innerdivHtml += '<th scope="col">Precio Compra</th>';
        innerdivHtml += '<th scope="col">Precio Venta</th>';
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
          innerdivHtml += '<p class="font-weight-bold">' + o[i].name_accesorio + '</p>';
          innerdivHtml += '</div>';
          innerdivHtml += '</td>';
          innerdivHtml += '<td>' + o[i].name_categoria + '</td>';
          innerdivHtml += '<td>' + o[i].descripcion + '</td>';
          innerdivHtml += '<td>' + o[i].stock + ' ' + o[i].name_unidad + '</td>';
          innerdivHtml += '<td>' + o[i].stock_minimo + ' ' + o[i].name_unidad + '</td>';
          innerdivHtml += '<td>' + o[i].signo_moneda + ' ' + o[i].precio_compra + '</td>';
          innerdivHtml += '<td>' + o[i].signo_moneda + ' ' + o[i].precio_venta + '</td>';
          innerdivHtml += o[i].estado;
          innerdivHtml += '<td>';
          innerdivHtml += o[i].flag_editar;
          innerdivHtml += o[i].flag_eliminar;
          innerdivHtml += '    </td>';
          innerdivHtml += '</tr>';
        }

        innerdivHtml += '</tbody></table>';

        $("#divDatos").html(innerdivHtml);
        $("#divSinDatos").addClass("d-none");
        $("#divPaginador").removeClass("d-none");

      }else {
        console.log(data1["message"]);
        $("#divSinDatos").removeClass("d-none");
        $("#divPaginador").addClass("d-none");
        $("#divDatos").html("");
      }
    }
    catch(err) {
      runAlert("Message",err+data,"warning");
      $("#divSinDatos").removeClass("d-none");
      $("#divPaginador").addClass("d-none");
      $("#divDatos").html("");
    }

	}).fail(function(jqXHR,textStatus,textError){
    runAlert("Oh No...!!!","Error al realizar la petición " + textError,"warning");
	});
}

function addClassDiv(){
  $("#panelForm").removeClass("d-none");
  $("#panelTabla").addClass("d-none");
  $("#panelOptions").addClass("d-none");
}

function removeClassDiv(){
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

function saveOperation(){

  Swal.fire({
    title: '¿Seguro de confirmar la operación?',
    text: "No podrás revertir esta operación.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#22c63b',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Realizar ahora!'
  }).then(function(result) {
    if (result.value) {
      var form = $("#frmDatos");
      var formdata = false;
      if (window.FormData){
          formdata = new FormData(form[0]);
      }
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goAccesorio",
        contentType: false,
        processData: false,
        data: formdata,
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
            runAlert("Oh No...!!!",e + data,"error");
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
}

function getDataEdit(id_accesorio){
  $.ajax({
    type: "POST",
    data:{
  		id_accesorio: id_accesorio
		},

    url: "ajax.php?accion=getDataEditAccesorio",
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          $("#id_accesorio").val(o[0].id_accesorio);
          $("#id_categoria").val(o[0].id_categoria);
          $("#name_accesorio").val(o[0].name_accesorio);
          $("#descripcion").val(o[0].descripcion);
          $("#stock").val(o[0].stock);
          $("#stock_minimo").val(o[0].stock_minimo);
          $("#precio_compra").val(o[0].precio_compra);
          $("#precio_venta").val(o[0].precio_venta);
          $("#id_unidad_medida").val(o[0].id_unidad_medida);
          $("#id_moneda").val(o[0].id_moneda);
          var estado = o[0].estado;
          var flag_igv = o[0].flag_igv;
          $('#img_destino').attr('src', o[0].src_imagen);
          $("#accion").val("edit");
          $("#flag_imagen").val("0");
          estado=="activo" ? $("#estado").prop('checked', true) : $("#estado").prop('checked', false);
          flag_igv=="1" ? $("#flag_igv").prop('checked', true) : $("#flag_igv").prop('checked', false);
          var name_categoria = o[0].name_categoria;
          var id_categoria = o[0].id_categoria;
          var flag_encontro = false;
          $("#id_categoria option").each(function(){
            if ($(this).val() == id_categoria ){
              flag_encontro = true;
            }
          });
          if (!flag_encontro) {
            $('#id_categoria').append('<option value="' + id_categoria + '" selected>' + name_categoria + '</option>');
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

function deleteRegistro(id_accesorio,accesorio){

  try {

    var parametros = {
      "id_accesorio" : id_accesorio
    };

    Swal.fire({
      title: '¿Seguro de eliminar el Producto : ' + accesorio + '?',
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
          url: "ajax.php?accion=deleteAccesorio",
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
