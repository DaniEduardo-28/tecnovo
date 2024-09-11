var tableForm = $('#table_form').DataTable({
  language: languageSpanish,
  searching: false,
  ordering: false,
  lengthChange: false,
  paging: false,
  destroy : true,
  info: false,
  columns: [
    { 'data': 'num' },
    { 'data': 'cod_producto' },
    { 'data': 'name_producto' },
    { 'data': 'stock' },
    { 'data': 'precio_unitario' },
    { 'data': 'cantidad' },
    { 'data': 'notas' },
    { 'data': 'total' },
    { 'data': 'opcion' },
    { 'data': 'name_tabla' }
  ],
  columnDefs: [
    {
      "targets": [1,3,9],
      "visible": false,
      "searchable": false
    }
  ]
});

var tableProducto = $('#tabla_productos').DataTable({
  language: languageSpanish,
  searching: false,
  ordering: false,
  lengthChange: false,
  paging: false,
  destroy : true,
  info: false,
  columns: [
    { 'data': 'num' },
    { 'data': 'cod_producto' },
    { 'data': 'name_producto' },
    { 'data': 'stock' },
    { 'data': 'precio_unitario' },
    { 'data': 'cantidad' },
    { 'data': 'opcion' },
    { 'data': 'name_producto_string' },
  ],
  columnDefs: [
    {
      "targets": [1,4,7],
      "visible": false,
      "searchable": false
    }
  ]
});

var tableListado = $('#tabla_listado').DataTable({
  language: languageSpanish,
  searching: false,
  ordering: false,
  lengthChange: false,
  paging: false,
  destroy : true,
  info: false,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_orden_compra' },
    { 'data': 'name_proveedor' },
    { 'data': 'name_usuario' },
    { 'data': 'fecha_orden' },
    { 'data': 'fecha_entrega' },
    { 'data': 'name_forma_envio' },
    { 'data': 'num_registros' },
    { 'data': 'total' },
    { 'data': 'estado' },
    { 'data': 'opciones' }
  ],
  columnDefs: [
    {
      "targets": [1,3],
      "visible": false,
      "searchable": false
    }
  ]
});

