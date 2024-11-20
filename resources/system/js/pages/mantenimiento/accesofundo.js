
var table = $('#example').DataTable({
    language: languageSpanish,
    searching: false,
    ordering: false,
    lengthChange: false,
    paging: false,
    destroy: true,
    info: false,
    columns: [
      { 'data': 'num' },
      { 'data': 'id_fundo' },
      { 'data': 'nombre' },
      { 'data': 'flag_check' },
    ],
    columnDefs: [
      {
        "targets": [1],
        "visible": false,
        "searchable": true
      }
    ]
  });
  
  $(document).ready(function () {
  
    $('#btnSave').click(function (e) {
      e.preventDefault();
      saveOperation();
    });
  
    showPermisos();
  
    $("#cboCliente").change(function (e) {
      e.preventDefault();
      showPermisos();
    });
  
  });
  
  function showPermisos() {
    var num = 1;
    $('#example > tbody  > tr').each(function () {
      table.cell(num - 1, 3).data('<input type="number" class="form-control cantidad-hc" min="0" step="1" value="0">').draw();
      num++;
    });
    var id_cliente = $("#cboCliente").val();
    $.ajax({
      url: "ajax.php?accion=showFundoCliente",
      type: "POST",
      data: {
        id_cliente: id_cliente
      },
      success: function (data) {
        try {
          var data1 = JSON.parse(data);
          if (data1["error"] == "NO") {
            var o = data1["data"];
            // $('#example > tbody > tr').each(function () {
            //   var data = table.row($(this)).data();
            //   var id_fundo = data['id_fundo'];
            //   var cantidad_hc = 4;//o.find(item => item.id_fundo === id_fundo)?.cantidad_hc || 0;
            //   $(this).find("td").eq(3).find("cantidad_hc").val(cantidad_hc);
            // });
            num = 1;
            $('#example > tbody  > tr').each(function () {
              var data = table.row($(this)).data();
              var id_fundo = data['id_fundo'];
              for (var i = 0; i < o.length; i++) {
                if (id_fundo == o[i].id_fundo) {
                  table.cell(num - 1, 3).data('<input type="number" class="form-control cantidad-hc" min="0" step="1" value="' + o[i].cantidad_hc + '">').draw();
                }
              }
              num++;
            });
          } else {
            console.log(data1["message"]);
          }
        } catch (e) {
          runAlert("Oh No...!!!", "Error en TryCatch: " + e + data, "error");
        }
      },
      beforeSend: function (xhr) {
        showHideLoader('block');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        runAlert("Oh No...!!!", "Error de petición: " + jqXHR, "warning");
      },
      complete: function (jqXHR, textStatus) {
        showHideLoader('none');
      }
    });
  }
  
  
  //AAQUI EMPIEZAN LOS CAMBIOS
  
  /* function saveOperation(){
   
    if (!table.data().count()) {
      runAlert("Oh No...!!!","La tabla no contiene datos para registrar.","warning");
      return;
    }
   
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
        var id_cliente = $("#cboCliente").val();
        var datos = [];
        var objeto = {};
        try {
          $('#example > tbody  > tr').each(function(){
            var data = table.row($(this)).data();
            var flag_agregar = $(this).find("td").eq(2).find("input").prop('checked') ? true : false;
            if (flag_agregar) {
              datos.push({
                "id_fundo" : data["id_fundo"],
              });
            }
          });
        } catch (e) {
          runAlert("Oh No...!!!",e,"warning");
          return;
        }
   
        objeto.datos = datos;
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=goAccesoFundo",
          datatype: "json",
          data: {
            id_cliente: id_cliente,
            datos: JSON.stringify(objeto)
          },
          success: function(data){
                  try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              }else {
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
  } */
  
  function saveOperation() {
    if (!table.data().count()) {
      runAlert("Oh No...!!!", "La tabla no contiene datos para registrar.", "warning");
      return;
    }
  
    Swal.fire({
      title: '¿Seguro de confirmar la operación?',
      text: "No podrás revertir esta operación.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Realizar ahora!'
    }).then(function (result) {
      if (result.value) {
        var id_cliente = $("#cboCliente").val();
        var datos = [];
  
        // $('#example > tbody > tr').each(function () {
        //   var data = table.row($(this)).data();
        //   var cantidad_hc = $(this).find("td").eq(3).find(".cantidad-hc").val();
        //   if (cantidad_hc) {
        //     datos.push({
        //       "id_fundo": data["id_fundo"],
        //       "cantidad_hc": cantidad_hc
        //     });
  
        //   }
        // });
  
        $('#example > tbody  > tr').each(function () {
          var data = table.row($(this)).data();
          var cantidad_hc = parseFloat($(this).find("td").eq(2).find("input").val()).toFixed(2);
          if (cantidad_hc > 0) {
            datos.push({
              "id_fundo": data["id_fundo"],
              "cantidad_hc": cantidad_hc,
            });
          }
        });
  
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=goAccesoFundo",
          datatype: "json",
          data: {
            id_cliente: id_cliente,
            datos: JSON.stringify(datos)
          },
          success: function (data) {
            try {
              var response = JSON.parse(data);
              if (response['error'] == "SI") {
                runAlert("Oh No...!!!", response['message'], "warning");
              } else {
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
  
  