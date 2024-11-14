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
    { 'data': 'cantidad_solicitada' },
    { 'data': 'cantidad_ingresada' },
    { 'data': 'cantidad' },
    { 'data': 'observaciones' },
    { 'data': 'name_tabla' },
  ],
  columnDefs: [
    {
      "targets": [1,7],
      "visible": false,
      "searchable": false
    }
  ]
});

var tableOrden = $('#tabla_orden').DataTable({
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
    { 'data': 'id_ingreso' },
    { 'data': 'documento' },
    { 'data': 'name_proveedor' },
    { 'data': 'name_usuario' },
    { 'data': 'fecha_orden' },
    { 'data': 'num_registros' },
    { 'data': 'estado' },
    { 'data': 'opciones' }
  ],
  columnDefs: [
    {
      "targets": [1,4],
      "visible": false,
      "searchable": false
    }
  ]
});

$(document).ready(function(){

  $("#contenedor_formulario").addClass("d-none");
  $("#contenedor_orden").addClass("d-none");

  $("#btnAdd").click(function(){
    $("#contenedor_orden").removeClass("d-none");
    $("#contenedor_listado").addClass("d-none");
    $("#panelOptions").addClass("d-none");
    $("#title_form").html("Datos de la Orden");
    showDataOrden();
  });

  $("#btnCancelForm").click(function(){
    cancelarForm();
    $("#btnSaveForm").removeClass("d-none");
  });

  $("#btnCancelFormVer").click(function(){

    $("#btnSaveForm").removeClass("d-none");
    $("#btnCancelForm").removeClass("d-none");
    $("#btnCancelFormVer").addClass("d-none");
    $("#panelOptions").removeClass("d-none");
    $("#contenedor_listado").removeClass("d-none");
    $("#contenedor_formulario").addClass("d-none");

  });

  $("#btnVolverOrden").click(function(){
    $("#contenedor_orden").addClass("d-none");
    $("#contenedor_listado").removeClass("d-none");
    $("#panelOptions").removeClass("d-none");
    showData();
  });

  $('#btnBuscarOrden').click(function(){
    showDataOrden();
  });

  $("#txtBuscarOrden").keypress(function(e) {
    if (e.which == 13 ) {
      showDataOrden();
    }
  });

  showData();

  $("#btnSaveForm").click(function(e){

    try {

      var id_orden_compra = $("#id_orden_compra").val();
      var id_tipo_docu = $("#id_tipo_docu_form").val();
      var num_documento = $("#txtNumDocumento").val();
      var observaciones = $("#txtObservacionesForm").val();

      var countRows = tableForm.data().count();

      if (id_orden_compra=="0" || id_orden_compra == "" || id_orden_compra == 0) {
        runAlert("Faltan Datos","Error al seleccionar el id orden de compra.","warning")
        return;
      }

      if (id_tipo_docu=="0" || id_tipo_docu == "" || id_tipo_docu == 0) {
        runAlert("Faltan Datos","Tiene que seleccionar el tipo de documento.","warning")
        return;
      }

      if (num_documento=="0" || num_documento == "" || num_documento == 0) {
        runAlert("Faltan Datos","Tiene que ingresar el número documento de ingreso","warning")
        return;
      }

      if (countRows==0) {
        runAlert("Faltan Datos","Tiene que seleccionar por lo menos un producto.","warning")
        return;
      }

      var datos = [];
      var objeto = {};

      $('#table_form > tbody  > tr').each(function(){

        var cantidad = $(this).find("td").eq(4).find("input").val();
        var observaciones_detalle = $(this).find("td").eq(5).find("input").val();
        var data = tableForm.row($(this)).data();
        datos.push({
          "cod_producto" : data['cod_producto'],
          "name_tabla" : data['name_tabla'],
          "cantidad" : cantidad,
          "observaciones" : observaciones_detalle
        });

      });

      objeto.datos = datos;

      var form = 'id_orden_compra=' + id_orden_compra + '&id_ingreso=' + id_ingreso + '&num_documento=' + num_documento +
              '&observaciones=' + observaciones + '&id_tipo_docu=' + id_tipo_docu +
              "&array_detalle=" + JSON.stringify(objeto);

      Swal.fire({
        title: '¿Seguro de registrar el ingreso de productos?',
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
            url: "ajax.php?accion=goIngreso",
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
                  showDataOrden();
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

  });

  $('#btnBuscarListado').click(function(){
    showData();
  });

  $("#txtBuscarListado").keypress(function(e) {
    if (e.which == 13 ) {
      showData();
    }
  });

});

function cancelarForm(){
  $("#contenedor_formulario").addClass("d-none");
  $("#contenedor_orden").removeClass("d-none");
  $("#txtObservacionesForm").val("");
  $("#id_orden_compra").val("0");
  $("#id_ingreso").val("0");
  $('#img_proveedor').attr('src', "resources/global/images/sin_imagen.png");
  $("#name_proveedor").html("No Seleccionado");
  $("#form_datos")[0].reset();
  var rows = tableForm.rows().remove().draw();
}

function showDataOrden(){

  $("#tbody_orden").html("");
  $("#paginador_orden").addClass("d-none");
  paginador = $("#paginador_orden");
  var items = 10, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback);
  cargaPagina(0);

}

function get_data_callback(){

  tableOrden.clear().draw();
  var fecha_inicio = $("#txtFechaInicioBuscarOrden").val();
  var fecha_fin = $("#txtFechaFinBuscarOrden").val();
  var tipo_busqueda = $("#cboTipoBuscarOrden").val();
  var valor = $("#txtBuscarOrden").val();

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
		url:'ajax.php?accion=showOrdenCompraIngreso'
	}).done(function(data,textStatus,jqXHR){
    try {
      var data1 = JSON.parse(data);
      if (data1["error"]=="NO") {

        if(pagina==0){
          creaPaginador(data1["cantidad"]);
        }

        var o = data1["data"];

        for (var i = 0; i < o.length; i++) {

          tableOrden.row.add({
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

        $("#paginador_orden").removeClass("d-none");

      }else {

        console.log(data1["message"]);
        $("#paginador_orden").addClass("d-none");

      }
    }
    catch(err) {
      runAlert("Message",err+data,"warning");
      $("#paginador_orden").addClass("d-none");
    }

	}).fail(function(jqXHR,textStatus,textError){
    runAlert("Oh No...!!!","Error al realizar la petición " + textError,"warning");
	});
}

function seleccionarOrden(id_orden_compra){

  try {

    cancelarForm();

    $.ajax({
      type: "POST",
      data:{
    		id_orden_compra: id_orden_compra
  		},
      url: "ajax.php?accion=getDataEditOrdenCompraIngreso",
      success : function(data) {
        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {
            var o = data1["data"];
            $("#id_orden_compra").val(o[0].id_orden_compra);
            $("#name_proveedor").html(o[0].name_proveedor);
            $('#img_proveedor').attr('src', o[0].src_imagen_proveedor);
            $("#txtNameMetodo").val(o[0].name_metodo);
            $("#txtFechaOrdenForm").val(o[0].fecha_orden);
            $("#txtEstadoForm").val(o[0].estado);

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
                "cantidad_solicitada": o[i].cantidad_solicitada,
                "cantidad_ingresada": o[i].cantidad_ingresada,
                "cantidad": '<input class="form-control" value="0" type="number" min="0" max="' + ( o[i].cantidad_solicitada - o[i].cantidad_ingresada ) + '">',
                "observaciones": '<input class="form-control" type="text">',
              }).draw();

            }

            $("#contenedor_formulario").removeClass("d-none");
            $("#contenedor_orden").addClass("d-none");
            $("#btnSaveForm").removeClass("d-none");

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
		url:'ajax.php?accion=showIngreso'
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
            "id_ingreso": o[i].id_ingreso,
            "documento": o[i].documento,
            "name_proveedor": o[i].name_proveedor,
            "name_usuario": o[i].name_usuario,
            "fecha_orden": o[i].fecha_orden,
            "num_registros": o[i].num_registros,
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

function verRegistro(id_ingreso){

  try {

    $("#txtObservacionesForm").val("");
    $("#id_orden_compra").val("0");
    $("#id_ingreso").val("0");
    $('#img_proveedor').attr('src', "resources/global/images/sin_imagen.png");
    $("#name_proveedor").html("No Seleccionado");
    $("#form_datos")[0].reset();
    var rows = tableForm.rows().remove().draw();

    $.ajax({
      type: "POST",
      data:{
    		id_ingreso: id_ingreso
  		},
      url: "ajax.php?accion=getDataVerIngreso",
      success : function(data) {

        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {

            var o = data1["data"];

            $("#id_ingreso").val(o[0].id_ingreso);
            $("#id_orden_compra").val(o[0].id_orden_compra);
            $("#name_proveedor").html(o[0].name_proveedor);
            $('#img_proveedor').attr('src', o[0].src_imagen_proveedor);
            $("#txtNameMetodo").val(o[0].name_metodo);
            $("#txtFechaOrdenForm").val(o[0].fecha_orden);
            $("#txtObservacionesForm").val(o[0].observaciones);
            $("#txtEstadoForm").val(o[0].estado);
            $("#id_tipo_docu_form").val(o[0].id_tipo_docu);
            $("#txtNumDocumento").val(o[0].num_documento);

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
                "cod_producto": o[i].cod_producto,
                "name_tabla": o[i].name_tabla,
                "name_producto": name_producto,
                "cantidad_solicitada": '',
                "cantidad_ingresada": '',
                "cantidad": o[i].cantidad,
                "observaciones": o[i].observaciones_detalle,
              }).draw();

            }

            $("#contenedor_formulario").removeClass("d-none");
            $("#contenedor_listado").addClass("d-none");
            $("#panelOptions").addClass("d-none");
            $("#btnSaveForm").addClass("d-none");
            $("#btnCancelForm").addClass("d-none");
            $("#btnCancelFormVer").removeClass("d-none");
            $("#title_form").html("Datos del Ingreso");

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

function deleteRegistro(id_ingreso){

  try {

    var parametros = {
      "id_ingreso" : id_ingreso
    };

    Swal.fire({
      title: '¿Seguro de anular el ingreso seleccionado?',
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
          url: "ajax.php?accion=deleteIngreso",
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
              runAlert("Oh No...!!!",e+data,"error");
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