$(document).ready(function(){

  $("#contenedor_formulario").addClass("d-none");
  $("#contenedor_proveedor").addClass("d-none");
  $("#contenedor_productos").addClass("d-none");

  $("#btnAdd").click(function(){
    $("#contenedor_formulario").removeClass("d-none");
    $("#contenedor_listado").addClass("d-none");
    $("#panelOptions").addClass("d-none");
    $("#accion").val("add");
    $("#txtEstadoForm").val("En proceso ...");
  });

  $("#btnCancelForm").click(function(){
    cancelarForm();
    $("#btnSaveForm").removeClass("d-none");
    $("#btnSeleccionarProveedor").removeClass("d-none");
    $("#btnSeleccionarProducto").removeClass("d-none");
  });

  $("#btnSeleccionarProveedor").click(function(){
    $("#contenedor_formulario").addClass("d-none");
    $("#contenedor_proveedor").removeClass("d-none");
    showDataProveedor();
  });

  $('#btnSearchProveedor').click(function(){
    showDataProveedor();
  });

  $('#btnSearchProducto').click(function(){
    showListaAgregarDetalle();
  });

  $("#txtBuscarProveedor").keypress(function(e) {
    if (e.which == 13 ) {
      showDataProveedor();
    }
  });

  $("#txtBuscarProducto").keypress(function(e) {
    if (e.which == 13 ) {
      showListaAgregarDetalle();
    }
  });

  $("#btnCancelarProveedor").click(function(){
    $("#contenedor_formulario").removeClass("d-none");
    $("#contenedor_proveedor").addClass("d-none");
    $("#id_proveedor").val("0");
    $('#img_proveedor').attr('src', "resources/global/images/sin_imagen.png");
    $("#name_proveedor").html("No Seleccionado");
  });

  $("#btnSiguienteProductos").click(function(){
    $("#contenedor_formulario").removeClass("d-none");
    $("#contenedor_productos").addClass("d-none");
  });

  $('#tabla_productos tbody').on( 'click', '#btnCheckProducto', function () {
    try {
      var name_tabla = $('input:radio[name=opcion_busqueda]:checked').val();
      var num = tableForm.data().count() + 1;
      var data = tableProducto.row( $(this).parents('tr') ).data();
      var cod_producto = data["cod_producto"];
      if (num>1) {
        if (verificarproductoontable(name_tabla,cod_producto)==true) {
          generateAlert('warning', 'El Producto ya se encuentra agregado a la lista.');
          return;
        }
      }
      var name_producto = data["name_producto"];
      var stock = data["stock"];
      var precio_unitario = data["precio_unitario"];
      precio_unitario = (Math.round( precio_unitario * 100 )/100 ).toFixed(2);
      var cantidad = $(this).parents("tr").find("td").eq(3).find("input").val();
      var total = precio_unitario * cantidad;
      total = (Math.round( total * 100 )/100 ).toFixed(2);
      tableForm.row.add({
        "num": num,
        "cod_producto": cod_producto,
        "name_producto": name_producto,
        "name_tabla": name_tabla,
        "stock": stock,
        "precio_unitario": '<input class="form-control" value="' + precio_unitario + '" step="0.10" type="number" min="0" >',
        "cantidad": '<input class="form-control" value="' + cantidad + '" type="number" min="1">',
        "notas": '<input class="form-control" value="" type="text">',
        "total": total,
        "opcion": '<button type="button" class="btn btn-danger" id="btnDeleteProducto"><span class="fa fa-close"></span></button>',
      }).draw();

      generateAlert('success', '<h5 style="text-color:#ffffff">Agregado</h5><br><h6 style="text-color:#f2f9f1">' + cantidad + ' ' + data["name_producto_string"] + ' al precio de ' + precio_unitario + ' c/u.</h6>');
      calcularTotal();

    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  });

  $('#table_form tbody').on( 'click', '#btnDeleteProducto', function (e) {
    try {
      e.preventDefault();
      tableForm.row($(this).parents('tr')).remove().draw();
      actualizarnumeracion();
      calcularTotal();
    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  });

  $('#table_form tbody').on( 'change', 'input', function (e) {
    try {
      var element = $(this).parents("tr").find("td").eq(2).find("input");
      element.val(dosDecimales(element));
      calcularTotal();
    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  });

  showData();

  $("#btnSaveForm").click(function(e){

    try {

      var id_orden_compra = $("#id_orden_compra").val();
      var accion = $('#accion').val();
      var id_proveedor = $("#id_proveedor").val();
      var id_metodo_envio = $("#cboFormaEnvioForm").val();
      var fecha_orden = $("#txtFechaOrdenForm").val();
      var fecha_entrega = $("#txtFechaEntregaForm").val();
      var observaciones = $("#txtObservacionesForm").val();
      var codigo_moneda = $("#codigo_moneda").val();

      var countRows = tableForm.data().count();

      if (id_proveedor=="0" || id_proveedor == "" || id_proveedor == 0) {
        runAlert("Faltan Datos","Tiene que seleccionar un proveedor.","warning")
        return;
      }

      if (id_metodo_envio=="0" || id_metodo_envio == "" || id_metodo_envio == 0) {
        runAlert("Faltan Datos","Tiene que seleccionar una forma de envío.","warning")
        return;
      }

      if ($("#codigo_moneda").val()=="") {
        runAlert("Advertencia","Selecciona la moneda con la que se realizará la operación","warning");
        return;
      }

      if (countRows==0) {
        runAlert("Faltan Datos","Tiene que seleccionar por lo menos un producto.","warning")
        return;
      }

      var datos = [];
      var objeto = {};

      $('#table_form > tbody  > tr').each(function(){

        var cantidad = $(this).find("td").eq(3).find("input").val();
        var precio_unitario = $(this).find("td").eq(2).find("input").val();
        var notas = $(this).find("td").eq(4).find("input").val();
        var data = tableForm.row($(this)).data();

        datos.push({
          "name_tabla" : data['name_tabla'],
          "cod_producto" : data['cod_producto'],
          "cantidad_solicitada" : cantidad,
          "precio_unitario" : precio_unitario,
          "notas" : notas
        });

      });

      objeto.datos = datos;

      var form = 'id_proveedor=' + id_proveedor + '&id_metodo_envio=' + id_metodo_envio + '&id_orden_compra=' + id_orden_compra +
              '&fecha_orden=' + fecha_orden + '&fecha_entrega=' + fecha_entrega + '&accion=' + accion + '&codigo_moneda=' + codigo_moneda +
              '&observaciones=' + observaciones +  "&array_detalle=" + JSON.stringify(objeto);

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
          $.ajax({
            type: "POST",
            url: "ajax.php?accion=goOrdenCompra",
            datatype: "json",
            data: form,
            success: function(data){
      			  try {
                var response = JSON.parse(data);
                if (response['error']=="SI") {
                  runAlert("Oh No...!!!",response['message'],"warning");
                } else {
                  cancelarForm();
                  runAlert("Bien hecho...!!!",response['message'],"success");
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
              showData();
            }
          });
        }
      });

    } catch (e) {
      runAlert("Oh No...!!!","Error en Try Catch : " + e,"error");
    }

  });

  $('#btnBuscarListado').click(function(){
    showData();
  });

  $("#txtBuscarListado").keypress(function(e) {
    if (e.which == 13 ) {
      showData();
    }
  });

  $('#btnAgregarDetalle').click(function(){

    if ($("#codigo_moneda").val()=="") {
      runAlert("Advertencia","Selecciona la moneda con la que se realizará la operación","warning");
      return;
    }

    var title = "AGREGAR " + $('input:radio[name=opcion_busqueda]:checked').val().toUpperCase();
    $("#title_modal").html(title);

    tableProducto.clear().draw();
    $("#txtBuscarProducto").val("");
    $("#contenedor_formulario").addClass("d-none");
    $("#contenedor_productos").removeClass("d-none");
    showListaAgregarDetalle();

  });

});

function cancelarForm(){
  $("#contenedor_formulario").addClass("d-none");
  $("#contenedor_listado").removeClass("d-none");
  $("#panelOptions").removeClass("d-none");
  $("#accion").val("");
  $("#txtTotalForm").val("S/ 0.00");
  $("#txtObservacionesForm").val("S/ 0.00");
  $("#id_proveedor").val("0");
  $("#id_orden_compra").val("0");
  $('#img_proveedor').attr('src', "resources/global/images/sin_imagen.png");
  $("#name_proveedor").html("No Seleccionado");
  $("#form_datos")[0].reset();
  var rows = tableForm.rows().remove().draw();
  calcularTotal();
}

function actualizarnumeracion(){

  try {

    var cantidad = tableForm.data().count();
    var num = 1;

    if (cantidad > 0) {

      $('#table_form > tbody  > tr').each(function(){
        tableForm.cell(num-1,0).data(num).draw();
        num++;
      });

    }

  } catch (e) {
    runAlert("Oh No...!!!","Error en TryCatch Actualizar Numeración : " + e,"error");
  }

}

function calcularTotal(){

  $("#txtTotalForm").val("0.00");

  try {

    var count = tableForm.data().count();
    var num = 1;
    var suma_total = 0.00;

    if (count > 0) {

      $('#table_form > tbody  > tr').each(function(){

        var precio_unitario = $(this).find("td").eq(2).find("input").val();
        var cantidad = $(this).find("td").eq(3).find("input").val();
        var total = cantidad * precio_unitario;
        total = (Math.round( total * 100 )/100 ).toFixed(2);
        tableForm.cell(num-1,7).data(total).draw();
        suma_total += parseFloat(total);
        num++;

      });

      suma_total = (Math.round( suma_total * 100 )/100 ).toFixed(2);
      $("#txtTotalForm").val(suma_total);
      return suma_total;
    }

    return 0.00;

  } catch (e) {
    runAlert("Oh No...!!!","Error en TryCatch Calcular Total: " + e,"error");
    return 0.00;
  }
}

function verificarproductoontable(name_tabla,cod_producto){

  try {
    var num=0;
    $('#table_form > tbody  > tr').each(function(){
      var data = tableForm.row($(this)).data();
      if (data['cod_producto']==cod_producto&&data['name_tabla']==name_tabla) {
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

function showDataProveedor(){

  $("#tbody_proveedor").html("");
  $("#paginador_proveedor").addClass("d-none");
  paginador = $("#paginador_proveedor");
  var items = 9, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback);
  cargaPagina(0);

}

function get_data_callback(){
  var valor = $("#txtBuscarProveedor").val();
  var id_documento = $("#cboDocuProveedor").val();
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      valor: valor,
      id_documento: id_documento,
      estado: 1
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
		url:'ajax.php?accion=showProveedor'
	}).done(function(data,textStatus,jqXHR){
    try {
      var data1 = JSON.parse(data);
      if (data1["error"]=="NO") {

        if(pagina==0){
          creaPaginador(data1["cantidad"]);
        }

        // genera el cuerpo de la tabla
        var innerdivHtml = "";
        var o = data1["data"];

        for (var i = 0; i < o.length; i++) {
          innerdivHtml += '<tr>';
          innerdivHtml += '<td>';
          innerdivHtml += '<div class="d-flex align-items-center">';
          innerdivHtml += '<div class="bg-img mr-4">';
          innerdivHtml += '<img src="' + o[i].src_imagen + '" class="img-fluid" alt="Proveedor">';
          innerdivHtml += '</div>';
          innerdivHtml += '<p class="font-weight-bold">' + o[i].apellidos + o[i].nombres + '</p>';
          innerdivHtml += '</div>';
          innerdivHtml += '</td>';
          innerdivHtml += '<td>' + o[i].name_documento + '</td>';
          innerdivHtml += '<td>' + o[i].num_documento + '</td>';
          innerdivHtml += '<td>' + o[i].direccion_completa + '</td>';
          innerdivHtml += '<td>' + o[i].telefono + '</td>';
          innerdivHtml += '<td>' + o[i].btnseleccionar + '</td>';
          innerdivHtml += '</tr>';
        }

        $("#paginador_proveedor").removeClass("d-none");
        $("#tbody_proveedor").html(innerdivHtml);

      }else {
        console.log(data1["message"]);
        $("#paginador_proveedor").addClass("d-none");
        $("#tbody_proveedor").html("");
      }
    }
    catch(err) {
      runAlert("Message",err+data,"warning");
      $("#paginador_proveedor").addClass("d-none");
      $("#tbody_proveedor").html("");
    }

	}).fail(function(jqXHR,textStatus,textError){
    runAlert("Oh No...!!!","Error al realizar la petición " + textError,"warning");
	});
}

function showListaAgregarDetalle(){

  tableProducto.clear().draw();
  $("#div_paginador_productos").addClass("d-none");
  paginador = $("#paginador_productos");
  var items = 10, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback_detalle);
  cargaPagina(0);

}

function get_data_callback_detalle(){
  tableProducto.clear().draw();
  var id_moneda = $("#codigo_moneda").val();
  var valor = $("#txtBuscarProducto").val();
  var tipo = $('input:radio[name=opcion_busqueda]:checked').val();
  $("#div_paginador_productos").addClass("d-none");
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
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
		url:'ajax.php?accion=showDetalleParaOrdenCompra'
	}).done(function(data,textStatus,jqXHR){
    try {
      var data1 = JSON.parse(data);
      if (data1["error"]=="NO") {

        if(pagina==0){
          creaPaginador(data1["cantidad"]);
        }

        var o = data1["data"];
        for (var i = 0; i < o.length; i++) {

          //tableProducto.row.add({
            //"num": o[i].num,
            //"descripcion": o[i].descripcion,
            //"cod_producto": o[i].cod_producto,
            //"precio_unitario": o[i].precio_unitario,
            //"cantidad": '<input class="form-control" type="number" min="1" value="1">',
            //"precio_unitario_string": o[i].precio_unitario_string,
            //"seleccionar": o[i].seleccionar
          //}).draw();

          var name_producto = '<div class="d-flex align-items-center">';
          name_producto += '<div class="bg-img mr-4">';
          name_producto += '<img src="' + o[i].src_imagen + '" class="img-fluid"';
          name_producto += 'alt="Producto" id="img_producto">';
          name_producto += '</div>';
          name_producto += '<p class="font-weight-bold">' + o[i].descripcion + '</p>';
          name_producto += '</div>';

          tableProducto.row.add({
            "num": o[i].num,
            "cod_producto": o[i].cod_producto,
            "name_producto": name_producto,
            "stock": o[i].stock,
            "precio_unitario": o[i].precio_unitario,
            "cantidad": '<input class="form-control" value="1" type="number" min="1">',
            "opcion": o[i].seleccionar,
            "name_producto_string": o[i].descripcion
          }).draw();

        }

        $("#div_paginador_productos").removeClass("d-none");

      }else {
        console.log(data1["message"]);
        $("#div_paginador_productos").addClass("d-none");
      }
    }
    catch(err) {
      runAlert("Message",err+data,"warning");
      $("#div_paginador_productos").addClass("d-none");
    }

	}).fail(function(jqXHR,textStatus,textError){
    runAlert("Oh No...!!!","Error al realizar la petición " + textError,"warning");
	});
}

function seleccionarProveedor(id_proveedor,proveedor,src_imagen){
  $("#contenedor_formulario").removeClass("d-none");
  $("#contenedor_proveedor").addClass("d-none");
  $("#id_proveedor").val(id_proveedor);
  $('#img_proveedor').attr('src', src_imagen);
  $("#name_proveedor").html(proveedor);
}

function showData(){

  tableListado.clear().draw();
  $("#paginador_listado").addClass("d-none");
  paginador = $("#paginador_listado");
  var items = 10, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback2);
  cargaPagina(0);

}

