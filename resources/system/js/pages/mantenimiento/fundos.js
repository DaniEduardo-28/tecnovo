
var table = $('#example').DataTable({
    language: languageSpanish,
    destroy : true,
    columns: [
      { 'data': 'num' },
      { 'data': 'id_fundo' },
      { 'data': 'id_empresa' },
      { 'data': 'nombre' },
      { 'data': 'cod_ubigeo' },
      { 'data': 'direccion' },
      { 'data': 'telefono' },
      { 'data': 'mapa' },
      { 'data': 'estado' },
      { 'data': 'token' },
      { 'data': 'ruta' },
      { 'data': 'options' }
    ],
    columnDefs: [
      {
        "targets": [1,2,7,9,10],
        "visible": false,
        "searchable": false
      }
    ]
  });
  
  $(document).ready(function(){
  
    $("#panelForm").addClass("d-none");
    showData();
    $('#btnSearch').click(function(){
      showData();
    });
  
    $('#btnAdd').click(function(){
      $("#id_fundo").val("0");
      $("#accion").val("add");
      addClassDiv();
    });
  
    $('#btnSave').click(function(e){
      e.preventDefault();
      saveOperation();
    });
  
    $('#btnCancel').click(function(){
      removeClassDiv();
      $("#id_fundo").val("0");
      $("#accion").val("add");
      $("#frmDatos")[0].reset();
      $("#estado").prop('checked', false);
    });
  
    $('#example tbody').on( 'click', '#btnEdit', function () {
      try {
        var data = table.row( $(this).parents('tr') ).data();
        $("#id_fundo").val(data["id_fundo"]);
        $("#accion").val("edit");
        $("#nombre").val(data["nombre"]);
        $("#cod_ubigeo").val(data["cod_ubigeo"]);
        $("#direccion").val(data["direccion"]);
        $("#telefono").val(data["telefono"]);
        $("#mapa").val(data["mapa"]);
        $("#token").val(data["token"]);
        $("#ruta").val(data["ruta"]);
        if ('<label class="badge badge-success">Activo</label>'==data["estado"]) {
          $("#estado").prop('checked', true);
        }else {
          $("#estado").prop('checked', false);
        }
        addClassDiv();
      } catch (e) {
        runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
      }
    });
  
    $('#example tbody').on( 'click', '#btnDelete', function () {
      try {
  
        var data = table.row( $(this).parents('tr') ).data();
        var id_fundo = data["id_fundo"];
        var nombre = data["nombre"];
        var parametros = {
          "id_fundo" : id_fundo
        };
  
        Swal.fire({
          title: '¿Seguro de eliminar sucursal : ' + nombre + '?',
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
              url: "ajax.php?accion=deleteFundo",
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
    });
  
  
  });
  
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
  }
  
  function showData(){
    $.ajax({
      url: "ajax.php?accion=showFundo",
      success : function(data) {
        table.clear().draw();
        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {
            var o = data1["data"];
            for (var i = 0; i < o.length; i++) {
              table.row.add({
                "num": o[i].num,
                "id_fundo": o[i].id_fundo,
                "id_empresa": o[i].id_empresa,
                "nombre": o[i].nombre,
                "cod_ubigeo": o[i].cod_ubigeo,
                "direccion": o[i].direccion,
                "telefono": o[i].telefono,
                "mapa": o[i].mapa,
                "estado": o[i].estado,
                "token": o[i].token,
                "ruta": o[i].ruta,
                "options": o[i].options
              }).draw();
            }
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
        table.clear().draw();
      },
      complete: function (jqXHR, textStatus) {
        showHideLoader('none');
      }
    });
  }
  
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
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=goFundo",
          datatype: "json",
          data: $("#frmDatos").serialize(),
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
              runAlert("Oh No...!!!",e + ' | data ' + data,"error");
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
  