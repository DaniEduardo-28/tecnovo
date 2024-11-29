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
      "targets": [2,7,9,10,11,12,13,14],
      "visible": false,
      "searchable": false
    }
  ]
});

var table_detalle = $('#example1').DataTable({
  language: languageSpanish,
  destroy : true,
  searching : false,
  paging : false,
  ordering : false,
  columns: [
    { 'data': 'name_tabla' },
    { 'data': 'codigo' },
    { 'data': 'descripcion' },
    { 'data': 'cantidad' },
    { 'data': 'precio_unitario' },
    { 'data': 'descuento' },
    { 'data': 'subtotal' },
    { 'data': 'tipo_igv' },
    { 'data': 'igv' },
    { 'data': 'total' },
    { 'data': 'notas' },
    { 'data': 'id_maquinaria' },
    { 'data': 'eliminar_item' }
  ],
  columnDefs: [
    {
      "targets": [0,1,4,5,6,7,8,9],
      "visible": false,
      "searchable": false
    }
  ]
});

var table_detalle_modal = $('#example2').DataTable({
  language: languageSpanish,
  destroy : true,
  searching : false,
  paging : false,
  ordering : false,
  columns: [
    { 'data': 'num' },
    { 'data': 'cod_producto' },
    { 'data': 'descripcion' },
    { 'data': 'cantidad' },
    { 'data': 'precio_unitario' },
    { 'data': 'precio_unitario_string' },
    { 'data': 'seleccionar' }
  ],
  columnDefs: [
    {
      "targets": [1,4,5],
      "visible": false,
      "searchable": false
    }
  ]
});

