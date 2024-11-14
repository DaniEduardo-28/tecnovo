
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  searching : false,
  paging : false,
  ordering : false,
  columns: [
    { 'data': 'num' },
    { 'data': 'options' },
    { 'data': 'id_compra' },
    { 'data': 'estado' },
    { 'data': 'doc_compra' },
    { 'data': 'doc_identidad' },
    { 'data': 'proveedor' },
    { 'data': 'direccion' },
    { 'data': 'fecha' },
    { 'data': 'moneda' },
    { 'data': 'metodo_pago' },
    { 'data': 'sub_total' },
    { 'data': 'igv' },
    { 'data': 'total' },
    { 'data': 'tipo_cambio' }
  ],
  columnDefs: [
    {
      "targets": [1,2,14],
      "visible": false,
      "searchable": false
    }
  ]
});

$(document).ready(function(){

  $("#txtFechaInicio").change(function() {
    showLista();
  });

  $("#txtFechaFin").change(function() {
    showLista();
  });

  showLista();

  $('#cboTipoDocVentaBuscar').change(function(){
    showLista();
  });

  $('#cboTipoDocuClieBuscar').change(function(){
    showLista();
  });

  $('#btnSearch').click(function(){
    showLista();
  });

  $('#btnReportePdf').click(function(){
    //
    try {

      var id_doc_compra = $("#cboTipoDocCompraBuscar").val();
      var id_doc_proveedor = $("#cboTipoDocuProBuscar").val();
      var fecha_inicio = $("#txtFechaInicio").val();
      var fecha_fin = $("#txtFechaFin").val();
      var valor = $("#txtBuscar").val();
      var link="?view=reportecompraspdf&id_doc_compra=" + id_doc_compra + "&id_doc_proveedor=" + id_doc_proveedor +
      "&fecha_inicio=" + fecha_inicio + "&fecha_fin=" + fecha_fin + "&valor=" + valor;
      window.open(link);

    } catch (e) {
      console.log(e);
    }

  });

  $('#btnReporteExcel').click(function(){
    //
    try {

      var id_doc_compra = $("#cboTipoDocCompraBuscar").val();
      var id_doc_proveedor = $("#cboTipoDocuProBuscar").val();
      var fecha_inicio = $("#txtFechaInicio").val();
      var fecha_fin = $("#txtFechaFin").val();
      var valor = $("#txtBuscar").val();
      var link="?view=reportecomprasexcel&id_doc_compra=" + id_doc_compra + "&id_doc_proveedor=" + id_doc_proveedor +
      "&fecha_inicio=" + fecha_inicio + "&fecha_fin=" + fecha_fin + "&valor=" + valor;
      window.open(link);

    } catch (e) {
      console.log(e);
    }

  });

});

function showLista(){

  table.clear().draw();
  $("#divPaginador").addClass("d-none");
  paginador = $("#paginador");
  var items = 10, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback);
  cargaPagina(0);

}

function get_data_callback(){
  table.clear().draw();
  var id_doc_compra = $("#cboTipoDocCompraBuscar").val();
  var id_doc_proveedor = $("#cboTipoDocuProBuscar").val();
  var fecha_inicio = $("#txtFechaInicio").val();
  var fecha_fin = $("#txtFechaFin").val();
  var valor = $("#txtBuscar").val();
  $("#divPaginador").addClass("d-none");
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      id_doc_compra: id_doc_compra,
      id_doc_proveedor: id_doc_proveedor,
      fecha_inicio: fecha_inicio,
      fecha_fin: fecha_fin,
      valor: valor
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
		url:'ajax.php?accion=showOrdenCompraReporte'
	}).done(function(data,textStatus,jqXHR){
    try {
      var data1 = JSON.parse(data);
      if (data1["error"]=="NO") {

        if(pagina==0){
          creaPaginador(data1["cantidad"]);
        }

        var o = data1["data"];
        for (var i = 0; i < o.length; i++) {
          table.row.add({
            "num": o[i].num,
            "options": o[i].options,
            "id_compra": o[i].id_compra,
            "estado": o[i].estado,
            "doc_compra": o[i].name_documento_compra + ' ' + o[i].serie + '-' + o[i].correlativo,
            "doc_identidad": o[i].name_documento_proveedor + ' ' + o[i].numero_documento_proveedor,
            "proveedor": o[i].proveedor,
            "direccion": o[i].direccion,
            "fecha": o[i].fecha,
            "moneda": o[i].abreviatura_moneda,
            "metodo_pago": o[i].name_forma_pago,
            "sub_total": o[i].signo_moneda + o[i].sub_total,
            "igv": o[i].signo_moneda + o[i].igv,
            "total": o[i].signo_moneda + o[i].total,
            "tipo_cambio": o[i].signo_moneda_cambio + o[i].monto_tipo_cambio
          }).draw();
        }

        $("#divPaginador").removeClass("d-none");

      } else {
        console.log(data1["message"]);
        $("#divPaginador").addClass("d-none");
      }
    }
    catch(err) {
      runAlert("Message",err+data,"warning");
      $("#divPaginador").addClass("d-none");
    }

	}).fail(function(jqXHR,textStatus,textError){
    runAlert("Oh No...!!!","Error al realizar la petición " + textError,"warning");
	});
}
