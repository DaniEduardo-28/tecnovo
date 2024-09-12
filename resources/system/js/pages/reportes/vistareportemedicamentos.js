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

  $('#btnReportePdf').click(function(){
    //
    try {

      var valor = $("#txtBuscar").val();
      var id_tipo_medicamento = $("#cboTipoBuscar").val();
      var link="?view=reportemedicamentopdf&valor=" + valor + "&id_tipo_medicamento=" + id_tipo_medicamento;
      window.open(link);

    } catch (e) {
      console.log(e);
    }

  });

  $('#btnReporteExcel').click(function(){
    //
    try {

      var valor = $("#txtBuscar").val();
      var id_tipo_medicamento = $("#cboTipoBuscar").val();
      var link="?view=reportemedicamentoexcel&valor=" + valor + "&id_tipo_medicamento=" + id_tipo_medicamento;
      window.open(link);

    } catch (e) {
      console.log(e);
    }

  });


});

function showData(){

  paginador = $(".pagination");
  var items = 6, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback);
  cargaPagina(0);

}

var innerdivHtml1 = '<table class="table clients-contant-table mb-0">';
innerdivHtml1 += '<thead>';
innerdivHtml1 += '<tr>';
innerdivHtml1 += '<th scope="col">Medicamento</th>';
innerdivHtml1 += '<th scope="col">Tipo</th>';
innerdivHtml1 += '<th scope="col">Descripción</th>';
innerdivHtml1 += '<th scope="col">Stock</th>';
innerdivHtml1 += '<th scope="col">Stock Mínimo</th>';
innerdivHtml1 += '<th scope="col">Precio Compra</th>';
innerdivHtml1 += '<th scope="col">Precio Venta</th>';
innerdivHtml1 += '<th scope="col">Estado</th>';
innerdivHtml1 += '</tr>';
innerdivHtml1 += '</thead>';
innerdivHtml1 += '<tbody></tbody></table>';

function get_data_callback(){
  $("#divPaginador").addClass("d-none");
  $("#divDatos").html(innerdivHtml1);
  var valor = $("#txtBuscar").val();
  var id_tipo_medicamento = $("#cboTipoBuscar").val();
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      valor: valor,
      id_tipo_medicamento: id_tipo_medicamento
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
		url:'ajax.php?accion=showMedicamento'
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
        innerdivHtml += '<th scope="col">Medicamento</th>';
        innerdivHtml += '<th scope="col">Tipo</th>';
        innerdivHtml += '<th scope="col">Descripción</th>';
        innerdivHtml += '<th scope="col">Stock</th>';
        innerdivHtml += '<th scope="col">Stock Mínimo</th>';
        innerdivHtml += '<th scope="col">Precio Compra</th>';
        innerdivHtml += '<th scope="col">Precio Venta</th>';
        innerdivHtml += '<th scope="col">Estado</th>';
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
          innerdivHtml += '<p class="font-weight-bold">' + o[i].name_medicamento + '</p>';
          innerdivHtml += '</div>';
          innerdivHtml += '</td>';
          innerdivHtml += '<td>' + o[i].name_tipo + '</td>';
          innerdivHtml += '<td>' + o[i].descripcion + '</td>';
          innerdivHtml += '<td>' + o[i].stock + ' ' + o[i].name_unidad + '</td>';
          innerdivHtml += '<td>' + o[i].stock_minimo + ' ' + o[i].name_unidad + '</td>';
          innerdivHtml += '<td>' + o[i].signo_moneda + ' ' + o[i].precio_compra + '</td>';
          innerdivHtml += '<td>' + o[i].signo_moneda + ' ' + o[i].precio_venta + '</td>';
          innerdivHtml += o[i].estado;
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