$(document).ready(function(){

  $('#example2 tbody').on( 'click', '#btnSeleccionar', function () {
    try {

      var num = table_detalle.data().count() + 1;
      var data = table_detalle_modal.row( $(this).parents('tr') ).data();
      var cod_producto = data["cod_producto"];
      var name_tabla = $('input:radio[name=opcion_busqueda]:checked').val();
      if (num>1) {
        if (verificarproductoontable(name_tabla,cod_producto)==true) {
          generateAlert('warning', 'El Producto ya se encuentra agregado a la lista.');
          return;
        }
      }
      var descripcion = data["descripcion"];
      var cantidad = $(this).parents("tr").find("td").eq(2).find("input").val();
    var precio_unitario = 1;
    var descuento = 0;
      var inputCantidad = '<input onkeypress="calcularTotal();" onchange="calcularTotal();" type="number" value="' + cantidad + '" class="form-control" min="1" style="width:90px;">';
      var inputDescuento = '<input type="number" value="0" class="form-control" min="0" style="width:90px;" readonly>';
      var botonEliminar = '<a href="javascript:void(0);" id="botonEliminar" class="btn btn-danger"><i class="fa fa-close"></i></a>';

      precio_unitario = (precio_unitario/1.18).toFixed(3);
      var sub_total = (1 * cantidad).toFixed(2);
      var igv = (sub_total * 0.18).toFixed(2);
      var total = (parseFloat(sub_total) + parseFloat(igv)).toFixed(2);

      table_detalle.row.add({
        "name_tabla": name_tabla,
        "codigo": cod_producto,
        "descripcion": descripcion,
        "cantidad": inputCantidad,
        "precio_unitario": precio_unitario,
        "descuento": 0,
        "subtotal": sub_total,
        "tipo_igv": 1,
        "igv": igv,
        "total": total,
        "notas": '<input class="form-control" value="" type="text">',
        "id_maquinaria": '<input class="form-control" value="" type="text">',
        "eliminar_item": botonEliminar
      }).draw();

      generateAlert('success', '<h5 style="text-color:#ffffff">Agregado</h5><br><h6 style="text-color:#f2f9f1">' + cantidad + ' ' + descripcion + ' al precio de ' + precio_unitario + ' c/u.</h6>');
      calcularTotal();

    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  });

  // Consolidar eventos de validación en el campo de número de documento del proveedor
  $("#numero_documento_cliente").on("keypress blur", function (event) {
    if (event.type === "keypress" && event.which == 13) {
      validarYEnviar();
    } else if (event.type === "blur") {
      validarYEnviar();
    }
  });

  // Función de validación y consulta de datos del proveedor
  function validarYEnviar() {
    var number_document = $("#numero_documento_cliente").val();
    var id_document = $("#codigo_documento_cliente").val();

    // Validar que tenga 8 o 11 dígitos
    if (number_document.length == 8 || number_document.length == 11) {
      // Verificar si el tipo de documento es válido
      if (id_document != 1 && id_document != 3) {
        console.log("Tipo de documento inválido.");
        return false;
      }
      // Determinar el tipo de documento: DNI o RUC
      var tipo = id_document == 1 ? 'dni' : 'ruc';

      // Solicitud AJAX
      $.ajax({
        url: "ajax.php?accion=buscar-" + tipo,
        method: "POST",
        dataType: "json",
        data: { dni: number_document, ruc: number_document },
        success: function (response) {
          if (response.success) {
            let nombres = id_document == 1 ? response.data.nombres : response.data.nombre_o_razon_social;
            let apellidos = id_document == 1 ? response.data.apellido_paterno + " " + response.data.apellido_materno : '';
            let direccion = id_document == 3 ? response.data.direccion_completa : '';

            // Mostrar los datos en los campos correspondientes
            $("#nombres").val(nombres);
            $("#apellidos").val(apellidos);
            $("#direccion").val(direccion);
          } else {
            console.log("Error en la API: " + response.error);
            limpiarCampos();
          }
        },
        error: function (xhr, status, error) {
          console.log("Error en la solicitud AJAX: " + error);
          limpiarCampos();
        }
      });
    } else {
      alert("El número de documento debe tener 8 o 11 dígitos.");
    }
  }

  // Función para limpiar los campos de datos del proveedor
  function limpiarCampos() {
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#direccion").val("");
  }


  $('#example1 tbody').on( 'click', '#botonEliminar', function () {
      table_detalle.row($(this).parents('tr')).remove().draw();
      calcularTotal();
  });

  $("#numero_documento_cliente").keypress(function(event) {
    if (event.which==13) {

     event.preventDefault();

     if ($("#codigo_documento_cliente").val()=="") {
      runAlert("Advertencia","Seleccione un documento de identidad del cliente.","warning");
      return;
     }

     if ($("#numero_documento_cliente").val()=="") {
      runAlert("Advertencia","Ingrese un número de documento del cliente.","warning");
      return;
     }

     /* Start Ajax */
     $.ajax({
       type: "POST",
       data:{
        id_documento: $("#codigo_documento_cliente").val(),
        num_documento: $("#numero_documento_cliente").val()
      },
       url: "ajax.php?accion=getDataClienteForDocumento",
       success : function(data) {
         try {
           var data1 = JSON.parse(data);
           if (data1["error"]=="NO") {
             var o = data1["data"];
             $("#nombres").val(o[0].nombres);
             $("#apellidos").val(o[0].apellidos);
             $("#direccion").val(o[0].direccion);
             $("#telefono").val(o[0].telefono);
             $("#correo").val(o[0].correo);
           } else {
             console.log(data1["message"]);
             $("#nombres").val("");
             $("#apellidos").val("");
             $("#direccion").val("");
             $("#telefono").val("");
             $("#correo").val("");
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
     /* End Ajax */

   }else {
     $("#nombres").val("");
     $("#apellidos").val("");
     $("#direccion").val("");
     $("#telefono").val("");
     $("#correo").val("");
   }

  });

  $("#txtMontoRecibido").keypress(function(event) {
    if (event.which==13) {
      event.preventDefault();
      try{
        var monto_recibido = parseFloat($("#txtMontoRecibido").val());
        var total = parseFloat($("#txtTotal").val());
        if (monto_recibido == 0 || monto_recibido == "") {
          $("#txtMontoRecibido").val("0");
          $("#txtVuelto").val("0");
          return;
        }
        var vuelto = parseFloat(monto_recibido - total);
        $("#txtMontoRecibido").val(monto_recibido.toFixed(2));
        $("#txtVuelto").val(vuelto.toFixed(2));
      }catch(e) {
        console.log(e);
        $("#txtMontoRecibido").val("0");
        $("#txtVuelto").val("0");
      }
    }
  });

  $("#txtMontoRecibido").change(function() {

    try{
      var monto_recibido = parseFloat($("#txtMontoRecibido").val());
      var total = parseFloat($("#txtTotal").val());
      if (monto_recibido == 0 || monto_recibido == "") {
        $("#txtMontoRecibido").val("0");
        $("#txtVuelto").val("0");
        return;
      }
      var vuelto = parseFloat(monto_recibido - total);
      $("#txtMontoRecibido").val(monto_recibido.toFixed(2));
      $("#txtVuelto").val(vuelto.toFixed(2));
    }catch(e) {
      console.log(e);
      $("#txtMontoRecibido").val("0");
      $("#txtVuelto").val("0");
    }

  });

  $("#txtFechaInicio").change(function() {
    showLista();
  });

  $("#txtFechaFin").change(function() {
    showLista();
  });

  $("#numero_documento_cliente").focusout(function(event) {

    event.preventDefault();

    if ($("#codigo_documento_cliente").val()=="") {
     runAlert("Advertencia","Seleccione un documento de identidad del cliente.","warning");
     return;
    }

    if ($("#numero_documento_cliente").val()=="") {
     runAlert("Advertencia","Ingrese un número de documento del cliente.","warning");
     return;
    }

    /* Start Ajax */
    $.ajax({
      type: "POST",
      data:{
       id_documento: $("#codigo_documento_cliente").val(),
       num_documento: $("#numero_documento_cliente").val()
     },
      url: "ajax.php?accion=getDataClienteForDocumento",
      success : function(data) {
        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {
            var o = data1["data"];
            $("#nombres").val(o[0].nombres);
            $("#apellidos").val(o[0].apellidos);
            $("#direccion").val(o[0].direccion);
            $("#telefono").val(o[0].telefono);
            $("#correo").val(o[0].correo);
          } else {
            console.log(data1["message"]);
            $("#nombres").val("");
            $("#apellidos").val("");
            $("#direccion").val("");
            $("#telefono").val("");
            $("#correo").val("");
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
    /* End Ajax */

  });

  $("#codigo_documento_cliente").change(function(){
    changeOption();
	});

  $('#btnAgregarDetalle').click(function(){

    if ($("#codigo_moneda").val()=="") {
      runAlert("Advertencia","Selecciona la moneda con la que se realizará la operación","warning");
      return;
    }

    table_detalle_modal.clear().draw();
    var title = "AGREGAR " + $('input:radio[name=opcion_busqueda]:checked').val().toUpperCase();
    $("#title_modal").html(title);
    $("#txtBuscarDetalle").val("");
    $('#modalAgregarDetalle').modal('show');
    showListaAgregarDetalle();

  });

  $("#panelForm").addClass("d-none");

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

  $('#btnSearchDetalle').click(function(){
    showListaAgregarDetalle();
  });

  $('#btnAdd').click(function(){
    $("#id_venta").val("0");
    $("#accion").val("add");
    $("#btnSave").removeClass("d-none");
    $("#btnSaveBorrador").removeClass("d-none");
    $("#btnAgregarDetalle").removeClass("d-none");
    $("#btnImprimir").addClass("d-none");
    addClassDiv();
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnSaveBorrador').click(function(e){
    e.preventDefault();
    saveOperationBorrador();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#id_venta").val("0");
    $("#accion").val("add");
    table_detalle.clear().draw();
    showLista();
  });

  $('#btnImprimir').click(function(){
    //
    try {

      var id_venta = $("#id_venta").val();
      var link="?view=printvercomprobante&id_venta="+ id_venta;
      window.open(link);

    } catch (e) {
      console.log(e);
    }

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

function calcularVuelto(){
  try{
    var monto_recibido = parseFloat($("#txtMontoRecibido").val());
    var total = parseFloat($("#txtTotal").val());
    if (monto_recibido == 0 || monto_recibido == "") {
      $("#txtMontoRecibido").val("0");
      $("#txtVuelto").val("0");
      return;
    }
    var vuelto = parseFloat(monto_recibido - total);
    $("#txtMontoRecibido").val(monto_recibido.toFixed(2));
    $("#txtVuelto").val(vuelto.toFixed(2));
  }catch(e) {
    console.log(e);
    $("#txtMontoRecibido").val("0");
    $("#txtVuelto").val("0");
  }
}

function calcularTotal(){

  $("#txtTotalDescuento").val("0");
  $("#txtGravada").val("0");
  $("#txtIgv").val("0");
  $("#txtTotal").val("0");

  try {

    var count = table_detalle.data().count();
    var num = 1;
    var total_descuento = 0;
    var total_gravada = 0;
    var total_igv = 0;
    var total_total = 0;

    if (count > 0) {

      $('#example1 > tbody  > tr').each(function(){

        var cantidad = $(this).find("td").eq(1).find("input").val();
        var precio_unitario = $(this).find("td").eq(2).html();
        var descuento = $(this).find("td").eq(3).find("input").val();
        var gravada = ((cantidad*1)).toFixed(2);
        var igv = (gravada * 0.18).toFixed(2);
        var total = (parseFloat(gravada) + parseFloat(igv)).toFixed(2);

        total_descuento = parseFloat(total_gravada) + parseFloat(gravada);
        total_gravada = parseFloat(total_gravada) + parseFloat(gravada);
        total_igv = parseFloat(total_igv) + parseFloat(igv);
        total_total = parseFloat(total_total) + parseFloat(total);

        table_detalle.cell(num-1,6).data(gravada).draw();
        table_detalle.cell(num-1,8).data(igv).draw();
        table_detalle.cell(num-1,9).data(total).draw();

        num++;

      });

    }

    $("#txtTotalDescuento").val(total_descuento.toFixed(2));
    $("#txtGravada").val(total_gravada.toFixed(2));
    $("#txtIgv").val(total_igv.toFixed(2));
    $("#txtTotal").val(total_total.toFixed(2));
    $("#txtMontoRecibido").val(total_total.toFixed(2));
    calcularVuelto();

  } catch (e) {
    runAlert("Oh No...!!!","Error en TryCatch Calcular Total: " + e,"error");
    $("#txtTotalDescuento").val("0");
    $("#txtGravada").val("0");
    $("#txtIgv").val("0");
    $("#txtTotal").val("0");
  }

}

function verificarproductoontable(name_tabla,cod_producto){

  try {
    var num=0;
    $('#example1 > tbody  > tr').each(function(){
      var data = table_detalle.row($(this)).data();
      if (data['codigo']==cod_producto&&data['name_tabla']==name_tabla) {
        num++;
      }
    });
    if (num>0) {
      return true;
    }else {
      return false;
    }
  } catch (e) {
    runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    return false;
  }

}

function changeOption(){
  var name_documento = $('select[name="codigo_documento_cliente"] option:selected').text();
  if (name_documento.toUpperCase().trim()=="RUC") {
    $("#lblNombres").html("Razón Social(*)");
    $("#lblApellidos").html("Nombre Comercial");
  }else {
    $("#lblNombres").html("Nombres(*)");
    $("#lblApellidos").html("Apellidos");
  }
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
  $('#frmDatos')[0].reset();
  table_detalle.clear().draw();
}

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
		url:'ajax.php?accion=showOrdenVenta'
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

function showListaAgregarDetalle(){

  table_detalle_modal.clear().draw();
  $("#divPaginador_Modal").addClass("d-none");
  paginador = $("#paginador_modal");
  var items = 10, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback_detalle);
  cargaPagina(0);

}

function get_data_callback_detalle(){
  table_detalle_modal.clear().draw();
  var id_sucursal = $("#sucursal_buscar").val();
  var id_moneda = $("#codigo_moneda").val();
  var valor = $("#txtBuscarDetalle").val();
  var tipo = $('input:radio[name=opcion_busqueda]:checked').val();
  $("#divPaginador_Modal").addClass("d-none");
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      id_sucursal: id_sucursal,
      id_moneda: id_moneda,
      valor: valor,
      tipo: tipo
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
		url:'ajax.php?accion=showDetalleParaOrden'
	}).done(function(data,textStatus,jqXHR){
    try {
      var data1 = JSON.parse(data);
      if (data1["error"]=="NO") {

        if(pagina==0){
          creaPaginador(data1["cantidad"]);
        }

        var o = data1["data"];
        for (var i = 0; i < o.length; i++) {
          table_detalle_modal.row.add({
            "num": o[i].num,
            "descripcion": o[i].descripcion,
            "cod_producto": o[i].cod_producto,
            "precio_unitario": o[i].precio_unitario,
            "cantidad": '<input class="form-control" type="number" min="1" value="1">',
            "precio_unitario_string": o[i].precio_unitario_string,
            "seleccionar": o[i].seleccionar
          }).draw();
        }

        $("#divPaginador_Modal").removeClass("d-none");

      }else {
        console.log(data1["message"]);
        $("#divPaginador_Modal").addClass("d-none");
      }
    }
    catch(err) {
      runAlert("Message",err+data,"warning");
      $("#divPaginador_Modal").addClass("d-none");
    }

	}).fail(function(jqXHR,textStatus,textError){
    runAlert("Oh No...!!!","Error al realizar la petición " + textError,"warning");
	});
}

function saveOperation(){

  try {

    var id_venta = $("#id_venta").val();
    var accion = $('#accion').val();
    var codigo_documento_venta = $("#codigo_documento_venta").val();
    var serie = $("#serie").val();
    var correlativo = $("#correlativo").val();
    var codigo_documento_cliente = $("#codigo_documento_cliente").val();
    var numero_documento_cliente = $("#numero_documento_cliente").val();
    var nombres = $("#nombres").val();
    var apellidos = $("#apellidos").val();
    var direccion = $("#direccion").val();
    var telefono = $("#telefono").val();
    var correo = $("#correo").val();
    var fecha = $("#fecha").val();
    var codigo_moneda = $("#codigo_moneda").val();
    var codigo_forma_pago = $("#codigo_forma_pago").val();
    var total_descuento = $("#txtTotalDescuento").val();
    var total_gravada = $("#txtGravada").val();
    var total_igv = $("#txtIgv").val();
    var total_total = $("#txtTotal").val();
    var monto_recibido = $("#txtMontoRecibido").val();
    var vuelto = $("#txtVuelto").val();

    var countRows = table_detalle.data().count();

    if (codigo_documento_venta=="0" || codigo_documento_venta == "" || codigo_documento_venta == 0) {
      runAlert("Faltan Datos","Tiene que seleccionar un tipo de documento.","warning")
      return;
    }

    if (codigo_documento_cliente == "") {
      runAlert("Faltan Datos","Tiene que seleccionar una documento de cliente.","warning")
      return;
    }

    if (numero_documento_cliente=="0" || numero_documento_cliente == "" || numero_documento_cliente == 0) {
      runAlert("Faltan Datos","Tiene que ingresar el número de documento del cliente.","warning")
      return;
    }

    if (nombres=="0" || nombres == "" || nombres == 0) {
      runAlert("Faltan Datos","Tiene que ingresar el nombre ó razón social del cliente.","warning")
      return;
    }

    if (codigo_moneda == "") {
      runAlert("Faltan Datos","Tiene que seleccionar una moneda para realizar la operación.","warning")
      return;
    }

    if (countRows==0) {
      runAlert("Faltan Datos","Tiene que tener por lo menos un detalle para guardar la orden de venta.","warning")
      return;
    }

    if (vuelto < 0) {
      runAlert("Error de Vuelto","El vuelto no puede ser menor a cero.","warning")
      return;
    }

    var datos = [];
    var objeto = {};

    $('#example1 > tbody  > tr').each(function(){

      var cantidad = $(this).find("td").eq(1).find("input").val();
    var descuento = $(this).find("td").eq(3).find("input").val();
    var notas = $(this).find("td").eq(2).find("input").val(); // Asegúrate de que el índice 10 sea el de "Notas".
    console.log("Notas capturadas:", notas); // Verificar el valor de notas
    var id_maquinaria = $(this).find("td").eq(3).find("input").val(); 
    var data = table_detalle.row($(this)).data();

    datos.push({
      "name_tabla": data['name_tabla'],
      "cod_producto": data['codigo'],
      "descripcion": data['descripcion'],
      "cantidad": cantidad,
      "precio_unitario": data['precio_unitario'],
      "descuento": descuento,
      "sub_total": data['subtotal'],
      "tipo_igv": data['tipo_igv'],
      "igv": data['igv'],
      "total": data['total'],
      "notas": notas, // Asegúrate de incluir 'notas' aquí.
      "id_maquinaria": id_maquinaria
  });

    });

    objeto.datos = datos;

    var form = 'id_venta=' + id_venta + '&accion=' + accion + '&codigo_documento_venta=' + codigo_documento_venta +
            '&serie=' + serie + '&correlativo=' + correlativo + '&codigo_documento_cliente=' + codigo_documento_cliente +
            '&numero_documento_cliente=' + numero_documento_cliente + '&nombres=' + nombres + '&apellidos=' + apellidos +
            '&direccion=' + direccion + '&telefono=' + telefono + '&correo=' + correo +
            '&fecha=' + fecha + '&codigo_moneda=' + codigo_moneda + '&codigo_forma_pago=' + codigo_forma_pago +
            '&total_descuento=' + total_descuento + '&total_gravada=' + total_gravada + '&total_igv=' + total_igv +
            '&monto_recibido=' + monto_recibido + '&vuelto=' + vuelto +
            '&total_total=' + total_total +  "&array_detalle=" + JSON.stringify(objeto);

    Swal.fire({
      title: '¿Seguro de confirmar la operación?',
      text: "Se guardará la operación en el sistema.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Guardar ahora!'
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=goOrdenVenta",
          datatype: "json",
          data: form,
          success: function(data){
            try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              } else {
                runAlert("Bien hecho...!!!",response['message'],"success");
                $("#id_venta").val(response['id_venta']);
                $("#serie").val(response['serie']);
                $("#correlativo").val(response['correlativo']);
                $("#accion").val("edit");
                $("#btnImprimir").removeClass("d-none");
                $("#btnAgregarDetalle").addClass("d-none");
                $("#btnSaveBorrador").addClass("d-none");
                $("#btnSave").addClass("d-none");
              }
            } catch (e) {
              runAlert("Oh No...!!!",data + e,"error");
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
    runAlert("Oh No...!!!","Error en Try Catch : " + e,"error");
  }

}

function saveOperationBorrador(){

  try {

    var id_venta = $("#id_venta").val();
    var accion = $('#accion').val();
    var codigo_documento_venta = $("#codigo_documento_venta").val();
    var serie = $("#serie").val();
    var correlativo = $("#correlativo").val();
    var codigo_documento_cliente = $("#codigo_documento_cliente").val();
    var numero_documento_cliente = $("#numero_documento_cliente").val();
    var nombres = $("#nombres").val();
    var apellidos = $("#apellidos").val();
    var direccion = $("#direccion").val();
    var telefono = $("#telefono").val();
    var correo = $("#correo").val();
    var fecha = $("#fecha").val();
    var codigo_moneda = $("#codigo_moneda").val();
    var codigo_forma_pago = $("#codigo_forma_pago").val();
    var total_descuento = $("#txtTotalDescuento").val();
    var total_gravada = $("#txtGravada").val();
    var total_igv = $("#txtIgv").val();
    var total_total = $("#txtTotal").val();
    var monto_recibido = $("#txtMontoRecibido").val();
    var vuelto = $("#txtVuelto").val();

    var countRows = table_detalle.data().count();

    if (codigo_documento_venta=="0" || codigo_documento_venta == "" || codigo_documento_venta == 0) {
      runAlert("Faltan Datos","Tiene que seleccionar un tipo de documento.","warning")
      return;
    }

    if (codigo_documento_cliente == "") {
      runAlert("Faltan Datos","Tiene que seleccionar una documento de cliente.","warning")
      return;
    }

    if (numero_documento_cliente=="0" || numero_documento_cliente == "" || numero_documento_cliente == 0) {
      runAlert("Faltan Datos","Tiene que ingresar el número de documento del cliente.","warning")
      return;
    }

    if (nombres=="0" || nombres == "" || nombres == 0) {
      runAlert("Faltan Datos","Tiene que ingresar el nombre ó razón social del cliente.","warning")
      return;
    }

    if (codigo_moneda == "") {
      runAlert("Faltan Datos","Tiene que seleccionar una moneda para realizar la operación.","warning")
      return;
    }

    if (countRows==0) {
      runAlert("Faltan Datos","Tiene que tener por lo menos un detalle para guardar la orden de venta.","warning")
      return;
    }

    if (vuelto < 0) {
      runAlert("Error de Vuelto","El vuelto no puede ser menor a cero.","warning")
      return;
    }

    var datos = [];
    var objeto = {};

    $('#example1 > tbody  > tr').each(function(){

      for (let i = 0; i < 11; i++) {
        console.log("Valor de columna " + i + ":", $(this).find("td").eq(i).text());
    }
      var cantidad = $(this).find("td").eq(1).find("input").val();
    var descuento = $(this).find("td").eq(3).find("input").val();
    var notas = $(this).find("td").eq(2).find("input").val(); // Captura el valor del campo 'notas'.
    console.log("Notas capturadas:", notas); // Verificar el valor de notas
    var id_maquinaria = $(this).find("td").eq(3).find("input").val(); 
    var data = table_detalle.row($(this)).data();

    datos.push({
      "name_tabla": data['name_tabla'],
      "cod_producto": data['codigo'],
      "descripcion": data['descripcion'],
      "cantidad": cantidad,
      "precio_unitario": data['precio_unitario'],
      "descuento": descuento,
      "sub_total": data['subtotal'],
      "tipo_igv": data['tipo_igv'],
      "igv": data['igv'],
      "total": data['total'],
      "notas": notas, // Asegúrate de incluir 'notas' aquí.
      "id_maquinaria": id_maquinaria,
  });

    });

    objeto.datos = datos;

    var form = 'id_venta=' + id_venta + '&accion=' + accion + '&codigo_documento_venta=' + codigo_documento_venta +
            '&serie=' + serie + '&correlativo=' + correlativo + '&codigo_documento_cliente=' + codigo_documento_cliente +
            '&numero_documento_cliente=' + numero_documento_cliente + '&nombres=' + nombres + '&apellidos=' + apellidos +
            '&direccion=' + direccion + '&telefono=' + telefono + '&correo=' + correo +
            '&fecha=' + fecha + '&codigo_moneda=' + codigo_moneda + '&codigo_forma_pago=' + codigo_forma_pago +
            '&total_descuento=' + total_descuento + '&total_gravada=' + total_gravada + '&total_igv=' + total_igv +
            '&monto_recibido=' + monto_recibido + '&vuelto=' + vuelto +
            '&total_total=' + total_total +  "&array_detalle=" + JSON.stringify(objeto);

    Swal.fire({
      title: '¿Seguro de confirmar la operación?',
      text: "Esta operación se guardará como un borrador.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Guardar ahora!'
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=goOrdenVentaBorrador",
          datatype: "json",
          data: form,
          success: function(data){
            try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              } else {
                runAlert("Bien hecho...!!!",response['message'],"success");
                $("#id_venta").val(response['id_venta']);
                $("#accion").val("edit");
              }
            } catch (e) {
              runAlert("Oh No...!!!",data + e,"error");
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
    runAlert("Oh No...!!!","Error en Try Catch : " + e,"error");
  }

}

function getDataEdit(id_venta){
  table_detalle.clear().draw();
  $.ajax({
    type: "POST",
    data:{
  		id_venta: id_venta
		},
    url: "ajax.php?accion=getDataOrdenVenta",
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

          for (var i = 0; i < o.length; i++) {

            var cod_producto = o[i].detalle_cod_producto;
            var name_tabla = o[i].detalle_name_tabla;
            var descripcion = o[i].detalle_descripcion;
            var cantidad = o[i].detalle_cantidad;
            var precio_unitario = o[i].detalle_precio_unitario;
            var descuento = o[i].detalle_descuento;
            var notas = o[i].detalle_notas; 
            var id_maquinaria = o[i].detalle_maquinaria;
            var inputCantidad = '<input onkeypress="calcularTotal();" onchange="calcularTotal();" type="number" value="' + cantidad + '" class="form-control" min="1" style="width:90px;">';
            var inputDescuento = '<input onkeypress="calcularTotal();" onchange="calcularTotal();" type="number" value="' + descuento + '" class="form-control" min="0" style="width:90px;">';
            var botonEliminar = '<a href="javascript:void(0);" id="botonEliminar" class="btn btn-danger"><i class="fa fa-close"></i></a>';
            var sub_total = o[i].detalle_sub_total;
            var igv = o[i].detalle_igv;
            var total = o[i].detalle_total;
            var inputNotas = '<input class="form-control" value="' + notas + '" type="text" readonly>';
            var inputMaquinaria = '<input class="form-control" value="' + id_maquinaria + '" type="text" readonly>';

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
              "notas": inputNotas,
              "id_maquinaria": inputMaquinaria,
              "eliminar_item": botonEliminar
            }).draw();

            calcularTotal();

          }

          addClassDiv();
          $("#btnSave").removeClass("d-none");
          $("#btnSaveBorrador").removeClass("d-none");
          $("#btnAgregarDetalle").removeClass("d-none");
          $("#btnImprimir").addClass("d-none");
          $("#txtMontoRecibido").val(o[0].monto_recibido);
          $("#txtVuelto").val(o[0].vuelto);

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

function verRegistro(id_venta){
  table_detalle.clear().draw();
  $("#btnImprimir").addClass("d-none");
  $.ajax({
    type: "POST",
    data:{
  		id_venta: id_venta
		},
    url: "ajax.php?accion=getDataOrdenVenta",
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
            var notas = o[i].detalle_notas;
            var id_maquinaria = o[i].detalle_maquinaria;
            var inputCantidad = '<input readonly onkeypress="calcularTotal();" onchange="calcularTotal();" type="number" value="' + cantidad + '" class="form-control" min="1" style="width:90px;">';
            var inputDescuento = '<input readonly onkeypress="calcularTotal();" onchange="calcularTotal();" type="number" value="' + descuento + '" class="form-control" min="0" style="width:90px;">';
            var inputNotas = '<input class="form-control" value="' + notas + '" type="text" readonly>';
            var inputMaquinaria = '<input class="form-control" value="' + id_maquinaria + '" type="text" readonly>';
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
              "notas": inputNotas,
              "id_maquinaria": inputMaquinaria,
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

function anularOperacion(id_venta,documento){

  try {

    var parametros = {
      "id_venta" : id_venta
    };

    Swal.fire({
      title: '¿Seguro de anular el documento : ' + documento + '?',
      text: "Al realizar la anulación si no es documento interno se procederá a comunicar a su operador de servicios electrónicos.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Anular ahora!'
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=anularOrdenVenta",
          datatype: "json",
          data: parametros,
          success: function(data){
            try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              }else {
                showLista();
                runAlert("Bien hecho...!!!",response['message'],"success");
              }
            } catch (e) {
              runAlert("Oh No...!!!",e,"error");
              console.log(data);
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

function eliminarOperacion(id_venta){

  try {

    var parametros = {
      "id_venta" : id_venta
    };

    Swal.fire({
      title: '¿Seguro de eliminar la operación?',
      text: "Al eliminar el documento, se perderán los datos guardados en el sistema.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar ahora!'
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=eliminarOrdenVenta",
          datatype: "json",
          data: parametros,
          success: function(data){
            try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              }else {
                showLista();
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
