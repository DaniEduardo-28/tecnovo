var tableForm = $('#table_form').DataTable({
    language: languageSpanish,
    searching: false,
    ordering: false,
    lengthChange: false,
    paging: false,
    destroy : true,
    info: false,
    columns: [
      { 'data': 'name_tabla' },
      { 'data': 'num' },
      { 'data': 'cod_producto' },
      { 'data': 'name_producto' },
      { 'data': 'cantidad' },
      { 'data': 'precio_unitario' },
      { 'data': 'descuento' },
      { 'data': 'sub_total' },
      { 'data': 'tipo_igv' },
      { 'data': 'igv' },
      { 'data': 'total' },
      { 'data': 'opcion' }
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
    columns: [
        { 'data': 'num' },
        { 'data': 'cod_producto' },
        { 'data': 'name_producto' },
        { 'data': 'opcion' }
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
      { 'data': 'opciones' },
      { 'data': 'id_documento_venta' },
      { 'data': 'id_documento_proveedor' },
      { 'data': 'name_proveedor' },
      { 'data': 'fecha_gasto' },
      { 'data': 'id_moneda' },
      { 'data': 'sub_total' },
      { 'data': 'igv_total' },
      { 'data': 'monto_total' }
    ],
    columnDefs: [
      {
        "targets": [1,3],
        "visible": false,
        "searchable": false
      }
    ]
  });

  $(document).ready(function() {
    var tableProducto = $('#tabla_productos').DataTable({
        language: languageSpanish,
        columns: [
            { 'data': 'num' },
            { 'data': 'cod_producto' },
            { 'data': 'name_producto' },
            { 'data': 'opcion' }
        ]
    });
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

  
    $('#tabla_productos tbody').on('click', '#btnCheckProducto', function () {
      try {
          var name_tabla = $('input:radio[name=opcion_busqueda]:checked').val();
          var num = tableForm.data().count() + 1;
          var data = tableProducto.row($(this).parents('tr')).data();
          
          var cod_producto = data["cod_producto"];
          if (num > 1) {
              if (verificarproductoontable(name_tabla, cod_producto) == true) {
                  generateAlert('warning', 'El Producto ya se encuentra agregado a la lista.');
                  return;
              }
          }
          
          var name_producto = data["name_producto"];
          var cantidad = $(this).parents("tr").find("td").eq(3).find("input").val();
          var precio_unitario = data["precio_unitario"];
          precio_unitario = (Math.round(precio_unitario * 100) / 100).toFixed(2);
          
          // Suponiendo que descuento y tipo_igv también están disponibles en los datos o en los inputs
          var descuento = parseFloat($(this).parents("tr").find("td").eq(4).find("input").val() || 0);
          var tipo_igv = $(this).parents("tr").find("td").eq(5).find("input:radio[name=tipo_igv]:checked").val() || 'NO';
          
          // Calcular sub_total
          var sub_total = (cantidad * precio_unitario) - descuento;
          sub_total = (Math.round(sub_total * 100) / 100).toFixed(2);
          
          // Calcular IGV
          var igv = tipo_igv === 'SI' ? (sub_total * 0.18) : 0;
          igv = (Math.round(igv * 100) / 100).toFixed(2);
          
          // Calcular total
          var total = parseFloat(sub_total) + parseFloat(igv);
          total = (Math.round(total * 100) / 100).toFixed(2);
  
          // Añadir fila a tableForm
          tableForm.row.add({
              "name_tabla": name_tabla,  
              "num": num,
              "cod_producto": cod_producto,
              "name_producto": name_producto,
              "cantidad": '<input class="form-control" value="' + cantidad + '" type="number" min="1">',
              "precio_unitario": '<input class="form-control" value="' + precio_unitario + '" step="0.10" type="number" min="0">',
              "descuento": '<input class="form-control" value="' + descuento + '" step="0.10" type="number" min="0">',
              "sub_total": sub_total,
              "tipo_igv": '<input class="form-control" value="' + tipo_igv + '" type="text">',
              "igv": igv,
              "total": total,
              "X": '<button type="button" class="btn btn-danger" id="btnDeleteProducto"><span class="fa fa-close"></span></button>',
          }).draw();
  
          // Mensaje de éxito
          generateAlert('success', '<h5 style="text-color:#ffffff">Agregado</h5><br><h6 style="text-color:#f2f9f1">' + cantidad + ' ' + name_producto + ' al precio de ' + precio_unitario + ' c/u.</h6>');
          
          // Actualizar total general
          calcularTotal();
  
      } catch (e) {
          runAlert("Oh No...!!!", "Error en TryCatch: " + e, "error");
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
  
        var id_orden_gasto = $("#id_orden_gasto").val();
        var accion = $('#accion').val();
        var id_proveedor = $("#id_proveedor").val();
        var fecha_gasto = $("#txtFechaEntregaForm").val();
        var codigo_moneda = $("#codigo_moneda").val();
  
        var countRows = tableForm.data().count();
  
        if (id_proveedor=="0" || id_proveedor == "" || id_proveedor == 0) {
          runAlert("Faltan Datos","Tiene que seleccionar un proveedor.","warning")
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
          var data = tableForm.row($(this)).data();
  
          datos.push({
            "name_tabla" : data['name_tabla'],
            "cod_producto" : data['cod_producto'],
            "cantidad" : cantidad,
            "precio_unitario" : precio_unitario
          });
  
        });
  
        objeto.datos = datos;
  
        var form = 'id_proveedor=' + id_proveedor + '&id_orden_gasto=' + id_orden_gasto +
                '&fecha_gasto=' + fecha_gasto + '&accion=' + accion + '&codigo_moneda=' + codigo_moneda +
                "&array_detalle=" + JSON.stringify(objeto);
  
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
              url: "ajax.php?accion=goOrdenGasto",
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
    $("#id_orden_gasto").val("0");
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
  
  function calcularTotal() {
    // Inicializar el campo de total en la interfaz
    $("#txtTotalForm").val("0.00");

    try {
        var count = tableForm.data().count();
        var num = 1;
        var suma_total = 0.00;

        if (count > 0) {
            $('#table_form > tbody  > tr').each(function() {
                // Obtener precio unitario, cantidad, y descuento
                var precio_unitario = parseFloat($(this).find("td").eq(2).find("input").val());
                var cantidad = parseFloat($(this).find("td").eq(3).find("input").val());
                var descuento = parseFloat($(this).find("td").eq(4).find("input").val()) || 0;

                // Calcular sub_total
                var sub_total = (cantidad * precio_unitario) - descuento;
                sub_total = (Math.round(sub_total * 100) / 100).toFixed(2);

                // Obtener el valor de tipo_igv ("SI" o "NO")
                var tipo_igv = $(this).find("td").eq(5).find("input").val();

                // Calcular igv basado en tipo_igv
                var igv = tipo_igv === "SI" ? (sub_total * 0.18) : 0;
                igv = (Math.round(igv * 100) / 100).toFixed(2);

                // Calcular total como sub_total + igv
                var total = parseFloat(sub_total) + parseFloat(igv);
                total = (Math.round(total * 100) / 100).toFixed(2);

                // Actualizar las celdas correspondientes en la tabla
                tableForm.cell(num - 1, 6).data(sub_total).draw();
                tableForm.cell(num - 1, 7).data(igv).draw();
                tableForm.cell(num - 1, 8).data(total).draw();

                // Acumular el total general
                suma_total += parseFloat(total);
                num++;
            });

            // Redondear y mostrar el total acumulado en el campo de interfaz
            suma_total = (Math.round(suma_total * 100) / 100).toFixed(2);
            $("#txtTotalForm").val(suma_total);
            return suma_total;
        }

        return 0.00;

    } catch (e) {
        runAlert("Oh No...!!!", "Error en TryCatch Calcular Total: " + e, "error");
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
  
  function showDataProveedor() {
    $("#tbody_proveedor").html("");
    $("#paginador_proveedor").addClass("d-none");
    paginador = $("#paginador_proveedor");
    var items = 9, numeros = 6;
    init_paginator(paginador, items, numeros);
    set_callback(get_data_callback_proveedor);
    cargaPagina(0);
}

function get_data_callback_proveedor() {
    var valor = $("#txtBuscarProveedor").val();
    var id_documento = $("#cboDocuProveedor").val();

    $.ajax({
        data: {
            limit: itemsPorPagina,
            offset: desde,
            valor: valor,
            id_documento: id_documento,
            estado: 1
        },
        type: "POST",
        url: 'ajax.php?accion=showProveedor',
        beforeSend: function() {
            showHideLoader('block');
        },
        complete: function() {
            showHideLoader('none');
            if (totalPaginas == 1 && pagina == 0) {
                paginador.find(".next_link").hide();
            }
        },
        success: function(data) {
            var data1 = JSON.parse(data);
            if (data1["error"] == "NO") {
                if (pagina == 0) {
                    creaPaginador(data1["cantidad"]);
                }
                var innerdivHtml = "";
                var o = data1["data"];

                for (var i = 0; i < o.length; i++) {
                    innerdivHtml += '<tr>';
                    innerdivHtml += '<td><div class="d-flex align-items-center">';
                    innerdivHtml += '<div class="bg-img mr-4"><img src="' + o[i].src_imagen + '" class="img-fluid" alt="Proveedor"></div>';
                    innerdivHtml += '<p class="font-weight-bold">' + o[i].apellidos + ' ' + o[i].nombres + '</p>';
                    innerdivHtml += '</div></td>';
                    innerdivHtml += '<td>' + o[i].name_documento + '</td>';
                    innerdivHtml += '<td>' + o[i].num_documento + '</td>';
                    innerdivHtml += '<td>' + o[i].direccion_completa + '</td>';
                    innerdivHtml += '<td>' + o[i].telefono + '</td>';
                    innerdivHtml += '<td>' + o[i].btnseleccionar + '</td>';
                    innerdivHtml += '</tr>';
                }
                $("#paginador_proveedor").removeClass("d-none");
                $("#tbody_proveedor").html(innerdivHtml);
            } else {
                console.log(data1["message"]);
                $("#paginador_proveedor").addClass("d-none");
                $("#tbody_proveedor").html("");
            }
        },
        error: function(jqXHR, textStatus, textError) {
            runAlert("Oh No...!!!", "Error al realizar la petición " + textError, "warning");
        }
    });
}

  
function showListaAgregarDetalle() {
  tableProducto.clear().draw();
  $("#div_paginador_productos").addClass("d-none");
  paginador = $("#paginador_productos");
  var items = 10, numeros = 6;
  init_paginator(paginador, items, numeros);
  set_callback(get_data_callback_detalle);
  cargaPagina(0);
}

function get_data_callback_detalle() {
  tableProducto.clear().draw();
  var id_moneda = $("#codigo_moneda").val();
  var valor = $("#txtBuscarProducto").val();
  var tipo = $('input:radio[name=opcion_busqueda]:checked').val();
  $("#div_paginador_productos").addClass("d-none");

  $.ajax({
      data: {
          limit: itemsPorPagina,
          offset: desde,
          id_moneda: id_moneda,
          valor: valor,
          tipo: tipo
      },
      type: "POST",
      url: 'ajax.php?accion=showDetalleParaOrdenGasto',
      beforeSend: function() {
          showHideLoader('block');
      },
      complete: function() {
          showHideLoader('none');
          if (totalPaginas == 1 && pagina == 0) {
              paginador.find(".next_link").hide();
          }
      },
      success: function(data) {
          var data1 = JSON.parse(data);
          if (data1["error"] == "NO") {
              if (pagina == 0) {
                  creaPaginador(data1["cantidad"]);
              }

              var o = data1["data"];
              for (var i = 0; i < o.length; i++) {
                  tableProducto.row.add({
                      "num": o[i].num,
                      "descripcion": o[i].descripcion,
                      "cod_producto": o[i].cod_producto,
                      "precio_unitario": o[i].precio_unitario,
                      "cantidad": '<input class="form-control" type="number" min="1" value="1">',
                      "precio_unitario_string": o[i].precio_unitario_string,
                      "seleccionar": o[i].seleccionar
                  }).draw();
              }

              $("#div_paginador_productos").removeClass("d-none");
          } else {
              console.log(data1["message"]);
              $("#div_paginador_productos").addClass("d-none");
          }
      },
      error: function(jqXHR, textStatus, textError) {
          runAlert("Oh No...!!!", "Error al realizar la petición " + textError, "warning");
      }
  });
}

  
function seleccionarProveedor(id_proveedor, proveedor, src_imagen) {
  // Muestra el panel de formulario y oculta el de selección de proveedor
  $("#contenedor_formulario").removeClass("d-none");
  $("#contenedor_proveedor").addClass("d-none");

  // Establece el ID del proveedor en un campo oculto para enviar con el formulario
  $("#id_proveedor").val(id_proveedor);

  // Actualiza el campo de texto con el nombre del proveedor seleccionado
  $("#campo_proveedor").val(proveedor);

  // Cambia la imagen del proveedor
  $('#img_proveedor').attr('src', src_imagen);
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
          url:'ajax.php?accion=showOrdenGasto'
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
              "#": o[i].num,
              "id_orden_gasto": o[i].id_orden_gasto,
              "opciones": o[i].options,
              "id_documento": o[i].id_documento,
              "id_orden_gasto": o[i].id_orden_gasto,
              "name_proveedor": o[i].name_proveedor,
              "fecha_gasto": o[i].fecha_gasto,
              "num_registros": o[i].num_registros,
              "total": o[i].total,
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
  
  function getDataEdit(id_orden_gasto){
  
    try {
  
      cancelarForm();
  
      $.ajax({
        type: "POST",
        data:{
              id_orden_gasto: id_orden_gasto
            },
  
        url: "ajax.php?accion=getDataEditOrdenGasto",
        success : function(data) {
          try {
            var data1 = JSON.parse(data);
            if (data1["error"]=="NO") {
              var o = data1["data"];
              $("#id_orden_gasto").val(o[0].id_orden_gasto);
              $("#id_proveedor").val(o[0].id_proveedor);
              $("#name_proveedor").html(o[0].name_proveedor);
              $('#img_proveedor').attr('src', o[0].src_imagen_proveedor);
              $("#txtFechaEntregaForm").val(o[0].fecha_gasto);
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
                  "cantidad": '<input class="form-control" value="' + o[i].cantidad + '" type="number" min="1">',
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
  
  function verRegistro(id_orden_gasto){
  
    try {
  
      cancelarForm();
  
      $.ajax({
        type: "POST",
        data:{
              id_orden_gasto: id_orden_gasto
            },
        url: "ajax.php?accion=getDataVerOrdenGasto",
        success : function(data) {
          try {
            var data1 = JSON.parse(data);
            if (data1["error"]=="NO") {
              var o = data1["data"];
              $("#id_orden_gasto").val(o[0].id_orden_gasto);
              $("#id_proveedor").val(o[0].id_proveedor);
              $("#name_proveedor").html(o[0].name_proveedor);
              $('#img_proveedor').attr('src', o[0].src_imagen_proveedor);
              $("#txtFechaEntregaForm").val(o[0].fecha_gasto);
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
  
  function deleteRegistro(id_orden_gasto) {
    try {
        var parametros = {
            "id_orden_gasto": id_orden_gasto
        };

        Swal.fire({
            title: '¿Seguro de anular la orden de gasto seleccionada?',
            text: "No podrás revertir esta operación.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c63b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Anular ahora!'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "ajax.php?accion=deleteOrdenGasto",
                    datatype: "json",
                    data: parametros,
                    success: function(data) {
                        try {
                            var response = JSON.parse(data);
                            if (response['error'] == "SI") {
                                runAlert("Oh No...!!!", response['message'], "warning");
                            } else {
                                showData();
                                runAlert("Bien hecho...!!!", response['message'], "success");
                            }
                        } catch (e) {
                            runAlert("Oh No...!!!", e, "error");
                        }
                    },
                    error: function(data) {
                        runAlert("Oh No...!!!", data, "error");
                    },
                    beforeSend: function(xhr) {
                        showHideLoader('block');
                    },
                    complete: function(jqXHR, textStatus) {
                        showHideLoader('none');
                    }
                });
            }
        });

    } catch (e) {
        runAlert("Oh No...!!!", "Error en TryCatch: " + e, "error");
    }
}

  