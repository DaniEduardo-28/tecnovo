var table = $('#example').DataTable({
  language: languageSpanish,
  destroy: true,
  ordering: false,
  searching: false,
  paging: false,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_promocion' },
    { 'data': 'id_cliente' },
    { 'data': 'titulo' },
    { 'data': 'descripcion' },
    { 'data': 'precio' },
    { 'data': 'fecha_inicio' },
    { 'data': 'fecha_fin' },
    { 'data': 'acciones' }
  ],
  columnDefs: [
    {
      "targets": [1,2,4,5],
      "visible": false,
      "searchable": true
    }
  ]
});

$(document).ready(function(){

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

  showData();

  $("#frmDatos").submit(function(e) {
    e.preventDefault();
    saveOperation();
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
innerdivHtml1 += '<th scope="col">Cliente</th>';
innerdivHtml1 += '<th scope="col">Documento</th>';
innerdivHtml1 += '<th scope="col">Dirección</th>';
innerdivHtml1 += '<th scope="col">Teléfono</th>';
innerdivHtml1 += '<th scope="col">Correo</th>';
innerdivHtml1 += '<th scope="col">Estado</th>';
innerdivHtml1 += '<th scope="col">Acciones</th>';
innerdivHtml1 += '</tr>';
innerdivHtml1 += '</thead>';
innerdivHtml1 += '<tbody></tbody></table>';

function get_data_callback(){
  $("#divPaginador").addClass("d-none");
  $("#divDatos").html(innerdivHtml1);
  var valor = $("#txtBuscar").val();
  var id_documento = $("#cboTipoBuscar").val();
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      valor: valor,
      id_documento: id_documento
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
		url:'ajax.php?accion=showClienteReporte'
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
        innerdivHtml += '<th scope="col">Cliente</th>';
        innerdivHtml += '<th scope="col">Documento</th>';
        innerdivHtml += '<th scope="col">Dirección</th>';
        innerdivHtml += '<th scope="col">Teléfono</th>';
        innerdivHtml += '<th scope="col">Correo</th>';
        innerdivHtml += '<th scope="col">Estado</th>';
        innerdivHtml += '<th scope="col">Acciones</th>';
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
          innerdivHtml += '<p class="font-weight-bold">' + o[i].apellidos + ' ' + o[i].nombres + '</p>';
          innerdivHtml += '</div>';
          innerdivHtml += '</td>';
          innerdivHtml += '<td>' + o[i].name_documento + ' ' + o[i].num_documento + '</td>';
          innerdivHtml += '<td>' + o[i].direccion + '</td>';
          innerdivHtml += '<td>' + o[i].telefono + '</td>';
          innerdivHtml += '<td>' + o[i].correo + '</td>';
          innerdivHtml += '<td>' + o[i].estado + '</td>';
          innerdivHtml += '<td>' + o[i].options + '</td>';
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

function saveOperation(){

  Swal.fire({
    title: '¿Seguro de agregar la promoción?',
    text: "",
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
        url: "ajax.php?accion=goPromocionCliente",
        contentType: false,
        processData: false,
        data: formdata,
        success: function(data){
    			try {
            var response = JSON.parse(data);
            if (response['error']=="SI") {
              runAlert("Oh No...!!!",response['message'],"warning");
            }else {
              runAlert("Bien hecho...!!!",response['message'],"success");
              $('#AddModal').modal('hide');
              $('#frmDatos')[0].reset();
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

function addPromocion(id_cliente,cliente){
  $("#frmDatos")[0].reset();
  $("#txtCliente").val(cliente);
  $("#id_cliente").val(id_cliente);
  $('#img_destino').attr('src', "resources/global/images/sin_imagen.png");
  $('#AddModal').modal('show');
}

function verPromociones(id_cliente,cliente){
  $.ajax({
    url: "ajax.php?accion=showPromocionesCliente",
    data: {
      id_cliente: id_cliente
    },
    method: "POST",
    success : function(data) {
      table.clear().draw();
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            table.row.add({
              "num": o[i].num,
              "id_promocion": o[i].id_promocion,
              "id_cliente": o[i].id_cliente,
              "titulo": o[i].titulo,
              "descripcion": o[i].descripcion,
              "precio": o[i].precio,
              "fecha_inicio": o[i].fecha_inicio,
              "fecha_fin": o[i].fecha_fin,
              "acciones": o[i].options
            }).draw();
          }
          $('#txtClienteVer').val(cliente);
          $('#showModal').modal('show');
        } else {
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
      table.clear().draw();
    },
    complete: function (jqXHR, textStatus) {
      showHideLoader('none');
    }
  });

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

function eliminarPromocion(id_promocion){
  //
  try {

    Swal.fire({
      title: '¿Seguro de eliminar esta promoción?',
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
          url: "ajax.php?accion=eliminarPromocionCliente",
          datatype: "json",
          data:{
            id_promocion: id_promocion
          },
          success: function(data){
            try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              } else {
                runAlert("Bien hecho...!!!",response['message'],"success");
                quitarLista(id_promocion);
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
    console.log(e);
  }
}

function quitarLista(id_promocion){

  $('#example > tbody  > tr').each(function(){

    var data = table.row($(this)).data();
    if (data['id_promocion'] == id_promocion) {
      table
        .row($(this))
        .remove()
        .draw();
    }

  });

}
