
var table = $('#example').DataTable({
    language: languageSpanish,
    destroy : true,
    columns: [
      { 'data': 'num' },
      { 'data': 'id_maquinaria' },
      { 'data': 'descripcion' },
      { 'data': 'observaciones' },
      { 'data': 'nombre_operador' },
      { 'data': 'estado' },
      { 'data': 'options' }
    ],
    columnDefs: [
      {
        "targets": [1],
        "visible": false,
        "searchable": true
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
      $("#id_maquinaria").val("0");
      $("#accion").val("add");
      $("#descripcion").val("");
      $("#observaciones").val("");
      $("#nombre_operador").val("");
      addClassDiv();
    });
  
    $('#btnSave').click(function(e){
      e.preventDefault();
      saveOperation();
    });
  
    $('#btnCancel').click(function(){
      removeClassDiv();
      $("#id_maquinaria").val("0");
      $("#accion").val("add");
      $("#descripcion").val("");
      $("#observaciones").val("");
      $("#nombre_operador").val("");
      $("#estado").prop('checked', false);
    });
  
    $('#example tbody').on( 'click', '#btnEdit', function () {
      try {
        var data = table.row( $(this).parents('tr') ).data();
        $("#id_maquinaria").val(data["id_maquinaria"]);
        $("#accion").val("edit");
        $("#descripcion").val(data["descripcion"]);
        $("#observaciones").val(data["observaciones"]);
        $("#nombre_operador").val(data["nombre_operador"]);
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
        var id_maquinaria = data["id_maquinaria"];
        var descripcion = data["descripcion"];
        var parametros = {
          "id_maquinaria" : id_maquinaria
        };
  
        Swal.fire({
          title: '¿Seguro de eliminar el registro de maquinaria : ' + descripcion + '?',
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
              url: "ajax.php?accion=deleteMaquinaria",
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
    $("#descripcion").val("");
    $("#observaciones").val("");
  }
  
  function showData(){
    $.ajax({
      url: "ajax.php?accion=showMaquinaria",
      success : function(data) {
        table.clear().draw();
        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {
            var o = data1["data"];
            for (var i = 0; i < o.length; i++) {
              table.row.add({
                "num": o[i].num,
                "id_maquinaria": o[i].id_maquinaria,
                "descripcion": o[i].descripcion,
                "observaciones": o[i].observaciones,
                "nombre_operador": o[i].nombre_operador,
                "estado": o[i].estado,
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
          url: "ajax.php?accion=goMaquinaria",
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
  }

  function getDataEdit(id_maquinaria){
    $.ajax({
      type: "POST",
      data:{
        id_maquinaria: id_maquinaria
      },
  
      url: "ajax.php?accion=getDataEditMaquinaria",
      success : function(data) {
        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {
            var o = data1["data"];
            $("#id_maquinaria").val(o[0].id_maquinaria);
            $("#descripcion").val(o[0].descripcion);
            $("#observaciones").val(o[0].observaciones);
            var estado = o[0].estado;
            estado=="activo" ? $("#estado").prop('checked', true) : $("#estado").prop('checked', false);
            var nombre_operador = o[0].nombre_operador;
            var id_operador = o[0].id_operador;
            var flag_encontro = false;
            $("#id_operador option").each(function(){
              if ($(this).val() == id_operador ){
                flag_encontro = true;
              }
            });
            if (!flag_encontro) {
              $('#id_operador').append('<option value="' + id_operador + '" selected>' + nombre_operador + '</option>');
            }
            addClassDiv();
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

  function deleteRegistro(id_maquinaria,maquinaria){

    try {
  
      var parametros = {
        "id_maquinaria" : id_maquinaria
      };
  
      Swal.fire({
        title: '¿Seguro de eliminar ' + maquinaria + '?',
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
            url: "ajax.php?accion=deleteMaquinaria",
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
  