function get_data_callback2(){

  tableListado.clear().draw();
  var fecha_inicio = $("#txtFechaInicioBuscarListado").val();
  var fecha_fin = $("#txtFechaFinBuscarListado").val();
  var tipo_busqueda = $("#cboTipoBuscarListado").val();
  var valor = $("#txtBuscarListado").val();

  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      valor: valor,
      tipo_busqueda: tipo_busqueda,
      fecha_fin: fecha_fin,
      fecha_inicio: fecha_inicio
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
		url:'ajax.php?accion=showOrdenCompra'
	}).done(function(data,textStatus,jqXHR){
    try {

      var data1 = JSON.parse(data);
      if (data1["error"]=="NO") {

        if(pagina==0){
          creaPaginador(data1["cantidad"]);
        }

        var o = data1["data"];

        for (var i = 0; i < o.length; i++) {

          tableListado.row.add({
            "num": o[i].num,
            "id_orden_compra": o[i].id_orden_compra,
            "name_proveedor": o[i].name_proveedor,
            "name_usuario": o[i].name_usuario,
            "fecha_orden": o[i].fecha_orden,
            "fecha_entrega": o[i].fecha_entrega,
            "name_forma_envio": o[i].name_forma_envio,
            "num_registros": o[i].num_registros,
            "total": o[i].total,
            "estado": o[i].estado,
            "opciones": o[i].options
          }).draw();

        }

        $("#paginador_listado").removeClass("d-none");

      } else {
        console.log(data1["message"]);
      }
    }
    catch(err) {
      runAlert("Message",err+data,"warning");
    }

	}).fail(function(jqXHR,textStatus,textError){
    runAlert("Oh No...!!!","Error al realizar la petición " + textError,"warning");
	});

}

