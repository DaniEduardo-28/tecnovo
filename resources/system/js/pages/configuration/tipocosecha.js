
var table = $('#example').DataTable({
    language: languageSpanish,
    destroy : true,
    columns: [
      { 'data': 'num' },
      { 'data': 'codigo' },
      { 'data': 'descripcion' },
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
      $("#codigo").val("0");
      $("#accion").val("add");
      $("#descripcion").val("");
      addClassDiv();
    });
  
    $('#btnSave').click(function(e){
      e.preventDefault();
      saveOperation();
    });
  
    $('#btnCancel').click(function(){
      removeClassDiv();
      $("#codigo").val("0");
      $("#accion").val("add");
      $("#descripcion").val("");
      $("#estado").prop('checked', false);
    });
  
    $('#example tbody').on( 'click', '#btnEdit', function () {
      try {
        var data = table.row( $(this).parents('tr') ).data();
        $("#codigo").val(data["codigo"]);
        $("#accion").val("edit");
        $("#descripcion").val(data["descripcion"]);
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
        var codigo = data["codigo"];
        var descripcion = data["descripcion"];
        var parametros = {
          "codigo" : codigo
        };
  
        Swal.fire({
          title: '¿Seguro de eliminar el tipo de cosecha : ' + descripcion + '?',
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
              url: "ajax.php?accion=deleteTipoCosecha",
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
    $("#name_tipo").val("");
  }
  
  function showData(){
    $.ajax({
      url: "ajax.php?accion=showTipoCosecha",
      success : function(data) {
        table.clear().draw();
        try {
          var data1 = JSON.parse(data);
          if (data1["error"]=="NO") {
            var o = data1["data"];
            for (var i = 0; i < o.length; i++) {
              table.row.add({
                "num": o[i].num,
                "codigo": o[i].codigo,
                "descripcion": o[i].descripcion,
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
          url: "ajax.php?accion=goTipoCosecha",
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
  