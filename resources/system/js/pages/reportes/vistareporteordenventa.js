
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  searching : false,
  paging : false,
  ordering : false,
  columns: [
    { 'data': 'num' },
    { 'data': 'options' },
    { 'data': 'id_venta' },
    { 'data': 'estado' },
    { 'data': 'doc_venta' },
    { 'data': 'doc_identidad' },
    { 'data': 'cliente' },
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
      "targets": [2,14],
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

      var id_doc_venta = $("#cboTipoDocVentaBuscar").val();
      var id_doc_cliente = $("#cboTipoDocuClieBuscar").val();
      var fecha_inicio = $("#txtFechaInicio").val();
      var fecha_fin = $("#txtFechaFin").val();
      var valor = $("#txtBuscar").val();
      var link="?view=reporteventaspdf&id_doc_venta=" + id_doc_venta + "&id_doc_cliente=" + id_doc_cliente +
      "&fecha_inicio=" + fecha_inicio + "&fecha_fin=" + fecha_fin + "&valor=" + valor;
      window.open(link);

    } catch (e) {
      console.log(e);
    }

  });

  $('#btnReporteExcel').click(function(){
    //
    try {

      var id_doc_venta = $("#cboTipoDocVentaBuscar").val();
      var id_doc_cliente = $("#cboTipoDocuClieBuscar").val();
      var fecha_inicio = $("#txtFechaInicio").val();
      var fecha_fin = $("#txtFechaFin").val();
      var valor = $("#txtBuscar").val();
      var link="?view=reporteventasexcel&id_doc_venta=" + id_doc_venta + "&id_doc_cliente=" + id_doc_cliente +
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
  var id_doc_venta = $("#cboTipoDocVentaBuscar").val();
  var id_doc_cliente = $("#cboTipoDocuClieBuscar").val();
  var fecha_inicio = $("#txtFechaInicio").val();
  var fecha_fin = $("#txtFechaFin").val();
  var valor = $("#txtBuscar").val();
  $("#divPaginador").addClass("d-none");
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      id_doc_venta: id_doc_venta,
      id_doc_cliente: id_doc_cliente,
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
		url:'ajax.php?accion=showOrdenVentaReporte'
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
            "id_venta": o[i].id_venta,
            "estado": o[i].estado,
            "doc_venta": o[i].name_documento_venta + ' ' + o[i].serie + '-' + o[i].correlativo,
            "doc_identidad": o[i].name_documento_cliente + ' ' + o[i].numero_documento_cliente,
            "cliente": o[i].cliente,
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

function verRegistro(id_venta){
  table_detalle.clear().draw();
  $("#btnImprimir").addClass("d-none");
  $.ajax({
    type: "POST",
    data:{
  		id_venta: id_venta
		},
    url: "ajax.php?accion=getDataOrdenVentaReporte",
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          $("#id_venta").val(o[0].id_venta);
          $("#accion").val("edit");
          $("#codigo_documento_venta").val(o[0].id_documento_venta);
          $("#serie").val(o[0].serie);
          $("#correlativo").val(o[0].correlativo);
          $("#codigo_documento_cliente").val(o[0].id_documento_cliente);
          $("#numero_documento_cliente").val(o[0].numero_documento_cliente);
          $("#nombres").val(o[0].cliente);
          $("#apellidos").val("");
          $("#direccion").val(o[0].direccion);
          $("#telefono").val(o[0].telefono);
          $("#correo").val(o[0].correo);
          $("#fecha").val(o[0].fecha);
          $("#codigo_moneda").val(o[0].id_moneda);
          $("#codigo_forma_pago").val(o[0].id_forma_pago);

          if ((o[0].estado=="2" || o[0].estado=="3") && o[0].flag_enviado == "1") {
            $("#btnImprimir").removeClass("d-none");
          }

          for (var i = 0; i < o.length; i++) {

            var cod_producto = o[i].detalle_cod_producto;
            var name_tabla = o[i].detalle_name_tabla;
            var descripcion = o[i].detalle_descripcion;
            var cantidad = o[i].detalle_cantidad;
            var precio_unitario = o[i].detalle_precio_unitario;
            var descuento = o[i].detalle_descuento;
            var inputCantidad = '<input readonly onkeypress="calcularTotal();" onchange="calcularTotal();" type="number" value="' + cantidad + '" class="form-control" min="1" style="width:90px;">';
            var inputDescuento = '<input readonly onkeypress="calcularTotal();" onchange="calcularTotal();" type="number" value="' + descuento + '" class="form-control" min="0" style="width:90px;">';
            var botonEliminar = '';
            var sub_total = o[i].detalle_sub_total;
            var igv = o[i].detalle_igv;
            var total = o[i].detalle_total;

            table_detalle.row.add({
              "name_tabla": name_tabla,
              "codigo": cod_producto,
              "descripcion": descripcion,
              "cantidad": inputCantidad,
              "precio_unitario": precio_unitario,
              "descuento": inputDescuento,
              "subtotal": sub_total,
              "tipo_igv": 1,
              "igv": igv,
              "total": total,
              "eliminar_item": botonEliminar
            }).draw();

            calcularTotal();

          }

          addClassDiv();
          $("#btnSave").addClass("d-none");
          $("#btnSaveBorrador").addClass("d-none");
          $("#btnAgregarDetalle").addClass("d-none");

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