function getDataEdit(id_orden_compra){

  try {

    cancelarForm();

    $.ajax({
      type: "POST",
      data:{
    		id_orden_compra: id_orden_compra
  		},

      url: "ajax.php?accion=getDataEditOrdenCompra",
      success : function(data) {
        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {
            var o = data1["data"];
            $("#id_orden_compra").val(o[0].id_orden_compra);
            $("#id_proveedor").val(o[0].id_proveedor);
            $("#name_proveedor").html(o[0].name_proveedor);
            $('#img_proveedor').attr('src', o[0].src_imagen_proveedor);
            $("#cboFormaEnvioForm").val(o[0].id_metodo_envio);
            $("#txtFechaOrdenForm").val(o[0].fecha_orden);
            $("#txtFechaEntregaForm").val(o[0].fecha_entrega);
            $("#txtObservacionesForm").val(o[0].observaciones);
            $("#txtEstadoForm").val(o[0].estado);
            $("#codigo_moneda").val(o[0].id_moneda);

            for (var i = 0; i < o.length; i++) {

              var name_producto = '<div class="d-flex align-items-center">';
              name_producto += '<div class="bg-img mr-4">';
              name_producto += '<img src="' + o[i].src_imagen_producto + '" class="img-fluid"';
              name_producto += 'alt="Producto" id="img_producto">';
              name_producto += '</div>';
              name_producto += '<p class="font-weight-bold" id="name_proveedor">' + o[i].name_producto + '</p>';
              name_producto += '</div>';

              tableForm.row.add({
                "num": i+1,
                "cod_producto": o[i].cod_producto,
                "name_tabla": o[i].name_tabla,
                "name_producto": name_producto,
                "stock": o[i].stock,
                "precio_unitario": '<input class="form-control" value="' + o[i].precio_unitario + '" step="0.10" type="number" min="0">',
                "cantidad": '<input class="form-control" value="' + o[i].cantidad_solicitada + '" type="number" min="1">',
                "notas": '<input class="form-control" value="' + o[i].notas + '" type="text">',
                "total": o[i].total,
                "opcion": '<button type="button" class="btn btn-danger" id="btnDeleteProducto"><span class="fa fa-close"></span></button>',
              }).draw();

            }

            $("#contenedor_formulario").removeClass("d-none");
            $("#contenedor_listado").addClass("d-none");
            $("#panelOptions").addClass("d-none");
            $("#accion").val("edit");
            $("#txtEstadoForm").val("En proceso ...");
            calcularTotal();

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

  } catch (e) {
    runAlert("Oh No...!!!","Error Try Catch " + e,"warning");
  }

}

function verRegistro(id_orden_compra){

  try {

    cancelarForm();

    $.ajax({
      type: "POST",
      data:{
    		id_orden_compra: id_orden_compra
  		},
      url: "ajax.php?accion=getDataVerOrdenCompra",
      success : function(data) {
        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {
            var o = data1["data"];
            $("#id_orden_compra").val(o[0].id_orden_compra);
            $("#id_proveedor").val(o[0].id_proveedor);
            $("#name_proveedor").html(o[0].name_proveedor);
            $('#img_proveedor').attr('src', o[0].src_imagen_proveedor);
            $("#cboFormaEnvioForm").val(o[0].id_metodo_envio);
            $("#txtFechaOrdenForm").val(o[0].fecha_orden);
            $("#txtFechaEntregaForm").val(o[0].fecha_entrega);
            $("#txtObservacionesForm").val(o[0].observaciones);
            $("#txtEstadoForm").val(o[0].estado);
            $("#codigo_moneda").val(o[0].id_moneda);

            for (var i = 0; i < o.length; i++) {

              var name_producto = '<div class="d-flex align-items-center">';
              name_producto += '<div class="bg-img mr-4">';
              name_producto += '<img src="' + o[i].src_imagen_producto + '" class="img-fluid"';
              name_producto += 'alt="Producto" id="img_producto">';
              name_producto += '</div>';
              name_producto += '<p class="font-weight-bold">' + o[i].name_producto + '</p>';
              name_producto += '</div>';

              tableForm.row.add({
                "num": i+1,
                "name_tabla": o[i].name_tabla,
                "cod_producto": o[i].cod_producto,
                "name_producto": name_producto,
                "stock": o[i].stock,
                "precio_unitario": '<input class="form-control" value="' + o[i].precio_unitario + '" step="0.10" type="number" min="0" disabled>',
                "cantidad": '<input class="form-control" value="' + o[i].cantidad_solicitada + '" type="number" min="1" disabled>',
                "notas": '<input class="form-control" value="' + o[i].notas + '" type="text" disabled>',
                "total": o[i].total,
                "opcion": '',
              }).draw();

            }

            $("#contenedor_formulario").removeClass("d-none");
            $("#contenedor_listado").addClass("d-none");
            $("#panelOptions").addClass("d-none");
            $("#accion").val("ver");

            $("#btnSaveForm").addClass("d-none");
            $("#btnSeleccionarProveedor").addClass("d-none");
            $("#btnSeleccionarProducto").addClass("d-none");

            calcularTotal();

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

  } catch (e) {
    runAlert("Oh No...!!!","Error Try Catch " + e,"warning");
  }

}

function deleteRegistro(id_orden_compra){

  try {

    var parametros = {
      "id_orden_compra" : id_orden_compra
    };

    Swal.fire({
      title: '¿Seguro de anular la orden de compra seleccionada?',
      text: "No podrás revertir esta operación.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Anular ahora!'
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=deleteOrdenCompra",
          datatype: "json",
          data: parametros,
          success: function(data){
            try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              }else {
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
